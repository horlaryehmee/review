<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div id="wpd-wrc-teaser" class="wpd-pro-teaser-wrap wpd-pro-collapsed">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-shield-alt"></span>
            <?php esc_html_e("Google reCAPTCHA Addon Settings", "wpdiscuz"); ?>
            <span class="wpd-pro-badge"><?php esc_html_e("PRO", "wpdiscuz"); ?></span>
        </span>
        <span class="wpd-pro-teaser-header-right">
            <span class="wpd-pro-unlock-hint"><?php esc_html_e("Click to preview", "wpdiscuz"); ?></span>
            <span class="wpd-pro-toggle-icon">&#9650;</span>
        </span>
    </div>

    <div class="wpd-pro-teaser-body">

        <div class="wpd-subtitle"><?php esc_html_e("reCAPTCHA v3", "wpdiscuz"); ?></div>

        <!-- Option start: useV3 -->
        <div class="wpd-opt-row" data-wpd-opt="useV3">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Use version 3", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrc-pro-useV3"/>
                    <label for="wrc-pro-useV3"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: v3_sitekey -->
        <div class="wpd-opt-row" data-wpd-opt="v3_sitekey">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Site Key", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled placeholder="reCAPTCHA V3 Site Key" value="" class="wpd-teaser-input"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: v3_secretkey -->
        <div class="wpd-opt-row" data-wpd-opt="v3_secretkey">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Secret Key", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled placeholder="reCAPTCHA V3 Secret Key" value="" class="wpd-teaser-input"/>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: v3_score -->
        <div class="wpd-opt-row" data-wpd-opt="v3_score">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Score", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="0.5" checked id="wrc-pro-scoreMiddle"/>
                    <label for="wrc-pro-scoreMiddle" class="wpd-radio-lbl"><?php esc_html_e("Middle", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="0.9" id="wrc-pro-scoreHigh"/>
                    <label for="wrc-pro-scoreHigh" class="wpd-radio-lbl"><?php esc_html_e("High", "wpdiscuz"); ?></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

        <!-- Option start: v3_showBadge -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="v3_showBadge">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show reCaptcha badge", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wrc-pro-showBadge" checked/>
                    <label for="wrc-pro-showBadge"></label>
                </div>
            </div>
            <div class="wpd-opt-doc"></div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-recaptcha/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Google reCAPTCHA Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
