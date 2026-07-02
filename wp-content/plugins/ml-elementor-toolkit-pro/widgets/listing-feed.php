<?php

namespace ML_Elementor_Toolkit_Pro\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;

class Listing_Feed extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mlt-listing-feed-widget';
	}

	public function get_title() {
		return __( 'Toolkit > Listing Feed (Related Listings)', 'my-listing' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

	public function get_keywords() {
        return [ 'listing feed', 'related listings', 'posts', 'mylisting', 'my listing' ];
    }

	protected function _register_controls() {
		$this->start_controls_section( 'the_listing_feed', [
			'label' => __( 'Listing Feed', 'my-listing' ),
		] );

		$this->add_control( 'the_template', [
			'label' => __( 'Template', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => [
				'grid' => __( 'Grid', 'my-listing' ),
				'carousel' => __( 'Carousel', 'my-listing' ),
			],
		] );

		$this->add_control( 'posts_per_page', [
			'label'   => __( 'Number of items to show', 'my-listing' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 6,
		] );

		$this->add_control( 'query_method', [
			'label' => _x( 'Find listings using:', 'Elementor > Listing Feed > Widget Settings', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'filters',
			'options' => [
				'wp_query' => _x( 'Current WP Query', 'Elementor > Listing Feed > Widget Settings', 'my-listing' ),
				'related_listings' => _x( 'Related Listings', 'Elementor > Listing Feed > Widget Settings', 'my-listing' ),
				'user_bookmarks' => _x( 'Bookmarks of user', 'Elementor > Listing Feed > Widget Settings', 'my-listing' ),
				'filters' => _x( 'Filters', 'Elementor > Listing Feed > Widget Settings', 'my-listing' ),
				'query_string' => _x( 'Explore page query URL', 'Elementor > Listing Feed > Widget Settings', 'my-listing' ),
			],
		] );

		$control_options = [
			'label' => __( 'Related listing field', 'elementor-pro' ),
			'type' => \Elementor\Controls_Manager::SELECT,		
			'default' => 'related-listing',	
			'condition' => ['query_method' => 'related_listings'],
		];

		$listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ( $listing && $listing->type) {
			$control_options['options'] = DynamicTagsModule::get_ml_fields_options( ['related-listing'] );
		} else{
			$control_options['groups'] = DynamicTagsModule::get_ml_fields_groups( ['related-listing'] );
		}

		$this->add_control(
			'related_listings_key',
			$control_options
		);

		$this->add_control( 'by_current_author', [
			'label' => __( 'Only posts by current author?', 'ml-elementor-toolkit-pro' ),
			'description' => __( 'If selected, only listings will be shown by the author of the current posts. Generally only works on single listing page.', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'my-listing' ),
			'label_off' => __( 'No', 'my-listing' ),
			'return_value' => 'yes',
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'select_categories', [
			'label' => __( 'Filter by Categories', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'options' => c27()->get_terms_dropdown_array( [
				'taxonomy' => 'job_listing_category',
				'hide_empty' => false,
			] ),
			'multiple' => true,
			'label_block' => true,
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'select_regions', [
			'label' => __( 'Filter by Regions', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'options' => c27()->get_terms_dropdown_array( [
				'taxonomy' => 'region',
				'hide_empty' => false,
			] ),
			'multiple' => true,
			'label_block' => true,
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'select_tags', [
			'label' => __( 'Filter by Tags', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'options' => c27()->get_terms_dropdown_array( [
				'taxonomy' => 'case27_job_listing_tags',
				'hide_empty' => false,
			] ),
			'multiple' => true,
			'label_block' => true,
			'condition' => ['query_method' => 'filters'],
		] );

		$taxonomy_list = mylisting_custom_taxonomies();

		foreach ( $taxonomy_list as $slug => $label ) {
			$this->add_control( 'select_'.$slug, [
				'label' => sprintf( '%s %s', __( 'Filter by', 'my-listing' ), $label ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => c27()->get_terms_dropdown_array( [
					'taxonomy' => $slug,
					'hide_empty' => false,
				] ),
				'multiple' => true,
				'label_block' => true,
				'condition' => ['query_method' => 'filters'],
			] );
		}

		$this->add_control( 'select_listing_types', [
			'label' => __( 'Filter by Listing Type(s).', 'my-listing' ),
			'type' => 'mylisting-posts-dropdown',
			'multiple' => true,
			'label_block' => true,
			'post_type' => 'case27_listing_type',
			'post_key' => 'slug',
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'priority_levels', [
			'label' => __( 'Filter by Priority', 'my-listing' ),
			'description' => __( 'Leave blank to include all priority levels', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'options' => [
				'normal' => 'Normal',
				'featured' => 'Featured',
				'promoted' => 'Promoted',
				'custom' => 'Custom',
			],
			'multiple' => true,
			'label_block' => true,
			'condition' => ['query_method' => 'filters'],
		] );

		$listings = \MyListing\get_posts_dropdown( 'job_listing' );
		$this->add_control( 'select_listings', [
			'label' => __( 'Or select a list of listings.', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => [[
				'name' => 'listing_id',
				'label' => is_array( $listings )
					? __( 'Select listing', 'my-listing' )
					: _x( 'Enter listing ID', 'Elementor/Listing Feed: Select a listing', 'my-listing' ),
				'type' => is_array( $listings )
					? \Elementor\Controls_Manager::SELECT2
					: \Elementor\Controls_Manager::TEXT,
				'options' => $listings,
				'default' => '',
				'label_block' => true,
			]],
			'title_field' => 'Listing ID: {{{ listing_id }}}',
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'order_by', [
			'label' => __( 'Order by', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'date',
			'options' => [
				'date' => __( 'Date', 'my-listing' ),
				'post__in' => __( 'Included order', 'my-listing' ),
				'_case27_average_rating' => __( 'Rating', 'my-listing' ),
				'rand' => __( 'Random', 'my-listing' ),
				'modified' => __( 'Last modified date', 'my-listing' ),
			],
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'order', [
			'label' => __( 'Order', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => [
				'ASC' => __( 'Ascending', 'my-listing' ),
				'DESC' => __( 'Descending', 'my-listing' ),
			],
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'behavior', [
			'label' => __( 'Order by priority first?', 'my-listing' ),
			'description' => __( 'If selected, listings will first be ordered based on their priority, then based on the "Order By" setting above.', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
			'label_on' => __( 'Yes', 'my-listing' ),
			'label_off' => __( 'No', 'my-listing' ),
			'return_value' => 'yes',
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'query_string', [
			'label' => __( 'Paste the URL here', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
			'label_block' => true,
			'placeholder' => home_url( '/explore?type=events&sort=latest' ),
			'description' => 'In Explore page, you can filter results the way you want, grab the generated URL from the address bar, and paste it here, to get that exact list of listings.',
			'condition' => ['query_method' => 'query_string'],
		] );

		$this->add_control( 'show_promoted_badge', [
			'label' => __( 'Show badge for featured/promoted listings?', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
			'label_on' => __( 'Yes', 'my-listing' ),
			'label_off' => __( 'No', 'my-listing' ),
			'return_value' => 'yes',
			'condition' => ['query_method' => 'filters'],
		] );

		$this->add_control( 'invert_nav_color', [
			'label' => __( 'Invert nav color?', 'my-listing' ),
			'description' => __( 'Use this option on dark section backgrounds for better visibility.', 'my-listing' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
			'label_on' => __( 'Yes', 'my-listing' ),
			'label_off' => __( 'No', 'my-listing' ),
			'return_value' => 'yes',
			'condition' => ['the_template' => 'carousel'],
		] );

		$this->add_control( 'cache_for', [
			'label' => __( 'Cache results for (in minutes)', 'my-listing' ),
			'description' => 'Set how long the listing feed results cache should be used before it is regenerated. Set to "0" to disable.',
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 0,
			'default' => 720, // 12 hours
		] );

		\MyListing\Elementor\apply_column_count_controls(
			$this,
			'column_count',
			__( 'Column count', 'my-listing' ),
			[
				'heading' => ['condition' => ['the_template' => ['grid', 'fluid-grid']]],
				'general' => [
					'condition' => ['the_template' => ['grid', 'fluid-grid']],
					'min' => 1,
					'max' => 4,
				],
				'lg' => ['default' => 3], 'md' => ['default' => 3],
				'sm' => ['default' => 2], 'xs' => ['default' => 1],
			]
		);

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		// $this->get_id() can be the same for widgets in different pages,
		// usually when pages are duplicated; to avoid them also sharing the
		// same cache key, the current page ID is appended to the key.
		$cache_key = sprintf(
			'mylisting_feed_cache_%s_%s',
			$this->get_id(),
			get_queried_object_id()
		);
		$cache_for = $this->get_settings( 'cache_for' );
		$cached_value = get_transient( $cache_key );
		$listing_ids = [];

		if ( \MyListing\Elementor\is_edit_mode() ) {
			if ( $cache_for > 0 ) {
				delete_transient( $cache_key );
			}

			$query = $this->get_listings_query();
			if ( $query instanceof \WP_Query ) {
				$listing_ids = $query->posts;
			}
		} elseif ( is_array( $cached_value ) && $cache_for > 0 ) {
			$listing_ids = $cached_value;
		} else {
			$query = $this->get_listings_query();
			if ( $query instanceof \WP_Query ) {
				$listing_ids = $query->posts;

				if ( $cache_for > 0 ) {
					set_transient( $cache_key, $listing_ids, $cache_for * 60 );
				}
			}
		}

		if ( empty( $listing_ids ) ) {
			return;
		}

		$template = $this->get_settings('the_template');
		$invert_nav = $this->get_settings('invert_nav_color') === 'yes';
		$hide_priority = $this->get_settings('show_promoted_badge') !== 'yes';
		$listing_wrap = sprintf(
			'col-lg-%1$d col-md-%2$d col-sm-%3$d col-xs-%4$d grid-item',
			12 / absint( $this->get_settings('column_count__lg') ),
			12 / absint( $this->get_settings('column_count__md') ),
			12 / absint( $this->get_settings('column_count__sm') ),
			12 / $this->get_settings('column_count__xs')
		);

		require locate_template( 'templates/widgets/listing-feed.php' );

		$current = max( 1, (int) isset($_GET['pg']) ? $_GET['pg'] : 1 );

		if($query->max_num_pages > 1){

			$paginate_args = [
				'type' => 'array',
				'current' => $current,
				'total' => $query->max_num_pages,
				'prev_next' => true,
				'format' => '?pg=%#%',
				'before_page_number' => '<span class="elementor-screen-only">' . esc_html__( 'Page', 'elementor-pro' ) . '</span>',
			];

			$links = paginate_links( $paginate_args );

			?>
			<nav class="elementor-pagination blog-footer text-center" role="navigation" aria-label="<?php esc_attr_e( 'Pagination', 'elementor-pro' ); ?>">
				<?php echo implode( PHP_EOL, $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</nav>
			
			<?php
		}

		if ( \MyListing\Elementor\is_edit_mode() ) {
			printf(
				'<script type="text/javascript">%s</script>',
				'case27_ready_script(jQuery);'
			);
		}
	}

	protected function content_template() {}
	public function render_plain_content() {}

	protected function get_listings_query() {
		// NEW OPTION: WP Query
		if( $this->get_settings('query_method') === 'wp_query'  ){
            global $wp_query;
            $args = $wp_query->query_vars;
            $args['fields'] = 'ids';

            $query = new \WP_Query( $args );
			return $query;
		}
		// handle find listings using explore page query url
		if ( $this->get_settings('query_method') === 'query_string' ) {
			if ( ! ( $query_string = parse_url( $this->get_settings('query_string'), PHP_URL_QUERY ) ) ) {
				return false;
			}

			if ( ! ( $query_args = wp_parse_args( $query_string ) ) ) {
				return false;
			}

			// 'pg' param must be converted to 'page'
			if ( ! empty( $query_args['pg'] ) ) {
				$query_args['page'] = max( 0, absint( $query_args['pg'] ) - 1 );
			}

			$query = \MyListing\Src\Queries\Explore_Listings::instance()->run( [
				'listing_type' => ! empty( $query_args['type'] ) ? $query_args['type'] : false,
				'form_data' => c27()->merge_options( [
					'per_page' => $this->get_settings('posts_per_page'),
				], (array) $query_args ),
				'return_query' => true,
			] );

			if ( ! $query instanceof \WP_Query ) {
				return false;
			}

			return $query;
		}


		$current_page = max( 1, (int) isset($_GET['pg']) ? $_GET['pg'] : 1 );


		// handle regular filter query
		$args = [
			'post_type' => 'job_listing',
			'post_status' => 'publish',
			'posts_per_page' => $this->get_settings('posts_per_page'),
			'ignore_sticky_posts' => false,
			'meta_query' => [],
			'tax_query' => [],
			'fields' => 'ids',
			'paged' => $current_page,
		];


		if( $this->get_settings('query_method') === 'related_listings'  ){
			$listing = \MyListing\Src\Listing::get( get_the_ID() );
			if ( ! $listing ) {
				return;
			}
			$related_items = [];
	
			$field = $listing->get_field_object( sanitize_text_field( $this->get_settings('related_listings_key')) );
			if ( $field && $field->get_type() === 'related-listing' ) {
				$related_items = (array) $field->get_related_items();
				$args['post__in'] = ! empty( $related_items ) ? $related_items : [0];
			} else{
				$args['post__in'] = [0];
			}

			return new \WP_Query( $args );
		}
		if( $this->get_settings('query_method') === 'user_bookmarks'  ){
			$bookmark_ids = \MyListing\Src\Bookmarks::get_by_user( get_current_user_id() );

			$args['post__in'] = $bookmark_ids;
			// $args = [
			// 	'post_type' => 'job_listing',
			// 	'posts_per_page' => 10,
			// 	'post_status' => 'publish',
			// 	'paged' => $_page,
			// 	'post__in' => $bookmark_ids,
			// ];
			return new \WP_Query( $args );

		}

		$by_current_author = (bool) $this->get_settings( 'by_current_author' );
		if($by_current_author){
			$post_author_id = get_post_field( 'post_author', get_the_ID() );
			$args['author'] = $post_author_id;
		}

		// filter by selected categories
		if ( $this->get_settings('select_categories') ) {
			$args['tax_query'][] = [
				'taxonomy' => 'job_listing_category',
				'terms' => $this->get_settings('select_categories'),
				'field' => 'term_id',
			];
		}

		// filter by selected regions
		if ( $this->get_settings('select_regions') ) {
			$args['tax_query'][] = [
				'taxonomy' => 'region',
				'terms' => $this->get_settings('select_regions'),
				'field' => 'term_id',
			];
		}

		// filter by selected tags
		if ( $this->get_settings('select_tags') ) {
			$args['tax_query'][] = [
				'taxonomy' => 'case27_job_listing_tags',
				'terms' => $this->get_settings('select_tags'),
				'field' => 'term_id',
			];
		}

		// filter by selected custom taxonomies
		$taxonomy_list = mylisting_custom_taxonomies();
		foreach ( $taxonomy_list as $slug => $label ) {
			if ( ! empty( $this->get_settings( 'select_'.$slug ) ) ) {
				$args['tax_query'][] = [
					'taxonomy' => $slug,
					'terms' => $this->get_settings( 'select_'.$slug ),
					'field' => 'term_id',
				];
			}
		}

		// handle "select a list of listings" setting
		$include_ids = array_filter( array_map( 'absint', array_column(
			(array) $this->get_settings('select_listings'),
			'listing_id'
		) ) );

		if ( ! empty( $include_ids ) ) {
			$args['post__in'] = $include_ids;
		}

		// filter by the listing type
		if ( $this->get_settings('select_listing_types') ) {
			$args['meta_query']['c27_listing_type_clause'] = [
				'key' => '_case27_listing_type',
				'value' => $this->get_settings('select_listing_types'),
				'compare' => 'IN',
			];
		}

		$orderby = $this->get_settings('order_by');
		$explore_query = \MyListing\Src\Queries\Explore_Listings::instance();
		if ( $orderby ) {
			if ( $orderby === '_case27_average_rating' ) {
				add_filter( 'posts_join', [ $explore_query, 'rating_field_join' ], 35, 2 );
				add_filter( 'posts_orderby', [ $explore_query, 'rating_field_orderby' ], 35, 2 );
				$args['orderby'] = [];
			} else {
				$args['orderby'] = $orderby;
			}
		}

		$args['order'] = $this->get_settings('order') === 'ASC' ? 'ASC' : 'DESC';

		// prevent duplicates
		add_filter( 'posts_distinct', [ $explore_query, 'prevent_duplicates' ], 30, 2 );

		// join priority meta
		add_filter( 'posts_join', [ $explore_query, 'priority_field_join' ], 30, 2 );

		// set which priority levels to include
		$priority_levels = array_filter( (array) $this->get_settings( 'priority_levels' ) );
		$priority_field_where = function( $where, $query ) use ( $priority_levels ) {
			global $wpdb;

			$levels = [];
			if ( in_array( 'normal', $priority_levels ) ) { $levels[] = 0; }
			if ( in_array( 'featured', $priority_levels ) ) { $levels[] = 1; }
			if ( in_array( 'promoted', $priority_levels ) ) { $levels[] = 2; }

			// all priority levels are included
			if ( count( $priority_levels ) === 0 || count( $priority_levels ) === 4 ) {
				return $where;
			}

			// handle levels 0,1,2
			$where .= sprintf( ' AND ( priority_meta.meta_value IN (%s)', join( ',', $levels ) );

			// handle levels 3+
			if ( in_array( 'custom', $priority_levels ) ) {
				$where .= ' OR priority_meta.meta_value > 2 ';
			}
			$where .= ' ) ';

			return $where;
		};

		add_filter( 'posts_where', $priority_field_where, 30, 2 );

		// order by priority
		$order_by_priority = (bool) $this->get_settings( 'behavior' );
		if ( $order_by_priority === true ) {
			$args['suppress_filters'] = false;
			add_filter( 'posts_orderby', [ $explore_query, 'priority_field_orderby' ], 30, 2 );
		}

		$query = new \WP_Query( apply_filters( 'mylisting/sections/listing-feed/args', $args ) );

		remove_filter( 'posts_join', [ $explore_query, 'priority_field_join' ], 30 );
		remove_filter( 'posts_orderby', [ $explore_query, 'priority_field_orderby' ], 30 );
		remove_filter( 'posts_where', $priority_field_where, 30 );
		remove_filter( 'posts_join', [ $explore_query, 'rating_field_join' ], 35 );
		remove_filter( 'posts_orderby', [ $explore_query, 'rating_field_orderby' ], 35 );
		remove_filter( 'posts_distinct', [ $explore_query, 'prevent_duplicates' ], 30 );

		return $query;
	}
}
