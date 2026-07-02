<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-heart"></span>
            <?php esc_html_e("Advanced Likers Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Extends comment voting with a detailed likers popup — shows avatars of users who voted on each comment, with a quick inline list and a full \"View all\" panel.", "wpdiscuz"); ?><br><br>
                <?php esc_html_e("Adds a reputation and badge system where comment authors earn tiered badges based on total likes received. Each level has a fully customizable icon, label, vote threshold, and color.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: wv_get_avatars -->
        <div class="wpd-opt-row" data-wpd-opt="wv_get_avatars">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display avatars on quick list of likers pop-up", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wv-pro-get-avatars" checked/>
                    <label for="wv-pro-get-avatars"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_real_time -->
        <div class="wpd-opt-row" data-wpd-opt="wv_real_time">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Real time", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wv-pro-real-time" checked/>
                    <label for="wv-pro-real-time"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_read_more -->
        <div class="wpd-opt-row" data-wpd-opt="wv_read_more">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("View all", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wv-pro-read-more" checked/>
                    <label for="wv-pro-read-more"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_read_more_get_avatar -->
        <div class="wpd-opt-row" data-wpd-opt="wv_read_more_get_avatar">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Display avatars on full likers list", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wv-pro-read-more-avatar" checked/>
                    <label for="wv-pro-read-more-avatar"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_count -->
        <div class="wpd-opt-row" data-wpd-opt="wv_count">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Max number of likers on quick pop-up window", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="8" min="1" max="25" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_count_all -->
        <div class="wpd-opt-row" data-wpd-opt="wv_count_all">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Max number of likers on pop-up window", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="8" min="1" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_level -->
        <div class="wpd-opt-row" data-wpd-opt="wv_level">
            <div class="wpd-opt-input wpd-opt-input-full-row">
                <h2 class="wv-pro-section-h2"><?php esc_html_e("Comment Author Rating and Badge", "wpdiscuz"); ?></h2>
                <hr/>
                <div class="wv-pro-levels-wrap">

                    <div class="wv_level_box">
                        <div class="wv-pro-center">
                            <span class="wv-icon-preview">
                                <i class="fas fa-user" style="color:#0CD85D;"></i>
                            </span>
                        </div>
                        <div>
                            <input disabled placeholder="<?php esc_attr_e("Total Votes", "wpdiscuz"); ?>" min="1" value="1" type="number"/>
                            <p class="wv-pro-votes-hint"><?php esc_html_e("Total count of votes", "wpdiscuz"); ?></p>
                        </div>
                        <div>
                            <input disabled placeholder="Badge Icon" value="fas fa-user" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <input disabled placeholder="Custom Label" value="<?php esc_attr_e("Member", "wpdiscuz"); ?>" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="wpd-color-wrap">
                                <span class="wpd-color-swatch" style="background-color:#0CD85D;"></span>
                                <input type="text" disabled value="#0CD85D"/>
                            </div>
                        </div>
                    </div>

                    <div class="wv_level_box">
                        <div class="wv-pro-center">
                            <span class="wv-icon-preview">
                                <i class="fas fa-star" style="color:#E5D600;"></i>
                            </span>
                        </div>
                        <div>
                            <input disabled placeholder="<?php esc_attr_e("Total Votes", "wpdiscuz"); ?>" min="1" value="10" type="number"/>
                            <p class="wv-pro-votes-hint"><?php esc_html_e("Total count of votes", "wpdiscuz"); ?></p>
                        </div>
                        <div>
                            <input disabled placeholder="Badge Icon" value="fas fa-star" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <input disabled placeholder="Custom Label" value="<?php esc_attr_e("Active Member", "wpdiscuz"); ?>" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="wpd-color-wrap">
                                <span class="wpd-color-swatch" style="background-color:#E5D600;"></span>
                                <input type="text" disabled value="#E5D600"/>
                            </div>
                        </div>
                    </div>

                    <div class="wv_level_box">
                        <div class="wv-pro-center">
                            <span class="wv-icon-preview">
                                <i class="fas fa-certificate" style="color:#FF812D;"></i>
                            </span>
                        </div>
                        <div>
                            <input disabled placeholder="<?php esc_attr_e("Total Votes", "wpdiscuz"); ?>" min="1" value="50" type="number"/>
                            <p class="wv-pro-votes-hint"><?php esc_html_e("Total count of votes", "wpdiscuz"); ?></p>
                        </div>
                        <div>
                            <input disabled placeholder="Badge Icon" value="fas fa-certificate" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <input disabled placeholder="Custom Label" value="<?php esc_attr_e("Trusted Member", "wpdiscuz"); ?>" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="wpd-color-wrap">
                                <span class="wpd-color-swatch" style="background-color:#FF812D;"></span>
                                <input type="text" disabled value="#FF812D"/>
                            </div>
                        </div>
                    </div>

                    <div class="wv_level_box">
                        <div class="wv-pro-center">
                            <span class="wv-icon-preview">
                                <i class="fas fa-shield-alt" style="color:#43A6DF;"></i>
                            </span>
                        </div>
                        <div>
                            <input disabled placeholder="<?php esc_attr_e("Total Votes", "wpdiscuz"); ?>" min="1" value="100" type="number"/>
                            <p class="wv-pro-votes-hint"><?php esc_html_e("Total count of votes", "wpdiscuz"); ?></p>
                        </div>
                        <div>
                            <input disabled placeholder="Badge Icon" value="fas fa-shield-alt" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <input disabled placeholder="Custom Label" value="<?php esc_attr_e("Noble Member", "wpdiscuz"); ?>" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="wpd-color-wrap">
                                <span class="wpd-color-swatch" style="background-color:#43A6DF;"></span>
                                <input type="text" disabled value="#43A6DF"/>
                            </div>
                        </div>
                    </div>

                    <div class="wv_level_box">
                        <div class="wv-pro-center">
                            <span class="wv-icon-preview">
                                <i class="fas fa-trophy" style="color:#E04A47;"></i>
                            </span>
                        </div>
                        <div>
                            <input disabled placeholder="<?php esc_attr_e("Total Votes", "wpdiscuz"); ?>" min="1" value="500" type="number"/>
                            <p class="wv-pro-votes-hint"><?php esc_html_e("Total count of votes", "wpdiscuz"); ?></p>
                        </div>
                        <div>
                            <input disabled placeholder="Badge Icon" value="fas fa-trophy" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <input disabled placeholder="Custom Label" value="<?php esc_attr_e("Famed Member", "wpdiscuz"); ?>" type="text"/>
                            <div class="wv-badges-inline">
                                <input type="checkbox" disabled checked/> <label><?php esc_html_e("Enable", "wpdiscuz"); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="wpd-color-wrap">
                                <span class="wpd-color-swatch" style="background-color:#E04A47;"></span>
                                <input type="text" disabled value="#E04A47"/>
                            </div>
                        </div>
                    </div>

                    <div class="wpd-clear"></div>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Subtitle: Background and Colors -->
        <div class="wpd-subtitle"><?php esc_html_e("Background and Colors", "wpdiscuz"); ?></div>

        <!-- Option start: wv_background_color -->
        <div class="wpd-opt-row" data-wpd-opt="wv_background_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Likers quick pop-up background color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#FAFAFA;"></span>
                    <input type="text" disabled value="#FAFAFA" style="background-color:#FAFAFA;"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_border_color -->
        <div class="wpd-opt-row" data-wpd-opt="wv_border_color">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Likers quick pop-up border color", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-color-wrap">
                    <span class="wpd-color-swatch" style="background-color:#AAAAAA;"></span>
                    <input type="text" disabled value="#AAAAAA" style="background-color:#AAAAAA;"/>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Subtitle: Front-end Phrases -->
        <div class="wpd-subtitle"><?php esc_html_e("Front-end Phrases", "wpdiscuz"); ?></div>

        <!-- Option start: wv_guests -->
        <div class="wpd-opt-row" data-wpd-opt="wv_guests">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Guests", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("Guests", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wv_view_all -->
        <div class="wpd-opt-row" data-wpd-opt="wv_view_all">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("View all", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="<?php esc_attr_e("View all", "wpdiscuz"); ?>" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: recountVotes -->
        <div class="wpd-opt-row" data-wpd-opt="recountVotes">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Recount user votes", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <button type="button" disabled class="button button-secondary"><?php esc_html_e("Recount user votes", "wpdiscuz"); ?></button>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-advanced-likers/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Advanced Likers Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
