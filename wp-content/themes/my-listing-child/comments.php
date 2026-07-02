<?php
/**
 * The template for displaying reviews.
 * Child override to add review summary.
 */

if ( post_password_required() ) {
	return;
}

$comments_wrapper = comments_open() ? 'col-md-7' : 'col-md-12';
$comment_form_wrapper = 'col-md-5';

if ( is_singular('post') ) {
	$comments_wrapper = 'col-md-8 col-md-offset-2';
	$comment_form_wrapper = 'col-md-8 col-md-offset-2';
}

$listing_id = get_the_ID();
$rating_enabled = function_exists( '\\MyListing\\is_rating_enabled' ) && \MyListing\is_rating_enabled( $listing_id );
$rating_counts = [ 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0 ];
$total_ratings = 0;
$avg_display = 0;
$rating_label = '';

if ( $rating_enabled && is_singular( 'job_listing' ) ) {
	$max_rating = \MyListing\Ext\Reviews\Reviews::max_rating( $listing_id );
	$avg_raw = \MyListing\Ext\Reviews\Reviews::get_listing_rating_optimized( $listing_id );
	$avg_raw = is_numeric( $avg_raw ) ? (float) $avg_raw : 0;
	$avg_display = ( $max_rating === 10 ) ? round( $avg_raw / 2, 1 ) : round( $avg_raw, 1 );
	if ( $avg_display > 0 ) {
		if ( $avg_display >= 4.5 ) {
			$rating_label = __( 'Excellent', 'my-listing' );
		} elseif ( $avg_display >= 3.5 ) {
			$rating_label = __( 'Great', 'my-listing' );
		} elseif ( $avg_display >= 2.5 ) {
			$rating_label = __( 'Good', 'my-listing' );
		} elseif ( $avg_display >= 1.5 ) {
			$rating_label = __( 'Fair', 'my-listing' );
		} else {
			$rating_label = __( 'Poor', 'my-listing' );
		}
	}

	$comment_ids = get_comments( [
		'post_id' => $listing_id,
		'status' => 'approve',
		'parent' => 0,
		'fields' => 'ids',
	] );

	foreach ( (array) $comment_ids as $comment_id ) {
		$rating_meta = \MyListing\Ext\Reviews\Reviews::sanitize_rating(
			get_comment_meta( $comment_id, '_case27_post_rating', true )
		);
		if ( ! $rating_meta ) {
			continue;
		}

		$rating_5 = $rating_meta / 2;
		$bucket = (int) round( $rating_5 );
		$bucket = max( 1, min( 5, $bucket ) );
		$rating_counts[ $bucket ]++;
		$total_ratings++;
	}
}
?>

<div class="container">
	<div class="row">
		<div class="<?php echo esc_attr( $comments_wrapper ) ?> comments-list-wrapper" data-current-page="<?php echo esc_attr( get_option( 'default_comments_page' ) === 'newest' ? get_comment_pages_count() : 1 ) ?>" data-page-count="<?php echo esc_attr( get_comment_pages_count() ) ?>">

			<?php if ( $rating_enabled && is_singular( 'job_listing' ) ): ?>
				<div class="r9-review-summary">
					<div class="r9-review-score">
						<div class="r9-review-score-value">
							<?php echo esc_html( number_format( (float) $avg_display, 1, '.', '' ) ); ?>
						</div>
						<div class="r9-review-score-stars">
							<?php
							if ( $avg_display > 0 ) {
								mylisting_locate_template( 'partials/star-ratings.php', [
									'rating' => $avg_display,
									'max-rating' => 5,
									'class' => 'listing-rating r9-review-stars',
								] );
							}
							?>
						</div>
				<?php if ( $rating_label !== '' ): ?>
					<div class="r9-review-score-grade">
						<?php echo esc_html( $rating_label ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $total_ratings > 0 ): ?>
					<div class="r9-review-score-count">
						<?php echo esc_html( sprintf( _n( '%s review', '%s reviews', $total_ratings, 'my-listing' ), number_format_i18n( $total_ratings ) ) ); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="r9-review-breakdown">
				<?php for ( $i = 5; $i >= 1; $i-- ):
					$count = $rating_counts[ $i ] ?? 0;
					$percent = $total_ratings > 0 ? round( ( $count / $total_ratings ) * 100 ) : 0;
					?>
					<div class="r9-review-row r9-review-row-<?php echo esc_attr( $i ); ?>">
						<div class="r9-review-row-percent"><?php echo esc_html( $percent ); ?>%</div>
						<div class="r9-review-row-bar">
							<span style="width: <?php echo esc_attr( $percent ); ?>%"></span>
						</div>
						<div class="r9-review-row-label"><?php echo esc_html( $i ); ?>-star</div>
					</div>
						<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!comments_open()): ?>
				<div class="no-results-wrapper">
					<i class="no-results-icon material-icons mood_bad"></i>
					<li class="no_job_listings_found"><?php _e( 'Comments are closed.', 'my-listing' ) ?></li>
				</div>
			<?php else: ?>
				<?php if (!have_comments()): ?>
					<div class="no-results-wrapper">
						<i class="no-results-icon material-icons mood_bad"></i>
						<li class="no_job_listings_found"><?php _e( 'No comments yet.', 'my-listing' ) ?></li>
					</div>
				<?php else: ?>
					<?php
					wp_list_comments( [
						'walker' => new MyListing\Ext\Reviews\Walker,
						'type' => 'all',
					] );
					?>
				<?php endif ?>
			<?php endif ?>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
				<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'my-listing' ); ?></h2>
					<div class="nav-links">
					<?php if ( is_singular('job_listing') ): ?>
						<div class="nav-next load-more"><a href="#" class="buttons button-5 full-width"><?php echo esc_html__( 'Load more', 'my-listing' ) ?></a></div>
					<?php else: ?>
						<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'my-listing' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'my-listing' ) ); ?></div>
					<?php endif ?>
					</div>
				</nav>
			<?php endif; ?>
		</div>

		<?php if ( comments_open() ): ?>
			<div class="<?php echo esc_attr( $comment_form_wrapper ) ?>">
				<div>
					<?php 
					include(locate_template('partials/review-form.php'))
					?>
				</div>
			</div>
		<?php endif ?>

	</div>
</div>
