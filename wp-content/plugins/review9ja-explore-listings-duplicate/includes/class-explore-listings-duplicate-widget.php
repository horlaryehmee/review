<?php
namespace Review9ja\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Explore_Listings_Duplicate_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'review9ja-explore-listings-alt';
	}

	public function get_title() {
		return __( 'Review9ja > Explore Listings (Alt)', 'review9ja-explore-listings-duplicate' );
	}

	public function get_icon() {
		return 'eicon-post';
	}

	public function get_categories() {
		return [ 'review9ja' ];
	}

	public function get_keywords() {
		return [ 'explore', 'listing', 'mylisting', 'map', 'review9ja' ];
	}

	public function get_script_depends() {
		return [ 'ml:explore' ];
	}

	public function get_style_depends() {
		return [ 'review9ja-explore-listings-duplicate' ];
	}

	protected function _register_controls() {
		$this->start_controls_section( 'section_content_block', [
			'label' => esc_html__( 'Content', 'review9ja-explore-listings-duplicate' ),
		] );

		$this->add_control( '27_title', [
			'label' => __( 'Title', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'What are you looking for?', 'review9ja-explore-listings-duplicate' ),
		] );

		$this->add_control( '27_subtitle', [
			'label' => __( 'Subtitle', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::TEXT,
		] );

		$this->add_control( '27_template', [
			'label' => __( 'Template', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'default' => 'explore-1',
			'options' => [
				'explore-1' => __( 'Template 1', 'review9ja-explore-listings-duplicate' ),
				'explore-2' => __( 'Template 2', 'review9ja-explore-listings-duplicate' ),
				'explore-no-map' => __( 'Template 3', 'review9ja-explore-listings-duplicate' ),
				'explore-classic' => __( 'Template 4', 'review9ja-explore-listings-duplicate' ),
			],
		] );

		$this->add_control( '27_finder_columns', [
			'label' => __( 'Columns', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'default' => 'finder-one-columns',
			'options' => [
				'finder-one-columns' => __( 'One', 'review9ja-explore-listings-duplicate' ),
				'finder-two-columns' => __( 'Two', 'review9ja-explore-listings-duplicate' ),
				'finder-three-columns' => __( 'Three', 'review9ja-explore-listings-duplicate' ),
			],
			'condition' => [ '27_template' => [ 'explore-1', 'explore-2', 'explore-classic' ] ],
		] );

		$this->add_control( '27_scroll_to_results', [
			'label' => __( 'Automatically scroll to results?', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'review9ja-explore-listings-duplicate' ),
			'label_off' => __( 'No', 'review9ja-explore-listings-duplicate' ),
			'return_value' => 'yes',
			'condition' => [ '27_template' => [ 'explore-2' ] ],
		] );

		$this->add_control( '27_disable_isotope', [
			'label' => __( 'Disable isotope masonry?', 'review9ja-explore-listings-duplicate' ),
			'description' => __( 'Disabling isotope will improve loading speed.', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'review9ja-explore-listings-duplicate' ),
			'label_off' => __( 'No', 'review9ja-explore-listings-duplicate' ),
			'return_value' => 'yes',
		] );

		$this->add_control( '27_disable_live_url_update', [
			'label' => __( 'Disable live url update?', 'review9ja-explore-listings-duplicate' ),
			'description' => __( 'When listing filters are used in Explore page, the url in the browser\'s address-bar is updated to reflect their new values. You can use this option to disable that behavior.', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'review9ja-explore-listings-duplicate' ),
			'label_off' => __( 'No', 'review9ja-explore-listings-duplicate' ),
			'return_value' => 'yes',
		] );

		$listing_types = function_exists( '\\MyListing\\get_posts_dropdown' )
			? \MyListing\get_posts_dropdown( 'case27_listing_type', 'post_name', 'post_title', true )
			: [];

		$this->add_control( '27_listing_types', [
			'label' => __( 'Listing Types', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => [ [
				'name' => 'type',
				'label' => __( 'Select Listing Type', 'review9ja-explore-listings-duplicate' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $listing_types,
				'default' => '',
				'label_block' => true,
			] ],
			'title_field' => sprintf( '{{{ (%s)[type] || "n/a" }}}', trim( wp_json_encode( $listing_types ), '"' ) ),
		] );

		$this->add_control( 'types_template', [
			'label' => _x( 'Display listing types as', 'Elementor > Explore widget settings', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'default' => 'topbar',
			'options' => [
				'topbar' => _x( 'Navbar', 'Elementor > Explore widget settings', 'review9ja-explore-listings-duplicate' ),
				'dropdown' => _x( 'Dropdown', 'Elementor > Explore widget settings', 'review9ja-explore-listings-duplicate' ),
			],
		] );

		$this->add_control( 'current_taxonomy_default_values', [
			'label' => __( 'Change default values to current taxonomy.', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'review9ja-explore-listings-duplicate' ),
			'label_off' => __( 'No', 'review9ja-explore-listings-duplicate' ),
			'return_value' => 'yes',
		] );

		$this->add_control( 'default_values_string', [
			'label' => __( 'Default filter values', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
			'label_block' => true,
			'placeholder' => home_url( '/explore?type=events&sort=latest' ),
			'description' => __( 'After filtering results a certain way, you can copy the generated URL from the address bar and paste it here to use it as default filter values.', 'review9ja-explore-listings-duplicate' ),
			'condition' => [ 'current_taxonomy_default_values' => '' ],
		] );

		$this->add_control( 'review9ja_wrapper_class', [
			'label' => __( 'Wrapper Class', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
			'label_block' => true,
			'description' => __( 'Add extra classes to target this Explore widget variant with custom CSS (e.g. review9ja-explore-variant).', 'review9ja-explore-listings-duplicate' ),
		] );

		$this->add_control( 'cts_map_settings', [
			'label' => __( 'Map', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( '27_map_skin', [
			'label' => __( 'Map Skin', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'skin1',
			'options' => function_exists( '\\MyListing\\Apis\\Maps\\get_skins' ) ? \MyListing\Apis\Maps\get_skins() : [],
		] );

		$this->add_control( '27_scroll_wheel', [
			'label' => __( 'Zoom map using mouse scroll?', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'review9ja-explore-listings-duplicate' ),
			'label_off' => __( 'No', 'review9ja-explore-listings-duplicate' ),
			'return_value' => 'yes',
			'condition' => [ '27_template' => [ 'explore-1', 'explore-2' ] ],
		] );

		$this->add_control( 'cts_map_default_lat', [
			'label' => _x( 'Default latitude', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'description' => _x( 'When there are no listings to show on the map, this will be used as the default location.', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 51.492,
			'min' => -90,
			'max' => 90,
		] );

		$this->add_control( 'cts_map_default_lng', [
			'label' => _x( 'Default longitude', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'description' => _x( 'When there are no listings to show on the map, this will be used as the default location.', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => -0.130,
			'min' => -180,
			'max' => 180,
		] );

		$this->add_control( 'cts_map_default_zoom', [
			'label' => _x( 'Default zoom level', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'description' => _x( 'Set the map zoom level when there are no map markers to show.', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 11,
			'min' => 0,
			'max' => 30,
		] );

		$this->add_control( 'cts_map_min_zoom', [
			'label' => _x( 'Minimum zoom level', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'description' => _x( 'Set the minimum zoom level allowed.', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 2,
			'min' => 0,
			'max' => 30,
		] );

		$this->add_control( 'cts_map_max_zoom', [
			'label' => _x( 'Maximum zoom level', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'description' => _x( 'Set the maximum zoom level allowed.', 'Explore map', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 18,
			'min' => 0,
			'max' => 30,
		] );

		$this->add_control( 'categories_tab_heading', [
			'label' => __( 'Categories/Taxonomies Tab', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'categories_count', [
			'label' => __( 'Item Count', 'review9ja-explore-listings-duplicate' ),
			'description' => __( 'Set the amount of terms to show in taxonomy tabs. Leave blank to show all.', 'review9ja-explore-listings-duplicate' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'default' => 10,
			'min' => 0,
		] );

		if ( function_exists( '\\MyListing\\Elementor\\apply_overlay_controls' ) ) {
			\MyListing\Elementor\apply_overlay_controls(
				$this,
				'27_categories_overlay',
				__( 'Set an overlay for taxonomy terms', 'review9ja-explore-listings-duplicate' )
			);
		}

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		if ( ! function_exists( 'c27' ) ) {
			return;
		}

		if ( function_exists( 'wp_print_styles' ) ) {
			wp_print_styles( 'mylisting-explore-widget' );
		}

		$default_values = $this->get_settings( 'default_values_string' );

		if ( $this->get_settings( 'current_taxonomy_default_values' ) === 'yes' && is_tax() ) {
			$term = get_queried_object();
			if ( $term ) {
				$base_taxonomies = [
					'job_listing_category' => 'category',
					'case27_job_listing_tags' => 'tag',
				];

				$taxonomy = isset( $base_taxonomies[ $term->taxonomy ] ) ? $base_taxonomies[ $term->taxonomy ] : $term->taxonomy;
				$slug = $term->slug;

				$default_values = "?$taxonomy=$slug";
			}
		}

		$template = $this->get_settings( '27_template' );
		$wrapper_classes = [ 'review9ja-explore-duplicate', 'review9ja-explore-template-' . sanitize_html_class( $template ) ];
		$extra_classes = $this->get_settings( 'review9ja_wrapper_class' );
		if ( is_string( $extra_classes ) && $extra_classes !== '' ) {
			$tokens = preg_split( '/\s+/', $extra_classes, -1, PREG_SPLIT_NO_EMPTY );
			foreach ( $tokens as $token ) {
				$wrapper_classes[] = sanitize_html_class( $token );
			}
		}

		$wrapper_classes = array_values( array_filter( $wrapper_classes ) );
		$wrapper_class_attr = implode( ' ', array_unique( $wrapper_classes ) );
		?>
		<div class="<?php echo esc_attr( $wrapper_class_attr ); ?>">
			<?php
			c27()->get_section( 'explore', [
				'title' => $this->get_settings( '27_title' ),
				'subtitle' => $this->get_settings( '27_subtitle' ),
				'listing_types' => $this->get_settings( '27_listing_types' ),
				'types_template' => $this->get_settings( 'types_template' ),
				'categories' => [
					'count' => $this->get_settings( 'categories_count' ),
				],
				'scroll_to_results' => 'yes' === $this->get_settings( '27_scroll_to_results' ),
				'disable_live_url_update' => 'yes' === $this->get_settings( '27_disable_live_url_update' ),
				'disable_isotope' => 'yes' === $this->get_settings( '27_disable_isotope' ),
				'template' => $template,
				'finder_columns' => $this->get_settings( '27_finder_columns' ),
				'default_values' => $default_values,
				'is_edit_mode' => \Elementor\Plugin::$instance->editor->is_edit_mode(),
				'categories_overlay' => [
					'type' => $this->get_settings( '27_categories_overlay' ),
					'gradient' => $this->get_settings( '27_categories_overlay__gradient' ),
					'solid_color' => $this->get_settings( '27_categories_overlay__solid_color' ),
				],
				'map' => [
					'default_lat' => $this->get_settings( 'cts_map_default_lat' ),
					'default_lng' => $this->get_settings( 'cts_map_default_lng' ),
					'default_zoom' => $this->get_settings( 'cts_map_default_zoom' ),
					'min_zoom' => $this->get_settings( 'cts_map_min_zoom' ),
					'max_zoom' => $this->get_settings( 'cts_map_max_zoom' ),
					'skin' => $this->get_settings( '27_map_skin' ),
					'scrollwheel' => $this->get_settings( '27_scroll_wheel' ),
				],
			] );
			?>
		</div>
		<?php
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}






