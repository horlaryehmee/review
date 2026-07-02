<?php

if (!defined("ABSPATH")) {
    exit();
}

$wsmPluginUrl = plugins_url("wpdiscuz") . "/options/pro-teasers/assets/img";
$wsmImgBase   = $wsmPluginUrl . "/emoticons/img/";

$wsmStickers = [
    ":wpds_smile:"      => ["file" => "smile.svg",      "title" => "smile"],
    ":wpds_grin:"       => ["file" => "grin.svg",       "title" => "grin"],
    ":wpds_wink:"       => ["file" => "wink.svg",       "title" => "wink"],
    ":wpds_mrgreen:"    => ["file" => "mrgreen.svg",    "title" => "mrgreen"],
    ":wpds_neutral:"    => ["file" => "neutral.svg",    "title" => "neutral"],
    ":wpds_twisted:"    => ["file" => "twisted.svg",    "title" => "twisted"],
    ":wpds_arrow:"      => ["file" => "arrow.svg",      "title" => "arrow"],
    ":wpds_shock:"      => ["file" => "shock.svg",      "title" => "shock"],
    ":wpds_unamused:"   => ["file" => "unamused.svg",   "title" => "unamused"],
    ":wpds_cool:"       => ["file" => "cool.svg",       "title" => "cool"],
    ":wpds_evil:"       => ["file" => "evil.svg",       "title" => "evil"],
    ":wpds_oops:"       => ["file" => "oops.svg",       "title" => "oops"],
    ":wpds_razz:"       => ["file" => "razz.svg",       "title" => "razz"],
    ":wpds_roll:"       => ["file" => "roll.svg",       "title" => "roll"],
    ":wpds_cry:"        => ["file" => "cry.svg",        "title" => "cry"],
    ":wpds_eek:"        => ["file" => "eek.svg",        "title" => "eek"],
    ":wpds_lol:"        => ["file" => "lol.svg",        "title" => "lol"],
    ":wpds_mad:"        => ["file" => "mad.svg",        "title" => "mad"],
    ":wpds_sad:"        => ["file" => "sad.svg",        "title" => "sad"],
    ":wpds_exclamation:" => ["file" => "exclamation.svg", "title" => "exclamation"],
    ":wpds_question:"   => ["file" => "question.svg",   "title" => "question"],
    ":wpds_idea:"       => ["file" => "idea.svg",       "title" => "idea"],
    ":wpds_hmm:"        => ["file" => "hmm.svg",        "title" => "hmm"],
    ":wpds_beg:"        => ["file" => "beg.svg",        "title" => "beg"],
    ":wpds_whew:"       => ["file" => "whew.svg",       "title" => "whew"],
    ":wpds_chuckle:"    => ["file" => "chuckle.svg",    "title" => "chuckle"],
    ":wpds_silly:"      => ["file" => "silly.svg",      "title" => "silly"],
    ":wpds_envy:"       => ["file" => "envy.svg",       "title" => "envy"],
    ":wpds_shutmouth:"  => ["file" => "shutmouth.svg",  "title" => "shutmouth"],
];

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-smiley"></span>
            <?php esc_html_e("Emoticons Addon Settings", "wpdiscuz"); ?>
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
                <?php esc_html_e("Enrich your comment section with emoji and custom sticker packs. Let commenters express themselves with built-in emoticons, enable shortname syntax, control sticker size, and manage which emoticons are active — plus add fully custom sticker sets stored in your own theme directory.", "wpdiscuz"); ?>
            </div>
        </div>

        <!-- Option start: enable_emoji -->
        <div class="wpd-opt-row" data-wpd-opt="enable_emoji">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable Emoji", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wsm-pro-enable_emoji" checked/>
                    <label for="wsm-pro-enable_emoji"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: enable_emoji_shortname -->
        <div class="wpd-opt-row" data-wpd-opt="enable_emoji_shortname">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable Emoji Shortname", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wsm-pro-enable_emoji_shortname" checked/>
                    <label for="wsm-pro-enable_emoji_shortname"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Sticker", "wpdiscuz"); ?></div>

        <!-- Option start: enable_stickers -->
        <div class="wpd-opt-row" data-wpd-opt="enable_stickers">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Enable Stickers", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switcher">
                    <input type="checkbox" disabled value="1" id="wsm-pro-enable_stickers" checked/>
                    <label for="wsm-pro-enable_stickers"></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: size -->
        <div class="wpd-opt-row" data-wpd-opt="size">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Sticker Size", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="number" disabled value="40" min="0" class="wpd-num-input"/> px
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: theme (sticker packages - no custom packs installed) -->
        <div class="wpd-opt-row" data-wpd-opt="enableDisableStickers">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Emoticon Packages", "wpdiscuz"); ?></label>
                <div class="wpd-desc">
                    <?php esc_html_e("wpDiscuz Emoticons Addon allows you to add new sticker packages and switch to any package you want.", "wpdiscuz"); ?><br />
                    <?php esc_html_e("To create a new Smiles package, please follow this instruction:", "wpdiscuz"); ?>
                    <div id="custom-smile-instruction" class="custom-smile-instruction">
                        <strong>1.</strong>&nbsp; <?php esc_html_e('Create "wpdiscuz" folder in WordPress', "wpdiscuz"); ?> <span class="wpddir">/wp-content/</span> <?php esc_html_e("directory", "wpdiscuz"); ?><br />
                        <strong>2.</strong>&nbsp; <?php esc_html_e('Create "emoticons" folder in WordPress', "wpdiscuz"); ?> <span class="wpddir">/wp-content/wpdiscuz/</span> <?php esc_html_e("directory", "wpdiscuz"); ?><br />
                        <strong>3.</strong>&nbsp; <?php esc_html_e("Choose a unique name for your new package and create a folder using this name in", "wpdiscuz"); ?> <span class="wpddir">/wp-content/wpdiscuz/emoticons/</span> <?php esc_html_e("directory.", "wpdiscuz"); ?><br />
                        <?php esc_html_e('For example "mysmiles", the end directory will be', "wpdiscuz"); ?> <span class="wpddir">/wp-content/wpdiscuz/emoticons/mysmiles/</span><br />
                        <strong>4.</strong>&nbsp; <?php esc_html_e("Copy all files from", "wpdiscuz"); ?> <span class="wpddir">/wp-content/plugins/wpdiscuz-emoticons/emoticons/</span> <?php esc_html_e("directory to", "wpdiscuz"); ?> <span class="wpddir">/wp-content/wpdiscuz/emoticons/mysmiles/</span><br />
                        <strong>5.</strong>&nbsp; <?php esc_html_e("Change the new package demonstration icon", "wpdiscuz"); ?> <span class="wpddir">mysmiles/icon.png</span><?php esc_html_e(", but do not rename it.", "wpdiscuz"); ?><br />
                        <strong>6.</strong>&nbsp; <?php esc_html_e("Delete all images in", "wpdiscuz"); ?> <span class="wpddir">mysmiles<strong>/</strong>img/</span> <?php esc_html_e("folder and upload your new emoticons images.", "wpdiscuz"); ?><br />
                        <strong>7.</strong>&nbsp; <?php esc_html_e("Open", "wpdiscuz"); ?> <span class="wpddir">mysmiles<strong>/</strong>wpsmiliestrans.php</span> <?php esc_html_e("file and change new image names for according emoticons' code.", "wpdiscuz"); ?><br />
                        <strong>8.</strong>&nbsp; <?php esc_html_e("Then come back to this page and find the emoticons package switcher.", "wpdiscuz"); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: enableDisableStickers -->
        <div class="wpd-opt-row" data-wpd-opt="enableDisableStickers">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Sticker enable/disable", "wpdiscuz"); ?></label>
                <p class="wpd-desc"><?php esc_html_e("Click on sticker to disable. It may take 1-2 seconds to become grey/inactive.", "wpdiscuz"); ?></p>
            </div>
            <div class="wpd-opt-input">
                <?php foreach ($wsmStickers as $code => $imageData) : ?>
                    <img src="<?php echo esc_url($wsmImgBase . $imageData["file"]); ?>"
                         alt="<?php echo esc_attr($imageData["title"]); ?>"
                         title="<?php echo esc_attr($imageData["title"]); ?>"
                         data-emoticon-code="<?php echo esc_attr($imageData["title"]); ?>"
                         class="wpdiscuz-option-smile"/>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: customSmiles -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="customSmiles">
            <div class="wpd-opt-input wsm-pro-custom-wrap">
                <h2 class="wsm-pro-custom-h2"><?php esc_html_e("Custom stickers", "wpdiscuz"); ?></h2>
                <p class="wpd-desc"></p>
                <hr />
                <div id="custom-smiles">
                <div class="add-custom-smile">
                    <table width="100%">
                        <tr>
                            <td class="wsm-pro-td-code"><label><?php esc_html_e("Code", "wpdiscuz"); ?></label></td>
                            <td class="sprefix">:</td>
                            <td class="wsm-pro-td-pfx"><input type="text" disabled placeholder="shock" class="wpd-input-full"/></td>
                            <td class="sprefix">:</td>
                            <td class="wsm-pro-td-label"><label><?php esc_html_e("Sticker Image URL", "wpdiscuz"); ?>:</label></td>
                            <td class="wsm-pro-td-url"><input type="text" disabled placeholder="http://example.com/shock.png" class="wpd-input-full"/></td>
                            <td><span class="button wsm-pro-add-btn"><?php esc_html_e("Add", "wpdiscuz"); ?></span></td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-emoticons/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Emoticons Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
