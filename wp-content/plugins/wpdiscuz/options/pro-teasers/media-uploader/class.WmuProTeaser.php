<?php

if (!defined("ABSPATH")) {
    exit();
}

class WmuProTeaser {

    /**
     * @var WpdiscuzOptions
     */
    private $options;
    private $version;

    public function __construct($options, $version) {
        $this->options = $options;
        $this->version = $version;
        add_action("wpdiscuz_settings_tab_after", [$this, "render"], 99, 2);
        add_action("admin_enqueue_scripts", [$this, "enqueue"]);
    }

    public function render($tab, $setting) {
        if (WpdiscuzCore::TAB_CONTENT !== $tab) {
            return;
        }
        if (apply_filters("wpdiscuz_mu_isactive", false)) {
            return;
        }
        include __DIR__ . "/wmu-pro-teaser.php";
    }

    public function enqueue($hook) {
        if (apply_filters("wpdiscuz_mu_isactive", false)) {
            return;
        }
        if (!isset($_GET["page"]) || $_GET["page"] !== WpdiscuzCore::PAGE_SETTINGS) {
            return;
        }
        if (!isset($_GET["wpd_tab"]) || $_GET["wpd_tab"] !== WpdiscuzCore::TAB_CONTENT) {
            return;
        }
        wp_enqueue_style(
            "wmu-pro-teaser-css",
            plugins_url(WPDISCUZ_DIR_NAME . "/options/pro-teasers/media-uploader/assets/css/wmu-pro-teaser.css"),
            [],
            $this->version
        );
        wp_enqueue_script(
            "wmu-pro-teaser-js",
            plugins_url(WPDISCUZ_DIR_NAME . "/options/pro-teasers/media-uploader/assets/js/wmu-pro-teaser.js"),
            ["jquery"],
            $this->version,
            true
        );
    }

}
