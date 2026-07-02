<?php

if (!defined("ABSPATH")) {
    exit();
}

$editableRoles = get_editable_roles();
$forms         = get_posts(["numberposts" => -1, "post_type" => "wpdiscuz_form", "post_status" => "publish"]);

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-lock"></span>
            <?php esc_html_e("Private Comments Addon Settings", "wpdiscuz"); ?>
            <span class="wpd-pro-badge"><?php esc_html_e("PRO", "wpdiscuz"); ?></span>
        </span>
        <span class="wpd-pro-teaser-header-right">
            <span class="wpd-pro-toggle-icon">&#9650;</span>
        </span>
    </div>

    <div class="wpd-pro-teaser-body">

        <!-- Intro -->
        <div class="wpd-opt-row">
            <div class="wpd-opt-intro">
                <?php esc_html_e("Allows users to create private comment threads visible only to the thread owner, site administrators, and designated moderator roles. Includes per-form control, post author moderation, and email notifications for new private threads.", "wpdiscuz"); ?>
            </div>
        </div>

        <div class="wpd-subtitle"><?php esc_html_e("General", "wpdiscuz"); ?></div>

        <!-- Option start: can_add_private_comment -->
        <div class="wpd-opt-row" data-wpd-opt="can_add_private_comment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("User roles can create private comment threads", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach ($editableRoles as $role => $info) :
                    $isAdmin = ($role === "administrator");
                ?>
                    <div class="wpd-mublock-inline wpd-mublock-half wpd-mu-mimes">
                        <input type="checkbox" disabled checked
                               value="<?php echo esc_attr($role); ?>"
                               id="wpc-pro-add-<?php echo esc_attr($role); ?>"/>
                        <label for="wpc-pro-add-<?php echo esc_attr($role); ?>"
                               class="wpd-check-label"<?php echo $isAdmin ? ' style="color:#999999;"' : ''; ?>><?php echo esc_html($info["name"]); ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: moderator_user_groups -->
        <div class="wpd-opt-row" data-wpd-opt="moderator_user_groups">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("User roles can moderate private comments threads", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach ($editableRoles as $role => $info) :
                    $isAdmin = ($role === "administrator");
                    if (!$isAdmin && !(key_exists("moderate_comments", $info["capabilities"]) && $info["capabilities"]["moderate_comments"])) {
                        continue;
                    }
                ?>
                    <div class="wpd-mublock-inline wpd-mublock-half wpd-mu-mimes">
                        <input type="checkbox" disabled checked
                               value="<?php echo esc_attr($role); ?>"
                               id="wpc-pro-mod-<?php echo esc_attr($role); ?>"/>
                        <label for="wpc-pro-mod-<?php echo esc_attr($role); ?>"
                               class="wpd-check-label"<?php echo $isAdmin ? ' style="color:#999999;"' : ''; ?>><?php echo esc_html($info["name"]); ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: post_author_can_moderate -->
        <div class="wpd-opt-row" data-wpd-opt="post_author_can_moderate">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Post author can moderate private comments threads", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpc-pro-postAuthorCanModerate" checked/>
                    <label for="wpc-pro-postAuthorCanModerate"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: private_comment_forms -->
        <div class="wpd-opt-row" data-wpd-opt="private_comment_forms">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable private threads for comment forms", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("You can manage comment forms and fields in Dashboard > Comments > Forms admin page.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach ($forms as $form) : ?>
                    <div class="wpd-mublock-inline wpd-mublock-full wpd-mu-mimes">
                        <input type="checkbox" disabled checked
                               value="<?php echo esc_attr($form->ID); ?>"
                               id="wpc-pro-form-<?php echo esc_attr($form->ID); ?>"/>
                        <label for="wpc-pro-form-<?php echo esc_attr($form->ID); ?>"
                               class="wpd-check-label"><?php echo $form->post_title ? esc_html($form->post_title) : esc_html__("no title", "wpdiscuz") . " ( ID : " . esc_html($form->ID) . " )"; ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: private_comment_set_private -->
        <div class="wpd-opt-row" data-wpd-opt="private_comment_set_private">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Set new comments to private", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpc-pro-setPrivate"/>
                    <label for="wpc-pro-setPrivate"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Email Notification", "wpdiscuz"); ?></div>

        <!-- Option start: private_comment_notification_enabled -->
        <div class="wpd-opt-row" data-wpd-opt="private_comment_notification_enabled">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable Notification", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpc-pro-notificationEnabled"/>
                    <label for="wpc-pro-notificationEnabled"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: private_comment_notification_subject -->
        <div class="wpd-opt-row" data-wpd-opt="private_comment_notification_subject">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Subject", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("New Private Comment", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: private_comment_notification_message -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="private_comment_notification_message">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Email Text", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    [post-title] - <?php esc_html_e("Post Title", "wpdiscuz"); ?><br>
                    [post-url] - <?php esc_html_e("Post URL", "wpdiscuz"); ?><br>
                    [comment-url] - <?php esc_html_e("Private Comment Thread URL", "wpdiscuz"); ?>
                </p>
            </div>
            <div class="wpd-opt-input">
                <textarea disabled rows="6" class="wpd-teaser-textarea"><?php echo esc_textarea('Hi!
New private comment thread is created under "[post-title]" post.
Please make sure you\'re logged-in before navigating to the private comment thread.

Post URL: [post-url]
Comment Thread URL: [comment-url]'); ?></textarea>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-private-comments/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Private Comments Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
