<?php
/**
 * Plugin Name: Review9ja Explore Listings (Alt)
 * Description: Duplicate Explore Listings Elementor widget for alternative designs.
 * Version: 1.0.13
 * Author: Bakare Olayemi
 * Text Domain: review9ja-explore-listings-duplicate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Review9ja_Explore_Listings_Duplicate_Plugin {

	const VERSION = '1.0.13';
	const SLUG = 'review9ja-explore-listings-duplicate';

	private static $instance = null;
	private $widgets_registered = false;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'elementor/loaded', [ $this, 'on_elementor_loaded' ] );
		add_action( 'wp_head', [ $this, 'output_star_ratings_css' ], 2000 );
		add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );

		if ( did_action( 'elementor/loaded' ) ) {
			$this->on_elementor_loaded();
		}
	}

	public function i18n() {
		load_plugin_textdomain( 'review9ja-explore-listings-duplicate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function on_elementor_loaded() {
		add_action( 'elementor/init', [ $this, 'register_category' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets_legacy' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_assets' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_assets' ] );
	}

	public function register_category() {
		if ( ! class_exists( '\\Elementor\\Plugin' ) ) {
			return;
		}

		$elements_manager = \Elementor\Plugin::instance()->elements_manager;
		if ( ! method_exists( $elements_manager, 'add_category' ) ) {
			return;
		}

		$elements_manager->add_category( 'review9ja', [
			'title' => __( 'Review9ja', 'review9ja-explore-listings-duplicate' ),
			'icon' => 'fa fa-plug',
		] );
	}

	public function register_assets() {
		wp_register_style(
			'review9ja-explore-listings-duplicate',
			plugins_url( 'assets/css/explore-duplicate.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_style(
			'review9ja-star-ratings',
			plugins_url( 'assets/css/star-ratings.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_enqueue_style( 'review9ja-star-ratings' );
	}

	public function output_star_ratings_css() {
		$css_path = __DIR__ . '/assets/css/star-ratings.css';
		if ( ! file_exists( $css_path ) ) {
			return;
		}

		$css = file_get_contents( $css_path );
		if ( ! $css ) {
			return;
		}

		printf( '<style id="review9ja-star-ratings-inline-alt">%s</style>', $css );
	}

	public function register_widgets( $widgets_manager ) {
		if ( $this->widgets_registered ) {
			return;
		}

		$this->widgets_registered = true;
		require_once __DIR__ . '/includes/class-explore-listings-duplicate-widget.php';
		$widgets_manager->register( new \Review9ja\Elementor\Explore_Listings_Duplicate_Widget() );
	}

	public function register_widgets_legacy() {
		if ( $this->widgets_registered ) {
			return;
		}

		if ( ! class_exists( '\\Elementor\\Plugin' ) ) {
			return;
		}

		$this->widgets_registered = true;
		require_once __DIR__ . '/includes/class-explore-listings-duplicate-widget.php';
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(
			new \Review9ja\Elementor\Explore_Listings_Duplicate_Widget()
		);
	}

	public function admin_notice_missing_elementor() {
		if ( did_action( 'elementor/loaded' ) ) {
			return;
		}

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$message = esc_html__( 'Review9ja Explore Listings (Alt) requires Elementor to be installed and activated.', 'review9ja-explore-listings-duplicate' );
		printf( '<div class="notice notice-warning"><p>%s</p></div>', $message );
	}

}

Review9ja_Explore_Listings_Duplicate_Plugin::instance();
