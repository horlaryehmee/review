<?php

if (!defined("ABSPATH")) {
    exit();
}

$allPostTypes = get_post_types(["public" => true], "objects");
$commentPostTypes = array_filter($allPostTypes, function ($pt) {
    return post_type_supports($pt->name, "comments");
});

$defaultExcludedTaxonomies = [
    'post_format',
    'product_visibility',
    'product_shipping_class',
    'pos_product_visibility',
];

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-star-filled"></span>
            <?php esc_html_e("Reviews Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Turn wpDiscuz comments into a fully featured review system. Collect star ratings on a 5-point or 10-point scale with optional half-steps, display aggregated averages in multiple layouts (distribution chart, numeric, compact, pill, or stars only), filter the comment thread by rating, and output AggregateRating JSON-LD structured data compatible with Yoast SEO and Rank Math.", "wpdiscuz"); ?>
            </div>
        </div>

        <div class="wr-settings-accordion">

            <!-- ═══════════════════════════════════════════════════════════ -->
            <!-- SHORTCODES                                                  -->
            <!-- ═══════════════════════════════════════════════════════════ -->
            <div class="wr-accordion-item wr-accordion-current">
                <div class="wr-accordion-title" data-wr-selector="wr-section-shortcodes">
                    <div class="wr-accordion-title-text">
                        <span class="dashicons dashicons-shortcode"></span> <?php esc_html_e("Shortcodes", "wpdiscuz"); ?>
                    </div>
                </div>
                <div class="wr-accordion-content">

                    <div class="wpd-opt-row">
                        <div class="wpd-opt-intro">

                            <!-- [wpdiscuz_reviews] -->
                            <div class="wr-shortcode-item">
                                <div class="wr-shortcode-title">
                                    <span class="dashicons dashicons-shortcode"></span>
                                    <?php printf(__("Shortcode: %s", "wpdiscuz"), '<code style="color:#07B290;">[wpdiscuz_reviews]</code>'); ?>
                                </div>
                                <div class="wr-shortcode-body">
                                    <?php esc_html_e("Use the shortcode above to display a list of reviews anywhere on your site.", "wpdiscuz"); ?>
                                    <br>
                                    <div><?php esc_html_e("Available attributes are:", "wpdiscuz"); ?></div>
                                    <ul class="wr-shortcode-attr-list">
                                        <li><code style="color:#07B290;"><strong>post_id</strong></code> <?php esc_html_e("Post ID to load reviews from (integer). Omit to query all posts; defaults to the current post when used inside a post template.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>number</strong></code> <span class="wr-shortcode-pill">default: 10</span> <?php esc_html_e("Number of reviews to display (integer)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>author__in</strong></code> <?php esc_html_e("Comma-separated user IDs to filter reviews by author. Omit to include all authors.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>orderby</strong></code> <span class="wr-shortcode-pill">default: rating</span> <?php esc_html_e("Field to sort reviews by. Available options: rating, comment_date, comment_ID.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>order</strong></code> <span class="wr-shortcode-pill">default: desc</span> <?php esc_html_e("Sort order: asc or desc.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_avatar</strong></code> <span class="wr-shortcode-pill">default: true</span> <?php esc_html_e("Show reviewer avatars (true/false)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>avatar_size</strong></code> <span class="wr-shortcode-pill">default: 40</span> <?php esc_html_e("Avatar size in pixels (integer)", "wpdiscuz"); ?></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- [wpdiscuz_reviews_top_rated] -->
                            <div class="wr-shortcode-item">
                                <div class="wr-shortcode-title">
                                    <span class="dashicons dashicons-shortcode"></span>
                                    <?php printf(__("Shortcode: %s", "wpdiscuz"), '<code style="color:#07B290;">[wpdiscuz_reviews_top_rated]</code>'); ?>
                                </div>
                                <div class="wr-shortcode-body">
                                    <?php esc_html_e("Use the shortcode above to display a list of top-rated posts anywhere on your site.", "wpdiscuz"); ?>
                                    <br>
                                    <div><?php esc_html_e("Available attributes are:", "wpdiscuz"); ?></div>
                                    <ul class="wr-shortcode-attr-list">
                                        <li><code style="color:#07B290;"><strong>number</strong></code> <span class="wr-shortcode-pill">default: 5</span> <?php esc_html_e("Number of posts to display (integer, 1–50)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>post_type</strong></code> <?php esc_html_e("Comma-separated post type slugs to include. Omit to use all allowed post types.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>min_rating</strong></code> <span class="wr-shortcode-pill">default: 0</span> <?php esc_html_e("Minimum average rating a post must have to appear (number)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>min_reviews</strong></code> <span class="wr-shortcode-pill">default: 1</span> <?php esc_html_e("Minimum number of approved reviews a post must have to appear (integer)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_rating</strong></code> <span class="wr-shortcode-pill">default: true</span> <?php esc_html_e("Show the numeric average rating next to each post (true/false)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_count</strong></code> <span class="wr-shortcode-pill">default: true</span> <?php esc_html_e("Show the review count next to each post (true/false)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_thumbnail</strong></code> <span class="wr-shortcode-pill">default: true</span> <?php esc_html_e("Show the post thumbnail (true/false)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_date</strong></code> <span class="wr-shortcode-pill">default: false</span> <?php esc_html_e("Show the post publish date next to each entry (true/false)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_excerpt</strong></code> <span class="wr-shortcode-pill">default: false</span> <?php esc_html_e("Show the post excerpt below each entry (true/false)", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>order</strong></code> <span class="wr-shortcode-pill">default: desc</span> <?php esc_html_e("Sort order: asc or desc.", "wpdiscuz"); ?></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- [wpdiscuz_reviews_avg] -->
                            <div class="wr-shortcode-item">
                                <div class="wr-shortcode-title">
                                    <span class="dashicons dashicons-shortcode"></span>
                                    <?php printf(__("Shortcode: %s", "wpdiscuz"), '<code style="color:#07B290;">[wpdiscuz_reviews_avg]</code>'); ?>
                                </div>
                                <div class="wr-shortcode-body">
                                    <?php esc_html_e("Use the shortcode above to embed the average rating widget anywhere.", "wpdiscuz"); ?>
                                    <br>
                                    <div><?php esc_html_e("Available attributes are:", "wpdiscuz"); ?></div>
                                    <ul class="wr-shortcode-attr-list">
                                        <li><code style="color:#07B290;"><strong>post_id</strong></code> <?php esc_html_e("Post ID to show the average for (integer). Defaults to the current post.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>mode</strong></code> <?php esc_html_e("Display mode override (defaults to global setting). Options: distribution, numeric, compact, pill, icons.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>show_count</strong></code> <?php esc_html_e("Show the review count (true/false). Defaults to the global setting.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>min_reviews</strong></code> <?php esc_html_e("Minimum approved reviews before the widget is visible (integer). Defaults to the global setting.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>singular_text</strong></code> <?php esc_html_e("Text for exactly 1 review. Use %d as placeholder for the number.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>plural_text</strong></code> <?php esc_html_e("Text for 2+ reviews. Use %d as placeholder for the number.", "wpdiscuz"); ?></li>
                                        <li><code style="color:#07B290;"><strong>star_size</strong></code> <?php esc_html_e("Star size in pixels for this instance (integer, 12–64)", "wpdiscuz"); ?></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div><!-- /Shortcodes -->

            <!-- ═══════════════════════════════════════════════════════════ -->
            <!-- APPEARANCE                                                  -->
            <!-- ═══════════════════════════════════════════════════════════ -->
            <div class="wr-accordion-item wr-accordion-current">
                <div class="wr-accordion-title" data-wr-selector="wr-section-appearance">
                    <div class="wr-accordion-title-text">
                        <span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e("Appearance", "wpdiscuz"); ?>
                    </div>
                </div>
                <div class="wr-accordion-content">

                    <!-- Option start: iconSize -->
                    <div class="wpd-opt-row" data-wpd-opt="iconSize">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Icon size", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Size of the rating icons in pixels (12–64). Applies to all icon contexts: comment form, comment list, and widget.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="12" max="64" value="20" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconFilledColor -->
                    <div class="wpd-opt-row" data-wpd-opt="iconFilledColor">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Filled icon color", "wpdiscuz"); ?></label>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="color" disabled value="#ffd700"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconHoverColor -->
                    <div class="wpd-opt-row" data-wpd-opt="iconHoverColor">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Hover icon color", "wpdiscuz"); ?></label>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="color" disabled value="#ffc200"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconEmptyColor -->
                    <div class="wpd-opt-row" data-wpd-opt="iconEmptyColor">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Empty icon color", "wpdiscuz"); ?></label>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="color" disabled value="#d3d3d3"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconFilledColorDark -->
                    <div class="wpd-opt-row" data-wpd-opt="iconFilledColorDark">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Filled icon color (dark mode)", "wpdiscuz"); ?></label>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="color" disabled value="#ffd700"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconHoverColorDark -->
                    <div class="wpd-opt-row" data-wpd-opt="iconHoverColorDark">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Hover icon color (dark mode)", "wpdiscuz"); ?></label>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="color" disabled value="#ffc200"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconEmptyColorDark -->
                    <div class="wpd-opt-row" data-wpd-opt="iconEmptyColorDark">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Empty icon color (dark mode)", "wpdiscuz"); ?></label>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="color" disabled value="#555555"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconGap -->
                    <div class="wpd-opt-row" data-wpd-opt="iconGap">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Icon gap", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Space between icons in pixels (0–16).", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="0" max="16" value="5" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: iconShape -->
                    <div class="wpd-opt-row" data-wpd-opt="iconShape">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Icon shape", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Choose the icon shape used for all rating icons across the frontend and the average widget.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <select disabled>
                                <option value="star-outline"><?php esc_html_e("Star (Outline)", "wpdiscuz"); ?></option>
                                <option value="star-filled" selected><?php esc_html_e("Star (Filled)", "wpdiscuz"); ?></option>
                                <option value="heart-outline"><?php esc_html_e("Heart (Outline)", "wpdiscuz"); ?></option>
                                <option value="heart-filled"><?php esc_html_e("Heart (Filled)", "wpdiscuz"); ?></option>
                                <option value="thumbsup-outline"><?php esc_html_e("Thumbs Up (Outline)", "wpdiscuz"); ?></option>
                                <option value="thumbsup-filled"><?php esc_html_e("Thumbs Up (Filled)", "wpdiscuz"); ?></option>
                            </select>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Preview: Star appearance -->
                    <div class="wpd-opt-row">
                        <div class="wpd-opt-input wpd-opt-input-full-row">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../assets/img/wr-stars-preview.jpg'); ?>" class="wpd-teaser-img" alt="<?php esc_attr_e('Star rating live preview', 'wpdiscuz'); ?>"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                </div>
            </div><!-- /Appearance -->

            <!-- ═══════════════════════════════════════════════════════════ -->
            <!-- BEHAVIOR                                                    -->
            <!-- ═══════════════════════════════════════════════════════════ -->
            <div class="wr-accordion-item wr-accordion-current">
                <div class="wr-accordion-title" data-wr-selector="wr-section-behavior">
                    <div class="wr-accordion-title-text">
                        <span class="dashicons dashicons-admin-settings"></span> <?php esc_html_e("Behavior", "wpdiscuz"); ?>
                    </div>
                </div>
                <div class="wr-accordion-content">

                    <!-- Option start: ratingScheme -->
                    <div class="wpd-opt-row" data-wpd-opt="ratingScheme">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Rating scheme", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("The rating scale is either 5-point or 10-point.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <select disabled>
                                <option value="5" selected><?php esc_html_e("5 points", "wpdiscuz"); ?></option>
                                <option value="10"><?php esc_html_e("10 points", "wpdiscuz"); ?></option>
                            </select>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: halfRatings -->
                    <div class="wpd-opt-row" data-wpd-opt="halfRatings">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Half-step ratings", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Allow users to select half-step values (e.g. 3.5). When disabled, only whole-number ratings are accepted.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-halfRatings" disabled value="1"/>
                                <label for="wr-pro-halfRatings"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showRatingLabels -->
                    <div class="wpd-opt-row" data-wpd-opt="showRatingLabels">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show rating label tooltips", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Show a text label (e.g. \"Good\", \"Excellent\") as a tooltip on each icon when hovering to select or edit a rating.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showRatingLabels" disabled value="1" checked/>
                                <label for="wr-pro-showRatingLabels"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: ratingLabels5 -->
                    <div class="wpd-opt-row" data-wpd-opt="ratingLabels5">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("5-point rating labels", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Tooltip text for each icon in the 5-point scheme (1 through 5).", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wr-pro-labels-grid">
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">1</span><input type="text" disabled value="<?php esc_attr_e("Terrible", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">2</span><input type="text" disabled value="<?php esc_attr_e("Poor", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">3</span><input type="text" disabled value="<?php esc_attr_e("Okay", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">4</span><input type="text" disabled value="<?php esc_attr_e("Good", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">5</span><input type="text" disabled value="<?php esc_attr_e("Excellent", "wpdiscuz"); ?>"/></div>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: ratingLabels10 -->
                    <div class="wpd-opt-row" data-wpd-opt="ratingLabels10">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("10-point rating labels", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Tooltip text for each icon in the 10-point scheme (1 through 10).", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wr-pro-labels-grid">
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">1</span><input type="text" disabled value="<?php esc_attr_e("Terrible", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">2</span><input type="text" disabled value="<?php esc_attr_e("Very Poor", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">3</span><input type="text" disabled value="<?php esc_attr_e("Poor", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">4</span><input type="text" disabled value="<?php esc_attr_e("Below Average", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">5</span><input type="text" disabled value="<?php esc_attr_e("Average", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">6</span><input type="text" disabled value="<?php esc_attr_e("Above Average", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">7</span><input type="text" disabled value="<?php esc_attr_e("Good", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">8</span><input type="text" disabled value="<?php esc_attr_e("Very Good", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">9</span><input type="text" disabled value="<?php esc_attr_e("Excellent", "wpdiscuz"); ?>"/></div>
                                <div class="wr-pro-label-row"><span class="wr-pro-label-num">10</span><input type="text" disabled value="<?php esc_attr_e("Outstanding", "wpdiscuz"); ?>"/></div>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: ratingRequired -->
                    <div class="wpd-opt-row" data-wpd-opt="ratingRequired">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Rating required", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("When enabled, eligible users must select a rating before their comment can be submitted.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-ratingRequired" disabled value="1"/>
                                <label for="wr-pro-ratingRequired"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: allowEditRating -->
                    <div class="wpd-opt-row" data-wpd-opt="allowEditRating">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Allow rating edit", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Allow users to edit their star rating after submitting a review.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-allowEditRating" disabled value="1" checked/>
                                <label for="wr-pro-allowEditRating"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: editWindowHours -->
                    <div class="wpd-opt-row" data-wpd-opt="editWindowHours">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Edit window (hours)", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("How many hours after submission a user can edit their rating. Set to 0 for no time limit.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="0" value="0" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showAverage -->
                    <div class="wpd-opt-row" data-wpd-opt="showAverage">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show average rating", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Show the average rating widget above or below the comment form.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showAverage" disabled value="1" checked/>
                                <label for="wr-pro-showAverage"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: averageDisplayMode -->
                    <div class="wpd-opt-row" data-wpd-opt="averageDisplayMode">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Average rating display mode", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Choose how the average rating is displayed: a full distribution chart, a centred numeric score, a compact inline row, a pill badge, or icons only.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <select disabled>
                                <option value="distribution" selected><?php esc_html_e("Distribution (rating + per-icon bars)", "wpdiscuz"); ?></option>
                                <option value="numeric"><?php esc_html_e("Numeric (large rating + icons)", "wpdiscuz"); ?></option>
                                <option value="compact"><?php esc_html_e("Compact (inline: rating · icons · count)", "wpdiscuz"); ?></option>
                                <option value="pill"><?php esc_html_e("Pill (★ 4.2 badge)", "wpdiscuz"); ?></option>
                                <option value="icons"><?php esc_html_e("Icons only", "wpdiscuz"); ?></option>
                            </select>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showReviewCount -->
                    <div class="wpd-opt-row" data-wpd-opt="showReviewCount">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show review count", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Show the number of reviews (\"X reviews\") in the average rating widget.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showReviewCount" disabled value="1" checked/>
                                <label for="wr-pro-showReviewCount"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Preview: Average display mode -->
                    <div class="wpd-opt-row">
                        <div class="wpd-opt-input wpd-opt-input-full-row">
                            <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../assets/img/wr-distribution-preview.jpg'); ?>" class="wpd-teaser-img" alt="<?php esc_attr_e('Average rating live preview', 'wpdiscuz'); ?>"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>

                    <!-- Option start: averageRatingLocation -->
                    <div class="wpd-opt-row" data-wpd-opt="averageRatingLocation">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Average rating location", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Display the average rating widget above or below the comment form.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <select disabled>
                                <option value="top"><?php esc_html_e("Above Form", "wpdiscuz"); ?></option>
                                <option value="bottom" selected><?php esc_html_e("Below Form", "wpdiscuz"); ?></option>
                            </select>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: minReviewsForAverage -->
                    <div class="wpd-opt-row" data-wpd-opt="minReviewsForAverage">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Minimum reviews to show average", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("The average score is hidden until this many approved reviews exist for the post.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="1" value="1" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showRatingOnComments -->
                    <div class="wpd-opt-row" data-wpd-opt="showRatingOnComments">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show rating on comments", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Inject the rating into each comment. Disable to store ratings and show the aggregate average without per-comment stars.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showRatingOnComments" disabled value="1" checked/>
                                <label for="wr-pro-showRatingOnComments"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: userRatingLocation -->
                    <div class="wpd-opt-row" data-wpd-opt="userRatingLocation">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("User rating location", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Display the user rating either above or below the comment text.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <select disabled>
                                <option value="top" selected><?php esc_html_e("Above Comment", "wpdiscuz"); ?></option>
                                <option value="bottom"><?php esc_html_e("Below Comment", "wpdiscuz"); ?></option>
                            </select>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: ratingInputLocation -->
                    <div class="wpd-opt-row" data-wpd-opt="ratingInputLocation">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Rating input location", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Display the rating input above or below the comment form.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <select disabled>
                                <option value="top" selected><?php esc_html_e("Above Form", "wpdiscuz"); ?></option>
                                <option value="bottom"><?php esc_html_e("Below Form", "wpdiscuz"); ?></option>
                            </select>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showReviewHeadline -->
                    <div class="wpd-opt-row" data-wpd-opt="showReviewHeadline">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show review headline", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Display the review headline below the rating icons.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showReviewHeadline" disabled value="1" checked/>
                                <label for="wr-pro-showReviewHeadline"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: headlineRequired -->
                    <div class="wpd-opt-row" data-wpd-opt="headlineRequired">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Review headline required", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("When enabled, users must fill in the review headline before submitting.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-headlineRequired" disabled value="1"/>
                                <label for="wr-pro-headlineRequired"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: headlineMinLength -->
                    <div class="wpd-opt-row" data-wpd-opt="headlineMinLength">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Headline minimum length", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Minimum number of characters required in the review headline. Set to 0 for no minimum.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="0" max="200" value="0" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: headlineMaxLength -->
                    <div class="wpd-opt-row" data-wpd-opt="headlineMaxLength">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Headline maximum length", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Maximum number of characters allowed in the review headline.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="1" max="200" value="75" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showFilterButton -->
                    <div class="wpd-opt-row" data-wpd-opt="showFilterButton">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show reviews filter button", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Show the reviews filter button in the thread filter bar, allowing users to filter and sort by rating.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showFilterButton" disabled value="1" checked/>
                                <label for="wr-pro-showFilterButton"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: enableReviewsTab -->
                    <div class="wpd-opt-row" data-wpd-opt="enableReviewsTab">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Enable reviews tab", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Show a \"Reviews\" tab in the \"My Content and Settings\" popup, listing the current user's submitted reviews.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-enableReviewsTab" disabled value="1" checked/>
                                <label for="wr-pro-enableReviewsTab"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: showVerifiedBadge -->
                    <div class="wpd-opt-row" data-wpd-opt="showVerifiedBadge">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Show verified purchase badge", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Show a \"Verified Purchase\" badge on reviews submitted by users who have purchased the product (WooCommerce only).", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-showVerifiedBadge" disabled value="1" checked/>
                                <label for="wr-pro-showVerifiedBadge"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                </div>
            </div><!-- /Behavior -->

            <!-- ═══════════════════════════════════════════════════════════ -->
            <!-- ACCESS                                                      -->
            <!-- ═══════════════════════════════════════════════════════════ -->
            <div class="wr-accordion-item wr-accordion-current">
                <div class="wr-accordion-title" data-wr-selector="wr-section-access">
                    <div class="wr-accordion-title-text">
                        <span class="dashicons dashicons-shield"></span> <?php esc_html_e("Access", "wpdiscuz"); ?>
                    </div>
                </div>
                <div class="wr-accordion-content">

                    <!-- Option start: minNumberOfComments -->
                    <div class="wpd-opt-row" data-wpd-opt="minNumberOfComments">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Minimum number of comments", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("The minimum number of comments a user must have to be able to add a review.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="number" min="0" value="0" disabled class="wpd-num-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: allowedRoles -->
                    <div class="wpd-opt-row" data-wpd-opt="allowedRoles">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Allowed roles", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("User roles that are allowed to add reviews.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <?php foreach (get_editable_roles() as $role => $info) { ?>
                                <div class="wpd-mublock-inline" style="width: 45%;">
                                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" checked style="margin:0; vertical-align: middle;"/>
                                    <label><?php echo esc_html($info["name"]); ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: allowedPostTypes -->
                    <div class="wpd-opt-row" data-wpd-opt="allowedPostTypes">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Allowed post types", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Post types eligible for reviews.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <?php foreach ($commentPostTypes as $postType) { ?>
                                <div class="wpd-mublock-inline" style="width: 45%;">
                                    <input type="checkbox" disabled value="<?php echo esc_attr($postType->name); ?>" checked style="margin:0; vertical-align: middle;"/>
                                    <label><?php echo esc_html($postType->labels->singular_name); ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: reviewGate -->
                    <div class="wpd-opt-row" data-wpd-opt="reviewGate">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Review gate", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Restrict who can leave a review per post type. \"Require approval\" means only users approved by the admin can submit.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <table class="wr-gate-posttypes-table">
                                <thead>
                                    <tr>
                                        <th><?php esc_html_e("Post type", "wpdiscuz"); ?></th>
                                        <th><?php esc_html_e("Gate", "wpdiscuz"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($commentPostTypes as $postType) { ?>
                                    <tr>
                                        <td>
                                            <?php echo esc_html($postType->labels->singular_name); ?>
                                            <code><?php echo esc_html($postType->name); ?></code>
                                        </td>
                                        <td>
                                            <select disabled>
                                                <option value="none"><?php esc_html_e("No gate", "wpdiscuz"); ?></option>
                                                <option value="require_approval"><?php esc_html_e("Require approval", "wpdiscuz"); ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Taxonomy include/exclude (flat, matching real plugin) -->
                    <?php foreach ($commentPostTypes as $postType) {
                        $taxonomies = get_object_taxonomies($postType->name, "objects");
                        foreach ($defaultExcludedTaxonomies as $excludedTaxonomy) {
                            unset($taxonomies[$excludedTaxonomy]);
                        }
                        if (empty($taxonomies)) {
                            continue;
                        }
                        $taxonomiesWithTerms = array_filter($taxonomies, function ($taxonomy) {
                            $terms = get_terms(["taxonomy" => $taxonomy->name, "hide_empty" => true, "number" => 1]);
                            return !empty($terms) && !is_wp_error($terms);
                        });
                        if (empty($taxonomiesWithTerms)) {
                            continue;
                        }
                    ?>
                    <div class="wpd-subtitle wr-postype-subtitle">
                        <h4><?php echo esc_html(sprintf(__("%s taxonomies", "wpdiscuz"), $postType->labels->singular_name)); ?></h4>
                    </div>
                    <?php foreach ($taxonomiesWithTerms as $taxonomy) { ?>
                    <div class="wpd-subtitle wr-subtitle">
                        <?php echo esc_html(sprintf(__("Include or Exclude %s", "wpdiscuz"), $taxonomy->label)); ?>
                    </div>
                    <!-- Option start: include -->
                    <div class="wpd-opt-row" data-wpd-opt="include<?php echo esc_attr($taxonomy->label); ?>">
                        <div class="wpd-opt-name">
                            <label><?php echo esc_html(sprintf(__("Include %s", "wpdiscuz"), $taxonomy->label)); ?></label>
                            <p class="wpd-desc"><?php printf(__("<strong>%s</strong> in these <strong>%s</strong> accept reviews.", "wpdiscuz"), esc_html($postType->labels->singular_name), esc_html(strtolower($taxonomy->label))); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="text" disabled class="wpd-teaser-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->
                    <!-- Option start: exclude -->
                    <div class="wpd-opt-row" data-wpd-opt="exclude<?php echo esc_attr($taxonomy->label); ?>">
                        <div class="wpd-opt-name">
                            <label><?php echo esc_html(sprintf(__("Exclude %s", "wpdiscuz"), $taxonomy->label)); ?></label>
                            <p class="wpd-desc"><?php printf(__("<strong>%s</strong> with any of these <strong>%s</strong> are excluded from reviews.", "wpdiscuz"), esc_html($postType->labels->singular_name), esc_html(strtolower($taxonomy->label))); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <input type="text" disabled class="wpd-teaser-input"/>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->
                    <?php } ?>
                    <?php } ?>

                </div>
            </div><!-- /Access -->

            <!-- ═══════════════════════════════════════════════════════════ -->
            <!-- STRUCTURED DATA (JSON-LD)                                  -->
            <!-- ═══════════════════════════════════════════════════════════ -->
            <div class="wr-accordion-item wr-accordion-current">
                <div class="wr-accordion-title" data-wr-selector="wr-section-jsonld">
                    <div class="wr-accordion-title-text">
                        <span class="dashicons dashicons-editor-code"></span> <?php esc_html_e("Structured Data (JSON-LD)", "wpdiscuz"); ?>
                    </div>
                </div>
                <div class="wr-accordion-content">

                    <datalist id="wr-jsonld-schema-types">
                        <option value="Article">
                        <option value="WebPage">
                        <option value="Product">
                        <option value="LocalBusiness">
                        <option value="Event">
                        <option value="Course">
                        <option value="Recipe">
                        <option value="SoftwareApplication">
                        <option value="FAQPage">
                        <option value="HowTo">
                        <option value="NewsArticle">
                        <option value="BlogPosting">
                    </datalist>

                    <!-- Option start: jsonLdEnabled -->
                    <div class="wpd-opt-row" data-wpd-opt="jsonLdEnabled">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Enable JSON-LD", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Output AggregateRating structured data in the page head on singular posts that have reviews.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <div class="wpd-switcher">
                                <input type="checkbox" id="wr-pro-jsonLdEnabled" disabled value="1" checked/>
                                <label for="wr-pro-jsonLdEnabled"></label>
                            </div>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: jsonLdPostTypes -->
                    <div class="wpd-opt-row" data-wpd-opt="jsonLdPostTypes">
                        <div class="wpd-opt-name">
                            <?php esc_html_e("Schema type per post type", "wpdiscuz"); ?>
                            <p class="wpd-desc"><?php esc_html_e("When Yoast SEO or Rank Math is active, AggregateRating is injected into their existing schema — no configuration needed. The table below is used only as a fallback when neither plugin is present. Leave a field blank to skip JSON-LD for that post type.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <table class="wr-jsonld-posttypes-table">
                                <thead>
                                    <tr>
                                        <th><?php esc_html_e("Post type", "wpdiscuz"); ?></th>
                                        <th><?php esc_html_e("Schema type", "wpdiscuz"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $schemaDefaults = ["post" => "Article", "page" => "WebPage", "product" => "Product"];
                                    foreach ($commentPostTypes as $postType) { ?>
                                    <tr>
                                        <td>
                                            <?php echo esc_html($postType->labels->singular_name); ?>
                                            <code><?php echo esc_html($postType->name); ?></code>
                                        </td>
                                        <td>
                                            <input type="text" disabled
                                                   value="<?php echo esc_attr($schemaDefaults[$postType->name] ?? ""); ?>"
                                                   list="wr-jsonld-schema-types"
                                                   placeholder="<?php esc_attr_e("e.g. Article", "wpdiscuz"); ?>"
                                                   class="wr-pro-schema-input"/>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                </div>
            </div><!-- /JSON-LD -->

            <!-- ═══════════════════════════════════════════════════════════ -->
            <!-- TOOLS                                                       -->
            <!-- ═══════════════════════════════════════════════════════════ -->
            <div class="wr-accordion-item wr-accordion-current">
                <div class="wr-accordion-title" data-wr-selector="wr-section-tools">
                    <div class="wr-accordion-title-text">
                        <span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e("Tools", "wpdiscuz"); ?>
                    </div>
                </div>
                <div class="wr-accordion-content">

                    <!-- Option start: rebuildAllRatings -->
                    <div class="wpd-opt-row" data-wpd-opt="rebuildAllRatings">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Rebuild All Ratings", "wpdiscuz"); ?></label>
                            <p class="wpd-desc"><?php esc_html_e("Re-scales all stored ratings to match the current rating scheme. Run this after changing the scheme.", "wpdiscuz"); ?></p>
                        </div>
                        <div class="wpd-opt-input">
                            <button type="button" disabled class="button button-secondary">
                                <?php esc_html_e("Rebuild All Ratings", "wpdiscuz"); ?>
                            </button>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                    <!-- Option start: syncWcRatings -->
                    <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="syncWcRatings">
                        <div class="wpd-opt-name">
                            <label><?php esc_html_e("Sync WooCommerce's Ratings", "wpdiscuz"); ?></label>
                            <p class="wpd-desc">
                                <?php esc_html_e("Imports existing WooCommerce product reviews into the addon.", "wpdiscuz"); ?>
                                <span class="wr-note wr-error"><?php esc_html_e("Guest reviews and reviews already imported are skipped.", "wpdiscuz"); ?></span>
                            </p>
                        </div>
                        <div class="wpd-opt-input">
                            <button type="button" disabled class="button button-secondary">
                                <?php esc_html_e("Sync WooCommerce's Ratings", "wpdiscuz"); ?>
                            </button>
                        </div>
                        <div class="wpd-opt-doc"></div>
                    </div>
                    <!-- Option end -->

                </div>
            </div><!-- /Tools -->

        </div><!-- .wr-settings-accordion -->

    </div><!-- .wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-reviews/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Reviews Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- .wpd-pro-teaser-wrap -->
