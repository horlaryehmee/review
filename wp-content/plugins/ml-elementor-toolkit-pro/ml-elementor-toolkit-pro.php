<?php
/**
 * Plugin Name: MyListing Elementor Toolkit Pro
 * Description: Adds extra functionality to the MyListing Elementor Toolkit plugin, such as preview card design and multiple widgets.
 * Plugin URI:  https://yellowwave.eu/ml-elementor-toolkit
 * Version:     1.7.2
 * Author:      YellowWave
 * Author URI:  https://yellowwave.nl
 * Text Domain: ml-elementor-toolkit
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly
 
/**
 * Main MyListing Elementor Toolkit Class
 *
 * The init class that runs the MyListing Elementor Toolkit plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.0.0
 */
final class ML_Elementor_Toolkit_Pro {
 
    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const VERSION = '1.7.2';
 
    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.9.0';
 
    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Minimum MyListing Theme Version
     *
     * @since 1.0.0
     * @var string Minimum MyListing version required to run the plugin.
     */
    const MINIMUM_MYLISTING_VERSION = '2.6';

    public static function autoload( $class_input ){
        $namespace = 'ML_Elementor_Toolkit_Pro\\';
  
        if (strpos($class_input, $namespace) !== 0) {
            return;
        }
        
        $class = str_replace($namespace, '', $class_input);

        if (strpos($class_input, 'DynamicTags') !== 0) {
            $class = str_replace('DynamicTags', 'dynamic-tags', $class);
        }

        $class = str_replace( '_', '-', $class );
        $class = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($class));

        $directory = plugin_dir_path( __FILE__ );
        $path = $directory . $class . '.php';
     
        if (file_exists($path)) {
            require_once($path);
        } 
    }
 
    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {

        // Load translation
        add_action( 'init', array( $this, 'i18n' ) );
 
        // $this->init();
        // Init Plugin
        add_action( 'init', array( $this, 'init' ) );
    }
 
    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain( 'ml-elementor-toolkit-pro' );
    }
 
    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function init() {

        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // Check for ML Toolkit Active
        if (!is_plugin_active( 'mylisting-elementor-toolkit/ml-elementor-toolkit.php' )) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_ml_toolkit' ) );
            return;
        }
 
        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
            return;
        }

        // Check for Elementor Pro installed
        if (!defined( 'ELEMENTOR_PRO_VERSION' )) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor_pro' ) );
            return;
        }

        if(!function_exists('mylisting')){
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_mylisting' ) );
            return;
        }
 
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }
 
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }

        $my_listing_theme = wp_get_theme( 'my-listing' );
        if( version_compare($my_listing_theme->get('Version'), self::MINIMUM_MYLISTING_VERSION, '<') ){
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_mylisting_version' ) );
            return;
        }
 
        // Once we get here, We have passed all validation checks so we can safely include our plugin
        require_once( 'plugin.php' );

        require_once( __DIR__ . '/api.php' );
        // dynamic background fix
        require_once( __DIR__ . '/includes/dynamic-style.php' );

        require_once( __DIR__ . '/includes/admin-settings.php' );
    }
 
    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_ml_toolkit() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $ml_toolkit_path = WP_PLUGIN_DIR . '/mylisting-elementor-toolkit/ml-elementor-toolkit.php';
        if( !file_exists( $ml_toolkit_path ) ){
            $action = 'install-plugin';
            $slug = 'mylisting-elementor-toolkit';
            $url = wp_nonce_url(
                add_query_arg(
                    array(
                        'action' => $action,
                        'plugin' => $slug
                    ),
                    admin_url( 'update.php' )
                ),
                $action.'_'.$slug
            );
            $btn_text = __('Install', 'ml-elementor-toolkit-pro');
        } else{
            $slug = 'mylisting-elementor-toolkit/ml-elementor-toolkit.php';
            $url = wp_nonce_url(
                add_query_arg(
                    array(
                        'action' => 'activate',
                        'plugin' => $slug
                    ),
                    admin_url( 'plugins.php' )
                ),
                'activate-plugin_'.$slug
            );
            $btn_text = __('Activate', 'ml-elementor-toolkit-pro');
        }

        $message = sprintf(
            esc_html__( '%1$s requires %2$s to be installed and activated.', 'ml-elementor-toolkit-pro' ),
            '<strong>' . esc_html__( 'MyListing Elementor Toolkit Pro', 'ml-elementor-toolkit-pro' ) . '</strong>',
            '<strong>' . esc_html__( 'MyListing Elementor Toolkit (Free)', 'ml-elementor-toolkit-pro' ) . '</strong>'
        );
        $btn = sprintf( 
            '<a class="button" href="%1$s">%2$s</a>', 
            $url,
            $btn_text
        );
 
        printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p><p>%2$s</p></div>', $message, $btn );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ml-elementor-toolkit-pro' ),
        '<strong>' . esc_html__( 'MyListing Elementor Toolkit', 'ml-elementor-toolkit-pro' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'ml-elementor-toolkit-pro' ) . '</strong>'
        );
 
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
 
    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor Pro installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_elementor_pro() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $message = sprintf(
      	/* translators: 1: Plugin name 2: Elementor Pro */
      	esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ml-elementor-toolkit-pro' ),
		'<strong>' . esc_html__( 'MyListing Elementor Toolkit', 'ml-elementor-toolkit-pro' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor Pro', 'ml-elementor-toolkit-pro' ) . '</strong>'
		);
 
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_missing_mylisting() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ml-elementor-toolkit-pro' ),
        '<strong>' . esc_html__( 'MyListing Elementor Toolkit Pro', 'ml-elementor-toolkit-pro' ) . '</strong>',
        '<strong>' . esc_html__( 'My Listing Theme', 'ml-elementor-toolkit-pro' ) . '</strong>'
        );
 
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
        esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ml-elementor-toolkit-pro' ),
        '<strong>' . esc_html__( 'Elementor MyListing Elementor', 'ml-elementor-toolkit-pro' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'ml-elementor-toolkit-pro' ) . '</strong>',
        self::MINIMUM_ELEMENTOR_VERSION
        );
 
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
 
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $message = sprintf(
      /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ml-elementor-toolkit-pro' ),
      '<strong>' . esc_html__( 'MyListing Elementor Toolkit Pro', 'ml-elementor-toolkit-pro' ) . '</strong>',
      '<strong>' . esc_html__( 'PHP', 'ml-elementor-toolkit-pro' ) . '</strong>',
      self::MINIMUM_PHP_VERSION
    );
 
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_mylisting_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
 
        $message = sprintf(
      /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ml-elementor-toolkit-pro' ),
      '<strong>' . esc_html__( 'MyListing Elementor Toolkit Pro', 'ml-elementor-toolkit-pro' ) . '</strong>',
      '<strong>' . esc_html__( 'My Listing Theme', 'ml-elementor-toolkit-pro' ) . '</strong>',
      self::MINIMUM_MYLISTING_VERSION
    );
 
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

}

spl_autoload_register( array( 'ML_Elementor_Toolkit_Pro', 'autoload' ) );

// Load ML_Elementor_Toolkit_Pro_Updater class if it exists.
if ( ! class_exists( 'ML_Elementor_Toolkit_Pro_Updater' ) ) {
    // Uncomment next line if this is a plugin
    require_once( plugin_dir_path( __FILE__ ) . 'updater-client.php' );
}


// Instantiate ML_Elementor_Toolkit_Pro_Updater class object if the ML_Elementor_Toolkit_Pro_Updater class is loaded.
if ( class_exists( 'ML_Elementor_Toolkit_Pro_Updater' ) ) {
    // Preferred positive integer product_id.
    $ml_toolkit_pro_updater = new ML_Elementor_Toolkit_Pro_Updater( 
        __FILE__, 
        52595, 
        \ML_Elementor_Toolkit_Pro::VERSION, 
        'plugin', 
        'https://plugins.yellowwave.eu/', 
        'MyListing Elementor Toolkit Pro',
        'ml-elementor-toolkit-pro'
    );
}

// Instantiate ML_Elementor_Toolkit_Pro.
new ML_Elementor_Toolkit_Pro();