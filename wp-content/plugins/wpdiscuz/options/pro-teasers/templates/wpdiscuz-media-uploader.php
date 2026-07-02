<?php

if (!defined("ABSPATH")) {
    exit();
}

$wmuTeaserImgBase = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img/";

?>
<div id="wpd-wmu-teaser" class="wpd-pro-teaser-wrap wpd-pro-collapsed">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-paperclip"></span>
            <?php esc_html_e("Media Uploader Addon Settings", "wpdiscuz-media-uploader"); ?>
            <span class="wpd-pro-badge"><?php esc_html_e("PRO", "wpdiscuz"); ?></span>
        </span>
        <span class="wpd-pro-teaser-header-right">
            <span class="wpd-pro-unlock-hint"><?php esc_html_e("Click to preview", "wpdiscuz"); ?></span>
            <span class="wpd-pro-toggle-icon">&#9650;</span>
        </span>
    </div>

    <div class="wpd-pro-teaser-body">

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuAllowedPostTypes">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow Media Uploading for Post Types", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_post_types() as $postType) { ?>
                    <?php if (post_type_supports($postType, "comments")) { ?>
                        <div class="wpd-mublock-inline wpd-mublock-third">
                            <input type="checkbox" disabled value="<?php echo esc_attr($postType); ?>"/>
                            <label class="wpd-check-label"><?php echo esc_html($postType); ?></label>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuAllowedRoles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow Media Uploading for User Roles", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("By default comment media uploading button is available for default WordPress user roles. if you have custom user roles please manage this option for those too.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) { ?>
                    <div class="wpd-mublock-inline wpd-mublock-wide">
                        <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>"/>
                        <label><?php echo esc_html($info["name"]); ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuImagesMaxWidth">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Images max width for uploading", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" value="800" disabled class="wpd-num-input-md"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuImagesMaxHeight">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Images max height for uploading", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" value="600" disabled class="wpd-num-input-md"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuIsHtml5Video">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable HTML5 video player", "wpdiscuz-media-uploader"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Uploaded video files will be added as a download link under comment text. However if file format is .mp4, .webm or .ogg, it'll convert link to HTML5 video player.", "wpdiscuz-media-uploader"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="checkbox" disabled value="1"/>
                <img src="<?php echo esc_url($wmuTeaserImgBase . "html5-video-player.png"); ?>" style="vertical-align:middle; height:70px;" class="wpd-teaser-img" title="Player Screenshot" alt="HTML5 Video Player"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuIsHtml5Audio">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable HTML5 audio player", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="checkbox" disabled value="1"/>
                <img src="<?php echo esc_url($wmuTeaserImgBase . "html5-audio-player.png"); ?>" style="vertical-align:middle;" class="wpd-teaser-img" title="Player Screenshot" alt="HTML5 Audio Player"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuMaxFileCount">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Max number of files", "wpdiscuz-media-uploader"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("You can not set this value more than 'max_file_uploads'. If you want to increase server parameters please contact to your hosting service support.", "wpdiscuz-media-uploader"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="number" value="5" disabled class="wpd-num-input-md"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuVideoSizes">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Video player sizes", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <span><input type="number" value="400" disabled class="wpd-num-input-sm"> <?php esc_html_e("width (px)", "wpdiscuz-media-uploader"); ?> </span>
                <span>&nbsp; <input type="number" value="300" disabled class="wpd-num-input-sm"> <?php esc_html_e("height (px)", "wpdiscuz-media-uploader"); ?></span>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuImageSizes">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Image sizes on comment", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <span><input type="text" value="auto" disabled class="wpd-num-input-sm"> <?php esc_html_e("width (px)", "wpdiscuz-media-uploader"); ?> </span>
                <span>&nbsp; <input type="text" value="200" disabled class="wpd-num-input-sm"> <?php esc_html_e("height (px)", "wpdiscuz-media-uploader"); ?></span>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuLazyLoadImages">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable images lazy loading?", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpd-pro-teaser-lazy"/>
                    <label for="wpd-pro-teaser-lazy"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuAttachToPost">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Attach files to current post?", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpd-pro-teaser-attach"/>
                    <label for="wpd-pro-teaser-attach"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuEnableCommentsFiltering">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable comments filtering", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpd-pro-teaser-filter"/>
                    <label for="wpd-pro-teaser-filter"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuEnableMediaTab">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show 'My Content and Settings' 'Media' tab", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpd-pro-teaser-mediatab"/>
                    <label for="wpd-pro-teaser-mediatab"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuIsCompressImages">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Compress images before upload", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpd-pro-teaser-compress"/>
                    <label for="wpd-pro-teaser-compress"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuCompressionQuality">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Compression quality", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" min="1" max="99" value="75" disabled class="wpd-num-input-sm"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuCanRepalceAttachments">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow attachments replace", "wpdiscuz-media-uploader"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpd-pro-teaser-replace"/>
                    <label for="wpd-pro-teaser-replace"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start -->
        <div class="wpd-opt-row" data-wpd-opt="wmuRolesCanReplaceAttachments">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow attachments replace for User Roles", "wpdiscuz-media-uploader"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("By default replace attachments button is available for default WordPress user roles. if you have custom user roles please manage this option for those too.", "wpdiscuz-media-uploader"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) { ?>
                    <div class="wpd-mublock-inline wpd-mublock-wide">
                        <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>"/>
                        <label><?php echo esc_html($info["name"]); ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

    </div><!-- .wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-media-uploader/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Media Uploader", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- .wpd-pro-teaser-wrap -->
