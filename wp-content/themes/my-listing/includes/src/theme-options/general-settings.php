<?php
/**
* New Theme Options page rendered with the built-in Vue interface.
*
* @since 3.0.0
*/

namespace MyListing\Src\Theme_Options;

use MyListing\Src\Traits\Instantiatable;

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

class General_Settings {
        use Instantiatable;

        const NONCE_ACTION = 'mylisting_theme_options';

        public function __construct() {
                add_action( 'after_setup_theme', [ $this, 'register_menu' ] );
                add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ], 40 );
                add_action( 'wp_ajax_mylisting_theme_options_save', [ $this, 'save_settings' ] );
        }

        /**
        * Register the Theme Options menu once translations are loaded.
        */
        public function register_menu() {
                add_action( 'admin_menu', [ $this, 'register_page' ], 20 );
        }

        /**
        * Register the Theme Tools > Theme Options submenu.
        */
        public function register_page() {
                add_submenu_page(
                        'case27/tools.php',
                        __( 'Theme Options', 'my-listing' ),
                        __( 'Theme Options', 'my-listing' ),
                        'manage_options',
                        'theme-general-settings',
                        [ $this, 'render_page' ]
                );
        }

        /**
        * Render the application container.
        */
        public function render_page() {
                require locate_template( 'templates/admin/theme-options/general-settings.php' );
        }

        /**
        * Localise configuration and enqueue assets for the new interface.
        */
        public function enqueue_assets() {
                if ( empty( $_GET['page'] ) || $_GET['page'] !== 'theme-general-settings' ) { // phpcs:ignore WordPress.Security.NonceVerification
                        return;
                }

                wp_enqueue_media();
                wp_enqueue_style( 'wp-color-picker' );
                wp_enqueue_style( 'mylisting-admin-theme-options' );
                wp_enqueue_script( 'wp-color-picker' );
                // Enable transparency slider for color pickers when requested by fields
                wp_enqueue_script( 'wp-color-picker-alpha' );

                // Load WP Code Editor (CodeMirror) for code fields in Custom Code tab.
                if ( function_exists( 'wp_enqueue_code_editor' ) ) {
                        // Enqueue modes we need. Settings return value can be used if needed by JS.
                        wp_enqueue_code_editor( [ 'type' => 'text/css' ] );
                        wp_enqueue_code_editor( [ 'type' => 'application/javascript' ] );
                        wp_enqueue_code_editor( [ 'type' => 'text/html' ] );
                }

                $repository = Settings_Repository::instance();

                $config = [
                        'nonce'      => wp_create_nonce( self::NONCE_ACTION ),
                        'tabs'       => $repository->get_tabs(),
                        'fields'     => [],
                        'layouts'    => [],
                        'values'     => [],
                        'activeTab'  => 'general',
                        'endpoints'  => [
                                'save' => admin_url( 'admin-ajax.php?action=mylisting_theme_options_save' ),
                        ],
                        'strings'    => [
                                'save'        => __( 'Save changes', 'my-listing' ),
                                'saving'      => __( 'Saving...', 'my-listing' ),
                                'saved'       => __( 'Settings saved.', 'my-listing' ),
                                'error'       => __( 'Something went wrong while saving.', 'my-listing' ),
                                'selectImage' => __( 'Select image', 'my-listing' ),
                                'changeImage' => __( 'Change image', 'my-listing' ),
                                'removeImage' => __( 'Remove image', 'my-listing' ),
                                'noImage'     => __( 'No image selected', 'my-listing' ),
                                'chooseColor' => __( 'Choose color', 'my-listing' ),
                                'dismiss'     => __( 'Dismiss notice', 'my-listing' ),
                        ],
                ];

                wp_enqueue_script( 'mylisting-admin-theme-options' );

                foreach ( $repository->get_tabs() as $tab ) {
                        $key = $tab['key'];
                        $config['fields'][ $key ] = $repository->get_tab_fields( $key );
                        $config['layouts'][ $key ] = $repository->get_tab_layout( $key );
                        $config['values'][ $key ] = $repository->get_values_for_editor( $key );
                }

                wp_localize_script( 'mylisting-admin-theme-options', 'MyListingThemeOptionsConfig', $config );
        }

        /**
        * Persist settings updates from the Vue interface.
        */
        public function save_settings() {
                check_ajax_referer( self::NONCE_ACTION, 'nonce' );

                if ( ! current_user_can( 'manage_options' ) ) {
                        wp_send_json_error( [ 'message' => __( 'You are not allowed to perform this action.', 'my-listing' ) ], 403 );
                }

                $group = isset( $_POST['group'] ) ? sanitize_key( wp_unslash( $_POST['group'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
                if ( ! $group ) {
                        wp_send_json_error( [ 'message' => __( 'Invalid settings group.', 'my-listing' ) ] );
                }

                $raw_values = isset( $_POST['values'] ) ? wp_unslash( $_POST['values'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
                $values     = json_decode( $raw_values, true );

                if ( ! is_array( $values ) ) {
                        wp_send_json_error( [ 'message' => __( 'Invalid payload received.', 'my-listing' ) ] );
                }

                $repository = Settings_Repository::instance();
                if ( ! $repository->has_tab( $group ) ) {
                        wp_send_json_error( [ 'message' => __( 'Invalid settings group.', 'my-listing' ) ] );
                }

                $updated = $repository->update_group( $group, $values );
                if ( is_wp_error( $updated ) ) {
                        wp_send_json_error( [ 'message' => $updated->get_error_message() ] );
                }

                \MyListing\generate_dynamic_styles();

                wp_send_json_success( [
                        'values'  => $repository->get_values_for_editor( $group ),
                        'message' => __( 'Settings saved.', 'my-listing' ),
                ] );
        }
}