<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-search"></span>
            <?php esc_html_e("Comment Search Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Adds an AJAX-powered search form to the comment section — results appear as you type, with no page reload. Supports three search modes: comment text, comment author name, and author email. Comes with full front-end customisation options for colors, backgrounds, borders, and phrases.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: display_form_for_guests -->
        <div class="wpd-opt-row" data-wpd-opt="display_form_for_guests">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display search form for guests", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpds-pro-display_form_for_guests" checked/>
                    <label for="wpds-pro-display_form_for_guests"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: display_setting -->
        <div class="wpd-opt-row" data-wpd-opt="display_setting">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display search setting button", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wpds-pro-display_setting" checked/>
                    <label for="wpds-pro-display_setting"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_available_fields -->
        <div class="wpd-opt-row" data-wpd-opt="search_available_fields">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search options", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (["all", "content", "author", "email", "custom_fields"] as $field) : ?>
                <div class="wpds-pro-fields-wrap">
                    <input type="checkbox" disabled value="<?php echo esc_attr($field); ?>" id="wpds-pro-field-<?php echo esc_attr($field); ?>" checked/>
                    <label for="wpds-pro-field-<?php echo esc_attr($field); ?>"><?php echo esc_html(ucfirst(str_replace("_", " ", $field))); ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_default_field -->
        <div class="wpd-opt-row" data-wpd-opt="search_default_field">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Default search field", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <select>
                    <?php foreach (["all", "content", "author", "email", "custom_fields"] as $field) : ?>
                    <option value="<?php echo esc_attr($field); ?>" <?php selected($field === "all"); ?>><?php echo esc_html(ucfirst(str_replace("_", " ", $field))); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_text_min_length -->
        <div class="wpd-opt-row" data-wpd-opt="search_text_min_length">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search text min length", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="3" min="0" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Search form style", "wpdiscuz"); ?></div>

        <!-- Option start: searched_data_bg -->
        <div class="wpd-opt-row" data-wpd-opt="searched_data_bg">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Searched data background", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#C4ECE4;"></span>
                    <input type="text" disabled value="#C4ECE4"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_icons_color -->
        <div class="wpd-opt-row" data-wpd-opt="search_icons_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search icons color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#00B38F;"></span>
                    <input type="text" disabled value="#00B38F"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_text_color -->
        <div class="wpd-opt-row" data-wpd-opt="search_text_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search form text color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#666666;"></span>
                    <input type="text" disabled value="#666666"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_bg_color -->
        <div class="wpd-opt-row" data-wpd-opt="search_bg_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search box background color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#FFFFFF; border:1px solid #ccc;"></span>
                    <input type="text" disabled value="#FFFFFF"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_box_border_color -->
        <div class="wpd-opt-row" data-wpd-opt="search_box_border_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search box border color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#CDCDCD;"></span>
                    <input type="text" disabled value="#CDCDCD"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Dialog style", "wpdiscuz"); ?></div>

        <!-- Option start: dialog_text_color -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_text_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Dialog text color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#666666;"></span>
                    <input type="text" disabled value="#666666"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_bg_color -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_bg_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Dialog background color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#FFFFFF; border:1px solid #ccc;"></span>
                    <input type="text" disabled value="#FFFFFF"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_hover_color -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_hover_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Dialog item hover color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#EEEEEE;"></span>
                    <input type="text" disabled value="#EEEEEE"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Pagination style", "wpdiscuz"); ?></div>

        <!-- Option start: pagination_text_color -->
        <div class="wpd-opt-row" data-wpd-opt="pagination_text_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pagination text color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#666666;"></span>
                    <input type="text" disabled value="#666666"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: pagination_item_bg_color -->
        <div class="wpd-opt-row" data-wpd-opt="pagination_item_bg_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Pagination item background color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#C4ECE4;"></span>
                    <input type="text" disabled value="#C4ECE4"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Widget and Shortcode Styles", "wpdiscuz"); ?></div>

        <!-- Option start: wpdiscuz_search_shortcode -->
        <div class="wpd-opt-row" data-wpd-opt="wpdiscuz_search_shortcode">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Shortcode", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="[commSearch]" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_post_letters_count -->
        <div class="wpd-opt-row" data-wpd-opt="widget_post_letters_count">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment letters count", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="60" min="0" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_post_content_color -->
        <div class="wpd-opt-row" data-wpd-opt="widget_post_content_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Comment content color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#686868;"></span>
                    <input type="text" disabled value="#686868"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_post_title_color -->
        <div class="wpd-opt-row" data-wpd-opt="widget_post_title_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Post title color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#00B490;"></span>
                    <input type="text" disabled value="#00B490"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_post_author_date_color -->
        <div class="wpd-opt-row" data-wpd-opt="widget_post_author_date_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Post author and date color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#CCCCCC;"></span>
                    <input type="text" disabled value="#CCC"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_loadmore_bg -->
        <div class="wpd-opt-row" data-wpd-opt="widget_loadmore_bg">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Load more button background color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#DAF3EE;"></span>
                    <input type="text" disabled value="#DAF3EE"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_loadmore_text -->
        <div class="wpd-opt-row" data-wpd-opt="widget_loadmore_text">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Load more button text color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#666666;"></span>
                    <input type="text" disabled value="#666666"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: widget_loadmore_border -->
        <div class="wpd-opt-row" data-wpd-opt="widget_loadmore_border">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Load more button border color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#CCCCCC;"></span>
                    <input type="text" disabled value="#CCCCCC"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Search Phrases", "wpdiscuz"); ?></div>

        <!-- Option start: search_result_phrase -->
        <div class="wpd-opt-row" data-wpd-opt="search_result_phrase">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search result", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Search result", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_no_result_phrase -->
        <div class="wpd-opt-row" data-wpd-opt="search_no_result_phrase">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("No comment found", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("No comment found", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: search_placeholder -->
        <div class="wpd-opt-row" data-wpd-opt="search_placeholder">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Search form placeholder", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Comment search...", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_search_by_all -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_search_by_all">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("All", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("All", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_search_by_content -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_search_by_content">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Content", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Content", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_search_by_author -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_search_by_author">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Author", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Author", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_search_by_email -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_search_by_email">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("E-mail", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("E-mail", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: dialog_search_by_custom_fields -->
        <div class="wpd-opt-row" data-wpd-opt="dialog_search_by_custom_fields">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Custom Fields", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Custom Fields", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/wpdiscuz-comment-search/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Comment Search Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
