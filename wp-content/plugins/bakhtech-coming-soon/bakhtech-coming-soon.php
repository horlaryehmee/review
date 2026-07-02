<?php
/**
 * Plugin Name: Bakhtech Solutions Coming Soon
 * Description: Coming soon countdown page with admin customization and bypass link.
 * Version: 0.1.0
 * Author: Bakare Olayemi
 * Text Domain: bakhtech-coming-soon
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BAKHTECH_CS_VERSION', '0.1.0');
define('BAKHTECH_CS_PATH', plugin_dir_path(__FILE__));
define('BAKHTECH_CS_URL', plugin_dir_url(__FILE__));

add_action('admin_menu', 'bakhtech_cs_add_settings_page');
add_action('admin_init', 'bakhtech_cs_register_settings');
add_action('admin_enqueue_scripts', 'bakhtech_cs_admin_assets');
add_action('template_redirect', 'bakhtech_cs_maybe_render', 0);
add_action('admin_post_bakhtech_cs_export_settings', 'bakhtech_cs_handle_export');
add_action('admin_post_bakhtech_cs_import_settings', 'bakhtech_cs_handle_import');
add_action('admin_bar_menu', 'bakhtech_cs_admin_bar_menu', 100);
add_action('admin_post_bakhtech_cs_toggle_status', 'bakhtech_cs_handle_toggle');

register_activation_hook(__FILE__, 'bakhtech_cs_activate');

function bakhtech_cs_activate() {
    $options = get_option('bakhtech_cs_options');
    if (!is_array($options)) {
        $options = bakhtech_cs_default_options();
        $options['bypass_key'] = wp_generate_password(16, false, false);
        update_option('bakhtech_cs_options', $options);
    }
}

function bakhtech_cs_default_options() {
    $launch_timestamp = current_time('timestamp') + (DAY_IN_SECONDS * 30);

    return array(
        'enabled' => 0,
        'page_title' => 'Topic.ng - Coming Soon',
        'header_label' => 'Launching Soon',
        'badge_text' => 'Coming Soon',
        'brand_title' => 'Topic.ng',
        'tagline_text' => 'The Tutoring',
        'tagline_highlight' => 'Marketplace.',
        'description_line_1' => 'Find experts. Book sessions. Pay as you learn.',
        'description_line_2' => 'The new standard for education is almost here.',
        'launch_datetime' => date('Y-m-d H:i:s', $launch_timestamp),
        'label_days' => 'DAYS',
        'label_hours' => 'HOURS',
        'label_mins' => 'MINS',
        'label_secs' => 'SECS',
        'input_placeholder' => 'Enter your email address',
        'button_label' => 'Notify Me',
        'form_note' => 'Be the first to know when we launch. No spam.',
        'footer_text' => '(c) ' . date('Y') . ' Topic.ng. All rights reserved.',
        'social_twitter' => '',
        'social_linkedin' => '',
        'social_instagram' => '',
        'logo_url' => '',
        'bypass_key' => '',
        'fluent_form_shortcode' => '',
        'color_primary' => '#1d77f2',
        'color_bg' => '#f8f9fa',
        'color_text' => '#111827',
        'color_card_bg' => '#ffffff',
    );
}

function bakhtech_cs_get_options() {
    $options = get_option('bakhtech_cs_options', array());
    if (!is_array($options)) {
        $options = array();
    }

    $defaults = bakhtech_cs_default_options();
    return wp_parse_args($options, $defaults);
}

function bakhtech_cs_register_settings() {
    register_setting('bakhtech_cs_settings', 'bakhtech_cs_options', 'bakhtech_cs_sanitize_options');
}

function bakhtech_cs_add_settings_page() {
    add_menu_page(
        'Coming Soon',
        'Coming Soon',
        'manage_options',
        'bakhtech-coming-soon',
        'bakhtech_cs_render_settings',
        'dashicons-clock',
        59
    );
}

function bakhtech_cs_admin_assets($hook) {
    if ($hook !== 'toplevel_page_bakhtech-coming-soon') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script(
        'bakhtech-coming-soon-admin',
        BAKHTECH_CS_URL . 'assets/js/coming-soon-admin.js',
        array('jquery'),
        BAKHTECH_CS_VERSION,
        true
    );
}

function bakhtech_cs_render_settings() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $options = bakhtech_cs_get_options();
    $launch_value = bakhtech_cs_format_datetime_local($options['launch_datetime']);
    $bypass_url = '';

    if ($options['bypass_key'] !== '') {
        $bypass_url = add_query_arg('bakhtech_bypass', $options['bypass_key'], home_url('/'));
    }
    ?>
    <div class="wrap">
        <h1>Coming Soon</h1>
        <form method="post" action="options.php">
            <?php settings_fields('bakhtech_cs_settings'); ?>

            <h2 class="title">General</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-enabled">Enable Coming Soon</label></th>
                    <td>
                        <label>
                            <input type="checkbox" id="bakhtech-cs-enabled" name="bakhtech_cs_options[enabled]" value="1" <?php checked(1, $options['enabled']); ?> />
                            Show on all public pages
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-page-title">Browser Title</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-page-title" name="bakhtech_cs_options[page_title]" value="<?php echo esc_attr($options['page_title']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-launch-datetime">Launch Date/Time</label></th>
                    <td>
                        <input type="datetime-local" id="bakhtech-cs-launch-datetime" name="bakhtech_cs_options[launch_datetime]" value="<?php echo esc_attr($launch_value); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-bypass-key">Bypass Key</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-bypass-key" name="bakhtech_cs_options[bypass_key]" value="<?php echo esc_attr($options['bypass_key']); ?>" />
                        <button class="button bakhtech-cs-generate-key" type="button">Generate</button>
                        <p class="description">Use the bypass link to view the site while Coming Soon is enabled.</p>
                        <?php if ($bypass_url !== '') : ?>
                            <p><input type="text" class="large-text code" readonly value="<?php echo esc_attr($bypass_url); ?>" /></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <h2 class="title">Branding</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-logo-url">Logo Image</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-logo-url" name="bakhtech_cs_options[logo_url]" value="<?php echo esc_attr($options['logo_url']); ?>" />
                        <button class="button bakhtech-cs-logo-upload" type="button">Select</button>
                        <button class="button bakhtech-cs-logo-remove" type="button">Remove</button>
                        <p class="description">If empty, the default icon is used.</p>
                        <div class="bakhtech-cs-logo-preview-wrap">
                            <img id="bakhtech-cs-logo-preview" src="<?php echo esc_url($options['logo_url']); ?>" class="bakhtech-cs-logo-preview <?php echo $options['logo_url'] ? '' : 'is-hidden'; ?>" alt="Logo preview" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-header-label">Top Label</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-header-label" name="bakhtech_cs_options[header_label]" value="<?php echo esc_attr($options['header_label']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-badge-text">Badge Text</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-badge-text" name="bakhtech_cs_options[badge_text]" value="<?php echo esc_attr($options['badge_text']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-brand-title">Main Title</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-brand-title" name="bakhtech_cs_options[brand_title]" value="<?php echo esc_attr($options['brand_title']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-tagline-text">Tagline Text</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-tagline-text" name="bakhtech_cs_options[tagline_text]" value="<?php echo esc_attr($options['tagline_text']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-tagline-highlight">Tagline Highlight</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-tagline-highlight" name="bakhtech_cs_options[tagline_highlight]" value="<?php echo esc_attr($options['tagline_highlight']); ?>" />
                    </td>
                </tr>
            </table>

            <h2 class="title">Body Copy</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-description-1">Description Line 1</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-description-1" name="bakhtech_cs_options[description_line_1]" value="<?php echo esc_attr($options['description_line_1']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-description-2">Description Line 2</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-description-2" name="bakhtech_cs_options[description_line_2]" value="<?php echo esc_attr($options['description_line_2']); ?>" />
                    </td>
                </tr>
            </table>

            <h2 class="title">Countdown Labels</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-label-days">Days Label</label></th>
                    <td>
                        <input type="text" class="small-text" id="bakhtech-cs-label-days" name="bakhtech_cs_options[label_days]" value="<?php echo esc_attr($options['label_days']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-label-hours">Hours Label</label></th>
                    <td>
                        <input type="text" class="small-text" id="bakhtech-cs-label-hours" name="bakhtech_cs_options[label_hours]" value="<?php echo esc_attr($options['label_hours']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-label-mins">Minutes Label</label></th>
                    <td>
                        <input type="text" class="small-text" id="bakhtech-cs-label-mins" name="bakhtech_cs_options[label_mins]" value="<?php echo esc_attr($options['label_mins']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-label-secs">Seconds Label</label></th>
                    <td>
                        <input type="text" class="small-text" id="bakhtech-cs-label-secs" name="bakhtech_cs_options[label_secs]" value="<?php echo esc_attr($options['label_secs']); ?>" />
                    </td>
                </tr>
            </table>
            
            <h2 class="title">Colors</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-color-primary">Primary Color</label></th>
                    <td>
                        <input type="color" id="bakhtech-cs-color-primary" name="bakhtech_cs_options[color_primary]" value="<?php echo esc_attr($options['color_primary']); ?>" style="height: 40px;" />
                        <p class="description">Buttons, links, and highlights.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-color-bg">Background Color</label></th>
                    <td>
                        <input type="color" id="bakhtech-cs-color-bg" name="bakhtech_cs_options[color_bg]" value="<?php echo esc_attr($options['color_bg']); ?>" style="height: 40px;" />
                        <p class="description">Page background.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-color-text">Text Color</label></th>
                    <td>
                        <input type="color" id="bakhtech-cs-color-text" name="bakhtech_cs_options[color_text]" value="<?php echo esc_attr($options['color_text']); ?>" style="height: 40px;" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-color-card-bg">Card Background</label></th>
                    <td>
                        <input type="color" id="bakhtech-cs-color-card-bg" name="bakhtech_cs_options[color_card_bg]" value="<?php echo esc_attr($options['color_card_bg']); ?>" style="height: 40px;" />
                        <p class="description">Countdown and form background (for light themes preferably white).</p>
                    </td>
                </tr>
            </table>

            <h2 class="title">Notify Form</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-fluent-form-shortcode">Fluent Form Shortcode</label></th>
                    <td>
                        <input type="text" class="large-text code" id="bakhtech-cs-fluent-form-shortcode" name="bakhtech_cs_options[fluent_form_shortcode]" value="<?php echo esc_attr($options['fluent_form_shortcode']); ?>" placeholder="[fluentform id=&quot;1&quot;]" />
                        <p class="description">If set, this form will replace the default email capture form.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-input-placeholder">Input Placeholder</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-input-placeholder" name="bakhtech_cs_options[input_placeholder]" value="<?php echo esc_attr($options['input_placeholder']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-button-label">Button Label</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-button-label" name="bakhtech_cs_options[button_label]" value="<?php echo esc_attr($options['button_label']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-form-note">Form Note</label></th>
                    <td>
                        <input type="text" class="regular-text" id="bakhtech-cs-form-note" name="bakhtech_cs_options[form_note]" value="<?php echo esc_attr($options['form_note']); ?>" />
                    </td>
                </tr>
            </table>

            <h2 class="title">Footer</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="bakhtech-cs-footer-text">Footer Text</label></th>
                    <td>
                        <textarea class="large-text" rows="3" id="bakhtech-cs-footer-text" name="bakhtech_cs_options[footer_text]"><?php echo esc_textarea($options['footer_text']); ?></textarea>
                        <p class="description">HTML allowed (e.g., &lt;a href="#"&gt;Link&lt;/a&gt;).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-social-twitter">Twitter URL</label></th>
                    <td>
                        <input type="url" class="regular-text" id="bakhtech-cs-social-twitter" name="bakhtech_cs_options[social_twitter]" value="<?php echo esc_attr($options['social_twitter']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-social-linkedin">LinkedIn URL</label></th>
                    <td>
                        <input type="url" class="regular-text" id="bakhtech-cs-social-linkedin" name="bakhtech_cs_options[social_linkedin]" value="<?php echo esc_attr($options['social_linkedin']); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bakhtech-cs-social-instagram">Instagram URL</label></th>
                    <td>
                        <input type="url" class="regular-text" id="bakhtech-cs-social-instagram" name="bakhtech_cs_options[social_instagram]" value="<?php echo esc_attr($options['social_instagram']); ?>" />
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>

        <hr>

        <h2 class="title" style="margin-top: 40px;">Import / Export</h2>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row">Export Settings</th>
                <td>
                    <form method="post" action="admin-post.php">
                        <input type="hidden" name="action" value="bakhtech_cs_export_settings">
                        <?php wp_nonce_field('bakhtech_cs_export_nonce', 'bakhtech_cs_export_nonce'); ?>
                        <button type="submit" class="button">Export JSON</button>
                        <p class="description">Download a backup of your current settings.</p>
                    </form>
                </td>
            </tr>
            <tr>
                <th scope="row">Import Settings</th>
                <td>
                    <form method="post" action="admin-post.php" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="bakhtech_cs_import_settings">
                        <?php wp_nonce_field('bakhtech_cs_import_nonce', 'bakhtech_cs_import_nonce'); ?>
                        <input type="file" name="import_file" accept=".json" required>
                        <button type="submit" class="button button-primary" style="margin-top: 10px;">Import JSON</button>
                        <p class="description">Upload a previously exported JSON file. <strong>Warning: This will overwrite current settings.</strong></p>
                    </form>
                </td>
            </tr>
        </table>

        <style>
            .bakhtech-cs-logo-preview-wrap { margin-top: 8px; }
            .bakhtech-cs-logo-preview { width: 80px; height: 80px; border-radius: 12px; border: 1px solid #d4dbe7; padding: 6px; background: #fff; object-fit: contain; }
            .bakhtech-cs-logo-preview.is-hidden { display: none; }
        </style>
    </div>
    <?php
}

function bakhtech_cs_sanitize_options($input) {
    $defaults = bakhtech_cs_default_options();
    $output = array();

    $output['enabled'] = !empty($input['enabled']) ? 1 : 0;
    $output['page_title'] = isset($input['page_title']) ? sanitize_text_field($input['page_title']) : $defaults['page_title'];
    $output['header_label'] = isset($input['header_label']) ? sanitize_text_field($input['header_label']) : $defaults['header_label'];
    $output['badge_text'] = isset($input['badge_text']) ? sanitize_text_field($input['badge_text']) : $defaults['badge_text'];
    $output['brand_title'] = isset($input['brand_title']) ? sanitize_text_field($input['brand_title']) : $defaults['brand_title'];
    $output['tagline_text'] = isset($input['tagline_text']) ? sanitize_text_field($input['tagline_text']) : $defaults['tagline_text'];
    $output['tagline_highlight'] = isset($input['tagline_highlight']) ? sanitize_text_field($input['tagline_highlight']) : $defaults['tagline_highlight'];
    $output['description_line_1'] = isset($input['description_line_1']) ? sanitize_text_field($input['description_line_1']) : $defaults['description_line_1'];
    $output['description_line_2'] = isset($input['description_line_2']) ? sanitize_text_field($input['description_line_2']) : $defaults['description_line_2'];
    $output['launch_datetime'] = isset($input['launch_datetime']) ? bakhtech_cs_sanitize_datetime($input['launch_datetime']) : $defaults['launch_datetime'];
    $output['label_days'] = isset($input['label_days']) ? sanitize_text_field($input['label_days']) : $defaults['label_days'];
    $output['label_hours'] = isset($input['label_hours']) ? sanitize_text_field($input['label_hours']) : $defaults['label_hours'];
    $output['label_mins'] = isset($input['label_mins']) ? sanitize_text_field($input['label_mins']) : $defaults['label_mins'];
    $output['label_secs'] = isset($input['label_secs']) ? sanitize_text_field($input['label_secs']) : $defaults['label_secs'];
    $output['input_placeholder'] = isset($input['input_placeholder']) ? sanitize_text_field($input['input_placeholder']) : $defaults['input_placeholder'];
    $output['button_label'] = isset($input['button_label']) ? sanitize_text_field($input['button_label']) : $defaults['button_label'];
    $output['form_note'] = isset($input['form_note']) ? sanitize_text_field($input['form_note']) : $defaults['form_note'];
    $output['footer_text'] = isset($input['footer_text']) ? wp_kses_post($input['footer_text']) : $defaults['footer_text'];
    $output['social_twitter'] = isset($input['social_twitter']) ? esc_url_raw($input['social_twitter']) : $defaults['social_twitter'];
    $output['social_linkedin'] = isset($input['social_linkedin']) ? esc_url_raw($input['social_linkedin']) : $defaults['social_linkedin'];
    $output['social_instagram'] = isset($input['social_instagram']) ? esc_url_raw($input['social_instagram']) : $defaults['social_instagram'];
    $output['logo_url'] = isset($input['logo_url']) ? esc_url_raw($input['logo_url']) : $defaults['logo_url'];
    $output['bypass_key'] = isset($input['bypass_key']) ? sanitize_text_field($input['bypass_key']) : $defaults['bypass_key'];
    $output['fluent_form_shortcode'] = isset($input['fluent_form_shortcode']) ? wp_kses_post($input['fluent_form_shortcode']) : $defaults['fluent_form_shortcode'];
    $output['color_primary'] = isset($input['color_primary']) ? sanitize_hex_color($input['color_primary']) : $defaults['color_primary'];
    $output['color_bg'] = isset($input['color_bg']) ? sanitize_hex_color($input['color_bg']) : $defaults['color_bg'];
    $output['color_text'] = isset($input['color_text']) ? sanitize_hex_color($input['color_text']) : $defaults['color_text'];
    $output['color_card_bg'] = isset($input['color_card_bg']) ? sanitize_hex_color($input['color_card_bg']) : $defaults['color_card_bg'];

    return $output;
}

function bakhtech_cs_sanitize_datetime($value) {
    $value = sanitize_text_field($value);
    if ($value === '') {
        return '';
    }

    $value = str_replace('T', ' ', $value);
    if (strlen($value) === 16) {
        $value .= ':00';
    }

    $timestamp = strtotime($value);
    if (!$timestamp) {
        return '';
    }

    return date('Y-m-d H:i:s', $timestamp);
}

function bakhtech_cs_format_datetime_local($value) {
    if ($value === '') {
        return '';
    }

    $timestamp = strtotime($value);
    if (!$timestamp) {
        return '';
    }

    return date('Y-m-d\TH:i', $timestamp);
}

function bakhtech_cs_format_js_datetime($value) {
    if ($value === '') {
        return '';
    }

    $timestamp = strtotime($value);
    if (!$timestamp) {
        return '';
    }

    return date('Y-m-d\TH:i:s', $timestamp);
}

function bakhtech_cs_should_skip() {
    if (is_admin()) {
        return true;
    }

    if (wp_doing_ajax()) {
        return true;
    }

    if (defined('REST_REQUEST') && REST_REQUEST) {
        return true;
    }

    if (defined('DOING_CRON') && DOING_CRON) {
        return true;
    }

    if (defined('WP_CLI') && WP_CLI) {
        return true;
    }

    if (is_user_logged_in() && current_user_can('manage_options')) {
        return true;
    }

    if (function_exists('is_customize_preview') && is_customize_preview()) {
        return true;
    }

    return false;
}

function bakhtech_cs_hash_key($key) {
    return hash_hmac('sha256', $key, wp_salt('auth'));
}

function bakhtech_cs_handle_bypass_request($bypass_key) {
    if (!isset($_GET['bakhtech_bypass'])) {
        return;
    }

    $provided = sanitize_text_field(wp_unslash($_GET['bakhtech_bypass']));
    if (!hash_equals($bypass_key, $provided)) {
        return;
    }

    $cookie_value = bakhtech_cs_hash_key($bypass_key);
    setcookie(
        'bakhtech_cs_bypass',
        $cookie_value,
        time() + (DAY_IN_SECONDS * 30),
        COOKIEPATH,
        COOKIE_DOMAIN,
        is_ssl(),
        true
    );

    $redirect = remove_query_arg('bakhtech_bypass');
    wp_safe_redirect($redirect);
    exit;
}

function bakhtech_cs_has_bypass_cookie($bypass_key) {
    if ($bypass_key === '') {
        return false;
    }

    if (empty($_COOKIE['bakhtech_cs_bypass'])) {
        return false;
    }

    $cookie = sanitize_text_field(wp_unslash($_COOKIE['bakhtech_cs_bypass']));
    return hash_equals(bakhtech_cs_hash_key($bypass_key), $cookie);
}

function bakhtech_cs_enqueue_assets() {
    wp_enqueue_style(
        'bakhtech-coming-soon',
        BAKHTECH_CS_URL . 'assets/css/coming-soon.css',
        array(),
        BAKHTECH_CS_VERSION
    );

    wp_enqueue_script(
        'bakhtech-coming-soon',
        BAKHTECH_CS_URL . 'assets/js/coming-soon.js',
        array(),
        BAKHTECH_CS_VERSION,
        true
    );
}

function bakhtech_cs_handle_export() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    check_admin_referer('bakhtech_cs_export_nonce', 'bakhtech_cs_export_nonce');

    $options = get_option('bakhtech_cs_options');
    if (!$options) {
        $options = array();
    }

    $filename = 'bakhtech-coming-soon-settings-' . date('Y-m-d') . '.json';
    
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo json_encode($options, JSON_PRETTY_PRINT);
    exit;
}

function bakhtech_cs_handle_import() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    check_admin_referer('bakhtech_cs_import_nonce', 'bakhtech_cs_import_nonce');

    if (empty($_FILES['import_file']['tmp_name'])) {
        wp_die('No file uploaded.');
    }

    $json_content = file_get_contents($_FILES['import_file']['tmp_name']);
    $data = json_decode($json_content, true);

    if (!is_array($data)) {
        wp_die('Invalid JSON file.');
    }

    // Sanitize by running through the existing sanitize function logic
    $sanitized = bakhtech_cs_sanitize_options($data);
    
    update_option('bakhtech_cs_options', $sanitized);

    wp_safe_redirect(add_query_arg('page', 'bakhtech-coming-soon', admin_url('admin.php')));
    exit;
}

function bakhtech_cs_maybe_render() {
    $options = bakhtech_cs_get_options();

    if (empty($options['enabled'])) {
        return;
    }

    if (bakhtech_cs_should_skip()) {
        return;
    }

    $bypass_key = trim((string) $options['bypass_key']);
    if ($bypass_key !== '') {
        bakhtech_cs_handle_bypass_request($bypass_key);
        if (bakhtech_cs_has_bypass_cookie($bypass_key)) {
            return;
        }
    }

    bakhtech_cs_enqueue_assets();

    status_header(503);
    nocache_headers();

    $options['launch_js'] = bakhtech_cs_format_js_datetime($options['launch_datetime']);

    $template = BAKHTECH_CS_PATH . 'templates/coming-soon.php';
    if (file_exists($template)) {
        include $template;
    } else {
        echo 'Coming Soon';
    }
    exit;
}

function bakhtech_cs_admin_bar_menu($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }

    $options = bakhtech_cs_get_options();
    $enabled = !empty($options['enabled']);
    
    $icon_color = $enabled ? '#46b450' : '#dc3232';
    $status_text = $enabled ? 'ON' : 'OFF';
    $title = sprintf(
        '<span style="display:inline-block;width:8px;height:8px;border-radius:50%%;background-color:%s;margin-right:6px;"></span>Coming Soon: %s',
        esc_attr($icon_color),
        esc_html($status_text)
    );

    $toggle_url = wp_nonce_url(
        admin_url('admin-post.php?action=bakhtech_cs_toggle_status'),
        'bakhtech_cs_toggle_nonce'
    );

    $wp_admin_bar->add_node(array(
        'id'    => 'bakhtech-cs-toggle',
        'title' => $title,
        'href'  => $toggle_url,
        'meta'  => array(
            'title' => 'Toggle Coming Soon Mode',
        ),
    ));
}

function bakhtech_cs_handle_toggle() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    check_admin_referer('bakhtech_cs_toggle_nonce');

    $options = get_option('bakhtech_cs_options');
    if (!is_array($options)) {
        $options = bakhtech_cs_default_options();
    }

    // Toggle
    $options['enabled'] = empty($options['enabled']) ? 1 : 0;
    
    update_option('bakhtech_cs_options', $options);

    // Redirect back to where they came from
    wp_safe_redirect(wp_get_referer() ? wp_get_referer() : admin_url());
    exit;
}
