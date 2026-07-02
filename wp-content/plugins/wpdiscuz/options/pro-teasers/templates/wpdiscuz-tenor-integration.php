<?php

if (!defined("ABSPATH")) {
    exit();
}

$wtiLogoUrl = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img/tenor-logo.png";

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-format-image"></span>
            <?php esc_html_e("Tenor GIFs Integration Addon Settings", "wpdiscuz"); ?>
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
                <img src="<?php echo esc_url($wtiLogoUrl); ?>" class="wti-pro-logo" alt="Tenor"/>
                <?php esc_html_e("Tenor is an online GIF database. Its main product is GIF Keyboard. Tenor provides animated GIF images that users can embed in posts, messages, and in this case in comments. Tenor is free.", "wpdiscuz"); ?>
                <a href="https://tenor.com/legal-terms" target="_blank" rel="noopener noreferrer"><?php esc_html_e("Terms of Service", "wpdiscuz"); ?></a>
                <?php esc_html_e("and", "wpdiscuz"); ?>
                <a href="https://tenor.com/gifapi/documentation#apiterms" target="_blank" rel="noopener noreferrer"><?php esc_html_e("API Terms", "wpdiscuz"); ?></a>
                <div class="wpd-clear"></div>
            </div>
        </div>

        <!-- Option start: key -->
        <div class="wpd-opt-row" data-wpd-opt="key">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("API Key", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("You need to create accounts on tenor.com and get your API keys.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: locale -->
        <div class="wpd-opt-row" data-wpd-opt="locale">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Locale", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <?php esc_html_e("Specify default language to interpret search string; xx is ISO 639-1 language code, _YY (optional) is 2-letter ISO 3166-1 country code.", "wpdiscuz"); ?>
                    <a href="https://tenor.com/gifapi" target="_blank" rel="noopener noreferrer"><?php esc_html_e("Supported Languages", "wpdiscuz"); ?></a>
                </p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="en_US" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: contentfilter -->
        <div class="wpd-opt-row" data-wpd-opt="contentfilter">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("GIF filtering", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-radio">
                    <input type="radio" disabled value="off" checked id="wti-pro-filterOff"/>
                    <label for="wti-pro-filterOff" class="wpd-radio-circle"></label>
                    <label for="wti-pro-filterOff"><?php esc_html_e("Off - G, PG, PG-13, and R (no nudity)", "wpdiscuz"); ?></label>
                </div>
                <div class="wpd-radio">
                    <input type="radio" disabled value="low" id="wti-pro-filterLow"/>
                    <label for="wti-pro-filterLow" class="wpd-radio-circle"></label>
                    <label for="wti-pro-filterLow"><?php esc_html_e("Low - G, PG, and PG-13", "wpdiscuz"); ?></label>
                </div>
                <div class="wpd-radio">
                    <input type="radio" disabled value="medium" id="wti-pro-filterMedium"/>
                    <label for="wti-pro-filterMedium" class="wpd-radio-circle"></label>
                    <label for="wti-pro-filterMedium"><?php esc_html_e("Medium - G and PG", "wpdiscuz"); ?></label>
                </div>
                <div class="wpd-radio">
                    <input type="radio" disabled value="high" id="wti-pro-filterHigh"/>
                    <label for="wti-pro-filterHigh" class="wpd-radio-circle"></label>
                    <label for="wti-pro-filterHigh"><?php esc_html_e("High - G", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: limit -->
        <div class="wpd-opt-row" data-wpd-opt="limit">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Limit GIFs on gif picker popup window", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="10" max="50" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: playOnLoad -->
        <div class="wpd-opt-row" data-wpd-opt="playOnLoad">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Autoplay GIF animations on comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wti-pro-playOnLoad" checked/>
                    <label for="wti-pro-playOnLoad"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: allowedForms -->
        <div class="wpd-opt-row" data-wpd-opt="allowedForms">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow GIFs for Comment Forms", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php
                $wtiForms = get_posts(["numberposts" => -1, "post_type" => "wpdiscuz_form", "post_status" => "publish"]);
                foreach ($wtiForms as $wtiForm) : ?>
                <div class="wpd-mublock-inline wpd-mublock-full">
                    <input type="checkbox" disabled value="<?php echo esc_attr($wtiForm->ID); ?>" id="wti-pro-form<?php echo esc_attr($wtiForm->ID); ?>" checked/>
                    <label for="wti-pro-form<?php echo esc_attr($wtiForm->ID); ?>" class="wpd-check-label"><?php echo $wtiForm->post_title ? esc_html($wtiForm->post_title) : esc_html__("no title", "wpdiscuz") . " ( ID : " . esc_html($wtiForm->ID) . " )"; ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: allowedUserRoles -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="allowedUserRoles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow user roles to embed GIFs in comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) : ?>
                <div class="wpd-mublock-inline wpd-mublock-wide">
                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" id="wti-pro-role-<?php echo esc_attr($role); ?>" checked/>
                    <label for="wti-pro-role-<?php echo esc_attr($role); ?>"><?php echo esc_html($info["name"]); ?></label>
                </div>
                <?php endforeach; ?>
                <div class="wpd-mublock-inline wpd-mublock-wide">
                    <input type="checkbox" disabled value="1" id="wti-pro-guest"/>
                    <label for="wti-pro-guest"><?php esc_html_e("Guest", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-tenor-integration/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Tenor GIFs Integration Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
