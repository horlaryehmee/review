<?php

if (!defined("ABSPATH")) {
    exit();
}

$widgVotesStyleUrl  = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img/widg-votes-style.png";
$widgAvatarStyleUrl = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img/widg-avatar-style.png";

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-welcome-widgets-menus"></span>
            <?php esc_html_e("Widgets Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Adds sidebar widgets displaying Most Voted Comments, Most Active Threads, Most Commented Posts, Popular Comment Authors, Recent Comments, and Top Rated Posts — each with configurable counts, date intervals, ordering, and style options.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: wpdiscuz_widget_post_title_cutting -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_post_title_cutting">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable post title shortening", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("If this option is enabled all titles will be cut with below defined number of words", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="widg-pro-post-title-cutting" checked/>
                    <label for="widg-pro-post-title-cutting"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widgets_post_title_word_count -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widgets_post_title_word_count">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("number of words in shortened titles", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="5" min="0" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widgets_post_content_word_count -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widgets_post_content_word_count">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Number of words in comment excerpt", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="0" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: mvc_displaying_style -->
        <div class="wpd-opt-row" data-wpd-opt="mvc_displaying_style">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Most Voted Comments Style", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <label class="wpdiscuz-widget-votes-style-label"><img src="<?php echo esc_url($widgVotesStyleUrl); ?>" class="widg-pro-mvc-img" alt="votes style"></label><br><br>
                <label class="wpdiscuz-widget-votes-style-label"><img src="<?php echo esc_url($widgAvatarStyleUrl); ?>" class="widg-pro-avatar-img" alt="avatar style"></label><br><br>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wc_widget_background_color -->
        <div class="wpd-opt-row" data-wpd-opt="wc_widget_background_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Widget Background Color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:rgba(255,255,255,0); border:1px solid #ccc;"></span>
                    <input type="text" disabled value="rgba(255, 255, 255, 0)" style="background-color:rgba(255,255,255,0);"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wc_icons_background_color -->
        <div class="wpd-opt-row" data-wpd-opt="wc_icons_background_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Items Icon Background Color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#777777;"></span>
                    <input type="text" disabled value="#777" style="background-color:#777777;"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wc_icons_color -->
        <div class="wpd-opt-row" data-wpd-opt="wc_icons_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Tab Icons Color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#777777;"></span>
                    <input type="text" disabled value="#777" style="background-color:#777777;"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_icon_circle -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_icon_circle">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Items Icon/Avatar Circle", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="widg-pro-icon-circle" checked/>
                    <label for="widg-pro-icon-circle"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_max_width -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_max_width">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Widget max width", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="550" min="0" class="wpd-num-input"/>&nbsp; px
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_lmargin -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_lmargin">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Widget left margin", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="0" class="wpd-num-input"/>&nbsp; px
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_rmargin -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_rmargin">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Widget right margin", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="0" class="wpd-num-input"/>&nbsp; px
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_lpadding -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_lpadding">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Widget left padding", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="0" class="wpd-num-input"/>&nbsp; px
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_rpadding -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_rpadding">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Widget right padding", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="10" min="0" class="wpd-num-input"/>&nbsp; px
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: excluded_user_roles -->
        <div class="wpd-opt-row" data-wpd-opt="excluded_user_roles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Exclude user roles", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) : ?>
                <div class="wpd-mublock-inline">
                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" id="widg-pro-excl-role-<?php echo esc_attr($role); ?>"/>
                    <label for="widg-pro-excl-role-<?php echo esc_attr($role); ?>" class="wpd-check-label"><?php echo esc_html(ucfirst($role)); ?></label>
                </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: enable_for_post_types -->
        <div class="wpd-opt-row" data-wpd-opt="enable_for_post_types">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display comments of certain post types", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e('This option is only for "Most Commented Posts" tab', "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_post_types() as $posttype) :
                    if (!post_type_supports($posttype, "comments")) continue; ?>
                <div class="wpd-mublock-inline">
                    <input type="checkbox" disabled value="<?php echo esc_attr($posttype); ?>" id="widg-pro-pt-<?php echo esc_attr($posttype); ?>" checked/>
                    <label for="widg-pro-pt-<?php echo esc_attr($posttype); ?>" class="wpd-check-label"><?php echo esc_html($posttype); ?></label>
                </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_displaying_guests -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_displaying_guests">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Show guest commenters", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="widg-pro-displaying-guests" checked/>
                    <label for="widg-pro-displaying-guests"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_author_link -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_author_link">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable user link for all users", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="widg-pro-author-link" checked/>
                    <label for="widg-pro-author-link"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_slider_enable -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_slider_enable">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable slider in single tab", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("You can display comments in slider when in each widget enabled only one tab", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="widg-pro-slider-enable" checked/>
                    <label for="widg-pro-slider-enable"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_theme_title_struct -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_widget_theme_title_struct">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Use theme's widget title structure", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("This option can help you solve problems with theme widget title structure. If your theme widget title structure does not match with our plugin's title structure you should uncheck this option", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="widg-pro-theme-title-struct" checked/>
                    <label for="widg-pro-theme-title-struct"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpdiscuz_widget_custom_css -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="wpdiscuz_widget_custom_css">
            <div class="wpd-opt-name widg-pro-opt-name-narrow">
                <label><?php esc_html_e("Widget custom CSS", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input widg-pro-opt-input-wide">
                <textarea disabled class="regular-text widg-pro-custom-css-ta" placeholder="">#widget-comments-container{font-size:100%}</textarea>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-widgets/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Widgets Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
