<?php

if (!defined("ABSPATH")) {
    exit();
}

class WpdiscuzHelperUpload implements WpDiscuzConstants {

    /**
     * @var $options WpdiscuzOptions
     */
    private $options;
    /**
     * @var $dbManager WpdiscuzDBManager
     */
    private $dbManager;
    /**
     * @var $wpdiscuzForm wpDiscuzForm
     */
    private $wpdiscuzForm;
    /**
     * @var $helper WpdiscuzHelper
     */
    private $helper;
    private $wpUploadsPath;
    private $wpUploadsUrl;
    private $wpUploadsSubdir;
    private $currentUser;
    private $requestUri;
    private $mimeTypes = [];

    public function __construct($options, $dbManager, $wpdiscuzForm, $helper) {
        $this->options      = $options;
        $this->dbManager    = $dbManager;
        $this->wpdiscuzForm = $wpdiscuzForm;
        $this->helper       = $helper;

        $this->requestUri = isset($_SERVER["REQUEST_URI"]) ? sanitize_text_field(wp_unslash($_SERVER["REQUEST_URI"])) : "";
        if ($this->options->content["wmuIsEnabled"]) {
            add_action("wpdiscuz_init", [$this, "initUploadsFolderVars"]);

            add_filter("wpdiscuz_editor_buttons_html", [$this, "uploadButtons"], 1, 2);
            add_action("wpdiscuz_button_actions", [$this, "uploadPreview"], 1, 2);

            add_filter("wpdiscuz_comment_list_args", [$this, "commentListArgs"]);
            add_filter("comment_text", [$this, "commentText"], 100, 3);
            add_filter("wpdiscuz_after_read_more", [$this, "afterReadMore"], 100, 3);

//            add_action("comment_post", [$this, "addAttachments"]);
            add_filter("wpdiscuz_comment_post", [$this, "postComment"], 10);
            add_filter("wpdiscuz_ajax_callbacks", [$this, "wmuImageCallbacks"], 10);

            add_action("wpdiscuz_before_wp_new_comment", [$this, "checkFiles"]);
            add_action("wpdiscuz_add_comment_before_wp_list_comments", [$this, "uploadFiles"], 10, 2);

            add_action("wp_ajax_wmuDeleteAttachment", [$this, "deleteAttachment"]);
            add_action("wp_ajax_nopriv_wmuDeleteAttachment", [$this, "deleteAttachment"]);

            add_action("delete_comment", [$this, "deleteLinkedAttachments"], 20);
            add_action("delete_attachment", [$this, "deleteAttachmentIdFromMeta"], 20);

            add_filter("wpdiscuz_privacy_personal_data_export", [$this, "exportPersonalData"], 10, 2);
            add_filter("wpdiscuz_do_export_personal_data", "__return_true");

            /* CRON JOBS */
            add_action("wpdiscuz_init", [$this, "registerJobThumbnailsViaCron"]);
            add_action("wpdiscuz_init", [$this, "deregisterJobThumbnailsViaCron"]);
            add_action(self::DELETE_UNATTACHED_FILES_ACTION, [$this, "deleteUnattachedFiles"]);
            add_action(self::GENERATE_THUMBNAILS_ACTION, [$this, "generateThumbnails"]);
            add_filter("cron_schedules", [$this, "setIntervalThumbnailsViaCron"]);
            /* /CRON JOBS */

            add_action("restrict_manage_posts", [$this, "wpdiscuzMediaFiler"]);
            add_filter("parse_query", [$this, "getWpdiscuzMedia"]);
//            add_filter("manage_media_columns", [$this, "wpdiscuzMediaCommentColumn"], 10, 2);
        }
    }

    public function initUploadsFolderVars() {
        $wpUploadsDir = wp_upload_dir();

        $this->wpUploadsSubdir = $wpUploadsDir["subdir"];
        $wpdiscuzUploadsFolder = apply_filters("wpdiscuz_uploads_folder", "");

        $this->wpUploadsPath = $wpUploadsDir["basedir"] . "/" . trim($wpdiscuzUploadsFolder, "/\\") . $this->wpUploadsSubdir;
        $this->wpUploadsUrl  = $this->helper->fixURLScheme($wpUploadsDir["baseurl"] . "/" . trim($wpdiscuzUploadsFolder, "/\\") . $this->wpUploadsSubdir);

        if (!is_dir($this->wpUploadsPath)) {
            wp_mkdir_p($this->wpUploadsPath);
        }
    }

    public function uploadButtons($html, $uniqueId) {
        if ($this->isUploadingAllowed()) {
            $type        = apply_filters("wpdiscuz_mu_upload_type", "");
            $faIcon      = apply_filters("wpdiscuz_mu_upload_icon", "far fa-image");
            $allowedExts = apply_filters("wpdiscuz_mu_allowed_extensions", "accept='image/*'");
            $html        .= "<span class='wmu-upload-wrap' wpd-tooltip='" . esc_attr($this->options->getPhrase("wmuAttachImage", ["unique_id" => $uniqueId])) . "' wpd-tooltip-position='" . (!is_rtl() ? 'left' : 'right') . "'>";
            $html        .= "<label class='wmu-add'>";
            $html        .= "<i class='$faIcon'></i>";
            $html        .= "<input style='display:none;' class='wmu-add-files' type='file' name='" . self::INPUT_NAME . "' $type $allowedExts/>";
            $html        .= "</label>";
            $html        .= "</span>";
        }
        return $html;
    }

    public function uploadPreview($uniqueId, $currentUser) {
        if ($this->isUploadingAllowed()) {
            $html = "<div class='wmu-action-wrap'>";
            $html .= "<div class='wmu-tabs wmu-" . self::KEY_IMAGES . "-tab wmu-hide'></div>";
            $html .= "<div class='wmu-tabs wmu-" . self::KEY_VIDEOS . "-tab wmu-hide'></div>";
            $html .= "<div class='wmu-tabs wmu-" . self::KEY_FILES . "-tab wmu-hide'></div>";
            $html .= apply_filters("wpdiscuz_mu_tabs", "");
            $html .= "</div>";
            echo $html;
        }
    }

    public function commentText($content, $comment) {
        if ($comment && strpos($this->requestUri, self::PAGE_COMMENTS) !== false && $this->options->content["wmuIsShowFilesDashboard"]) {
            if (empty($this->currentUser->ID)) {
                $this->currentUser = WpdiscuzHelper::getCurrentUser();
            }
            $content = $this->getAttachments($content, $comment);
        }
        return $content;
    }

    public function afterReadMore($content, $comment) {
        return $this->getAttachments($content, $comment);
    }

    /**
     * @param $content
     * @param $comment WP_Comment
     * @return mixed|string
     */
    private function getAttachments($content, $comment) {
        $attachments = get_comment_meta($comment->comment_ID, self::METAKEY_ATTACHMENTS, true);
        if ($attachments && is_array($attachments)) {
            // get files from jetpack CDN on ajax calls
            add_filter("jetpack_photon_admin_allow_image_downsize", "__return_true");
            $content .= "<div class='wmu-comment-attachments' data-comment-id='{$comment->comment_ID}'>";
            foreach ($attachments as $key => $ids) {
                if (!empty($ids)) {
                    $attachIds = array_map("intval", $ids);
                    $type      = (count($attachIds) > 1) ? "multi" : "single";
                    if ($key == self::KEY_IMAGES) {
                        $imgHtml = $this->getAttachedImages($attachIds, $this->currentUser);
                        $content .= "<div class='wmu-attached-images wmu-count-" . $type . "'>" . $imgHtml . "</div>";
                    }
                    $content .= apply_filters("wpdiscuz_mu_get_attachments", "", $attachIds, $this->currentUser, $key);
                }
            }
            $content .= "</div>";
        }
        return $content;
    }

    public function getAttachedImages($attachIds, $currentUser = null, $size = "full", $lazyLoad = true, $totalCount = null, $forceAdminStyle = false) {
        global $pagenow;
        $images = "";
        if ($attachIds) {
            $attachments = get_posts(["include" => $attachIds, "post_type" => "attachment", "orderby" => "post__in"]);
            if ($attachments && is_array($attachments)) {
                $style = "";
                if ($forceAdminStyle || $pagenow == self::PAGE_COMMENTS) {
                    $style            .= "max-height:100px;";
                    $style            .= "width:auto;";
                    $height           = "";
                    $width            = "";
                    $secondarySizeKey = "";
                    $secondarySize    = "";
                } else {
                    if (($totalCount ?? count($attachments)) > 1) {
                        $whData = apply_filters("wpdiscuz_mu_image_sizes", ["width" => 90, "height" => 90]);
                        $width  = $whData["width"];
                        $height = $whData["height"];
                    } else {
                        $width  = $this->options->content["wmuSingleImageWidth"];
                        $height = $this->options->content["wmuSingleImageHeight"];
                    }

                    if (intval($width)) {
                        $primarySizeKey   = "width";
                        $primarySize      = $width;
                        $secondarySizeKey = "height";
                        $secondarySize    = $height;
                    } else {
                        $primarySizeKey   = "height";
                        $primarySize      = $height;
                        $secondarySizeKey = "width";
                        $secondarySize    = $width;
                    }

                    $style .= "max-$primarySizeKey:{$primarySize}px;";
                    $style .= "$primarySizeKey:{$primarySize}px;";
                    $style .= "$secondarySizeKey:auto;";
                }

                if ($forceAdminStyle || $pagenow == self::PAGE_COMMENTS) {
                    $size = "thumbnail";
                } else {
                    foreach ($this->getImageSizes() as $sizeKey => $sizeValue) {
                        if (!intval($sizeValue["height"]) && !intval($sizeValue["width"])) {
                            continue;
                        }

                        if ($sizeValue[$primarySizeKey] > 0 && $primarySize <= $sizeValue[$primarySizeKey]) {
                            $size = $sizeKey;
                            break;
                        } else {
                            $size = "full";
                        }
                    }
                }

                $lightboxCls       = $this->options->content["wmuIsLightbox"] ? "wmu-lightbox" : "";
                $wmuLazyLoadImages = apply_filters("wpdiscuz_mu_lazyload_images", "");

                foreach ($attachments as $attachment) {
                    $deleteHtml = $this->getDeleteHtml($currentUser, $attachment, "image");
                    $url        = $this->helper->fixURLScheme(wp_get_attachment_image_url($attachment->ID, "full"));
                    $srcData    = wp_get_attachment_image_src($attachment->ID, $size);
                    $src        = $this->helper->fixURLScheme($srcData[0]);

                    if ($wmuLazyLoadImages && $lazyLoad) {
                        $srcValue     = "data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
                        $dataSrcValue = $src;
                    } else {
                        $srcValue     = $src;
                        $dataSrcValue = "";
                    }

                    $attachmentId = self::encrypt($attachment->ID);

                    $alt = get_post_meta($attachment->ID, "_wp_attachment_image_alt", true);

                    $images    .= "<div class='wmu-attachment wmu-attachment-$attachmentId'>";
                    $imageHtml = "<img style='" . esc_attr($style) . "' 
                                         alt='" . esc_attr($alt) . "' 
                                         title='" . esc_attr($attachment->post_excerpt) . "'  
                                         id='wmu-attachemnt-" . esc_attr($attachmentId) . "' 
                                         class='attachment-" . esc_attr($size) . " size-" . esc_attr($size) . " wmu-attached-image'  
                                         src='" . esc_url($srcValue) . "' 
                                         wmu-data-src='" . esc_url($dataSrcValue) . "' 
                                         $secondarySizeKey='" . esc_attr($secondarySize) . "' />";

                    if ($lightboxCls) {
                        $images .= "<a href='" . esc_attr($url) . "' class='wmu-attached-image-link " . esc_attr($lightboxCls) . "'>";
                        $images .= $imageHtml;
                        $images .= "</a>";
                    } else {
                        $images .= apply_filters("wpdiscuz_mu_attached_image_before", "<a href='" . esc_attr($url) . "' class='wmu-attached-image-link' target='_blank' rel='noreferrer ugc'>", $attachment->ID);
                        $images .= $imageHtml;
                        $images .= apply_filters("wpdiscuz_mu_attached_image_after", "</a>", $attachment->ID);
                    }
                    $images .= $deleteHtml;
                    $images .= "</div>";
                }
            }
        }
        return $images;
    }

    public function addAttachments($cId, $attachmentsIdData) {
        if ($attachmentsIdData && is_array($attachmentsIdData)) {

            $attachments = [];

            foreach ($attachmentsIdData as $key => $data) {
                if ($data && is_array($data)) {
                    foreach ($data as $attachmentId) {
                        if (!empty($attachmentId) && ($attachmentId = self::decrypt($attachmentId))) {
                            $attachments[$key][] = $attachmentId;
                            update_post_meta($attachmentId, self::METAKEY_ATTCHMENT_COMMENT_ID, $cId);
                        }
                    }
                }
            }

            if ($attachments) {
                update_comment_meta($cId, self::METAKEY_ATTACHMENTS, $attachments);
            }
        }
    }

    public function postComment($response) {
        $response["callbackFunctions"][] = "wmuHideAll";
        $response["callbackFunctions"][] = "wmuAddLightBox";
        return $response;
    }

    public function wmuImageCallbacks($response) {
        $response["callbackFunctions"][] = "wmuAddLightBox";
        return $response;
    }


    private function getFilteredFiles() {
        $files = $this->combineArray($_FILES[self::INPUT_NAME]);

        foreach ($files as $key => $file) {
            if (empty($file["tmp_name"]) || empty($file["size"])) {
                unset($files[$key]);
            }
        }
        return $files;
    }

    public function checkFiles() {
        $this->helper->validateNonce();
        $postId = WpdiscuzHelper::sanitize(INPUT_POST, "postId", FILTER_SANITIZE_NUMBER_INT, 0);

        if (!$postId) {
            wp_send_json_error("msgPostIdNotExists");
        }

        if (empty($_FILES[self::INPUT_NAME]) || !is_array($_FILES[self::INPUT_NAME])) {
            return;
        }

        $files        = $this->getFilteredFiles();
        $filesCount   = count($files);
        $allowedCount = apply_filters("wpdiscuz_mu_file_count", 1);

        if ($filesCount > $allowedCount) {
            wp_send_json_error("wmuPhraseMaxFileCount");
        }

        $post = get_post($postId);
        if (!$this->isUploadingAllowed($post)) {
            wp_send_json_error("msgUploadingNotAllowed");
        }

        $postSize = empty($_SERVER["CONTENT_LENGTH"]) ? 0 : intval($_SERVER["CONTENT_LENGTH"]);
        if ($postSize && $postSize > $this->options->wmuPostMaxSize) {
            wp_send_json_error("wmuPhrasePostMaxSize");
        }

        $size = 0;
        foreach ($files as $file) {
            $size += empty($file["size"]) ? 0 : intval($file["size"]);
        }
        if ($size > ($this->options->content["wmuMaxFileSize"] * 1024 * 1024)) {
            wp_send_json_error("wmuPhraseMaxFileSize");
        }

        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            if (!$this->isAllowedFileType($this->getMimeType($file, $extension), $extension)) {
                wp_send_json_error(["error" => sprintf(__(".%s files are not allowed", "wpdiscuz"), $extension)]);
            }
        }
    }

    /**
     * @param $newComment WP_Comment
     * @param $currentUser
     * @return void
     */
    public function uploadFiles($newComment, $currentUser) {

        if (empty($_FILES[self::INPUT_NAME]) || !is_array($_FILES[self::INPUT_NAME])) {
            return;
        }

        $files = $this->getFilteredFiles();

        // all expected data are correct, continue uploading
        $this->includeImageFunctions();

        $attachmentIds = [];

        foreach ($files as $file) {

            $error     = false;
            $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            if ($mimeType = $this->isImage($file)) {
                if ((strpos($mimeType, "image/") !== false) && empty($extension)) {
                    $file["name"] .= ".jpg";
                    $extension    = "jpg";
                }
            } else {
                $mimeType = $this->getMimeType($file, $extension);
            }

            if ($this->isAllowedFileType($mimeType, $extension)) {
                if (empty($extension)) {
                    if (strpos($mimeType, "image/") === false) {
                        foreach ($this->mimeTypes as $ext => $mimes) {
                            if (in_array($mimeType, explode("|", $mimes))) {
                                $file["name"] .= "." . $ext;
                            }
                        }
                    }
                }
                $file["type"] = $mimeType;
            } else {
                $error = true;
            }

            do_action("wpdiscuz_mu_preupload", $file);

            if (!$error) {
                $attachmentData = $this->uploadSingleFile($file);
                if ($attachmentData) {
                    if (strpos($file["type"], "image/") !== false) {
                        $attachmentIds[self::KEY_IMAGES][] = $attachmentData["id"];
                    } else {
                        $attachmentIds = apply_filters("wpdiscuz_mu_add_attachment_ids", $attachmentIds, $attachmentData, $file);
                    }
                }
            }
        }

        if ($attachmentIds) {
            $this->addAttachments($newComment->comment_ID, $attachmentIds);
        }
    }

    public static function encrypt($data) {
        $key            = __FILE__;
        $plaintext      = $data;
        $ivlen          = openssl_cipher_iv_length($cipher = 'AES-128-CBC');
        $iv             = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac           = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        $ciphertext     = base64_encode($iv . $hmac . $ciphertext_raw);
        return $ciphertext;
    }

    public static function decrypt($data) {
        $key                = __FILE__;
        $c                  = base64_decode($data);
        $ivlen              = openssl_cipher_iv_length($cipher = 'AES-128-CBC');
        $iv                 = substr($c, 0, $ivlen);
        $hmac               = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw     = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac            = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if ($original_plaintext && hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
        return false;
    }

    public function isAllowedFileType($mimeType, $extension) {
        $isAllowed = false;
        if (!empty($this->mimeTypes) && is_array($this->mimeTypes)) {
            foreach ($this->mimeTypes as $ext => $mimes) {
                if ($ext === $extension) {
                    if ($isAllowed = in_array($mimeType, explode("|", $mimes))) {
                        break;
                    }
                }
            }
        }
        return $isAllowed;
    }

    public function getMimeType($file, $extension) {
        $mimeType = "";
        if (function_exists("finfo_open") && function_exists("finfo_file")) {
            $finfo    = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file["tmp_name"]);
        } elseif (function_exists("mime_content_type")) {
            $mimeType = mime_content_type($file["tmp_name"]);
        } elseif ($extension) {
            foreach ($this->mimeTypes as $ext => $mimeTypes) {
                $exp = explode("|", $mimeTypes);
                if ($extension === $ext) {
                    $mimeType = $exp[0];
                    break;
                }
            }
        }
        return $mimeType;
    }

    public function deleteAttachment() {
        $this->helper->validateNonce();
        $response     = ["errorCode" => "", "error" => ""];
        $attachmentId = isset($_POST["attachmentId"]) ? trim(sanitize_text_field(wp_unslash($_POST["attachmentId"]))) : 0;
        $attachmentId = self::decrypt($attachmentId);
        $attachment   = get_post($attachmentId);

        if (empty($attachment->ID) || $attachment->post_type !== "attachment") {
            $response["error"] = esc_html__("The attachment does not exist!", "wpdiscuz");
            wp_send_json_error($response);
        }

        $commentId = get_post_meta($attachmentId, self::METAKEY_ATTCHMENT_COMMENT_ID, true);
        $comment   = get_comment($commentId);

        if (empty($comment->comment_ID)) {
            $response["error"] = esc_html__("Attachment's parent comment does not exist!", "wpdiscuz");
            wp_send_json_error($response);
        }

        $post = get_post($comment->comment_post_ID);
        WpdiscuzHelper::validatePostAccess($post);

        if (empty($this->currentUser->ID)) {
            $this->setCurrentUser(WpdiscuzHelper::getCurrentUser());
        }
        $args = [];
        if (isset($this->currentUser->user_email)) {
            $args["comment_author_email"] = $this->currentUser->user_email;
        }
        if (current_user_can("moderate_comments") || ($this->helper->isCommentEditable($comment) && $this->helper->canUserEditComment($comment, $this->currentUser, $args))) {
            wp_delete_attachment($attachmentId, true);
            do_action("wpdiscuz_reset_comments_extra_cache", $comment->comment_post_ID);
            wp_send_json_success($response);
        } else {
            $response["error"] = esc_html__("You don't have sufficient permission for this action!", "wpdiscuz");
            wp_send_json_error($response);
        }
    }

    public function isUploadingAllowed($postObj = null) {
        global $post;
        $gPost           = $postObj ? $postObj : $post;
        $isAllowed       = false;
        $this->mimeTypes = apply_filters("wpdiscuz_mu_mime_types", $this->options->content["wmuMimeTypes"]);
        if ($this->isAllowedPostType($gPost) && !empty($this->mimeTypes)) {
            $currentUser    = WpdiscuzHelper::getCurrentUser();
            $isUserLoggedIn = !empty($currentUser->ID);
            $isGuestAllowed = !$isUserLoggedIn && $this->options->content["wmuIsGuestAllowed"];
            $isUserAllowed  = $isUserLoggedIn && $this->canUserUpload($currentUser);
            if ($isGuestAllowed || $isUserAllowed) {
                $isAllowed = true;
            }
        }
        return $isAllowed;
    }

    public function isAllowedPostType($post) {
        $allowedPosttypes = apply_filters("wpdiscuz_mu_allowed_posttypes", $this->getDefaultPostTypes());
        return ($post && is_object($post) && isset($post->post_type) && in_array($post->post_type, $allowedPosttypes));
    }

    public function canUserUpload($currentUser) {
        $bool = false;
        if ($currentUser && $currentUser->ID) {
            $userRoles    = $currentUser->roles;
            $allowedRoles = apply_filters("wpdiscuz_mu_allowed_roles", $this->getDefaultRoles());
            foreach ($userRoles as $role) {
                if (in_array($role, $allowedRoles)) {
                    $bool = true;
                    break;
                }
            }
        }
        return $bool;
    }

    public function uploadSingleFile($file) {
        $currentTime       = WpdiscuzHelper::getMicrotime();
        $attachmentData    = [];
        $path              = $this->wpUploadsPath . "/";
        $fName             = $file["name"];
        $pathInfo          = pathinfo($fName);
        $realFileName      = $pathInfo["filename"];
        $ext               = empty($pathInfo["extension"]) ? "" : strtolower($pathInfo["extension"]);
        $sanitizedName     = sanitize_file_name($realFileName);
        $cleanFileName     = $sanitizedName . "-" . $currentTime . "." . $ext;
        $cleanRealFileName = $sanitizedName . "." . $ext;
        $fileName          = $path . $cleanFileName;

        if (in_array($ext, ["jpeg", "jpg"])) {
            $this->imageFixOrientation($file["tmp_name"]);
        }

        $success = apply_filters("wpdiscuz_mu_compress_image", false, $file["tmp_name"], $fileName, $q = 60);
        if ($success || @move_uploaded_file($file["tmp_name"], $fileName)) {
            $postParent = apply_filters("wpdiscuz_mu_attachment_parent", 0);
            $attachment = [
                "guid"           => $this->wpUploadsUrl . "/" . $cleanFileName,
                "post_mime_type" => $file["type"],
                "post_title"     => preg_replace("#\.[^.]+$#", "", wp_slash($sanitizedName)),
                "post_excerpt"   => wp_slash($sanitizedName),
                "post_content"   => "",
                "post_status"    => "inherit",
                "post_parent"    => $postParent
            ];

            if ($attachId = wp_insert_attachment($attachment, $fileName)) {
                if (!$this->options->content["wmuIsThumbnailsViaCron"]) {
                    $attachData = $this->generateAttachmentMetadata($attachId, $fileName);
                }
                update_post_meta($attachId, "_wp_attachment_image_alt", $sanitizedName);
                $ip = WpdiscuzHelper::getRealIPAddr();
                update_post_meta($attachId, self::METAKEY_ATTCHMENT_OWNER_IP, $ip);
                update_post_meta($attachId, self::METAKEY_ATTCHMENT_COMMENT_ID, 0);
                $attachmentData["id"]        = self::encrypt($attachId);
                $attachmentData["url"]       = empty($attachData["sizes"]["thumbnail"]["file"]) ? $this->wpUploadsUrl . "/" . $cleanFileName : $this->wpUploadsUrl . "/" . $attachData["sizes"]["thumbnail"]["file"];
                $attachmentData["fullname"]  = $cleanRealFileName;
                $attachmentData["shortname"] = $this->getFileName($cleanRealFileName);
            }
        }
        return $attachmentData;
    }

    private function getImageSizes() {
        $sizes                                       = [];
        $this->options->content["wmuThumbnailSizes"] = array_filter($this->options->content["wmuThumbnailSizes"], function ($v) {
            return in_array($v, get_intermediate_image_sizes());
        });
        foreach ($this->options->content["wmuThumbnailSizes"] as $_size) {
            if (in_array($_size, $this->options->getDefaultThumbnailSizes())) {
                $sizes[$_size]["width"]  = intval(get_option("{$_size}_size_w"));
                $sizes[$_size]["height"] = intval(get_option("{$_size}_size_h"));
            } else if (isset($additionalSizes[$_size])) {
                $sizes[$_size]["width"]  = $additionalSizes[$_size]["width"];
                $sizes[$_size]["height"] = $additionalSizes[$_size]["height"];
            }
        }
        return $sizes;
    }

    public function getThumbnailSizes() {
        $sizes = $this->options->content["wmuThumbnailSizes"];
        if ($sizes && is_array($sizes) && !in_array("full", $sizes)) {
            $sizes[] = "full";
        }

        if (!$sizes) {
            $sizes = ["full"];
        }
        return $sizes;
    }

    private function combineArray($array) {
        $combinedArray = [];
        foreach ($array as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $combinedArray[$k1][$k] = $v1;
            }
        }
        return $combinedArray;
    }

    private function imageFixOrientation($filename) {
        $isFunctionsExists = function_exists("exif_read_data") && function_exists("imagecreatefromjpeg") && function_exists("imagerotate") && function_exists("imagejpeg");
        if ($isFunctionsExists) {
            $exif = @exif_read_data($filename);
            if (!empty($exif["Orientation"])) {
                $image = imagecreatefromjpeg($filename);
                switch ($exif["Orientation"]) {
                    case 3:
                        $image = imagerotate($image, 180, 0);
                        break;
                    case 6:
                        $image = imagerotate($image, -90, 0);
                        break;
                    case 8:
                        $image = imagerotate($image, 90, 0);
                        break;
                }
                imagejpeg($image, $filename, 90);
            }
        }
    }

    public function getFileName($attachment) {
        $name = false;
        if ($attachment) {
            if (is_object($attachment) && (isset($attachment->post_excerpt) || isset($attachment->post_title))) {
                $name = $attachment->post_excerpt ? $attachment->post_excerpt : $attachment->post_title;
            } else {
                $name = $attachment;
            }
            if (strlen($name) > 40) {
                $name = function_exists("mb_substr") ? mb_substr($name, -40, 40, "UTF-8") : substr($name, -40, 40);
                $name = "..." . $name;
            }
        }
        return $name;
    }

    public function deleteLinkedAttachments($commentId) {
        if ($commentId) {
            $metaData = get_comment_meta($commentId, self::METAKEY_ATTACHMENTS, true);
            if ($metaData && is_array($metaData)) {
                foreach ($metaData as $key => $attachments) {
                    if ($attachments && is_array($attachments)) {
                        foreach ($attachments as $attachment) {
                            wp_delete_attachment($attachment);
                        }
                    }
                }
            }
        }
    }

    public function deleteAttachmentIdFromMeta($postId) {
        $commentId = get_post_meta($postId, self::METAKEY_ATTCHMENT_COMMENT_ID, true);
        if ($commentId) {
            $attachments = get_comment_meta($commentId, self::METAKEY_ATTACHMENTS, true);
            if ($attachments && is_array($attachments)) {
                $tmpData = [];
                foreach ($attachments as $key => $value) {
                    $index = array_search($postId, $value);
                    if ($index !== false) {
                        unset($value[$index]);
                        $tmpData[$key] = array_values($value);
                    } else {
                        $tmpData[$key] = $value;
                    }
                }

                if (self::hasAttachments($tmpData)) {
                    update_comment_meta($commentId, self::METAKEY_ATTACHMENTS, $tmpData);
                } else {
                    delete_comment_meta($commentId, self::METAKEY_ATTACHMENTS);
                }
            }
        }
    }

    public static function hasAttachments($attachments) {
        $hasItems = false;
        if ($attachments && is_array($attachments)) {
            foreach ($attachments as $attachment) {
                if (is_array($attachment) && count($attachment)) {
                    $hasItems = true;
                    break;
                }
            }
        }
        return $hasItems;
    }

    public function canEditAttachments($currentUser, $attachment) {
        $args = [];
        if (isset($this->currentUser->user_email)) {
            $args["comment_author_email"] = $this->currentUser->user_email;
        }
        $commentId = get_post_meta($attachment->ID, self::METAKEY_ATTCHMENT_COMMENT_ID, true);
        $comment   = get_comment($commentId);
        return current_user_can("moderate_comments") || ($this->helper->isCommentEditable($comment) && $this->helper->canUserEditComment($comment, $currentUser, $args));
    }

    public function canReplaceAttachment($currentUser, $attachment, $type) {
        if (!apply_filters("wpdiscuz_mu_isactive", false)) {
            return false;
        }
        $commentId = (int)get_post_meta($attachment->ID, WpdiscuzCore::METAKEY_ATTCHMENT_COMMENT_ID, true);
        return (bool)apply_filters("wpdiscuz_mu_can_replace_attachments", false, $currentUser, $commentId, $type);
    }

    public function getDeleteHtml($currentUser, $attachment, $type) {
        $attachmentId = self::encrypt($attachment->ID);
        $deleteHtml   = "<div class='wmu-attachment-delete wmu-delete-" . esc_attr($type) . "' title='" . esc_html__("Delete", "wpdiscuz") . "' data-wmu-attachment='" . esc_attr($attachmentId) . "'>";
        $deleteHtml   .= "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 640'><path d='M232.7 69.9C237.1 56.8 249.3 48 263.1 48L377 48C390.8 48 403 56.8 407.4 69.9L416 96L512 96C529.7 96 544 110.3 544 128C544 145.7 529.7 160 512 160L128 160C110.3 160 96 145.7 96 128C96 110.3 110.3 96 128 96L224 96L232.7 69.9zM128 208L512 208L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 208zM216 272C202.7 272 192 282.7 192 296L192 488C192 501.3 202.7 512 216 512C229.3 512 240 501.3 240 488L240 296C240 282.7 229.3 272 216 272zM320 272C306.7 272 296 282.7 296 296L296 488C296 501.3 306.7 512 320 512C333.3 512 344 501.3 344 488L344 296C344 282.7 333.3 272 320 272zM424 272C410.7 272 400 282.7 400 296L400 488C400 501.3 410.7 512 424 512C437.3 512 448 501.3 448 488L448 296C448 282.7 437.3 272 424 272z'/></svg>";
        $deleteHtml   .= "</div>";
        if ($this->canEditAttachments($currentUser, $attachment)) {
            if ($this->canReplaceAttachment($currentUser, $attachment, $type)) {
                $deleteHtml .= $this->getAttachmentReplaceHtml($attachmentId);
            }
            return $deleteHtml;
        }
        return "<div class='wmu-separator'></div>";
    }

    private function getAttachmentReplaceHtml($attachmentId) {
        $label       = esc_attr__("Replace", "wpdiscuz");
        $allowedExts = apply_filters("wpdiscuz_mu_allowed_extensions", "accept='image/*'");
        $replaceHtml = "<label class='wmu-attachment-replace' title='" . $label . "' data-wmu-attachment='" . esc_attr($attachmentId) . "'>";
        $replaceHtml .= "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 640 640'><path d='M500.7 138.7L512 149.4L512 96C512 78.3 526.3 64 544 64C561.7 64 576 78.3 576 96L576 224C576 241.7 561.7 256 544 256L416 256C398.3 256 384 241.7 384 224C384 206.3 398.3 192 416 192L463.9 192L456.3 184.8C456.1 184.6 455.9 184.4 455.7 184.2C380.7 109.2 259.2 109.2 184.2 184.2C109.2 259.2 109.2 380.7 184.2 455.7C259.2 530.7 380.7 530.7 455.7 455.7C463.9 447.5 471.2 438.8 477.6 429.6C487.7 415.1 507.7 411.6 522.2 421.7C536.7 431.8 540.2 451.8 530.1 466.3C521.6 478.5 511.9 490.1 501 501C401 601 238.9 601 139 501C39.1 401 39 239 139 139C238.9 39.1 400.7 39 500.7 138.7z'/></svg>";
        $replaceHtml .= "<input type='file' style='display:none' class='wmu-replace-attachment-input' " . $allowedExts . ">";
        $replaceHtml .= "</label>";
        return $replaceHtml;
    }

    public function commentListArgs($args) {
        if (empty($args["current_user"])) {
            $this->currentUser = WpdiscuzHelper::getCurrentUser();
        } else {
            $this->currentUser = $args["current_user"];
        }
        return $args;
    }

    public function setCurrentUser($currentUser) {
        $this->currentUser = $currentUser;
    }

    private function getDefaultPostTypes() {
        return ["post", "page", "attachment"];
    }

    private function getDefaultRoles() {
        return ["administrator", "editor", "author", "contributor", "subscriber"];
    }

    public function isImage($file) {
        return wp_get_image_mime($file["tmp_name"]);
    }

    /**
     * DEPRECATED due to some secuirty issues
     */
    public function getMimeTypeFromContent($path) {
        $fileContent = $path && function_exists("file_get_contents") && ($v = file_get_contents($path)) ? $v : "";
        if ($fileContent && preg_match('/\A(?:(\xff\xd8\xff)|(GIF8[79]a)|(\x89PNG\x0d\x0a)|(BM)|(\x49\x49(?:\x2a\x00|\x00\x4a))|(FORM.{4}ILBM))/', $fileContent, $hits)) {
            $type = [
                1 => "jpeg",
                2 => "gif",
                3 => "png",
                4 => "bmp",
                5 => "tiff",
                6 => "ilbm",
            ];
            return $type[count($hits) - 1];
        }
        return false;
    }

    public function exportPersonalData($data, $commentId) {
        $attachments = get_comment_meta($commentId, self::METAKEY_ATTACHMENTS, true);
        if ($attachments && is_array($attachments)) {
            $isWmuExists = apply_filters("wpdiscuz_mu_isactive", false);
            foreach ($attachments as $key => $attachIds) {
                if (empty($attachIds)) {
                    continue;
                }

                foreach ($attachIds as $attachId) {
                    if (intval($attachId)) {
                        if ($key === self::KEY_IMAGES) {
                            $data[] = ["name" => esc_html__("Attached Images", "wpdiscuz"), "value" => wp_get_attachment_url($attachId)];
                        } else if ($isWmuExists) {
                            $data = apply_filters("wpdiscuz_mu_export_data", $data, $key, $attachId);
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function deleteUnattachedFiles() {
        if (!apply_filters("wpdiscuz_delete_unattached_files", true)) {
            wp_clear_scheduled_hook(self::DELETE_UNATTACHED_FILES_ACTION);
            return;
        }
        $attachments = get_posts([
            "post_type"      => "attachment",
            "posts_per_page" => apply_filters("wpdiscuz_delete_unattached_files_limit", 20),
            /*
            "date_query" => [
                [
                    "column" => "post_date_gmt",
                    "before" => "30 minutes ago",
                ],
            ],
            */
            "meta_query"     => [
                [
                    "key"     => self::METAKEY_ATTCHMENT_COMMENT_ID,
                    "value"   => "0",
                    "compare" => "=",
                ],
            ],
            "fields"         => "ids",
        ]);
        foreach ($attachments as $key => $attachment) {
            wp_delete_attachment($attachment, true);
        }
    }

    public function registerJobThumbnailsViaCron() {
        if (!wp_next_scheduled(self::GENERATE_THUMBNAILS_ACTION)) {
            wp_schedule_event(current_time("timestamp"), self::GENERATE_THUMBNAILS_KEY_RECURRENCE, self::GENERATE_THUMBNAILS_ACTION);
        }
    }

    public function deregisterJobThumbnailsViaCron() {
        if (!$this->options->content["wmuIsThumbnailsViaCron"] && wp_next_scheduled(self::GENERATE_THUMBNAILS_ACTION)) {
            wp_clear_scheduled_hook(self::GENERATE_THUMBNAILS_ACTION);
        }
    }

    public function setIntervalThumbnailsViaCron($schedules) {
        $schedules[self::GENERATE_THUMBNAILS_KEY_RECURRENCE] = [
            "interval" => self::GENERATE_THUMBNAILS_RECURRENCE * HOUR_IN_SECONDS,
            "display"  => "Every 3 hours"
        ];

        return $schedules;
    }

    public function generateThumbnails() {
        if (!apply_filters("wpdiscuz_generate_thumbnails_check", true)) {
            wp_clear_scheduled_hook(self::GENERATE_THUMBNAILS_ACTION);
            return;
        }

        $attachments = get_posts([
            "post_type"      => "attachment",
            "posts_per_page" => apply_filters("wpdiscuz_generate_thumbnails_limit", 5),
            "fields"         => "ids",
            "meta_query"     => [
                "relation" => "AND",
                [
                    "relation" => "OR",
                    [
                        "key"     => "_wp_attachment_metadata",
                        "compare" => "NOT EXISTS",
                    ],
                    [
                        "key"     => '_wp_attachment_metadata',
                        "value"   => "",
                        "compare" => "=",
                    ],
                ],
                [
                    "key"     => "_wmu_comment_id",
                    "value"   => "",
                    "compare" => "!="
                ]
            ],
        ]);

        foreach ($attachments as $attachId) {
            $fileName               = get_post_meta($attachId, "_wp_attached_file", true);
            $is_wpdiscuz_attachment = (int)get_post_meta($attachId, '_wmu_comment_id', true);
            if (!$fileName || !$is_wpdiscuz_attachment) {
                continue;
            }

            $fileName   = $this->wpUploadsPath . "/" . basename($fileName);
            $attachData = $this->generateAttachmentMetadata($attachId, $fileName);
        }
    }

    private function generateAttachmentMetadata($attachId, $fileName) {
        $this->includeImageFunctions();
        add_filter("intermediate_image_sizes", [$this, "getThumbnailSizes"]);
        $attachData = wp_generate_attachment_metadata($attachId, $fileName);
        wp_update_attachment_metadata($attachId, $attachData);
        return $attachData;
    }

    public function includeImageFunctions() {
        if (!function_exists("get_file_description")) {
            require_once ABSPATH . "wp-admin/includes/file.php";
        }

        if (!function_exists("wp_generate_attachment_metadata")) {
            require_once ABSPATH . "wp-admin/includes/image.php";
        }

        if (!function_exists("wp_get_additional_image_sizes")) {
            require_once ABSPATH . "wp-includes/media.php";
        }

        if (!function_exists("wp_read_audio_metadata")) {
            require_once ABSPATH . "wp-admin/includes/media.php";
        }
    }

    public function wpdiscuzMediaFiler() {
        $scr = get_current_screen();
        if ($scr->base !== "upload") {
            return;
        }

        $source   = WpdiscuzHelper::sanitize(INPUT_GET, "media_source", "FILTER_SANITIZE_STRING");
        $selected = $source === "wpdiscuz" ? " selected='selected'" : "";

        $dropdown = "<select name='media_source' id='wpdiscuz_media' class='postform'>";
        $dropdown .= "<option value=''>" . esc_html__("All Media Items", "wpdiscuz") . "</option>";
        $dropdown .= "<option value='wpdiscuz' {$selected}>" . esc_html__("wpDiscuz Media Items", "wpdiscuz") . "</option>";
        $dropdown .= "</select>";
        echo wp_kses($dropdown, [
            "select" => [
                "name"  => true,
                "id"    => true,
                "class" => true,
            ],
            "option" => [
                "value"    => true,
                "selected" => true,
            ],
        ]);
    }

    function getWpdiscuzMedia($query) {
        global $pagenow;
        $mode   = WpdiscuzHelper::sanitize(INPUT_GET, "mode", "FILTER_SANITIZE_STRING");
        $source = WpdiscuzHelper::sanitize(INPUT_GET, "media_source", "FILTER_SANITIZE_STRING");

        if (is_admin() && "upload.php" === $pagenow && $mode === "list" && $source === "wpdiscuz") {
            $query->query_vars["meta_key"]     = "_wmu_comment_id";
            $query->query_vars["meta_value"]   = "";
            $query->query_vars["meta_compare"] = "!=";
        }
    }

    public function wpdiscuzMediaCommentColumn($columns, $detached) {
        if ($columns && is_array($columns)) {
            $columns['wpdcomment'] = esc_html__('Attached To Comment', 'wpdiscuz');
        }
        return $columns;
    }

}
