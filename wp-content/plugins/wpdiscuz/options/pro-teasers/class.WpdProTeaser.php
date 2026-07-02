<?php

if (!defined("ABSPATH")) {
    exit();
}

/**
 * Generic pro teaser class.
 *
 * All behaviour is driven by a $config array passed to the constructor.
 *
 * Shared config keys (both types):
 *   isactive_filter  string   e.g. 'wpdiscuz_wam_isactive'
 *   plugin_file      string   e.g. 'wpdiscuz-ads-manager/class-WpdiscuzAdsManager.php' — fallback
 *                             for old addon versions that don't register the isactive_filter hook
 *   tab_key          string   Tab key — created by fake_tab, or existing core tab for inline
 *   template_path    string   Absolute path to the teaser template file
 *   published        string   MySQL datetime of the addon's original publish date (e.g. '2016-10-22 16:08:00')
 *
 * Config keys for type = 'fake_tab':
 *   title            string   Translated tab title
 *   title_original   string   Untranslated tab title
 *   filter_priority  int      Priority for the wpdiscuz_settings filter
 *
 * Config keys for type = 'inline':
 *   render_priority        int      Priority for the wpdiscuz_settings_tab_after action
 *   sidebar_title          string   (optional) Translated addon title — when set, a
 *                                   sidebar item and a dashboard card are rendered for
 *                                   this teaser so users can navigate to tab_key.
 *   sidebar_title_original string   (optional) Untranslated version of sidebar_title.
 */
class WpdProTeaser {

    /** @var array */
    private $config;

    /** @var WpdiscuzOptions */
    private $options;

    /** @var string */
    private $version;

    public function __construct(array $config, $options, $version) {
        $this->config  = $config;
        $this->options = $options;
        $this->version = $version;

        if ($config["type"] === "fake_tab") {
            add_filter("wpdiscuz_settings", [$this, "addFakeTab"], $config["filter_priority"]);
        } else {
            add_action("wpdiscuz_settings_tab_after", [$this, "render"], $config["render_priority"], 2);
            if (!empty($config["sidebar_title"])) {
                add_filter("wpdiscuz_settings", [$this, "addToTeasersList"], $config["render_priority"]);
            }
        }

        add_action("admin_enqueue_scripts", [$this, "enqueue"]);
    }

    private function isAddonActive() {
        if (apply_filters($this->config["isactive_filter"], false)) {
            return true;
        }
        if (!empty($this->config["plugin_file"]) && function_exists("is_plugin_active")) {
            if (is_plugin_active($this->config["plugin_file"])) {
                return true;
            }
        }
        return false;
    }

    private function isNew() {
        if (empty($this->config["published"])) {
            return false;
        }
        return strtotime($this->config["published"]) >= strtotime("-3 months");
    }

    public function addFakeTab($settings) {
        if ($this->isAddonActive()) {
            return $settings;
        }
        $settings["teasers"][$this->config["tab_key"]] = [
            "title"          => $this->config["title"],
            "title_original" => $this->config["title_original"],
            "icon"           => !empty($this->config["icon"]) ? plugins_url(WPDISCUZ_DIR_NAME . "/" . $this->config["icon"]) : "",
            "icon-height"    => "",
            "file_path"      => $this->config["template_path"],
            "values"         => null,
            "options"        => [],
            "is_new"         => $this->isNew(),
            "no_save"        => true,
        ];
        return $settings;
    }

    public function addToTeasersList($settings) {
        if ($this->isAddonActive()) {
            return $settings;
        }
        $settings["teasers"][$this->config["tab_key"]] = [
            "title"          => $this->config["sidebar_title"],
            "title_original" => $this->config["sidebar_title_original"],
            "icon"           => !empty($this->config["icon"]) ? plugins_url(WPDISCUZ_DIR_NAME . "/" . $this->config["icon"]) : "",
            "icon-height"    => "",
            "file_path"      => null,
            "values"         => null,
            "options"        => [],
            "is_new"         => $this->isNew(),
            "anchor"         => !empty($this->config["anchor"]) ? $this->config["anchor"] : "",
        ];
        return $settings;
    }

    public function render($tab, $setting) {
        if ($tab !== $this->config["tab_key"]) {
            return;
        }
        if ($this->isAddonActive()) {
            return;
        }
        include $this->config["template_path"];
    }

    public function enqueue($hook) {
        if ($this->isAddonActive()) {
            return;
        }
        if (!isset($_GET["page"]) || $_GET["page"] !== WpdiscuzCore::PAGE_SETTINGS) {
            return;
        }

        if ($this->config["type"] === "inline") {
            // Only enqueue when on the tab (accordion JS + CSS needed there).
            if (!isset($_GET["wpd_tab"]) || $_GET["wpd_tab"] !== $this->config["tab_key"]) {
                return;
            }
            wp_enqueue_style(
                "wpd-pro-teasers-shared-css",
                plugins_url(WPDISCUZ_DIR_NAME . "/options/pro-teasers/assets/css/pro-teasers-shared.css"),
                [],
                $this->version
            );
            wp_enqueue_script(
                "wpd-pro-teasers-shared-js",
                plugins_url(WPDISCUZ_DIR_NAME . "/options/pro-teasers/assets/js/pro-teasers-shared.js"),
                ["jquery"],
                $this->version,
                true
            );
            return;
        }

        // fake_tab type
        wp_enqueue_style(
            "wpd-pro-teasers-shared-css",
            plugins_url(WPDISCUZ_DIR_NAME . "/options/pro-teasers/assets/css/pro-teasers-shared.css"),
            [],
            $this->version
        );
        wp_enqueue_script(
            "wpd-pro-teasers-shared-js",
            plugins_url(WPDISCUZ_DIR_NAME . "/options/pro-teasers/assets/js/pro-teasers-shared.js"),
            ["jquery"],
            $this->version,
            true
        );
    }

}
