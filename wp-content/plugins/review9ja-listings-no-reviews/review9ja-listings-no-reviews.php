<?php
/**
 * Plugin Name: Review9ja Listings Without Reviews
 * Description: Admin page to list job listings with no comments or reviews.
 * Version: 1.0.0
 * Author: Review9ja
 * Text Domain: review9ja-listings-no-reviews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Review9ja_Listings_No_Reviews {
	const VERSION = '1.0.0';
	const POST_TYPE = 'job_listing';
	const OPTION_PER_PAGE = 'review9ja_no_reviews_per_page';
	const MAX_PER_PAGE = 100;
	const META_HIDE = '_review9ja_no_reviews_hidden';
	const META_HIDE_REASON = '_review9ja_no_reviews_hidden_reason';
	const META_HIDE_AT = '_review9ja_no_reviews_hidden_at';
	const PAGE_NO_REVIEWS = 'review9ja-no-reviews';
	const PAGE_HIDDEN = 'review9ja-hidden-listings';
	const AJAX_NONCE = 'review9ja_no_reviews_nonce';

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'admin_post_review9ja_hide_no_reviews_listing', [ $this, 'handle_hide_listing' ] );
		add_action( 'admin_post_review9ja_unhide_no_reviews_listing', [ $this, 'handle_unhide_listing' ] );
		add_action( 'wp_ajax_review9ja_no_reviews_list', [ $this, 'ajax_no_reviews_list' ] );
		add_action( 'wp_ajax_review9ja_hidden_list', [ $this, 'ajax_hidden_list' ] );
		add_action( 'wp_ajax_review9ja_hide_listing', [ $this, 'ajax_hide_listing' ] );
		add_action( 'wp_ajax_review9ja_unhide_listing', [ $this, 'ajax_unhide_listing' ] );
		add_action( 'pre_get_posts', [ $this, 'exclude_hidden_listings' ] );
		add_action( 'template_redirect', [ $this, 'block_hidden_listing' ] );
	}

	public function register_page() {
		add_submenu_page(
			'edit.php?post_type=' . self::POST_TYPE,
			__( 'Listings Without Reviews', 'review9ja-listings-no-reviews' ),
			__( 'No Reviews', 'review9ja-listings-no-reviews' ),
			'edit_posts',
			self::PAGE_NO_REVIEWS,
			[ $this, 'render_no_reviews_page' ]
		);

		add_submenu_page(
			'edit.php?post_type=' . self::POST_TYPE,
			__( 'Hidden Listings', 'review9ja-listings-no-reviews' ),
			__( 'Hidden Listings', 'review9ja-listings-no-reviews' ),
			'edit_posts',
			self::PAGE_HIDDEN,
			[ $this, 'render_hidden_page' ]
		);
	}

	public function enqueue_assets( $hook ) {
		$is_no_reviews = ( 'job_listing_page_' . self::PAGE_NO_REVIEWS ) === $hook;
		$is_hidden = ( 'job_listing_page_' . self::PAGE_HIDDEN ) === $hook;

		if ( ! $is_no_reviews && ! $is_hidden ) {
			return;
		}

		wp_enqueue_style(
			'review9ja-no-reviews-admin',
			plugins_url( 'assets/admin-no-reviews.css', __FILE__ ),
			[],
			self::VERSION
		);

		wp_enqueue_script(
			'review9ja-no-reviews-admin',
			plugins_url( 'assets/admin-no-reviews.js', __FILE__ ),
			[],
			self::VERSION,
			true
		);

		wp_add_inline_script(
			'review9ja-no-reviews-admin',
			'window.Review9jaNoReviewsSettings=' . wp_json_encode( [
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( self::AJAX_NONCE ),
				'maxPerPage' => self::MAX_PER_PAGE,
			] ) . ';',
			'before'
		);
	}

	private function get_default_per_page() {
		$default = (int) get_option( self::OPTION_PER_PAGE, 20 );
		if ( $default < 1 ) {
			$default = 20;
		}

		return $default;
	}

	private function sanitize_per_page( $value, $persist = false ) {
		$per_page = absint( $value );

		if ( $per_page < 1 ) {
			$per_page = 1;
		}

		if ( $per_page > self::MAX_PER_PAGE ) {
			$per_page = self::MAX_PER_PAGE;
		}

		if ( $persist ) {
			update_option( self::OPTION_PER_PAGE, $per_page );
		}

		return $per_page;
	}

	private function sanitize_sort( $value ) {
		$sort = sanitize_text_field( (string) $value );

		$allowed = [ 'az', 'za', 'random' ];
		if ( ! in_array( $sort, $allowed, true ) ) {
			$sort = 'az';
		}

		return $sort;
	}

	private function get_order_sql( $sort ) {
		switch ( $sort ) {
			case 'za':
				return 'ORDER BY p.post_title DESC';
			case 'random':
				return 'ORDER BY RAND()';
			case 'az':
			default:
				return 'ORDER BY p.post_title ASC';
		}
	}

	private function get_base_sql() {
		global $wpdb;

		return "
			FROM {$wpdb->posts} p
			LEFT JOIN {$wpdb->comments} c
				ON c.comment_post_ID = p.ID
				AND c.comment_approved NOT IN ('spam','trash')
			LEFT JOIN {$wpdb->postmeta} pm
				ON pm.post_id = p.ID
				AND pm.meta_key = %s
			WHERE p.post_type = %s
				AND p.post_status NOT IN ('trash','auto-draft','draft')
				AND pm.meta_id IS NULL
			GROUP BY p.ID
			HAVING COUNT(c.comment_ID) = 0
		";
	}

	private function get_hidden_sort_args( $sort ) {
		switch ( $sort ) {
			case 'za':
				return [ 'orderby' => 'title', 'order' => 'DESC' ];
			case 'random':
				return [ 'orderby' => 'rand', 'order' => 'DESC' ];
			case 'az':
			default:
				return [ 'orderby' => 'title', 'order' => 'ASC' ];
		}
	}

	private function get_return_url() {
		$return_url = '';
		if ( isset( $_POST['return_url'] ) ) {
			$return_url = wp_unslash( $_POST['return_url'] );
		}

		$return_url = $return_url ? wp_validate_redirect( $return_url, '' ) : '';
		if ( ! $return_url ) {
			$return_url = admin_url( 'edit.php?post_type=' . self::POST_TYPE . '&page=review9ja-no-reviews' );
		}

		return $return_url;
	}

	private function set_listing_hidden( $listing_id, $hidden ) {
		if ( $hidden ) {
			update_post_meta( $listing_id, self::META_HIDE, 1 );
			update_post_meta( $listing_id, self::META_HIDE_REASON, 'google' );
			update_post_meta( $listing_id, self::META_HIDE_AT, current_time( 'mysql', true ) );
		} else {
			delete_post_meta( $listing_id, self::META_HIDE );
			delete_post_meta( $listing_id, self::META_HIDE_REASON );
			delete_post_meta( $listing_id, self::META_HIDE_AT );
		}
	}

	public function handle_hide_listing() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'Not allowed.' );
		}

		check_admin_referer( 'review9ja_hide_no_reviews_listing' );

		$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
		if ( ! $listing_id || get_post_type( $listing_id ) !== self::POST_TYPE ) {
			wp_safe_redirect( add_query_arg( 'r9nr_status', 'invalid', $this->get_return_url() ) );
			exit;
		}

		$this->set_listing_hidden( $listing_id, true );

		wp_safe_redirect( add_query_arg( 'r9nr_status', 'hidden', $this->get_return_url() ) );
		exit;
	}

	public function handle_unhide_listing() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'Not allowed.' );
		}

		check_admin_referer( 'review9ja_unhide_no_reviews_listing' );

		$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
		if ( ! $listing_id || get_post_type( $listing_id ) !== self::POST_TYPE ) {
			wp_safe_redirect( add_query_arg( 'r9nr_status', 'invalid', $this->get_return_url() ) );
			exit;
		}

		$this->set_listing_hidden( $listing_id, false );

		wp_safe_redirect( add_query_arg( 'r9nr_status', 'unhidden', $this->get_return_url() ) );
		exit;
	}

	public function ajax_hide_listing() {
		check_ajax_referer( self::AJAX_NONCE, 'nonce' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => 'Not allowed.' ], 403 );
		}

		$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
		if ( ! $listing_id || get_post_type( $listing_id ) !== self::POST_TYPE ) {
			wp_send_json_error( [ 'message' => 'Invalid listing.' ], 400 );
		}

		$this->set_listing_hidden( $listing_id, true );

		wp_send_json_success( [ 'listing_id' => $listing_id ] );
	}

	public function ajax_unhide_listing() {
		check_ajax_referer( self::AJAX_NONCE, 'nonce' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => 'Not allowed.' ], 403 );
		}

		$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
		if ( ! $listing_id || get_post_type( $listing_id ) !== self::POST_TYPE ) {
			wp_send_json_error( [ 'message' => 'Invalid listing.' ], 400 );
		}

		$this->set_listing_hidden( $listing_id, false );

		wp_send_json_success( [ 'listing_id' => $listing_id ] );
	}

	public function exclude_hidden_listings( $query ) {
		if ( is_admin() ) {
			return;
		}

		if ( ! $query instanceof WP_Query ) {
			return;
		}

		if ( $query->get( 'review9ja_show_hidden' ) ) {
			return;
		}

		$post_types = $query->get( 'post_type' );
		if ( empty( $post_types ) ) {
			if ( ! $query->is_search() ) {
				return;
			}
			$post_types = 'any';
		}

		if ( $post_types !== 'any' ) {
			$post_types = (array) $post_types;
			if ( ! in_array( self::POST_TYPE, $post_types, true ) ) {
				return;
			}
		}

		$meta_query = $query->get( 'meta_query' );
		if ( ! is_array( $meta_query ) ) {
			$meta_query = [];
		}

		$hide_clause = [
			'key' => self::META_HIDE,
			'compare' => 'NOT EXISTS',
		];

		if ( isset( $meta_query['relation'] ) && strtoupper( (string) $meta_query['relation'] ) === 'OR' ) {
			$meta_query = [
				'relation' => 'AND',
				$meta_query,
				$hide_clause,
			];
		} else {
			$meta_query[] = $hide_clause;
		}

		$query->set( 'meta_query', $meta_query );
	}

	public function block_hidden_listing() {
		if ( is_admin() || ! is_singular( self::POST_TYPE ) ) {
			return;
		}

		$post_id = get_queried_object_id();
		if ( ! $post_id ) {
			return;
		}

		if ( get_post_meta( $post_id, self::META_HIDE, true ) ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();
			include get_404_template();
			exit;
		}
	}

	private function get_no_reviews_data( $page, $per_page, $sort ) {
		global $wpdb;

		$page = max( 1, (int) $page );
		$per_page = $this->sanitize_per_page( $per_page );
		$offset = ( $page - 1 ) * $per_page;

		$base_sql = $this->get_base_sql();
		$count_sql = "SELECT COUNT(*) FROM (SELECT p.ID {$base_sql}) AS r9_no_reviews";
		$total = (int) $wpdb->get_var( $wpdb->prepare( $count_sql, self::META_HIDE, self::POST_TYPE ) );

		$order_sql = $this->get_order_sql( $sort );
		$list_sql = "SELECT p.ID {$base_sql} {$order_sql} LIMIT %d OFFSET %d";
		$post_ids = $wpdb->get_col( $wpdb->prepare( $list_sql, self::META_HIDE, self::POST_TYPE, $per_page, $offset ) );

		$posts = [];
		if ( $post_ids ) {
			$posts = get_posts( [
				'post_type' => self::POST_TYPE,
				'post_status' => 'any',
				'posts_per_page' => count( $post_ids ),
				'post__in' => $post_ids,
				'orderby' => 'post__in',
			] );
		}

		$total_pages = max( 1, (int) ceil( $total / $per_page ) );

		return [
			'posts' => $posts,
			'total' => $total,
			'total_pages' => $total_pages,
			'page' => $page,
		];
	}

	private function get_hidden_data( $page, $per_page, $sort ) {
		$page = max( 1, (int) $page );
		$per_page = $this->sanitize_per_page( $per_page );

		$hidden_sort = $this->get_hidden_sort_args( $sort );
		$hidden_query = new WP_Query( [
			'post_type' => self::POST_TYPE,
			'post_status' => 'any',
			'posts_per_page' => $per_page,
			'paged' => $page,
			'meta_query' => [
				[
					'key' => self::META_HIDE,
					'compare' => 'EXISTS',
				],
			],
			'orderby' => $hidden_sort['orderby'],
			'order' => $hidden_sort['order'],
			'no_found_rows' => false,
		] );

		return [
			'posts' => $hidden_query->posts,
			'total' => (int) $hidden_query->found_posts,
			'total_pages' => max( 1, (int) $hidden_query->max_num_pages ),
			'page' => $page,
		];
	}

	private function build_pagination( $current, $total ) {
		$current = max( 1, (int) $current );
		$total = max( 1, (int) $total );

		if ( $total <= 1 ) {
			return '';
		}

		$range = 2;
		$pages = [ 1, $total ];

		$start = max( 2, $current - $range );
		$end = min( $total - 1, $current + $range );
		for ( $i = $start; $i <= $end; $i++ ) {
			$pages[] = $i;
		}

		$pages = array_values( array_unique( $pages ) );
		sort( $pages );

		$html = '<ul class="page-numbers">';

		if ( $current > 1 ) {
			$html .= '<li><a href="#" class="page-numbers prev" data-page="' . esc_attr( $current - 1 ) . '">&lsaquo;</a></li>';
		}

		$last_page = 0;
		foreach ( $pages as $page ) {
			if ( $last_page && $page > $last_page + 1 ) {
				$html .= '<li><span class="page-numbers dots">&hellip;</span></li>';
			}

			if ( $page === $current ) {
				$html .= '<li><span class="page-numbers current">' . esc_html( $page ) . '</span></li>';
			} else {
				$html .= '<li><a href="#" class="page-numbers" data-page="' . esc_attr( $page ) . '">' . esc_html( $page ) . '</a></li>';
			}

			$last_page = $page;
		}

		if ( $current < $total ) {
			$html .= '<li><a href="#" class="page-numbers next" data-page="' . esc_attr( $current + 1 ) . '">&rsaquo;</a></li>';
		}

		$html .= '</ul>';

		return $html;
	}

	private function render_no_reviews_rows( $posts ) {
		if ( empty( $posts ) ) {
			return '<tr><td colspan="5" class="r9-empty">' . esc_html__( 'All listings already have reviews.', 'review9ja-listings-no-reviews' ) . '</td></tr>';
		}

		$rows = '';
		foreach ( $posts as $post ) {
			$view_url = get_permalink( $post->ID );
			$review_url = add_query_arg(
				[
					'post_type' => self::POST_TYPE,
					'page' => 'review9ja-add-reviews',
					'listing_id' => $post->ID,
					'listing_title' => $post->post_title,
				],
				admin_url( 'edit.php' )
			);
			$author = get_the_author_meta( 'display_name', $post->post_author );
			$date = get_the_date( get_option( 'date_format' ), $post );

			$rows .= '<tr>';
			$rows .= '<td class="r9-cell-listing" data-label="' . esc_attr__( 'Listing', 'review9ja-listings-no-reviews' ) . '"><strong>' . esc_html( $post->post_title ) . '</strong><div class="r9-sub">' . esc_html( sprintf( 'ID %d', $post->ID ) ) . '</div></td>';
			$rows .= '<td data-label="' . esc_attr__( 'Status', 'review9ja-listings-no-reviews' ) . '">' . esc_html( ucfirst( $post->post_status ) ) . '</td>';
			$rows .= '<td data-label="' . esc_attr__( 'Author', 'review9ja-listings-no-reviews' ) . '">' . esc_html( $author ? $author : '-' ) . '</td>';
			$rows .= '<td data-label="' . esc_attr__( 'Date', 'review9ja-listings-no-reviews' ) . '">' . esc_html( $date ? $date : '-' ) . '</td>';
			$rows .= '<td class="r9-actions" data-label="' . esc_attr__( 'Actions', 'review9ja-listings-no-reviews' ) . '">';
			if ( $view_url ) {
				$rows .= '<a class="button button-secondary" href="' . esc_url( $view_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'View', 'review9ja-listings-no-reviews' ) . '</a>';
			}
			$rows .= '<a class="button" href="' . esc_url( $review_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'Review', 'review9ja-listings-no-reviews' ) . '</a>';
			$rows .= '<button type="button" class="button button-primary r9-action" data-action="hide" data-id="' . esc_attr( $post->ID ) . '">' . esc_html__( 'No reviews found on Google', 'review9ja-listings-no-reviews' ) . '</button>';
			$rows .= '</td>';
			$rows .= '</tr>';
		}

		return $rows;
	}

	private function render_hidden_rows( $posts ) {
		if ( empty( $posts ) ) {
			return '<tr><td colspan="5" class="r9-empty">' . esc_html__( 'No hidden listings yet.', 'review9ja-listings-no-reviews' ) . '</td></tr>';
		}

		$rows = '';
		foreach ( $posts as $post ) {
			$view_url = get_permalink( $post->ID );
			$hidden_reason = get_post_meta( $post->ID, self::META_HIDE_REASON, true );
			$hidden_reason_label = $hidden_reason === 'google'
				? __( 'No reviews found on Google', 'review9ja-listings-no-reviews' )
				: ( $hidden_reason ? $hidden_reason : '-' );
			$hidden_at = get_post_meta( $post->ID, self::META_HIDE_AT, true );
			$hidden_at_display = $hidden_at
				? get_date_from_gmt( $hidden_at, get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) )
				: '-';

			$rows .= '<tr>';
			$rows .= '<td class="r9-cell-listing" data-label="' . esc_attr__( 'Listing', 'review9ja-listings-no-reviews' ) . '"><strong>' . esc_html( $post->post_title ) . '</strong><div class="r9-sub">' . esc_html( sprintf( 'ID %d', $post->ID ) ) . '</div></td>';
			$rows .= '<td data-label="' . esc_attr__( 'Status', 'review9ja-listings-no-reviews' ) . '">' . esc_html( ucfirst( $post->post_status ) ) . '</td>';
			$rows .= '<td data-label="' . esc_attr__( 'Hidden reason', 'review9ja-listings-no-reviews' ) . '">' . esc_html( $hidden_reason_label ) . '</td>';
			$rows .= '<td data-label="' . esc_attr__( 'Hidden date', 'review9ja-listings-no-reviews' ) . '">' . esc_html( $hidden_at_display ) . '</td>';
			$rows .= '<td class="r9-actions" data-label="' . esc_attr__( 'Actions', 'review9ja-listings-no-reviews' ) . '">';
			if ( $view_url ) {
				$rows .= '<a class="button button-secondary" href="' . esc_url( $view_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'View', 'review9ja-listings-no-reviews' ) . '</a>';
			}
			$rows .= '<button type="button" class="button r9-action" data-action="unhide" data-id="' . esc_attr( $post->ID ) . '">' . esc_html__( 'Restore', 'review9ja-listings-no-reviews' ) . '</button>';
			$rows .= '</td>';
			$rows .= '</tr>';
		}

		return $rows;
	}

	public function ajax_no_reviews_list() {
		check_ajax_referer( self::AJAX_NONCE, 'nonce' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => 'Not allowed.' ], 403 );
		}

		$per_page = isset( $_POST['per_page'] ) ? $this->sanitize_per_page( $_POST['per_page'], true ) : $this->get_default_per_page();
		$sort = isset( $_POST['sort'] ) ? $this->sanitize_sort( wp_unslash( $_POST['sort'] ) ) : 'az';
		$page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

		$data = $this->get_no_reviews_data( $page, $per_page, $sort );

		wp_send_json_success( [
			'rows' => $this->render_no_reviews_rows( $data['posts'] ),
			'pagination' => $this->build_pagination( $data['page'], $data['total_pages'] ),
			'total' => $data['total'],
		] );
	}

	public function ajax_hidden_list() {
		check_ajax_referer( self::AJAX_NONCE, 'nonce' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => 'Not allowed.' ], 403 );
		}

		$per_page = isset( $_POST['per_page'] ) ? $this->sanitize_per_page( $_POST['per_page'], true ) : $this->get_default_per_page();
		$sort = isset( $_POST['sort'] ) ? $this->sanitize_sort( wp_unslash( $_POST['sort'] ) ) : 'az';
		$page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

		$data = $this->get_hidden_data( $page, $per_page, $sort );

		wp_send_json_success( [
			'rows' => $this->render_hidden_rows( $data['posts'] ),
			'pagination' => $this->build_pagination( $data['page'], $data['total_pages'] ),
			'total' => $data['total'],
		] );
	}

	private function render_page_shell( $mode ) {
		$per_page = $this->get_default_per_page();
		$sort = 'az';
		$title = $mode === 'hidden'
			? __( 'Hidden Listings', 'review9ja-listings-no-reviews' )
			: __( 'Listings Without Reviews', 'review9ja-listings-no-reviews' );

		$stat_label = $mode === 'hidden'
			? __( 'Hidden listings', 'review9ja-listings-no-reviews' )
			: __( 'Listings with no reviews', 'review9ja-listings-no-reviews' );
		?>
		<div class="wrap review9ja-no-reviews" data-mode="<?php echo esc_attr( $mode ); ?>">
			<h1><?php echo esc_html( $title ); ?></h1>

			<form method="get" class="r9-filters" data-action="filters">
				<input type="hidden" name="post_type" value="<?php echo esc_attr( self::POST_TYPE ); ?>">
				<input type="hidden" name="page" value="<?php echo esc_attr( $mode === 'hidden' ? self::PAGE_HIDDEN : self::PAGE_NO_REVIEWS ); ?>">

				<div class="r9-filter-row">
					<div class="r9-filter-group">
						<label for="r9-sort"><?php esc_html_e( 'Sort', 'review9ja-listings-no-reviews' ); ?></label>
						<select id="r9-sort" name="sort">
							<option value="az"><?php esc_html_e( 'A-Z', 'review9ja-listings-no-reviews' ); ?></option>
							<option value="za"><?php esc_html_e( 'Z-A', 'review9ja-listings-no-reviews' ); ?></option>
							<option value="random"><?php esc_html_e( 'Random', 'review9ja-listings-no-reviews' ); ?></option>
						</select>
					</div>

					<div class="r9-filter-group">
						<label for="r9-per-page"><?php esc_html_e( 'Per page (max 100)', 'review9ja-listings-no-reviews' ); ?></label>
						<input
							id="r9-per-page"
							type="number"
							name="per_page"
							min="1"
							max="<?php echo esc_attr( self::MAX_PER_PAGE ); ?>"
							value="<?php echo esc_attr( $per_page ); ?>"
						>
					</div>

					<div class="r9-filter-actions">
						<button class="button button-primary" type="submit"><?php esc_html_e( 'Apply', 'review9ja-listings-no-reviews' ); ?></button>
						<button class="button" type="button" data-action="reload"><?php esc_html_e( 'Reload', 'review9ja-listings-no-reviews' ); ?></button>
					</div>
				</div>
			</form>

			<div class="r9-stats">
				<div class="r9-stat">
					<span class="r9-stat-label"><?php echo esc_html( $stat_label ); ?></span>
					<span class="r9-stat-value" data-role="count">0</span>
				</div>
			</div>

			<div class="r9-table-wrap">
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Listing', 'review9ja-listings-no-reviews' ); ?></th>
							<th><?php esc_html_e( 'Status', 'review9ja-listings-no-reviews' ); ?></th>
							<?php if ( $mode === 'hidden' ) : ?>
								<th><?php esc_html_e( 'Hidden reason', 'review9ja-listings-no-reviews' ); ?></th>
								<th><?php esc_html_e( 'Hidden date', 'review9ja-listings-no-reviews' ); ?></th>
							<?php else : ?>
								<th><?php esc_html_e( 'Author', 'review9ja-listings-no-reviews' ); ?></th>
								<th><?php esc_html_e( 'Date', 'review9ja-listings-no-reviews' ); ?></th>
							<?php endif; ?>
							<th><?php esc_html_e( 'Actions', 'review9ja-listings-no-reviews' ); ?></th>
						</tr>
					</thead>
					<tbody data-role="rows">
						<tr><td colspan="5" class="r9-empty"><?php esc_html_e( 'Loading...', 'review9ja-listings-no-reviews' ); ?></td></tr>
					</tbody>
				</table>
			</div>

			<nav class="r9-pagination" data-role="pagination"></nav>
		</div>
		<?php
	}

	public function render_no_reviews_page() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$this->render_page_shell( 'no-reviews' );
	}

	public function render_hidden_page() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$this->render_page_shell( 'hidden' );
	}
}

new Review9ja_Listings_No_Reviews();
