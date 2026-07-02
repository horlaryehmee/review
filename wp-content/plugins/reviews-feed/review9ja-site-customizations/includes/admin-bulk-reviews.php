<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Review9ja_Admin_Bulk_Reviews {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_bulk_reviews_page' ] );
		add_action( 'wp_ajax_review9ja_search_listings', [ $this, 'search_listings' ] );
		add_action( 'wp_ajax_review9ja_listing_review_settings', [ $this, 'listing_review_settings' ] );
		add_action( 'admin_post_review9ja_save_bulk_reviews', [ $this, 'save_bulk_reviews' ] );
	}

	public function register_bulk_reviews_page() {
		add_submenu_page(
			'edit.php?post_type=job_listing',
			'Add Reviews',
			'Add Reviews',
			'edit_posts',
			'review9ja-add-reviews',
			[ $this, 'render_bulk_reviews_page' ]
		);
	}

	public function render_bulk_reviews_page() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$status = isset( $_GET['review9ja_status'] ) ? sanitize_text_field( $_GET['review9ja_status'] ) : '';
		$message = isset( $_GET['review9ja_message'] ) ? sanitize_text_field( $_GET['review9ja_message'] ) : '';
		?>
		<div class="wrap">
			<h1>Add Reviews to Listings</h1>

			<?php if ( $status === 'success' ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php echo esc_html( $message ?: 'Reviews added successfully.' ); ?></p></div>
			<?php elseif ( $status === 'error' ) : ?>
				<div class="notice notice-error is-dismissible"><p><?php echo esc_html( $message ?: 'Could not add reviews.' ); ?></p></div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<?php wp_nonce_field( 'review9ja_bulk_reviews', '_review9ja_nonce' ); ?>
				<input type="hidden" name="action" value="review9ja_save_bulk_reviews">
				<input type="hidden" name="listing_id" id="review9ja_listing_id" value="">

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="review9ja_listing_search">Listing</label></th>
					<td>
						<input type="text" id="review9ja_listing_search" class="regular-text" placeholder="Search listings...">
						<button type="button" class="button" id="review9ja_listing_search_btn">Search</button>
						<p class="description">Type at least 2 characters to search for a listing, then select it.</p>
						<div id="review9ja_listing_results" class="review9ja-listing-results"></div>
						<p id="review9ja_listing_selected" class="review9ja-listing-selected"></p>
						<p id="review9ja_listing_counts" class="review9ja-listing-counts"></p>
					</td>
				</tr>
			</table>

				<h2>Reviews</h2>
				<div id="review9ja_reviews_container"></div>

				<p>
					<button type="button" class="button" id="review9ja_add_review">Add another review</button>
				</p>

				<?php submit_button( 'Save Reviews' ); ?>
			</form>
		</div>

		<style>
			.review9ja-review-row {
				background: #fff;
				border: 1px solid #ccd0d4;
				border-radius: 4px;
				padding: 12px;
				margin-bottom: 12px;
			}
			.review9ja-review-row h3 {
				margin: 0 0 12px;
			}
			.review9ja-row-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
				gap: 12px;
			}
			.review9ja-row-grid label {
				display: block;
				font-weight: 600;
				margin-bottom: 4px;
			}
			.review9ja-listing-results {
				margin-top: 8px;
			}
			.review9ja-listing-results button {
				display: block;
				width: 100%;
				text-align: left;
				margin-bottom: 6px;
			}
			.review9ja-listing-selected {
				margin-top: 8px;
				font-weight: 600;
			}
			.review9ja-remove-review {
				margin-top: 12px;
			}
		</style>

		<script>
			(function() {
				const ajaxUrl = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
				const ajaxNonce = "<?php echo esc_js( wp_create_nonce( 'review9ja_admin_reviews' ) ); ?>";

				const listingSearch = document.getElementById('review9ja_listing_search');
				const listingResults = document.getElementById('review9ja_listing_results');
				const listingIdField = document.getElementById('review9ja_listing_id');
				const listingSelected = document.getElementById('review9ja_listing_selected');
				const listingCounts = document.getElementById('review9ja_listing_counts');
				const searchBtn = document.getElementById('review9ja_listing_search_btn');
				const reviewsContainer = document.getElementById('review9ja_reviews_container');
				const addReviewBtn = document.getElementById('review9ja_add_review');

				let reviewIndex = 0;
				let currentMaxRating = 5;
				let galleryEnabled = true;

				function createReviewRow(index) {
					const wrapper = document.createElement('div');
					wrapper.className = 'review9ja-review-row';
					wrapper.dataset.index = index;
					wrapper.innerHTML = `
						<h3>Review ${index + 1}</h3>
						<div class="review9ja-row-grid">
							<div>
								<label for="review9ja_author_${index}">Author Name</label>
								<input type="text" id="review9ja_author_${index}" name="reviews[${index}][author]" class="regular-text" required>
							</div>
							<div>
								<label for="review9ja_email_${index}">Author Email</label>
								<input type="email" id="review9ja_email_${index}" name="reviews[${index}][email]" class="regular-text">
							</div>
							<div>
								<label for="review9ja_rating_${index}">Rating (1-${currentMaxRating})</label>
								<input type="number" min="1" max="${currentMaxRating}" step="1" id="review9ja_rating_${index}" name="reviews[${index}][rating]" class="small-text">
							</div>
							<div>
								<label for="review9ja_approved_${index}">Approved</label>
								<input type="checkbox" id="review9ja_approved_${index}" name="reviews[${index}][approved]" value="1" checked>
							</div>
							<div>
								<label for="review9ja_gallery_${index}">Images</label>
								<input type="file" id="review9ja_gallery_${index}" name="review_gallery[${index}][]" class="review9ja-gallery-input" multiple ${galleryEnabled ? '' : 'disabled'}>
								<p class="description review9ja-gallery-note" style="${galleryEnabled ? 'display:none;' : ''}">Gallery is disabled for this listing type.</p>
							</div>
						</div>
						<p>
							<label for="review9ja_content_${index}">Review Content</label>
							<textarea id="review9ja_content_${index}" name="reviews[${index}][content]" rows="4" class="large-text" required></textarea>
						</p>
						<button type="button" class="button link-delete review9ja-remove-review">Remove review</button>
					`;
					return wrapper;
				}

				function addReviewRow() {
					const row = createReviewRow(reviewIndex);
					reviewsContainer.appendChild(row);
					reviewIndex += 1;
				}

				function clearListingResults() {
					listingResults.innerHTML = '';
				}

				function selectListing(id, text) {
					listingIdField.value = id;
					listingSelected.textContent = `Selected listing: ${text} (ID ${id})`;
					if (listingCounts) {
						listingCounts.textContent = 'Comments on this listing: loading...';
					}
					clearListingResults();
					updateRatingFields(id);
				}

				function updateRatingFields(listingId) {
					const formData = new URLSearchParams();
					formData.append('action', 'review9ja_listing_review_settings');
					formData.append('listing_id', listingId);
					formData.append('_ajax_nonce', ajaxNonce);

					fetch(ajaxUrl, {
						method: 'POST',
						credentials: 'same-origin',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
						body: formData.toString()
					})
					.then(response => response.json())
					.then(data => {
						if (!data || !data.success) {
							return;
						}
						const maxRating = data.data.max_rating || 5;
						currentMaxRating = maxRating;
						galleryEnabled = !!data.data.gallery_enabled;
						if (listingCounts && typeof data.data.review_count_total !== 'undefined') {
							const total = parseInt(data.data.review_count_total, 10) || 0;
							listingCounts.textContent = `Comments on this listing: ${total}`;
						}
						const ratingInputs = reviewsContainer.querySelectorAll('input[name$="[rating]"]');
						ratingInputs.forEach(input => {
							input.max = maxRating;
							input.min = 1;
							input.step = 1;
						});
						const ratingLabels = reviewsContainer.querySelectorAll('label[for^="review9ja_rating_"]');
						ratingLabels.forEach(label => {
							label.textContent = `Rating (1-${maxRating})`;
						});
						updateGalleryFields(galleryEnabled);
					})
					.catch(() => {});
				}

				function updateGalleryFields(enabled) {
					const inputs = reviewsContainer.querySelectorAll('.review9ja-gallery-input');
					inputs.forEach(input => {
						input.disabled = !enabled;
					});
					const notes = reviewsContainer.querySelectorAll('.review9ja-gallery-note');
					notes.forEach(note => {
						note.style.display = enabled ? 'none' : 'block';
					});
				}

				function searchListings() {
					const query = listingSearch.value.trim();
					if (query.length < 2) {
						clearListingResults();
						return;
					}
					const formData = new URLSearchParams();
					formData.append('action', 'review9ja_search_listings');
					formData.append('q', query);
					formData.append('_ajax_nonce', ajaxNonce);

					listingResults.innerHTML = '<p>Searching...</p>';

					fetch(ajaxUrl, {
						method: 'POST',
						credentials: 'same-origin',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
						body: formData.toString()
					})
					.then(response => response.json())
					.then(data => {
						clearListingResults();
						if (!data || !data.success || !data.data.length) {
							listingResults.innerHTML = '<p>No listings found.</p>';
							return;
						}
						data.data.forEach(item => {
							const btn = document.createElement('button');
							btn.type = 'button';
							btn.className = 'button';
							btn.textContent = `${item.text} (ID ${item.id})`;
							btn.addEventListener('click', () => selectListing(item.id, item.text));
							listingResults.appendChild(btn);
						});
					})
					.catch(() => {
						listingResults.innerHTML = '<p>Search failed. Please try again.</p>';
					});
				}

				addReviewBtn.addEventListener('click', addReviewRow);
				reviewsContainer.addEventListener('click', (event) => {
					if (event.target.classList.contains('review9ja-remove-review')) {
						event.preventDefault();
						const row = event.target.closest('.review9ja-review-row');
						if (row) {
							row.remove();
						}
					}
				});

				listingSearch.addEventListener('keyup', (event) => {
					if (event.key === 'Enter') {
						event.preventDefault();
						searchListings();
					}
				});
				searchBtn.addEventListener('click', searchListings);

				// Initialize with one review row
				addReviewRow();
			})();
		</script>
		<?php
	}

	public function search_listings() {
		check_ajax_referer( 'review9ja_admin_reviews' );
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => 'Not allowed.' ], 403 );
		}

		$query = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';
		if ( strlen( $query ) < 2 ) {
			wp_send_json_success( [] );
		}

		$posts = get_posts( [
			'post_type'      => 'job_listing',
			'post_status'    => 'any',
			's'              => $query,
			'posts_per_page' => 20,
			'orderby'        => 'title',
			'order'          => 'ASC',
		] );

		$results = [];
		foreach ( $posts as $post ) {
			$results[] = [
				'id' => $post->ID,
				'text' => $post->post_title,
			];
		}

		wp_send_json_success( $results );
	}

	public function listing_review_settings() {
		check_ajax_referer( 'review9ja_admin_reviews' );
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => 'Not allowed.' ], 403 );
		}

		$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
		if ( ! $listing_id || get_post_type( $listing_id ) !== 'job_listing' ) {
			wp_send_json_error( [ 'message' => 'Invalid listing.' ], 400 );
		}

		$max_rating = 5;
		$gallery_enabled = false;
		if ( class_exists( '\MyListing\Ext\Reviews\Reviews' ) ) {
			$max_rating = \MyListing\Ext\Reviews\Reviews::max_rating( $listing_id );
			$gallery_enabled = \MyListing\Ext\Reviews\Reviews::is_review_gallery_enabled( $listing_id );
		}

		$review_count_total = (int) get_comments_number( $listing_id );
		$review_count_approved = $review_count_total;

		wp_send_json_success( [
			'max_rating' => $max_rating,
			'gallery_enabled' => $gallery_enabled,
			'review_count_total' => (int) $review_count_total,
			'review_count_approved' => (int) $review_count_approved,
		] );
	}

	private function extract_review_gallery_files( $index ) {
		if ( empty( $_FILES['review_gallery'] ) || ! isset( $_FILES['review_gallery']['name'][ $index ] ) ) {
			return [];
		}

		$names = $_FILES['review_gallery']['name'][ $index ];
		$types = $_FILES['review_gallery']['type'][ $index ];
		$tmp_names = $_FILES['review_gallery']['tmp_name'][ $index ];
		$errors = $_FILES['review_gallery']['error'][ $index ];
		$sizes = $_FILES['review_gallery']['size'][ $index ];

		if ( ! is_array( $names ) ) {
			return [];
		}

		$files = [];
		foreach ( $names as $i => $name ) {
			if ( empty( $name ) || empty( $tmp_names[ $i ] ) ) {
				continue;
			}
			$files[] = [
				'name'     => $name,
				'type'     => $types[ $i ] ?? '',
				'tmp_name' => $tmp_names[ $i ] ?? '',
				'error'    => $errors[ $i ] ?? 0,
				'size'     => $sizes[ $i ] ?? 0,
			];
		}

		return $files;
	}

	private function handle_review_gallery_uploads( $listing_id, $comment_id, $files ) {
		if ( empty( $files ) ) {
			return;
		}

		if ( ! class_exists( '\MyListing\Ext\Reviews\Reviews' ) ) {
			return;
		}

		if ( ! \MyListing\Ext\Reviews\Reviews::is_review_gallery_enabled( $listing_id ) ) {
			return;
		}

		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
		}

		foreach ( $files as $file_data ) {
			if ( ! empty( $file_data['error'] ) ) {
				continue;
			}

			$type = wp_check_filetype( $file_data['name'] );
			if ( empty( $type['type'] ) || strpos( $type['type'], 'image' ) === false ) {
				continue;
			}

			$_FILES['review9ja_gallery_tmp'] = $file_data;
			$attachment_id = media_handle_upload( 'review9ja_gallery_tmp', $listing_id );

			if ( is_wp_error( $attachment_id ) ) {
				continue;
			}

			update_post_meta( $attachment_id, '_case27_review_gallery', $comment_id );
			add_comment_meta( $comment_id, '_case27_review_gallery', $attachment_id, false );
		}

		unset( $_FILES['review9ja_gallery_tmp'] );
	}

	public function save_bulk_reviews() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'Not allowed.' );
		}

		check_admin_referer( 'review9ja_bulk_reviews', '_review9ja_nonce' );

		$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
		if ( ! $listing_id || get_post_type( $listing_id ) !== 'job_listing' ) {
			$redirect_url = add_query_arg(
				[
					'page' => 'review9ja-add-reviews',
					'post_type' => 'job_listing',
					'review9ja_status' => 'error',
					'review9ja_message' => rawurlencode( 'Please select a valid listing.' ),
				],
				admin_url( 'edit.php' )
			);
			wp_safe_redirect( $redirect_url );
			exit;
		}

		$raw_reviews = isset( $_POST['reviews'] ) ? (array) $_POST['reviews'] : [];

		if ( empty( $raw_reviews ) ) {
			$redirect_url = add_query_arg(
				[
					'page' => 'review9ja-add-reviews',
					'post_type' => 'job_listing',
					'review9ja_status' => 'error',
					'review9ja_message' => rawurlencode( 'Please add at least one review.' ),
				],
				admin_url( 'edit.php' )
			);
			wp_safe_redirect( $redirect_url );
			exit;
		}

		$max_rating = 5;
		$categories = [];
		$reviews_class_available = class_exists( '\MyListing\Ext\Reviews\Reviews' );
		if ( $reviews_class_available ) {
			$max_rating = \MyListing\Ext\Reviews\Reviews::max_rating( $listing_id );
			$categories = \MyListing\Ext\Reviews\Reviews::get_review_categories( $listing_id );
		}
		if ( empty( $categories ) ) {
			$categories = [
				[ 'id' => 'rating', 'label' => 'Rating' ],
			];
		}

		$inserted = 0;
		foreach ( $raw_reviews as $index => $review ) {
			$author = isset( $review['author'] ) ? sanitize_text_field( wp_unslash( $review['author'] ) ) : '';
			$email = isset( $review['email'] ) ? sanitize_email( wp_unslash( $review['email'] ) ) : '';
			$content = isset( $review['content'] ) ? sanitize_textarea_field( wp_unslash( $review['content'] ) ) : '';
			$rating_input = isset( $review['rating'] ) ? floatval( $review['rating'] ) : 0;
			$approved = ! empty( $review['approved'] ) ? 1 : 0;
			$gallery_files = $this->extract_review_gallery_files( $index );

			if ( $author === '' && $content === '' && $rating_input <= 0 && empty( $gallery_files ) ) {
				continue;
			}

			if ( $author === '' ) {
				$author = 'Anonymous';
			}

			$commentdata = [
				'comment_post_ID' => $listing_id,
				'comment_author' => $author,
				'comment_author_email' => $email,
				'comment_content' => $content,
				'comment_approved' => $approved,
			];

			$comment_id = wp_insert_comment( $commentdata );
			if ( ! $comment_id ) {
				continue;
			}

			if ( $rating_input > 0 && $reviews_class_available ) {
				$rating_input = $max_rating === 5 ? max( 1, min( 5, $rating_input ) ) : max( 1, min( 10, $rating_input ) );
				$stored_rating = $max_rating === 5 ? ( $rating_input * 2 ) : $rating_input;
				$stored_rating = \MyListing\Ext\Reviews\Reviews::sanitize_rating( $stored_rating );

				if ( $stored_rating ) {
					$ratings = [];
					$ratings_total = 0;
					foreach ( $categories as $category ) {
						if ( empty( $category['id'] ) ) {
							continue;
						}
						$ratings[ $category['id'] ] = $stored_rating;
						$ratings_total += $stored_rating;
					}

					if ( $ratings ) {
						update_comment_meta( $comment_id, '_case27_ratings', $ratings );
						update_comment_meta( $comment_id, '_case27_post_rating', \MyListing\Ext\Reviews\Reviews::sanitize_rating( $ratings_total / count( $ratings ) ) );
					}
				}
			}

			$this->handle_review_gallery_uploads( $listing_id, $comment_id, $gallery_files );

			$inserted++;
		}

		if ( $reviews_class_available ) {
			update_post_meta( $listing_id, '_case27_average_rating', \MyListing\Ext\Reviews\Reviews::get_listing_rating( $listing_id ) );
			do_action( 'mylisting/reviews/updated-average-rating', $listing_id );
		}

		$redirect_url = add_query_arg(
			[
				'page' => 'review9ja-add-reviews',
				'post_type' => 'job_listing',
				'review9ja_status' => 'success',
				'review9ja_message' => rawurlencode( sprintf( 'Added %d review(s).', $inserted ) ),
			],
			admin_url( 'edit.php' )
		);
		wp_safe_redirect( $redirect_url );
		exit;
	}
}

new Review9ja_Admin_Bulk_Reviews();
