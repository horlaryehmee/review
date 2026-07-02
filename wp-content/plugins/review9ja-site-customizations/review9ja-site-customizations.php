<?php
/**
 * Plugin Name: Review9ja Site Customizations
 * Description: Custom Elementor widgets and site updates for Review9ja.
 * Version: 1.0.84
 * Author: Review9ja
 * Text Domain: review9ja-site-customizations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Review9ja_Site_Customizations_Plugin {

	const VERSION = '1.0.84';
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
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'wp_head', [ $this, 'output_star_ratings_css' ], 2000 );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_filter( 'mylisting/compile-string-field', [ $this, 'maybe_trim_location_field' ], 20, 4 );
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

		wp_register_style(
			'review9ja-listing-preview-footer',
			plugins_url( 'assets/css/listing-preview-footer.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_style(
			'review9ja-star-ratings',
			plugins_url( 'assets/css/star-ratings.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_style(
			'review9ja-listing-header',
			plugins_url( 'assets/css/listing-header.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_style(
			'review9ja-reviews-summary',
			plugins_url( 'assets/css/reviews-summary.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_style(
			'review9ja-reviews-list',
			plugins_url( 'assets/css/reviews-list.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_register_style(
			'review9ja-review-card',
			plugins_url( 'assets/css/review-card.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_enqueue_style( 'review9ja-listing-preview-footer' );
		wp_enqueue_style( 'review9ja-star-ratings' );
		wp_enqueue_style( 'review9ja-listing-header' );
		wp_enqueue_style( 'review9ja-reviews-summary' );
		wp_enqueue_style( 'review9ja-reviews-list' );
		wp_enqueue_style( 'review9ja-review-card' );
	}

	public function register_scripts() {
		wp_register_script(
			'review9ja-explore-star-size',
			plugins_url( 'assets/js/explore-star-size.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		wp_enqueue_script( 'review9ja-explore-star-size' );

		wp_register_script(
			'review9ja-listing-review-scroll',
			plugins_url( 'assets/js/listing-review-scroll.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-listing-review-scroll' );
		}

		wp_register_script(
			'review9ja-listing-tabs-fix',
			plugins_url( 'assets/js/listing-tabs-fix.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-listing-tabs-fix' );
		}

		wp_register_script(
			'review9ja-review-card-footer',
			plugins_url( 'assets/js/review-card-footer.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-review-card-footer' );
		}

		wp_register_script(
			'review9ja-review-reply-actions',
			plugins_url( 'assets/js/review-reply-actions.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-review-reply-actions' );
		}

		wp_register_script(
			'review9ja-review-reply-tighten',
			plugins_url( 'assets/js/review-reply-tighten.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-review-reply-tighten' );
		}

		wp_register_script(
			'review9ja-review-submitted-notice',
			plugins_url( 'assets/js/review-submitted-notice.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-review-submitted-notice' );
			wp_add_inline_script(
				'review9ja-review-submitted-notice',
				'window.Review9jaNoticeSettings=' . wp_json_encode( [
					'userId' => get_current_user_id(),
				] ) . ';',
				'before'
			);
		}

		wp_register_script(
			'review9ja-review-form-custom-stars',
			plugins_url( 'assets/js/review-form-custom-stars.js', __FILE__ ),
			[],
			self::VERSION,
			false
		);

		if ( is_singular( 'job_listing' ) ) {
			wp_enqueue_script( 'review9ja-review-form-custom-stars' );
			wp_add_inline_script(
				'review9ja-review-form-custom-stars',
				'(function(){document.documentElement.classList.add("r9-review-stars-js");})();',
				'before'
			);
		}

		$address_max = (int) get_option( 'review9ja_address_max_length', 30 );

		$star_color = get_option( 'review9ja_star_color', '#16a34a' );
		$star_color = sanitize_hex_color( $star_color );
		if ( empty( $star_color ) ) {
			$star_color = '#16a34a';
		}
		wp_add_inline_script(
			'review9ja-explore-star-size',
			'window.Review9jaExploreSettings=' . wp_json_encode( [
				'addressMax' => $address_max,
				'starColor' => $star_color,
			] ) . ';',
			'before'
		);
	}

	public function register_settings() {
		register_setting( 'general', 'review9ja_address_max_length', [
			'type' => 'integer',
			'sanitize_callback' => function( $value ) {
				$value = (int) $value;
				return $value > 0 ? $value : 0;
			},
			'default' => 30,
		] );

		$current_limit = (int) get_option( 'review9ja_address_max_length', 0 );
		if ( $current_limit === 0 || $current_limit === 20 ) {
			update_option( 'review9ja_address_max_length', 30 );
		}

		add_settings_field(
			'review9ja_address_max_length',
			__( 'Explore address length', 'review9ja-site-customizations' ),
			function() {
				$value = (int) get_option( 'review9ja_address_max_length', 30 );
				printf(
					'<input type="number" min="0" step="1" name="review9ja_address_max_length" value="%d" class="small-text" />',
					$value
				);
				echo '<p class="description">0 = no limit. Applies to location/address output in listing previews. You can also use [[location.20]] in listing type labels to override per field.</p>';
			},
			'general'
		);

		register_setting( 'general', 'review9ja_star_color', [
			'type' => 'string',
			'sanitize_callback' => function( $value ) {
				$color = sanitize_hex_color( $value );
				return $color ? $color : '#16a34a';
			},
			'default' => '#16a34a',
		] );

		add_settings_field(
			'review9ja_star_color',
			__( 'Star rating color', 'review9ja-site-customizations' ),
			function() {
				$value = get_option( 'review9ja_star_color', '#16a34a' );
				$value = sanitize_hex_color( $value );
				if ( empty( $value ) ) {
					$value = '#16a34a';
				}
				printf(
					'<input type="color" name="review9ja_star_color" value="%s" />',
					esc_attr( $value )
				);
				echo '<p class="description">Custom color for the Review9ja star rating fill (used across the site).</p>';
			},
			'general'
		);
	}

	public function maybe_trim_location_field( $value, $field, $modifier, $listing ) {
		if ( ! is_object( $field ) || ! method_exists( $field, 'get_type' ) ) {
			return $value;
		}

		$field_type = $field->get_type();
		$field_key = method_exists( $field, 'get_key' ) ? $field->get_key() : '';
		$field_key = is_string( $field_key ) ? strtolower( $field_key ) : '';

		$is_address_field = $field_type === 'location'
			|| $field_key === 'location'
			|| $field_key === 'address'
			|| strpos( $field_key, 'address' ) !== false
			|| strpos( $field_key, 'location' ) !== false;

		if ( ! $is_address_field ) {
			return $value;
		}

		if ( in_array( $modifier, [ 'lat', 'lng' ], true ) ) {
			return $value;
		}

		$limit = 0;
		if ( is_string( $modifier ) && ctype_digit( $modifier ) ) {
			$limit = (int) $modifier;
		} else {
			$limit = (int) get_option( 'review9ja_address_max_length', 0 );
		}

		if ( $limit <= 0 ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			if ( isset( $value['address'] ) ) {
				$value = $value['address'];
			} else {
				$value = join( ', ', $value );
			}
		}

		$value = trim( (string) $value );
		$value = preg_replace( '/\s+/', ' ', str_replace( [ "\r", "\n" ], ' ', $value ) );
		if ( $value === '' ) {
			return $value;
		}

		$length = function_exists( 'mb_strlen' ) ? mb_strlen( $value ) : strlen( $value );
		if ( $length <= $limit ) {
			return $value;
		}

		$truncated = function_exists( 'mb_substr' ) ? mb_substr( $value, 0, $limit ) : substr( $value, 0, $limit );
		return rtrim( $truncated ) . '...';
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

		$star_color = sanitize_hex_color( get_option( 'review9ja_star_color', '#16a34a' ) );
		if ( empty( $star_color ) ) {
			$star_color = '#16a34a';
		}
		$css .= sprintf( "\n:root{--review9ja-star-green:%s;}", $star_color );

		printf( '<style id="review9ja-star-ratings-inline">%s</style>', $css );
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
