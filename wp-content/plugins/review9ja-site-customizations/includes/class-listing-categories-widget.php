<?php
namespace Review9ja\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Listing_Categories_Widget extends Widget_Base {

	public function get_name() {
		return 'review9ja-listing-categories';
	}

	public function get_title() {
		return __( 'Review9ja > Listing Categories', 'review9ja-site-customizations' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'review9ja' ];
	}

	public function get_keywords() {
		return [ 'listing categories', 'taxonomy', 'mylisting', 'my listing', 'cards' ];
	}

	public function get_style_depends() {
		return [ 'review9ja-site-customizations' ];
	}

	protected function _register_controls() {
		$custom_taxonomies = function_exists( 'mylisting_custom_taxonomies' )
			? mylisting_custom_taxonomies()
			: [];

		$this->start_controls_section( 'section_content', [
			'label' => __( 'Listing Categories', 'review9ja-site-customizations' ),
		] );

		$this->add_control( 'taxonomy', [
			'label' => __( 'Taxonomy', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'job_listing_category',
			'options' => array_merge( [
				'job_listing_category' => __( 'Categories', 'my-listing' ),
				'region' => __( 'Regions', 'my-listing' ),
				'case27_job_listing_tags' => __( 'Tags', 'my-listing' ),
				'listing_types' => __( 'Listing Types', 'my-listing' ),
			], $custom_taxonomies ),
		] );

		$this->add_control( 'show_all_terms', [
			'label' => __( 'Show All Terms', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', 'review9ja-site-customizations' ),
			'label_off' => __( 'Select', 'review9ja-site-customizations' ),
			'return_value' => 'yes',
			'default' => '',
			'description' => __( 'Turn off to choose specific terms.', 'review9ja-site-customizations' ),
		] );

		$this->add_control( 'hide_empty', [
			'label' => __( 'Hide Empty Terms', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => __( 'Yes', 'review9ja-site-customizations' ),
			'label_off' => __( 'No', 'review9ja-site-customizations' ),
			'return_value' => 'yes',
			'default' => '',
		] );

		$this->add_control( 'order_by', [
			'label' => __( 'Order By', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'name',
			'options' => [
				'name' => __( 'Name', 'review9ja-site-customizations' ),
				'count' => __( 'Count', 'review9ja-site-customizations' ),
				'slug' => __( 'Slug', 'review9ja-site-customizations' ),
				'id' => __( 'ID', 'review9ja-site-customizations' ),
				'term_order' => __( 'Term Order', 'review9ja-site-customizations' ),
			],
			'condition' => [
				'show_all_terms' => 'yes',
			],
		] );

		$this->add_control( 'order', [
			'label' => __( 'Order', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'ASC',
			'options' => [
				'ASC' => __( 'ASC', 'review9ja-site-customizations' ),
				'DESC' => __( 'DESC', 'review9ja-site-customizations' ),
			],
			'condition' => [
				'show_all_terms' => 'yes',
			],
		] );

		$this->add_control( 'limit', [
			'label' => __( 'Limit', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 0,
			'min' => 0,
			'description' => __( 'Set to 0 to show all terms.', 'review9ja-site-customizations' ),
			'condition' => [
				'show_all_terms' => 'yes',
			],
		] );

		$this->add_control( 'select_categories', [
			'label' => __( 'Select Categories', 'my-listing' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => [ [
				'name' => 'category_id',
				'label' => __( 'Select Category', 'my-listing' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_term_options( 'job_listing_category' ),
				'label_block' => true,
				'default' => '',
			] ],
			'title_field' => 'Item #{{{ category_id }}}',
			'condition' => [
				'taxonomy' => 'job_listing_category',
				'show_all_terms!' => 'yes',
			],
		] );

		$this->add_control( 'select_regions', [
			'label' => __( 'Select Regions', 'my-listing' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => [ [
				'name' => 'category_id',
				'label' => __( 'Select Region', 'my-listing' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_term_options( 'region' ),
				'label_block' => true,
				'default' => '',
			] ],
			'title_field' => 'Item #{{{ category_id }}}',
			'condition' => [
				'taxonomy' => 'region',
				'show_all_terms!' => 'yes',
			],
		] );

		$this->add_control( 'select_tags', [
			'label' => __( 'Select Tags', 'my-listing' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => [ [
				'name' => 'category_id',
				'label' => __( 'Select Tag', 'my-listing' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_term_options( 'case27_job_listing_tags' ),
				'label_block' => true,
				'default' => '',
			] ],
			'title_field' => 'Item #{{{ category_id }}}',
			'condition' => [
				'taxonomy' => 'case27_job_listing_tags',
				'show_all_terms!' => 'yes',
			],
		] );

		$listing_types = $this->get_listing_type_options();
		$this->add_control( 'select_listing_types', [
			'label' => __( 'Select Listing Types', 'my-listing' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => [ [
				'name' => 'category_id',
				'label' => __( 'Select Listing Type', 'my-listing' ),
				'type' => is_array( $listing_types ) && ! empty( $listing_types )
					? Controls_Manager::SELECT2
					: Controls_Manager::TEXT,
				'options' => $listing_types,
				'label_block' => true,
				'default' => '',
			] ],
			'condition' => [
				'taxonomy' => 'listing_types',
				'show_all_terms!' => 'yes',
			],
		] );

		if ( $custom_taxonomies ) {
			foreach ( $custom_taxonomies as $slug => $label ) {
				$this->add_control( 'select_' . $slug, [
					'label' => sprintf( _x( 'Select %s', 'custom taxonomy', 'my-listing' ), $label ),
					'type' => Controls_Manager::REPEATER,
					'fields' => [ [
						'name' => 'category_id',
						'label' => __( 'Select Item', 'my-listing' ),
						'type' => Controls_Manager::SELECT2,
						'options' => $this->get_term_options( $slug ),
						'label_block' => true,
						'default' => '',
					] ],
					'title_field' => 'Item #{{{ category_id }}}',
					'condition' => [
						'taxonomy' => $slug,
						'show_all_terms!' => 'yes',
					],
				] );
			}
		}

		$this->add_responsive_control( 'columns', [
			'label' => __( 'Columns', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 4,
			'tablet_default' => 2,
			'mobile_default' => 1,
			'min' => 1,
			'max' => 6,
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-grid' => '--review9ja-lc-columns: {{VALUE}};',
			],
		] );

		$this->add_control( 'gap', [
			'label' => __( 'Gap', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'size' => 24,
				'unit' => 'px',
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 60,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-grid' => '--review9ja-lc-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_card', [
			'label' => __( 'Card', 'review9ja-site-customizations' ),
			'tab' => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_background', [
			'label' => __( 'Background', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-card' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label' => __( 'Padding', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default' => [
				'top' => 24,
				'right' => 16,
				'bottom' => 20,
				'left' => 16,
				'unit' => 'px',
				'isLinked' => false,
			],
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'card_radius', [
			'label' => __( 'Border Radius', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default' => [
				'top' => 18,
				'right' => 18,
				'bottom' => 18,
				'left' => 18,
				'unit' => 'px',
				'isLinked' => true,
			],
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name' => 'card_shadow',
			'selector' => '{{WRAPPER}} .review9ja-lc-card',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_icon', [
			'label' => __( 'Icon', 'review9ja-site-customizations' ),
			'tab' => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'icon_wrap_size', [
			'label' => __( 'Wrapper Size', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'size' => 54,
				'unit' => 'px',
			],
			'range' => [
				'px' => [
					'min' => 30,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label' => __( 'Icon Size', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'size' => 22,
				'unit' => 'px',
			],
			'range' => [
				'px' => [
					'min' => 12,
					'max' => 60,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .review9ja-lc-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .review9ja-lc-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'icon_spacing', [
			'label' => __( 'Spacing', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'size' => 12,
				'unit' => 'px',
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 40,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'icon_bg_opacity', [
			'label' => __( 'Icon Background Opacity', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'size' => 0.18,
			],
			'range' => [
				'' => [
					'min' => 0,
					'max' => 1,
					'step' => 0.05,
				],
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_text', [
			'label' => __( 'Text', 'review9ja-site-customizations' ),
			'tab' => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'text_color', [
			'label' => __( 'Text Color', 'review9ja-site-customizations' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#2a2f36',
			'selectors' => [
				'{{WRAPPER}} .review9ja-lc-name' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name' => 'text_typography',
			'selector' => '{{WRAPPER}} .review9ja-lc-name',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items = $this->get_listing_items( $settings );

		if ( empty( $items ) ) {
			return;
		}

		$icon_opacity = $this->get_icon_bg_opacity( $settings );
		?>
		<div class="review9ja-lc-grid">
			<?php foreach ( $items as $item ) :
				$icon_color = $item['color'] ? $item['color'] : '#f24286';
				$icon_bg = $this->color_to_rgba( $icon_color, $icon_opacity );
				$tag = $item['link'] ? 'a' : 'div';
				?>
				<<?php echo $tag; ?>
					class="review9ja-lc-card"
					<?php echo $item['link'] ? 'href="' . esc_url( $item['link'] ) . '"' : ''; ?>
				>
					<span class="review9ja-lc-icon" style="--review9ja-lc-icon-color: <?php echo esc_attr( $icon_color ); ?>; --review9ja-lc-icon-bg: <?php echo esc_attr( $icon_bg ); ?>;">
						<?php echo wp_kses_post( $item['icon'] ); ?>
					</span>
					<span class="review9ja-lc-name"><?php echo esc_html( $item['name'] ); ?></span>
				</<?php echo $tag; ?>>
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function get_listing_items( $settings ) {
		if ( ! class_exists( '\MyListing\Src\Term' ) ) {
			return [];
		}

		$taxonomy = isset( $settings['taxonomy'] ) ? $settings['taxonomy'] : 'job_listing_category';
		$show_all = isset( $settings['show_all_terms'] ) && $settings['show_all_terms'] === 'yes';
		$hide_empty = isset( $settings['hide_empty'] ) && $settings['hide_empty'] === 'yes';
		$limit = isset( $settings['limit'] ) ? absint( $settings['limit'] ) : 0;

		if ( $taxonomy === 'listing_types' ) {
			return $this->get_listing_type_items( $settings, $show_all, $limit );
		}

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return [];
		}

		$term_ids = $show_all ? [] : $this->get_selected_term_ids( $settings, $taxonomy );
		if ( ! $show_all && empty( $term_ids ) ) {
			return [];
		}

		$args = [
			'taxonomy' => $taxonomy,
			'hide_empty' => $hide_empty,
		];

		if ( ! empty( $term_ids ) ) {
			$args['include'] = $term_ids;
			$args['orderby'] = 'include';
		} else {
			$args['orderby'] = $this->sanitize_orderby( $settings );
			$args['order'] = $this->sanitize_order( $settings );
			if ( $limit > 0 ) {
				$args['number'] = $limit;
			}
		}

		$terms = (array) get_terms( $args );
		if ( is_wp_error( $terms ) ) {
			return [];
		}

		$items = [];
		foreach ( $terms as $term ) {
			$term_obj = \MyListing\Src\Term::get( $term );
			if ( ! $term_obj ) {
				continue;
			}

			$items[] = [
				'name' => $term_obj->get_name(),
				'link' => $term_obj->get_link(),
				'icon' => $term_obj->get_icon( [ 'background' => false, 'color' => false ] ),
				'color' => $term_obj->get_color(),
			];
		}

		return $items;
	}

	private function get_listing_type_items( $settings, $show_all, $limit ) {
		if ( ! class_exists( '\MyListing\Src\Listing_Type' ) ) {
			return [];
		}

		$explore_link = function_exists( 'c27' )
			? c27()->get_setting( 'general_explore_listings_page' )
			: '';

		$args = [
			'post_type' => 'case27_listing_type',
			'post_status' => 'any',
			'posts_per_page' => $limit > 0 ? $limit : -1,
		];

		if ( ! $show_all ) {
			$type_ids = $this->get_selected_term_ids( $settings, 'listing_types' );
			if ( empty( $type_ids ) ) {
				return [];
			}
			$args['post__in'] = $type_ids;
			$args['orderby'] = 'post__in';
		} else {
			$args['orderby'] = $this->sanitize_listing_type_orderby( $settings );
			$args['order'] = $this->sanitize_order( $settings );
		}

		$types = (array) get_posts( $args );
		$items = [];
		foreach ( $types as $type ) {
			$type_obj = \MyListing\Src\Listing_Type::get( $type );
			if ( ! $type_obj ) {
				continue;
			}

			$items[] = [
				'name' => $type_obj->get_plural_name(),
				'link' => $explore_link ? add_query_arg( 'type', $type_obj->get_slug(), $explore_link ) : '',
				'icon' => $type_obj->get_icon(),
				'color' => function_exists( 'c27' )
					? c27()->get_setting( 'general_brand_color', '#f24286' )
					: '#f24286',
			];
		}

		return $items;
	}

	private function get_selected_term_ids( $settings, $taxonomy ) {
		switch ( $taxonomy ) {
			case 'region':
				$terms = isset( $settings['select_regions'] ) ? $settings['select_regions'] : [];
				break;
			case 'case27_job_listing_tags':
				$terms = isset( $settings['select_tags'] ) ? $settings['select_tags'] : [];
				break;
			case 'job_listing_category':
				$terms = isset( $settings['select_categories'] ) ? $settings['select_categories'] : [];
				break;
			case 'listing_types':
				$terms = isset( $settings['select_listing_types'] ) ? $settings['select_listing_types'] : [];
				break;
			default:
				$key = 'select_' . $taxonomy;
				$terms = isset( $settings[ $key ] ) ? $settings[ $key ] : [];
				break;
		}

		$ids = [];
		foreach ( (array) $terms as $term ) {
			if ( ! empty( $term['category_id'] ) ) {
				$ids[] = absint( $term['category_id'] );
			}
		}

		return array_values( array_filter( $ids ) );
	}

	private function sanitize_orderby( $settings ) {
		$orderby = isset( $settings['order_by'] ) ? $settings['order_by'] : 'name';
		$map = [
			'name' => 'name',
			'count' => 'count',
			'slug' => 'slug',
			'id' => 'term_id',
			'term_order' => 'term_order',
		];

		return isset( $map[ $orderby ] ) ? $map[ $orderby ] : 'name';
	}

	private function sanitize_listing_type_orderby( $settings ) {
		$orderby = isset( $settings['order_by'] ) ? $settings['order_by'] : 'name';
		$map = [
			'name' => 'title',
			'count' => 'title',
			'slug' => 'name',
			'id' => 'ID',
			'term_order' => 'menu_order',
		];

		return isset( $map[ $orderby ] ) ? $map[ $orderby ] : 'title';
	}

	private function sanitize_order( $settings ) {
		$order = isset( $settings['order'] ) ? strtoupper( $settings['order'] ) : 'ASC';
		return in_array( $order, [ 'ASC', 'DESC' ], true ) ? $order : 'ASC';
	}

	private function get_icon_bg_opacity( $settings ) {
		$opacity = 0.18;
		if ( isset( $settings['icon_bg_opacity']['size'] ) && $settings['icon_bg_opacity']['size'] !== '' ) {
			$opacity = (float) $settings['icon_bg_opacity']['size'];
		}

		if ( $opacity < 0 ) {
			$opacity = 0;
		} elseif ( $opacity > 1 ) {
			$opacity = 1;
		}

		return $opacity;
	}

	private function color_to_rgba( $color, $alpha ) {
		$color = trim( (string) $color );
		$alpha = max( 0, min( 1, (float) $alpha ) );

		if ( $color === '' ) {
			return sprintf( 'rgba(0,0,0,%.2f)', $alpha );
		}

		if ( strpos( $color, 'rgba' ) === 0 && preg_match( '/rgba\\((\\d+),\\s*(\\d+),\\s*(\\d+)/', $color, $matches ) ) {
			return sprintf( 'rgba(%d,%d,%d,%.2f)', $matches[1], $matches[2], $matches[3], $alpha );
		}

		if ( strpos( $color, 'rgb' ) === 0 && preg_match( '/rgb\\((\\d+),\\s*(\\d+),\\s*(\\d+)\\)/', $color, $matches ) ) {
			return sprintf( 'rgba(%d,%d,%d,%.2f)', $matches[1], $matches[2], $matches[3], $alpha );
		}

		if ( $color[0] === '#' ) {
			$hex = substr( $color, 1 );
			if ( strlen( $hex ) === 3 ) {
				$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
			}
			if ( strlen( $hex ) === 6 ) {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
				return sprintf( 'rgba(%d,%d,%d,%.2f)', $r, $g, $b, $alpha );
			}
		}

		return $color;
	}

	private function get_term_options( $taxonomy ) {
		if ( ! is_admin() || ! function_exists( 'c27' ) ) {
			return [];
		}

		return c27()->get_terms_dropdown_array( [
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
		] );
	}

	private function get_listing_type_options() {
		if ( ! is_admin() || ! function_exists( '\MyListing\get_posts_dropdown' ) ) {
			return [];
		}

		return \MyListing\get_posts_dropdown( 'case27_listing_type' );
	}
}
