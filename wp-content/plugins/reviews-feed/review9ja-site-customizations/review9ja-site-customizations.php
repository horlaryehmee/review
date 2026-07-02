<?php
/**
 * Plugin Name: Review9ja Site Customizations
 * Description: Custom Elementor widgets and site updates for Review9ja.
 * Version: 1.0.0
 * Author: Review9ja
 * Text Domain: review9ja-site-customizations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Review9ja_Site_Customizations_Plugin {

	const VERSION = '1.0.0';
	const SLUG = 'review9ja-site-customizations';

	private static $instance = null;
	private $widget_registered = false;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'elementor/loaded', [ $this, 'on_elementor_loaded' ] );
		add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );

		if ( did_action( 'elementor/loaded' ) ) {
			$this->on_elementor_loaded();
		}
	}

	public function i18n() {
		load_plugin_textdomain( 'review9ja-site-customizations', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function on_elementor_loaded() {
		add_action( 'elementor/init', [ $this, 'register_category' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets_legacy' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_styles' ] );
	}

	public function register_category() {
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		$elements_manager = \Elementor\Plugin::instance()->elements_manager;
		if ( ! method_exists( $elements_manager, 'add_category' ) ) {
			return;
		}

		$elements_manager->add_category( 'review9ja', [
			'title' => __( 'Review9ja', 'review9ja-site-customizations' ),
			'icon' => 'fa fa-plug',
		] );
	}

	public function register_styles() {
		wp_register_style(
			'review9ja-site-customizations',
			plugins_url( 'assets/css/listing-categories.css', __FILE__ ),
			[],
			self::VERSION
		);
	}

	public function register_widgets( $widgets_manager ) {
		if ( $this->widget_registered ) {
			return;
		}

		$this->widget_registered = true;
		require_once __DIR__ . '/includes/class-listing-categories-widget.php';
		$widgets_manager->register( new \Review9ja\Elementor\Listing_Categories_Widget() );
	}

	public function register_widgets_legacy() {
		if ( $this->widget_registered ) {
			return;
		}

		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		$this->widget_registered = true;
		require_once __DIR__ . '/includes/class-listing-categories-widget.php';
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(
			new \Review9ja\Elementor\Listing_Categories_Widget()
		);
	}

	public function admin_notice_missing_elementor() {
		if ( did_action( 'elementor/loaded' ) ) {
			return;
		}

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$message = esc_html__( 'Review9ja Site Customizations requires Elementor to be installed and activated.', 'review9ja-site-customizations' );
		printf( '<div class="notice notice-warning"><p>%s</p></div>', $message );
	}
}

require_once __DIR__ . '/includes/admin-bulk-reviews.php';

Review9ja_Site_Customizations_Plugin::instance();
