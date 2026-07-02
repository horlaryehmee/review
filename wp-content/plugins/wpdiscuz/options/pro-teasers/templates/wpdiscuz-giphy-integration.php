<?php

if (!defined("ABSPATH")) {
    exit();
}

$wgiLogoUrl = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img/giphy-logo.svg";

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-format-image"></span>
            <?php esc_html_e("GIPHY Integration Addon Settings", "wpdiscuz"); ?>
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
                <img src="<?php echo esc_url($wgiLogoUrl); ?>" class="wgi-pro-logo" alt="GIPHY"/>
                <?php esc_html_e("GIPHY is an online GIF database. Its main product is GIF Keyboard. GIPHY provides animated GIF images that users can embed in posts, messages, and in this case in comments. GIPHY is free.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: lang -->
        <div class="wpd-opt-row" data-wpd-opt="lang">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Language", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><a href="https://developers.giphy.com/docs/optional-settings#language-support" target="_blank"><?php esc_html_e("Supported Languages", "wpdiscuz"); ?></a></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="en" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: rating -->
        <div class="wpd-opt-row" data-wpd-opt="rating">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("GIF rating", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><a href="https://developers.giphy.com/docs/optional-settings/#rating" target="_blank"><?php esc_html_e("Content Rating", "wpdiscuz"); ?></a></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-radio">
                    <input type="radio" disabled value="g" checked id="wgi-pro-ratingG" class="rating"/>
                    <label for="wgi-pro-ratingG" class="wpd-radio-circle"></label>
                    <label for="wgi-pro-ratingG"><?php esc_html_e("G", "wpdiscuz"); ?></label>
                </div>
                <div class="wpd-radio">
                    <input type="radio" disabled value="pg" id="wgi-pro-ratingPG" class="rating"/>
                    <label for="wgi-pro-ratingPG" class="wpd-radio-circle"></label>
                    <label for="wgi-pro-ratingPG"><?php esc_html_e("PG", "wpdiscuz"); ?></label>
                </div>
                <div class="wpd-radio">
                    <input type="radio" disabled value="pg-13" id="wgi-pro-ratingPG13" class="rating"/>
                    <label for="wgi-pro-ratingPG13" class="wpd-radio-circle"></label>
                    <label for="wgi-pro-ratingPG13"><?php esc_html_e("PG-13", "wpdiscuz"); ?></label>
                </div>
                <div class="wpd-radio">
                    <input type="radio" disabled value="r" id="wgi-pro-ratingR" class="rating"/>
                    <label for="wgi-pro-ratingR" class="wpd-radio-circle"></label>
                    <label for="wgi-pro-ratingR"><?php esc_html_e("R", "wpdiscuz"); ?></label>
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
                    <input type="checkbox" disabled value="1" id="wgi-pro-playOnLoad" checked/>
                    <label for="wgi-pro-playOnLoad"></label>
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
                $wgiForms = get_posts(["numberposts" => -1, "post_type" => "wpdiscuz_form", "post_status" => "publish"]);
                foreach ($wgiForms as $wgiForm) : ?>
                <div class="wpd-mublock-inline wpd-mublock-full">
                    <input type="checkbox" disabled value="<?php echo esc_attr($wgiForm->ID); ?>" id="wgi-pro-form<?php echo esc_attr($wgiForm->ID); ?>" checked/>
                    <label for="wgi-pro-form<?php echo esc_attr($wgiForm->ID); ?>" class="wpd-check-label"><?php echo $wgiForm->post_title ? esc_html($wgiForm->post_title) : esc_html__("no title", "wpdiscuz") . " ( ID : " . esc_html($wgiForm->ID) . " )"; ?></label>
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
                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" id="wgi-pro-role-<?php echo esc_attr($role); ?>" checked/>
                    <label for="wgi-pro-role-<?php echo esc_attr($role); ?>"><?php echo esc_html($info["name"]); ?></label>
                </div>
                <?php endforeach; ?>
                <div class="wpd-mublock-inline wpd-mublock-wide">
                    <input type="checkbox" disabled value="1" id="wgi-pro-guest"/>
                    <label for="wgi-pro-guest"><?php esc_html_e("Guest", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-giphy/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get GIPHY Integration Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
