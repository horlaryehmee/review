<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-awards"></span>
            <?php esc_html_e("myCRED Integration Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Integrates myCRED Badges and Ranks into the wpDiscuz comment section and converts comment votes and post ratings into myCRED points. Members earn or lose points for liking and disliking comments, and comment authors receive separate point rewards. Post ratings also generate myCRED events for both the rater and the post author. Earned badges and ranks are displayed under the comment author avatar.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Settings location notice -->
        <div class="wmi-notice">
            <span class="dashicons dashicons-warning wmi-notice-icon"></span>
            <div>
                <strong class="wmi-notice-title"><?php esc_html_e("Settings location: myCRED \u{2192} Hooks", "wpdiscuz"); ?></strong>
                <span class="wmi-notice-body"><?php esc_html_e("After activating this addon, configure it from the myCRED \u{2192} Hooks page in your WordPress admin — not from wpDiscuz. The fields below are a preview of what you can control.", "wpdiscuz"); ?></span>
            </div>
        </div>

        <!-- Section: Awarded Points for comment Like / Dislike -->
        <div class="wpd-opt-row">
            <div class="wpd-opt-name wmi-section-name">
                <label>
                    <span class="dashicons dashicons-thumbs-up"></span>
                    <?php esc_html_e("Awarded Points for Comment Like / Dislike", "wpdiscuz"); ?>
                </label>
            </div>
        </div>

        <!-- Option start: vote_member -->
        <div class="wpd-opt-row" data-wpd-opt="vote_member">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Member Up / Down", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Points awarded to the member who casts a like or dislike.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="0" size="8" class="wmi-points-input"/>
                <input type="text" disabled value="0" size="8"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: vote_author -->
        <div class="wpd-opt-row" data-wpd-opt="vote_author">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment Author Up / Down", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Points awarded to the comment author when their comment is liked or disliked.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="1" size="8" class="wmi-points-input"/>
                <input type="text" disabled value="-1" size="8"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Section: Awarded Points for rating a post -->
        <div class="wpd-opt-row">
            <div class="wpd-opt-name wmi-section-name">
                <label>
                    <span class="dashicons dashicons-star-filled"></span>
                    <?php esc_html_e("Awarded Points for Rating a Post", "wpdiscuz"); ?>
                </label>
            </div>
        </div>

        <!-- Option start: post_rating_member -->
        <div class="wpd-opt-row" data-wpd-opt="post_rating_member">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Member", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Points awarded to the member who rates a post.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="1" size="8"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: post_rating_author -->
        <div class="wpd-opt-row" data-wpd-opt="post_rating_author">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Author", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Points awarded to the post author when their post is rated.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="1" size="8"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Section: Comment Template -->
        <div class="wpd-opt-row">
            <div class="wpd-opt-name wmi-section-name">
                <label>
                    <span class="dashicons dashicons-admin-comments"></span>
                    <?php esc_html_e("Comment Template", "wpdiscuz"); ?>
                </label>
            </div>
        </div>

        <!-- Option start: show_badges -->
        <div class="wpd-opt-row" data-wpd-opt="show_badges">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display earned Badges under comment author avatar", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wmi-pro-showBadges" checked/>
                    <label for="wmi-pro-showBadges"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: show_ranks -->
        <div class="wpd-opt-row" data-wpd-opt="show_ranks">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display earned Ranks under comment author avatar", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wmi-pro-showRanks" checked/>
                    <label for="wmi-pro-showRanks"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: show_points -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="show_points">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display earned Points under comment author avatar", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wmi-pro-showPoints"/>
                    <label for="wmi-pro-showPoints"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-mycred/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get myCRED Integration Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
