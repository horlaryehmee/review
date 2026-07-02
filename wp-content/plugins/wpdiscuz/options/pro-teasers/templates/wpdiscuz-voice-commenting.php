<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-microphone"></span>
            <?php esc_html_e("Voice Commenting Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Allows visitors and registered users to record and post voice comments directly from the browser. Supports recording time limits, role-based access, and guest voice commenting.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: enableForForms -->
        <div class="wpd-opt-row" data-wpd-opt="enableForForms">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable for the following comment forms", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php
                $wvcForms = get_posts(["numberposts" => -1, "post_type" => "wpdiscuz_form", "post_status" => "publish"]);
                foreach ($wvcForms as $wvcForm) : ?>
                <div class="wpd-mublock-inline wpd-mu-mimes">
                    <input type="checkbox" disabled value="<?php echo esc_attr($wvcForm->ID); ?>" id="wvc-pro-form<?php echo esc_attr($wvcForm->ID); ?>" checked/>
                    <label for="wvc-pro-form<?php echo esc_attr($wvcForm->ID); ?>" class="wpd-check-label"><?php echo $wvcForm->post_title ? esc_html($wvcForm->post_title) : esc_html__("no title", "wpdiscuz") . " ( ID : " . esc_html($wvcForm->ID) . " )"; ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: timeLimit -->
        <div class="wpd-opt-row" data-wpd-opt="timeLimit">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Recording time limit", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="30" min="0" class="wpd-num-input-sm"/>&nbsp;<?php esc_html_e("seconds", "wpdiscuz"); ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: canAddAudioComment -->
        <div class="wpd-opt-row" data-wpd-opt="canAddAudioComment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow user roles to post voice comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) : ?>
                <div class="wpd-mublock-inline wpd-mublock-wide">
                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" id="wvc-pro-role-<?php echo esc_attr($role); ?>" checked/>
                    <label for="wvc-pro-role-<?php echo esc_attr($role); ?>"><?php echo esc_html($info["name"]); ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: guestCanAddAudioComment -->
        <div class="wpd-opt-row" data-wpd-opt="guestCanAddAudioComment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow guests to post voice comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wvc-pro-guestCanAddAudioComment"/>
                    <label for="wvc-pro-guestCanAddAudioComment"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: allowEditing -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="allowEditing">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow voice comments editing", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wvc-pro-allowEditing"/>
                    <label for="wvc-pro-allowEditing"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-voice-commenting/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Voice Commenting Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
