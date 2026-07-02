<?php
/**
 * Plugin Name: Review9ja Admin Review Stats
 * Description: Tracks admin-added and admin-approved listing reviews and shows date-range stats.
 * Version: 1.0.0
 * Author: Review9ja
 * Text Domain: review9ja-admin-review-stats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Review9ja_Admin_Review_Stats {
	const VERSION = '1.0.0';
	const POST_TYPE = 'job_listing';
	const META_ADDED_BY = '_review9ja_added_by';
	const META_ADDED_AT = '_review9ja_added_at';
	const META_APPROVED_BY = '_review9ja_approved_by';
	const META_APPROVED_AT = '_review9ja_approved_at';
	const META_APPROVED_LOCK = '_review9ja_approved_lock';
	const LISTINGS_PER_PAGE = 20;
	const REVIEWS_PER_PAGE = 20;
	const OPTION_ADMIN_SCOPE = 'review9ja_review_stats_admin_scope';
	const OPTION_ADMIN_IDS = 'review9ja_review_stats_admin_ids';
	const OPTION_OWNER_ID = 'review9ja_review_stats_owner_id';

	public function __construct() {
		add_action( 'wp_insert_comment', [ $this, 'track_admin_added_review' ], 10, 2 );
		add_action( 'transition_comment_status', [ $this, 'track_admin_approval' ], 10, 3 );
		add_action( 'admin_menu', [ $this, 'register_admin_page' ] );
		add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
		add_action( 'admin_post_review9ja_save_review_stats_admins', [ $this, 'save_admin_list' ] );
	}

	private function current_user_can_track() {
		$cap = apply_filters( 'review9ja_review_stats_actor_cap', 'manage_options' );
		return is_user_logged_in() && current_user_can( $cap );
	}

	private function is_listing_comment( $comment ) {
		if ( ! $comment instanceof WP_Comment ) {
			return false;
		}

		$post_id = (int) $comment->comment_post_ID;
		if ( ! $post_id ) {
			return false;
		}

		return self::POST_TYPE === get_post_type( $post_id );
	}

	private function now_gmt_timestamp() {
		return (int) current_time( 'timestamp', true );
	}

	public function track_admin_added_review( $comment_id, $comment ) {
		if ( ! $this->current_user_can_track() ) {
			return;
		}

		$comment = $comment instanceof WP_Comment ? $comment : get_comment( $comment_id );
		if ( ! $this->is_listing_comment( $comment ) ) {
			return;
		}

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return;
		}

		if ( ! get_comment_meta( $comment_id, self::META_ADDED_BY, true ) ) {
			update_comment_meta( $comment_id, self::META_ADDED_BY, $user_id );
		}

		if ( ! get_comment_meta( $comment_id, self::META_ADDED_AT, true ) ) {
			update_comment_meta( $comment_id, self::META_ADDED_AT, $this->now_gmt_timestamp() );
		}
	}

	public function track_admin_approval( $new_status, $old_status, $comment ) {
		if ( ! $this->current_user_can_track() ) {
			return;
		}

		$comment = $comment instanceof WP_Comment ? $comment : get_comment( $comment );
		if ( ! $this->is_listing_comment( $comment ) ) {
			return;
		}

		$comment_id = (int) $comment->comment_ID;

		if ( 'approved' === $old_status && 'approved' !== $new_status ) {
			if ( ! get_comment_meta( $comment_id, self::META_APPROVED_LOCK, true ) ) {
				add_comment_meta( $comment_id, self::META_APPROVED_LOCK, 1, true );
			}
			return;
		}

		if ( 'approved' !== $new_status || 'approved' === $old_status ) {
			return;
		}

		if ( get_comment_meta( $comment_id, self::META_APPROVED_LOCK, true ) ) {
			return;
		}

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return;
		}

		$existing = get_comment_meta( $comment_id, self::META_APPROVED_BY, true );
		if ( $existing ) {
			if ( ! get_comment_meta( $comment_id, self::META_APPROVED_LOCK, true ) ) {
				add_comment_meta( $comment_id, self::META_APPROVED_LOCK, 1, true );
			}
			return;
		}

		add_comment_meta( $comment_id, self::META_APPROVED_BY, $user_id, true );
		add_comment_meta( $comment_id, self::META_APPROVED_AT, $this->now_gmt_timestamp(), true );
		add_comment_meta( $comment_id, self::META_APPROVED_LOCK, 1, true );
	}

	public function register_admin_page() {
		add_submenu_page(
			'edit.php?post_type=' . self::POST_TYPE,
			'Review Stats',
			'Review Stats',
			'manage_options',
			'review9ja-review-stats',
			[ $this, 'render_admin_page' ]
		);
	}

	public function register_settings_page() {
		if ( ! $this->current_user_can_manage_settings() ) {
			return;
		}

		add_submenu_page(
			'edit.php?post_type=' . self::POST_TYPE,
			'Review Stats Admins',
			'Review Stats Admins',
			'manage_options',
			'review9ja-review-stats-admins',
			[ $this, 'render_settings_page' ]
		);
	}

	public function render_settings_page() {
		if ( ! $this->current_user_can_manage_settings() ) {
			return;
		}

		$admin_scope = $this->get_admin_scope();
		$selected_admin_ids = $this->get_selected_admin_ids();
		$all_admins = $this->get_all_admin_users();
		$owner_id = $this->get_settings_owner_id();
		?>
		<div class="wrap">
			<h1>Review Stats Admins</h1>

			<?php if ( ! empty( $_GET['review9ja_admin_saved'] ) ) : ?>
				<div class="notice notice-success"><p>Admin list updated.</p></div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'review9ja_review_stats_admins' ); ?>
				<input type="hidden" name="action" value="review9ja_save_review_stats_admins">

				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">Scope</th>
						<td>
							<label>
								<input type="radio" name="admin_scope" value="all" <?php checked( 'all', $admin_scope ); ?>>
								All admins
							</label>
							<br>
							<label>
								<input type="radio" name="admin_scope" value="selected" <?php checked( 'selected', $admin_scope ); ?>>
								Selected admins
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">Admins</th>
						<td>
							<?php if ( empty( $all_admins ) ) : ?>
								<p>No admin accounts found.</p>
							<?php else : ?>
								<?php foreach ( $all_admins as $admin ) : ?>
									<label style="display:block;margin-bottom:6px;">
										<input type="checkbox" name="review9ja_admin_ids[]" value="<?php echo esc_attr( $admin->ID ); ?>" <?php checked( in_array( $admin->ID, $selected_admin_ids, true ) ); ?>>
										<?php echo esc_html( $admin->display_name ? $admin->display_name : $admin->user_login ); ?>
									</label>
								<?php endforeach; ?>
							<?php endif; ?>
							<p class="description">The list above is used only when "Selected admins" is chosen.</p>
						</td>
					</tr>
				</table>

				<?php submit_button( 'Save Admin List' ); ?>
			</form>

			<p class="description">
				Only the owner (user ID <?php echo esc_html( $owner_id ); ?>) can see and edit this page.
			</p>
		</div>
		<?php
	}

	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$range = $this->get_date_range();
		$reviews_range = $this->get_recent_reviews_range( $range );
		$admins = $this->get_admin_users();
		$selected_admin_id = isset( $_GET['admin_id'] ) ? absint( $_GET['admin_id'] ) : 0;
		$selected_admin = null;
		$selected_admin_label = '';
		if ( $selected_admin_id ) {
			foreach ( $admins as $admin ) {
				if ( (int) $admin->ID === $selected_admin_id ) {
					$selected_admin = $admin;
					$selected_admin_label = $admin->display_name ? $admin->display_name : $admin->user_login;
					break;
				}
			}
		}
		?>
		<div class="wrap">
			<h1>Review Stats</h1>

			<?php if ( $range['error'] ) : ?>
				<div class="notice notice-error"><p><?php echo esc_html( $range['error'] ); ?></p></div>
			<?php endif; ?>

			<form method="get">
				<input type="hidden" name="post_type" value="<?php echo esc_attr( self::POST_TYPE ); ?>">
				<input type="hidden" name="page" value="review9ja-review-stats">
				<?php if ( $selected_admin_id ) : ?>
					<input type="hidden" name="admin_id" value="<?php echo esc_attr( $selected_admin_id ); ?>">
				<?php endif; ?>

				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="review9ja_range">Quick range</label></th>
						<td>
							<select id="review9ja_range" name="range">
								<option value="" <?php selected( '', $range['range_key'] ); ?>>Custom (use start/end dates)</option>
								<option value="24h" <?php selected( '24h', $range['range_key'] ); ?>>Last 24 hours</option>
								<option value="7d" <?php selected( '7d', $range['range_key'] ); ?>>Last 7 days</option>
								<option value="30d" <?php selected( '30d', $range['range_key'] ); ?>>Last 30 days</option>
							</select>
							<p class="description">Selecting a quick range overrides start/end dates.</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="review9ja_start_date">Start date</label></th>
						<td><input type="datetime-local" id="review9ja_start_date" name="start_date" value="<?php echo esc_attr( $range['start_input'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="review9ja_end_date">End date</label></th>
						<td><input type="datetime-local" id="review9ja_end_date" name="end_date" value="<?php echo esc_attr( $range['end_input'] ); ?>"></td>
					</tr>
				</table>

				<?php submit_button( 'Filter' ); ?>
			</form>

			<?php
				$totals = $this->get_total_review_counts( $range['start_ts'], $range['end_ts'] );
				$range_label = $range['range_label'] ? '(' . $range['range_label'] . ')' : $this->format_range_label( $range['start_label'], $range['end_label'] );
			?>

			<h2>Totals <?php echo esc_html( $range_label ); ?></h2>
			<table class="widefat striped">
				<thead>
					<tr>
						<th>Total reviews</th>
						<th>Approved</th>
						<th>Pending</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo esc_html( number_format_i18n( $totals['total'] ) ); ?></td>
						<td><?php echo esc_html( number_format_i18n( $totals['approved'] ) ); ?></td>
						<td><?php echo esc_html( number_format_i18n( $totals['pending'] ) ); ?></td>
					</tr>
				</tbody>
			</table>

			<h2>By Admin <?php echo esc_html( $range_label ); ?></h2>
			<table class="widefat striped">
				<thead>
					<tr>
						<th>Admin</th>
						<th>Listings reviewed</th>
						<th>Reviews added</th>
						<th>Reviews approved</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $admins ) ) : ?>
						<tr><td colspan="4">No admin accounts found.</td></tr>
					<?php else : ?>
						<?php foreach ( $admins as $admin ) : ?>
							<?php
								$added_count = $this->get_admin_event_count( $admin->ID, self::META_ADDED_BY, self::META_ADDED_AT, $range['start_ts'], $range['end_ts'] );
								$approved_count = $this->get_admin_event_count( $admin->ID, self::META_APPROVED_BY, self::META_APPROVED_AT, $range['start_ts'], $range['end_ts'] );

								$added_listing_ids = $this->get_admin_event_listing_ids( $admin->ID, self::META_ADDED_BY, self::META_ADDED_AT, $range['start_ts'], $range['end_ts'] );
								$listing_ids = $added_listing_ids;
								$base_url = $this->build_admin_listings_url( $admin->ID, $range );
								$listings_url = $base_url . '#review9ja-admin-listings';
								$reviews_url = $this->build_admin_listings_url( $admin->ID, $reviews_range ) . '#review9ja-admin-recent-reviews';
							?>
							<tr>
								<td><?php echo esc_html( $admin->display_name ? $admin->display_name : $admin->user_login ); ?></td>
								<td>
									<?php echo esc_html( number_format_i18n( count( $listing_ids ) ) ); ?>
									<div><a href="<?php echo esc_url( $listings_url ); ?>">View listings</a></div>
								</td>
								<td>
									<?php echo esc_html( number_format_i18n( $added_count ) ); ?>
									<div><a class="review9ja-view-reviews-link" href="<?php echo esc_url( $reviews_url ); ?>">View recent reviews</a></div>
								</td>
								<td><?php echo esc_html( number_format_i18n( $approved_count ) ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>

			<?php if ( $selected_admin_id ) : ?>
				<h2 id="review9ja-admin-listings">Listings Reviewed<?php echo $selected_admin_label ? ' — ' . esc_html( $selected_admin_label ) : ''; ?></h2>
				<?php if ( ! $selected_admin ) : ?>
					<div class="notice notice-warning"><p>Selected admin is not in the current stats scope.</p></div>
				<?php else : ?>
					<?php
						$listing_ids = $this->get_admin_event_listing_ids( $selected_admin_id, self::META_ADDED_BY, self::META_ADDED_AT, $range['start_ts'], $range['end_ts'] );
					?>
					<?php if ( empty( $listing_ids ) ) : ?>
						<p>No listings found for this admin in the selected date range.</p>
					<?php else : ?>
						<?php
							$listing_page = isset( $_GET['listing_page'] ) ? absint( $_GET['listing_page'] ) : 1;
							$listing_page = max( 1, $listing_page );
							$listing_query = new WP_Query( [
								'post_type' => self::POST_TYPE,
								'post_status' => 'any',
								'post__in' => $listing_ids,
								'orderby' => 'title',
								'order' => 'ASC',
								'posts_per_page' => self::LISTINGS_PER_PAGE,
								'paged' => $listing_page,
								'no_found_rows' => false,
							] );
							$listing_posts = $listing_query->posts;
						?>
						<table class="widefat striped">
							<thead>
								<tr>
									<th>Listing</th>
									<th>ID</th>
									<th>Profile</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $listing_posts as $post ) : ?>
									<?php
										$view_url = get_permalink( $post );
										$edit_url = get_edit_post_link( $post->ID, 'raw' );
									?>
									<tr>
										<td><?php echo esc_html( $post->post_title ); ?></td>
										<td><?php echo esc_html( $post->ID ); ?></td>
										<td>
											<?php if ( $view_url ) : ?>
												<a href="<?php echo esc_url( $view_url ); ?>" target="_blank" rel="noopener">View profile</a>
											<?php else : ?>
												&mdash;
											<?php endif; ?>
										</td>
										<td>
											<?php if ( $edit_url ) : ?>
												<a href="<?php echo esc_url( $edit_url ); ?>">Edit listing</a>
											<?php else : ?>
												&mdash;
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php
							$listing_total_pages = max( 1, (int) $listing_query->max_num_pages );
							if ( $listing_total_pages > 1 ) :
							$listing_pagination_args = $this->build_admin_filter_args( $range, $selected_admin_id );
							$listing_pagination_args['listing_page'] = '%#%';
							$listing_pagination_base = add_query_arg( $listing_pagination_args, admin_url( 'edit.php' ) ) . '#review9ja-admin-listings';
								echo wp_kses_post( paginate_links( [
									'base' => $listing_pagination_base,
									'format' => '',
									'current' => $listing_page,
									'total' => $listing_total_pages,
									'type' => 'list',
								] ) );
							endif;
						?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( $selected_admin_id ) : ?>
				<?php
					$reviews_range_label = $reviews_range['range_label']
						? '(' . $reviews_range['range_label'] . ')'
						: $this->format_range_label( $reviews_range['start_label'], $reviews_range['end_label'] );
				?>
				<h2 id="review9ja-admin-recent-reviews">Recent Added Reviews<?php echo $selected_admin_label ? ' — ' . esc_html( $selected_admin_label ) : ''; ?> <?php echo esc_html( $reviews_range_label ); ?></h2>
				<?php if ( ! $selected_admin ) : ?>
					<div class="notice notice-warning"><p>Selected admin is not in the current stats scope.</p></div>
				<?php else : ?>
					<?php
						$review_page = isset( $_GET['reviews_page'] ) ? absint( $_GET['reviews_page'] ) : 1;
						$review_page = max( 1, $review_page );
						$review_page_data = $this->get_admin_added_reviews_page( $selected_admin_id, $reviews_range['start_ts'], $reviews_range['end_ts'], $review_page, self::REVIEWS_PER_PAGE );
						$admin_reviews = [];
						$review_ids = $review_page_data['ids'] ?? [];
						if ( ! is_array( $review_ids ) ) {
							$review_ids = array_filter( array_map( 'absint', explode( ',', (string) $review_ids ) ) );
						}
						if ( ! empty( $review_ids ) ) {
							foreach ( $review_ids as $review_id ) {
								$comment = get_comment( $review_id );
								if ( $comment instanceof WP_Comment ) {
									$admin_reviews[] = $comment;
								}
							}

							$admin_reviews = $this->filter_strict_admin_added_reviews( $admin_reviews, $selected_admin_id, $reviews_range['start_ts'], $reviews_range['end_ts'] );
						}
					?>
					<?php if ( empty( $admin_reviews ) ) : ?>
						<p>No approved reviews added for this admin in the selected date range.</p>
					<?php else : ?>
						<?php
							$display_timezone = wp_timezone();
							$display_date_format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
						?>
						<table class="widefat striped">
							<thead>
								<tr>
									<th>Review</th>
									<th>Listing</th>
									<th>Rating</th>
									<th>Status</th>
									<th>Date</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $admin_reviews as $comment ) : ?>
									<?php
										$listing_title = get_the_title( $comment->comment_post_ID );
										$listing_url = get_permalink( $comment->comment_post_ID );
										$edit_comment_url = get_edit_comment_link( $comment->comment_ID );
										$rating = get_comment_meta( $comment->comment_ID, '_case27_post_rating', true );
										$rating_display = '&mdash;';
										if ( $rating !== '' && is_numeric( $rating ) ) {
											$rating_display = number_format_i18n( (float) $rating, 1 );
										}
										$status = wp_get_comment_status( $comment->comment_ID );
										$status_label = $status ? ucfirst( $status ) : 'Unknown';
										$added_at_meta = get_comment_meta( $comment->comment_ID, self::META_ADDED_AT, true );
										$added_ts = is_numeric( $added_at_meta ) ? (int) $added_at_meta : 0;
										if ( ! $added_ts && ! empty( $comment->comment_date_gmt ) ) {
											$added_ts = strtotime( $comment->comment_date_gmt . ' UTC' );
										}
										$date_label = $added_ts
											? wp_date( $display_date_format, $added_ts, $display_timezone )
											: $comment->comment_date;
										$review_excerpt = wp_trim_words( $comment->comment_content, 24, '...' );
									?>
									<tr>
										<td><?php echo esc_html( $review_excerpt ); ?></td>
										<td>
											<?php echo esc_html( $listing_title ); ?>
											<?php if ( $listing_url ) : ?>
												<div><a href="<?php echo esc_url( $listing_url ); ?>" target="_blank" rel="noopener">View profile</a></div>
											<?php endif; ?>
										</td>
										<td><?php echo wp_kses_post( $rating_display ); ?></td>
										<td><?php echo esc_html( $status_label ); ?></td>
										<td><?php echo esc_html( $date_label ); ?></td>
										<td>
											<?php if ( $edit_comment_url ) : ?>
												<a href="<?php echo esc_url( $edit_comment_url ); ?>">Edit review</a>
											<?php else : ?>
												&mdash;
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php
							$review_total_pages = max( 1, (int) ceil( $review_page_data['total'] / self::REVIEWS_PER_PAGE ) );
							if ( $review_total_pages > 1 ) :
								$review_pagination_args = $this->build_admin_filter_args( $reviews_range, $selected_admin_id );
								$review_pagination_args['reviews_page'] = '%#%';
								$review_pagination_base = add_query_arg( $review_pagination_args, admin_url( 'edit.php' ) ) . '#review9ja-admin-recent-reviews';
								echo wp_kses_post( paginate_links( [
									'base' => $review_pagination_base,
									'format' => '',
									'current' => $review_page,
									'total' => $review_total_pages,
									'type' => 'list',
								] ) );
							endif;
						?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>

			<p class="description">
				Stats for admin actions start from plugin activation. "Listings reviewed" only counts listings where the admin added reviews.
			</p>
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					var links = document.querySelectorAll('.review9ja-view-reviews-link');
					for (var i = 0; i < links.length; i++) {
						links[i].addEventListener('click', function() {
							try {
								var url = new URL(this.href, window.location.origin);
								url.searchParams.set('_rvts', String(Date.now()));
								this.href = url.toString();
							} catch (e) {
								// no-op
							}
						});
					}
				});
			</script>
		</div>
		<?php
	}

	private function current_user_can_manage_settings() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$owner_id = $this->get_settings_owner_id();
		if ( ! $owner_id ) {
			return false;
		}

		return get_current_user_id() === $owner_id;
	}

	private function get_settings_owner_id() {
		$owner_id = (int) apply_filters( 'review9ja_review_stats_owner_id', 0 );
		if ( $owner_id ) {
			return $owner_id;
		}

		$owner_id = (int) get_option( self::OPTION_OWNER_ID, 0 );
		if ( $owner_id ) {
			return $owner_id;
		}

		$current_id = get_current_user_id();
		if ( $current_id && current_user_can( 'manage_options' ) ) {
			update_option( self::OPTION_OWNER_ID, $current_id );
			return $current_id;
		}

		return 0;
	}

	private function get_admin_users() {
		$roles = apply_filters( 'review9ja_review_stats_roles', [ 'administrator' ] );

		$args = [
			'role__in' => $roles,
			'orderby' => 'display_name',
			'order' => 'ASC',
			'fields' => [ 'ID', 'display_name', 'user_login' ],
		];

		if ( 'selected' === $this->get_admin_scope() ) {
			$selected = $this->get_selected_admin_ids();
			if ( empty( $selected ) ) {
				return [];
			}
			$args['include'] = $selected;
		}

		return get_users( $args );
	}

	private function get_all_admin_users() {
		$roles = apply_filters( 'review9ja_review_stats_roles', [ 'administrator' ] );

		return get_users( [
			'role__in' => $roles,
			'orderby' => 'display_name',
			'order' => 'ASC',
			'fields' => [ 'ID', 'display_name', 'user_login' ],
		] );
	}

	private function get_admin_scope() {
		$scope = get_option( self::OPTION_ADMIN_SCOPE, 'all' );
		return $scope === 'selected' ? 'selected' : 'all';
	}

	private function get_selected_admin_ids() {
		$ids = get_option( self::OPTION_ADMIN_IDS, [] );
		if ( ! is_array( $ids ) ) {
			return [];
		}

		$ids = array_map( 'absint', $ids );
		return array_values( array_filter( $ids ) );
	}

	public function save_admin_list() {
		if ( ! $this->current_user_can_manage_settings() ) {
			wp_die( 'Not allowed.' );
		}

		check_admin_referer( 'review9ja_review_stats_admins' );

		$scope = isset( $_POST['admin_scope'] ) ? sanitize_text_field( wp_unslash( $_POST['admin_scope'] ) ) : 'all';
		if ( ! in_array( $scope, [ 'all', 'selected' ], true ) ) {
			$scope = 'all';
		}

		$ids = [];
		if ( ! empty( $_POST['review9ja_admin_ids'] ) && is_array( $_POST['review9ja_admin_ids'] ) ) {
			$ids = array_map( 'absint', wp_unslash( $_POST['review9ja_admin_ids'] ) );
			$ids = array_values( array_filter( $ids ) );
		}

		if ( 'all' === $scope && $ids ) {
			$scope = 'selected';
		}

		update_option( self::OPTION_ADMIN_SCOPE, $scope );
		update_option( self::OPTION_ADMIN_IDS, $ids );

		$redirect_url = add_query_arg(
			[
				'post_type' => self::POST_TYPE,
				'page' => 'review9ja-review-stats-admins',
				'review9ja_admin_saved' => 1,
			],
			admin_url( 'edit.php' )
		);
		wp_safe_redirect( $redirect_url );
		exit;
	}

	private function build_admin_filter_args( $range, $admin_id = 0 ) {
		$args = [
			'post_type' => self::POST_TYPE,
			'page' => 'review9ja-review-stats',
		];

		if ( $admin_id ) {
			$args['admin_id'] = $admin_id;
		}

		if ( ! empty( $range['range_key'] ) ) {
			$args['range'] = $range['range_key'];
		} else {
			if ( ! empty( $range['start_input'] ) ) {
				$args['start_date'] = $range['start_input'];
			}

			if ( ! empty( $range['end_input'] ) ) {
				$args['end_date'] = $range['end_input'];
			}
		}

		return $args;
	}

	private function build_admin_listings_url( $admin_id, $range ) {
		$args = $this->build_admin_filter_args( $range, $admin_id );
		return add_query_arg( $args, admin_url( 'edit.php' ) );
	}

	private function get_admin_added_reviews_page( $user_id, $start_ts, $end_ts, $page, $per_page ) {
		global $wpdb;

		$page = max( 1, (int) $page );
		$per_page = max( 1, (int) $per_page );
		$offset = ( $page - 1 ) * $per_page;

		$sql = "
			FROM {$wpdb->comments} c
			INNER JOIN {$wpdb->posts} p ON p.ID = c.comment_post_ID AND p.post_type = %s
			INNER JOIN {$wpdb->commentmeta} m_user ON m_user.comment_id = c.comment_ID AND m_user.meta_key = %s AND m_user.meta_value = %s
			LEFT JOIN {$wpdb->commentmeta} m_time ON m_time.comment_id = c.comment_ID AND m_time.meta_key = %s
		";

		$params = [ self::POST_TYPE, self::META_ADDED_BY, (string) $user_id, self::META_ADDED_AT ];
		$time_expr = "COALESCE(CAST(m_time.meta_value AS UNSIGNED), UNIX_TIMESTAMP(c.comment_date_gmt))";
		$time_conditions = '';

		if ( $start_ts ) {
			$time_conditions .= " AND {$time_expr} >= %d";
			$params[] = $start_ts;
		}

		if ( $end_ts ) {
			$time_conditions .= " AND {$time_expr} <= %d";
			$params[] = $end_ts;
		}

		$params[] = (int) $user_id;
		$sql .= " WHERE c.comment_approved = '1'" . $time_conditions . " AND (c.user_id = 0 OR c.user_id = %d)";

		$total = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT c.comment_ID) {$sql}", $params ) );

		$ids_sql = "SELECT c.comment_ID, MAX({$time_expr}) AS event_ts {$sql} GROUP BY c.comment_ID ORDER BY event_ts DESC, c.comment_ID DESC LIMIT %d OFFSET %d";
		$ids_params = array_merge( $params, [ $per_page, $offset ] );
		$rows = $wpdb->get_results( $wpdb->prepare( $ids_sql, $ids_params ), ARRAY_A );
		$ids = [];
		if ( is_array( $rows ) ) {
			$ids = array_map( 'intval', wp_list_pluck( $rows, 'comment_ID' ) );
		}

		return [
			'ids' => $ids,
			'total' => $total,
		];
	}

	private function format_range_label( $start, $end ) {
		if ( $start && $end ) {
			return '(' . $start . ' to ' . $end . ')';
		}

		if ( $start ) {
			return '(from ' . $start . ')';
		}

		if ( $end ) {
			return '(up to ' . $end . ')';
		}

		return '(all time)';
	}

	private function filter_strict_admin_added_reviews( $comments, $user_id, $start_ts, $end_ts ) {
		$user_id = (int) $user_id;
		$start_ts = $start_ts ? (int) $start_ts : 0;
		$end_ts = $end_ts ? (int) $end_ts : 0;

		$filtered = [];
		foreach ( $comments as $comment ) {
			if ( ! $comment instanceof WP_Comment ) {
				continue;
			}

			if ( ! $this->is_listing_comment( $comment ) ) {
				continue;
			}

			if ( 'approved' !== wp_get_comment_status( $comment->comment_ID ) ) {
				continue;
			}

			$added_by = (string) get_comment_meta( $comment->comment_ID, self::META_ADDED_BY, true );
			if ( (string) $user_id !== $added_by ) {
				continue;
			}

			// If comment has a real user author, it must match the selected admin.
			if ( (int) $comment->user_id > 0 && (int) $comment->user_id !== $user_id ) {
				continue;
			}

			$added_ts_raw = get_comment_meta( $comment->comment_ID, self::META_ADDED_AT, true );
			$added_ts = is_numeric( $added_ts_raw ) ? (int) $added_ts_raw : 0;
			if ( ! $added_ts && ! empty( $comment->comment_date_gmt ) ) {
				$added_ts = strtotime( $comment->comment_date_gmt . ' UTC' );
			}

			if ( $start_ts && $added_ts && $added_ts < $start_ts ) {
				continue;
			}

			if ( $end_ts && $added_ts && $added_ts > $end_ts ) {
				continue;
			}

			$filtered[] = $comment;
		}

		return array_values( $filtered );
	}

	private function get_recent_reviews_range( $range ) {
		$has_valid_quick_range = in_array( (string) $range['range_key'], [ '24h', '7d', '30d' ], true );
		$has_valid_custom_range = ! empty( $range['start_ts'] ) || ! empty( $range['end_ts'] );
		$has_error = ! empty( $range['error'] );

		// Keep explicit valid filters. Invalid/empty filters fall back to recent 24h.
		if ( ! $has_error && ( $has_valid_quick_range || $has_valid_custom_range ) ) {
			return $range;
		}

		$end_ts = (int) current_time( 'timestamp', true );
		$start_ts = $end_ts - DAY_IN_SECONDS;
		$timezone = wp_timezone();

		return [
			'start_label' => wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $start_ts, $timezone ),
			'end_label' => wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $end_ts, $timezone ),
			'start_input' => wp_date( 'Y-m-d\TH:i', $start_ts, $timezone ),
			'end_input' => wp_date( 'Y-m-d\TH:i', $end_ts, $timezone ),
			'start_ts' => $start_ts,
			'end_ts' => $end_ts,
			'error' => '',
			'range_key' => '24h',
			'range_label' => 'Last 24 hours',
		];
	}

	private function get_date_range() {
		$range_key = isset( $_GET['range'] ) ? sanitize_text_field( wp_unslash( $_GET['range'] ) ) : '';
		$quick_ranges = [
			'24h' => [
				'label' => 'Last 24 hours',
				'seconds' => DAY_IN_SECONDS,
			],
			'7d' => [
				'label' => 'Last 7 days',
				'seconds' => 7 * DAY_IN_SECONDS,
			],
			'30d' => [
				'label' => 'Last 30 days',
				'seconds' => 30 * DAY_IN_SECONDS,
			],
		];

		if ( ! isset( $quick_ranges[ $range_key ] ) ) {
			$range_key = '';
		}

		$start_raw = isset( $_GET['start_date'] ) ? sanitize_text_field( wp_unslash( $_GET['start_date'] ) ) : '';
		$end_raw = isset( $_GET['end_date'] ) ? sanitize_text_field( wp_unslash( $_GET['end_date'] ) ) : '';
		$start_ts = null;
		$end_ts = null;
		$error = '';
		$range_label = '';
		$start_input = '';
		$end_input = '';
		$start_label = '';
		$end_label = '';

		$timezone = wp_timezone();

		if ( $range_key ) {
			$end_ts = (int) current_time( 'timestamp', true );
			$start_ts = $end_ts - (int) $quick_ranges[ $range_key ]['seconds'];
			$range_label = $quick_ranges[ $range_key ]['label'];
			$start_input = wp_date( 'Y-m-d\TH:i', $start_ts, $timezone );
			$end_input = wp_date( 'Y-m-d\TH:i', $end_ts, $timezone );
			$start_label = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $start_ts, $timezone );
			$end_label = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $end_ts, $timezone );

			return [
				'start_label' => $start_label,
				'end_label' => $end_label,
				'start_input' => $start_input,
				'end_input' => $end_input,
				'start_ts' => $start_ts,
				'end_ts' => $end_ts,
				'error' => '',
				'range_key' => $range_key,
				'range_label' => $range_label,
			];
		}

		if ( $start_raw ) {
			try {
				$start_value = $start_raw;
				if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $start_raw ) ) {
					$start_value = $start_raw . ' 00:00:00';
					$start_input = $start_raw . 'T00:00';
				} else {
					$start_input = str_replace( ' ', 'T', $start_raw );
				}
				$start_dt = new DateTimeImmutable( $start_value, $timezone );
				$start_ts = $start_dt->getTimestamp();
			} catch ( Exception $e ) {
				$error = 'Invalid start date.';
				$start_raw = '';
				$start_input = '';
			}
		}

		if ( $end_raw ) {
			try {
				$end_value = $end_raw;
				if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $end_raw ) ) {
					$end_value = $end_raw . ' 23:59:59';
					$end_input = $end_raw . 'T23:59';
				} else {
					$end_input = str_replace( ' ', 'T', $end_raw );
				}
				$end_dt = new DateTimeImmutable( $end_value, $timezone );
				$end_ts = $end_dt->getTimestamp();
			} catch ( Exception $e ) {
				$error = 'Invalid end date.';
				$end_raw = '';
				$end_input = '';
			}
		}

		if ( $start_ts && $end_ts && $end_ts < $start_ts ) {
			$error = 'End date must be after start date.';
		}

		if ( $error ) {
			$start_ts = null;
			$end_ts = null;
			$start_label = '';
			$end_label = '';
		} else {
			if ( $start_ts ) {
				$start_label = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $start_ts, $timezone );
			}
			if ( $end_ts ) {
				$end_label = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $end_ts, $timezone );
			}
		}

		return [
			'start_label' => $start_label,
			'end_label' => $end_label,
			'start_input' => $start_input,
			'end_input' => $end_input,
			'start_ts' => $start_ts,
			'end_ts' => $end_ts,
			'error' => $error,
			'range_key' => '',
			'range_label' => '',
		];
	}

	private function get_total_review_counts( $start_ts, $end_ts ) {
		global $wpdb;

		$sql = "
			SELECT
				COUNT(*) as total,
				SUM(CASE WHEN c.comment_approved = '1' THEN 1 ELSE 0 END) as approved,
				SUM(CASE WHEN c.comment_approved IN ('0','hold') THEN 1 ELSE 0 END) as pending
			FROM {$wpdb->comments} c
			INNER JOIN {$wpdb->posts} p ON p.ID = c.comment_post_ID AND p.post_type = %s
			WHERE c.comment_approved NOT IN ('spam','trash')
		";

		$params = [ self::POST_TYPE ];

		if ( $start_ts ) {
			$sql .= " AND c.comment_date_gmt >= %s";
			$params[] = gmdate( 'Y-m-d H:i:s', $start_ts );
		}

		if ( $end_ts ) {
			$sql .= " AND c.comment_date_gmt <= %s";
			$params[] = gmdate( 'Y-m-d H:i:s', $end_ts );
		}

		$row = $wpdb->get_row( $wpdb->prepare( $sql, $params ), ARRAY_A );

		return [
			'total' => isset( $row['total'] ) ? (int) $row['total'] : 0,
			'approved' => isset( $row['approved'] ) ? (int) $row['approved'] : 0,
			'pending' => isset( $row['pending'] ) ? (int) $row['pending'] : 0,
		];
	}

	private function get_admin_event_count( $user_id, $meta_user_key, $meta_time_key, $start_ts, $end_ts ) {
		global $wpdb;

		$sql = "
			SELECT COUNT(DISTINCT c.comment_ID)
			FROM {$wpdb->comments} c
			INNER JOIN {$wpdb->posts} p ON p.ID = c.comment_post_ID AND p.post_type = %s
			INNER JOIN {$wpdb->commentmeta} m_user ON m_user.comment_id = c.comment_ID AND m_user.meta_key = %s AND m_user.meta_value = %s
		";

		$params = [ self::POST_TYPE, $meta_user_key, (string) $user_id ];
		$time_conditions = '';

		if ( $start_ts || $end_ts ) {
			if ( self::META_ADDED_AT === $meta_time_key ) {
				$sql .= " LEFT JOIN {$wpdb->commentmeta} m_time ON m_time.comment_id = c.comment_ID AND m_time.meta_key = %s";
				$params[] = $meta_time_key;
				$time_expr = "COALESCE(CAST(m_time.meta_value AS UNSIGNED), UNIX_TIMESTAMP(c.comment_date_gmt))";

				if ( $start_ts ) {
					$time_conditions .= " AND {$time_expr} >= %d";
					$params[] = $start_ts;
				}

				if ( $end_ts ) {
					$time_conditions .= " AND {$time_expr} <= %d";
					$params[] = $end_ts;
				}
			} else {
				$sql .= " INNER JOIN {$wpdb->commentmeta} m_time ON m_time.comment_id = c.comment_ID AND m_time.meta_key = %s";
				$params[] = $meta_time_key;

				if ( $start_ts ) {
					$sql .= " AND CAST(m_time.meta_value AS UNSIGNED) >= %d";
					$params[] = $start_ts;
				}

				if ( $end_ts ) {
					$sql .= " AND CAST(m_time.meta_value AS UNSIGNED) <= %d";
					$params[] = $end_ts;
				}
			}
		}

		if ( self::META_ADDED_BY === $meta_user_key ) {
			$params[] = (int) $user_id;
			$sql .= " WHERE c.comment_approved = '1'" . $time_conditions . " AND (c.user_id = 0 OR c.user_id = %d)";
		} else {
			$sql .= " WHERE c.comment_approved NOT IN ('spam','trash')" . $time_conditions;
		}

		return (int) $wpdb->get_var( $wpdb->prepare( $sql, $params ) );
	}

	private function get_admin_event_listing_ids( $user_id, $meta_user_key, $meta_time_key, $start_ts, $end_ts ) {
		global $wpdb;

		$sql = "
			SELECT DISTINCT c.comment_post_ID
			FROM {$wpdb->comments} c
			INNER JOIN {$wpdb->posts} p ON p.ID = c.comment_post_ID AND p.post_type = %s
			INNER JOIN {$wpdb->commentmeta} m_user ON m_user.comment_id = c.comment_ID AND m_user.meta_key = %s AND m_user.meta_value = %s
		";

		$params = [ self::POST_TYPE, $meta_user_key, (string) $user_id ];
		$time_conditions = '';

		if ( $start_ts || $end_ts ) {
			if ( self::META_ADDED_AT === $meta_time_key ) {
				$sql .= " LEFT JOIN {$wpdb->commentmeta} m_time ON m_time.comment_id = c.comment_ID AND m_time.meta_key = %s";
				$params[] = $meta_time_key;
				$time_expr = "COALESCE(CAST(m_time.meta_value AS UNSIGNED), UNIX_TIMESTAMP(c.comment_date_gmt))";

				if ( $start_ts ) {
					$time_conditions .= " AND {$time_expr} >= %d";
					$params[] = $start_ts;
				}

				if ( $end_ts ) {
					$time_conditions .= " AND {$time_expr} <= %d";
					$params[] = $end_ts;
				}
			} else {
				$sql .= " INNER JOIN {$wpdb->commentmeta} m_time ON m_time.comment_id = c.comment_ID AND m_time.meta_key = %s";
				$params[] = $meta_time_key;

				if ( $start_ts ) {
					$sql .= " AND CAST(m_time.meta_value AS UNSIGNED) >= %d";
					$params[] = $start_ts;
				}

				if ( $end_ts ) {
					$sql .= " AND CAST(m_time.meta_value AS UNSIGNED) <= %d";
					$params[] = $end_ts;
				}
			}
		}

		if ( self::META_ADDED_BY === $meta_user_key ) {
			$params[] = (int) $user_id;
			$sql .= " WHERE c.comment_approved = '1'" . $time_conditions . " AND (c.user_id = 0 OR c.user_id = %d)";
		} else {
			$sql .= " WHERE c.comment_approved NOT IN ('spam','trash')" . $time_conditions;
		}

		$ids = $wpdb->get_col( $wpdb->prepare( $sql, $params ) );

		return array_map( 'intval', $ids );
	}
}

function review9ja_review_stats_activate() {
	if ( get_option( 'review9ja_review_stats_owner_id' ) ) {
		return;
	}

	$user_id = get_current_user_id();
	if ( $user_id ) {
		update_option( 'review9ja_review_stats_owner_id', $user_id );
	}
}

register_activation_hook( __FILE__, 'review9ja_review_stats_activate' );

new Review9ja_Admin_Review_Stats();
