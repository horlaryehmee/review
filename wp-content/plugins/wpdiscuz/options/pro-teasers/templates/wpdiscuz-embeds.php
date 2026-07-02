<?php

if (!defined("ABSPATH")) {
    exit();
}

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-admin-links"></span>
            <?php esc_html_e("Embeds Addon Settings", "wpdiscuz"); ?>
            <span class="wpd-pro-badge"><?php esc_html_e("PRO", "wpdiscuz"); ?></span>
        </span>
        <span class="wpd-pro-teaser-header-right">
            <span class="wpd-pro-toggle-icon">&#9650;</span>
        </span>
    </div>

    <div class="wpd-pro-teaser-body">

        <!-- Option start: playerWidth -->
        <div class="wpd-opt-row" data-wpd-opt="playerWidth">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Embed video player width", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <span>
                    <input type="text" disabled value="480" class="wpd-num-input-sm"/>
                    <select class="we-pro-dim-select">
                        <option value="px" selected>px</option>
                        <option value="%">%</option>
                    </select>
                </span>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: playerHeight -->
        <div class="wpd-opt-row" data-wpd-opt="playerHeight">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Embed video player height", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <span>
                    <input type="text" disabled value="270" class="wpd-num-input-sm"/>
                    <select class="we-pro-dim-select">
                        <option value="px" selected>px</option>
                        <option value="%">%</option>
                    </select>
                </span>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: embedsPerComment -->
        <div class="wpd-opt-row" data-wpd-opt="embedsPerComment">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Maximum number of embedded content per comment", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Leave empty or set this option value 0 to remove the limit", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="5" min="0" class="wpd-num-input"/>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: embedWebsites -->
        <div class="wpd-opt-row" data-wpd-opt="embedWebsites">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Embed Website URLs", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="we-pro-embedWebsites"/>
                    <label for="we-pro-embedWebsites"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: embedInDashboard -->
        <div class="wpd-opt-row" data-wpd-opt="embedInDashboard">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Embed in dashboard comments", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="we-pro-embedInDashboard"/>
                    <label for="we-pro-embedInDashboard"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: embedInMobile -->
        <div class="wpd-opt-row" data-wpd-opt="embedInMobile">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Embed in mobile", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="we-pro-embedInMobile"/>
                    <label for="we-pro-embedInMobile"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: isGuestAllowed -->
        <div class="wpd-opt-row" data-wpd-opt="isGuestAllowed">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow embedding for guests", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="we-pro-isGuestAllowed" checked/>
                    <label for="we-pro-isGuestAllowed"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: allowedUserRoles -->
        <div class="wpd-opt-row" data-wpd-opt="allowedUserRoles">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow embedding for user roles", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Embedding will work for checked user roles only", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach (get_editable_roles() as $role => $info) : ?>
                <div class="wpd-mublock-inline wpd-mublock-wide">
                    <input type="checkbox" disabled value="<?php echo esc_attr($role); ?>" id="we-pro-role-<?php echo esc_attr($role); ?>" checked/>
                    <label for="we-pro-role-<?php echo esc_attr($role); ?>"><?php echo esc_html($info["name"]); ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: allowedForms -->
        <div class="wpd-opt-row" data-wpd-opt="allowedForms">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Allow embedding for comment forms", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("You can manage comment forms and fields in Dashboard > Comments > Forms admin page.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php
                $forms = get_posts(["numberposts" => -1, "post_type" => "wpdiscuz_form", "post_status" => "publish"]);
                foreach ($forms as $form) : ?>
                <div class="wpd-mublock-inline wpd-mublock-full">
                    <input type="checkbox" disabled value="<?php echo esc_attr($form->ID); ?>" id="we-pro-form<?php echo esc_attr($form->ID); ?>" checked/>
                    <label for="we-pro-form<?php echo esc_attr($form->ID); ?>" class="wpd-check-label"><?php echo $form->post_title ? esc_html($form->post_title) : esc_html__("no title", "wpdiscuz") . " ( ID : " . esc_html($form->ID) . " )"; ?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpoEmbedProviders -->
        <div class="wpd-opt-row we-embed-row" data-wpd-opt="wpoEmbedProviders">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("oEmbed Options", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input we-embed-items">
                <?php
                $embedsDir = WP_PLUGIN_DIR . "/wpdiscuz/options/pro-teasers/assets/img";
                $embedsUrl = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img";
                $iconBase  = "/wp-icons/";
                $fallback  = $embedsUrl . $iconBase . "embed.png";

                // host => enabled (matches plugin's defaults: WP core providers = 1, custom added ones vary)
                $providers = [
                    "youtube.com"              => 1,
                    "vimeo.com"                => 1,
                    "publish.twitter.com"      => 1,
                    "soundcloud.com"           => 1,
                    "embed.spotify.com"        => 1,
                    "flickr.com"               => 1,
                    "animoto.com"              => 1,
                    "cloudup.com"              => 1,
                    "dailymotion.com"          => 1,
                    "hulu.com"                 => 1,
                    "api.imgur.com"            => 1,
                    "issuu.com"                => 1,
                    "kickstarter.com"          => 1,
                    "api.meetup.com"           => 1,
                    "mixcloud.com"             => 1,
                    "reverbnation.com"         => 1,
                    "scribd.com"               => 1,
                    "api.smugmug.com"          => 1,
                    "ted.com"                  => 1,
                    "tumblr.com"               => 1,
                    "public-api.wordpress.com" => 1,
                    "wordpress.tv"             => 1,
                    "slideshare.net"           => 1,
                    "reddit.com"               => 1,
                    "giphy.com"                => 1,
                    "api.crowdsignal.com"      => 1,
                    "speakerdeck.com"          => 1,
                    "someecards.com"           => 1,
                    "api.screencast.com"       => 1,
                    "instagram.com"            => 0,
                    "videos.facebook.com"      => 0,
                    "posts.facebook.com"       => 0,
                    "tenor.com"                => 0,
                    "tiktok.com"               => 0,
                    "pinterest.com"            => 0,
                    "bilibili.com"             => 0,
                    "bitchute.com"             => 0,
                    "nicovideo.jp"             => 0,
                    "rutube.ru"                => 0,
                    "acfun.cn"                 => 0,
                    "youku.com"                => 0,
                    "liveleak.com"             => 0,
                    "v.qq.com"                 => 0,
                    "music.yandex.com"         => 0,
                    "music.yandex.ru"          => 0,
                    "fast.wistia.com"          => 0,
                    "sketchfab.com"            => 0,
                    "iwmb.icloud.com"          => 0,
                    "api.gfycat.com"           => 0,
                    "read.amazon.com"          => 0,
                    "read.amazon.co.uk"        => 0,
                    "read.amazon.com.au"       => 0,
                    "read.amazon.cn"           => 0,
                    "read.amazon.in"           => 0,
                    "tudou.com"                => 0,
                ];

                foreach ($providers as $host => $enabled) :
                    $iconFile = $embedsDir . $iconBase . $host . ".png";
                    $iconUrl  = file_exists($iconFile) ? $embedsUrl . $iconBase . $host . ".png" : $fallback;
                    ?>
                    <div class="wpd-opt-input we-block">
                        <div class="embed-label-wrap">
                            <label for="we-pro-embed-<?php echo esc_attr($host); ?>" class="embed-label">
                                <img src="<?php echo esc_url($iconUrl); ?>" title="<?php echo esc_attr($host); ?>" class="we-embed-icon" alt="<?php echo esc_attr($host); ?>">
                                <span><?php echo esc_html(ucfirst($host)); ?></span>
                            </label>
                        </div>
                        <div class="we-provider-checkbox-values">
                            <input type="checkbox" disabled <?php checked($enabled); ?> id="we-pro-embed-<?php echo esc_attr($host); ?>" class="we-provider-checkbox"/>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="wpd-clear"></div>
            </div>
            <div class="we-buttons-row">
                <button type="button" disabled class="button button-secondary"><?php esc_html_e("Select All", "wpdiscuz"); ?></button>
                <button type="button" disabled class="button button-secondary"><?php esc_html_e("Unselect All", "wpdiscuz"); ?></button>
                <button type="button" disabled class="button button-secondary"><?php esc_html_e("Invert Selection", "wpdiscuz"); ?></button>
            </div>
            <div class="wpd-clear"></div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-embeds/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Embeds Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
