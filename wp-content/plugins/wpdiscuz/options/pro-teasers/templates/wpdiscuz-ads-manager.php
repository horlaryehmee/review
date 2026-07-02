<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-megaphone"></span>
            <?php esc_html_e("Ads Manager Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("A full-featured advertising toolkit for your comment section. Manage ads and banners with fine-grained control over locations, post types, user roles, and scheduling — all from the wpDiscuz settings panel.", "wpdiscuz"); ?><br><br>
                <?php esc_html_e("Display ads and banners inside your comment section. Ads are managed as a custom post type with content, date range, target post types, excluded posts, and role-based visibility. Banner groups define where and how often ads appear across five locations: above/below the comment form, above/below the comment list, and between comments or replies. A built-in caching layer with configurable expiry keeps frontend performance fast, with manual cache reset controls for both ads and banners.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: wamIsDisplayOnReplies -->
        <div class="wpd-opt-row" data-wpd-opt="wamIsDisplayOnReplies">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display ads between replies", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This option is related to the 'Comment list' location in Banner settings.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wam-pro-isDisplayOnReplies" checked/>
                    <label for="wam-pro-isDisplayOnReplies"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wamIsCachingDisabled -->
        <div class="wpd-opt-row" data-wpd-opt="wamIsCachingDisabled">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Disable caching", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("When enabled, ads and banners will always be fetched fresh from the database on every page load.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wam-pro-isCachingDisabled"/>
                    <label for="wam-pro-isCachingDisabled"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wamCacheExpireTime -->
        <div class="wpd-opt-row" data-wpd-opt="wamCacheExpireTime">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Set cache expire time for", "wpdiscuz"); ?></label>
                <p class="wpd-desc"></p>
            </div>
            <div class="wpd-opt-input">
                <select id="wam-pro-cacheExpireTime">
                    <option value="1"><?php esc_html_e("1 hour", "wpdiscuz"); ?></option>
                    <option value="3"><?php esc_html_e("3 hours", "wpdiscuz"); ?></option>
                    <option value="6"><?php esc_html_e("6 hours", "wpdiscuz"); ?></option>
                    <option value="12"><?php esc_html_e("12 hours", "wpdiscuz"); ?></option>
                    <option value="24" selected><?php esc_html_e("1 day", "wpdiscuz"); ?></option>
                    <option value="48"><?php esc_html_e("2 days", "wpdiscuz"); ?></option>
                    <option value="72" ><?php esc_html_e("3 days", "wpdiscuz"); ?></option>
                    <option value="168"><?php esc_html_e("1 week", "wpdiscuz"); ?></option>
                </select>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wamResetCache -->
        <div class="wpd-opt-row" data-wpd-opt="wamResetCache">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Reset ads cache", "wpdiscuz"); ?></label>
                <p class="wpd-desc"></p>
            </div>
            <div class="wpd-opt-input">
                <a href="" class="button button-secondary wam-pro-cache-btn" class="wam-pro-cache-btn"><?php esc_html_e("Reset ads cache", "wpdiscuz"); ?></a>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wamResetBannersCache -->
        <div class="wpd-opt-row" data-wpd-opt="wamResetBannersCache">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Reset banners cache", "wpdiscuz"); ?></label>
                <p class="wpd-desc"></p>
            </div>
            <div class="wpd-opt-input">
                <a href="" class="button button-secondary wam-pro-cache-btn" class="wam-pro-cache-btn"><?php esc_html_e("Reset banners cache", "wpdiscuz"); ?></a>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-ads-manager/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Ads Manager Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
