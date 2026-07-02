<?php

namespace MyListing\Ext\Reviews;

// Walker class used to display comments/reviews on listings.
class Walker extends \Walker_Comment {

	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
	var $current_reply_link;

	function __construct() {
		?><ul class="comments-list no-list-style"><?php
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;
		?><div class="r9-review-thread r9-review-thread-depth-<?php echo esc_attr( $depth + 1 ); ?>"><ul class="replies no-list-style r9-review-replies"><?php
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;
		?></ul></div></li><?php
	}

	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
		$other_classes = ' single-comment ';
		$is_reply = false;
		if ($depth > 1) {
			$other_classes .= ' reply ';
			$is_reply = true;
		}
		$user_id = $comment->user_id;
		$is_verified = $user_id ? user_can( $user_id, 'publish_posts' ) : false;
		$author_name = trim( (string) get_comment_author( $comment ) );
		$initial_source = $author_name !== '' ? $author_name : '?';
		$initial = function_exists( 'mb_substr' ) ? mb_substr( $initial_source, 0, 1 ) : substr( $initial_source, 0, 1 );
		$initial = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $initial ) : strtoupper( $initial );
		$rating_enabled = \MyListing\is_rating_enabled( $comment->comment_post_ID );
		$review_rating = ( ! $is_reply && $rating_enabled ) ? \MyListing\Ext\Reviews\Reviews::get_rating( get_comment_ID() ) : false;
		$review_max_rating = $review_rating ? \MyListing\Ext\Reviews\Reviews::max_rating( $comment->comment_post_ID ) : 5;
		$review_rating_display = $review_rating
			? ( $review_max_rating === 10 ? round( (float) $review_rating / 2, 1 ) : round( (float) $review_rating, 1 ) )
			: 0;
		$listing_title = get_the_title( $comment->comment_post_ID );
		$listing_location = $this->get_listing_location( $comment->comment_post_ID );
		$shareable_review_text = $this->get_shareable_review_text( $comment->comment_content );
		?>

		<li <?php comment_class( $parent_class . $other_classes ); ?> id="comment-<?php comment_ID() ?>">
			<div class="comment-container r9-review-card<?php echo $is_reply ? ' r9-review-reply' : ' r9-review-root'; ?>">
				<div class="comment-head r9-review-head">

					<div class="r9-review-author">
						<?php if ($args['avatar_size'] != 0): ?>
							<?php
							$custom_avatar_url = '';
							if ( $user_id ) {
								$custom_avatar_url = (string) get_user_meta( $user_id, '_mylisting_profile_photo_url', true );
								if ( $custom_avatar_url === '' ) {
									$custom_avatar_id = (int) get_user_meta( $user_id, '_mylisting_profile_photo', true );
									if ( $custom_avatar_id ) {
										$custom_avatar_url = (string) wp_get_attachment_image_url( $custom_avatar_id, 'thumbnail' );
									}
								}
							}
							$has_avatar = $custom_avatar_url !== '';
							$avatar_style = sprintf( ' style="--r9-avatar-color:%s;"', esc_attr( $this->get_avatar_color( $initial ) ) );
							$avatar_class = 'c27-user-avatar';
							if ( ! $has_avatar ) {
								$avatar_class .= ' r9-avatar-fallback';
							}
							?>
							<div class="<?php echo esc_attr( $avatar_class ); ?>"<?php echo $avatar_style; ?>>
								<span class="r9-avatar-initial" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
								<?php if ( $has_avatar ): ?>
									<img class="r9-avatar-img" src="<?php echo esc_url( $custom_avatar_url ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" />
								<?php endif; ?>
								<?php if ( $is_verified ): ?>
									<span class="r9-verified-badge" title="<?php echo esc_attr__( 'Verified', 'my-listing' ); ?>"></span>
								<?php endif; ?>
							</div>
						<?php endif ?>
						<div class="r9-review-meta">
						<div class="r9-review-name">
							<h5 class="case27-primary-text"><?php echo get_comment_author_link() ?></h5>
							<?php if ( $is_verified ): ?>
								<span class="r9-verified-label"><?php echo esc_html__( 'Verified', 'my-listing' ); ?></span>
							<?php endif; ?>
						</div>
						<div class="r9-review-meta-line">
							<span class="comment-date"><?php comment_date() ?> <?php edit_comment_link( esc_html__('&middot; Edit', 'my-listing') ); ?></span>
						</div>
						</div>
					</div>
					<?php if ( ! $is_reply && $review_rating && $rating_enabled ): ?>
						<div class="r9-review-rating">
							<?php mylisting_locate_template( 'partials/star-ratings.php', [
								'rating' => $review_rating,
								'max-rating' => $review_max_rating,
								'class' => 'listing-rating listing-review-rating r9-review-stars',
							] ) ?>
						</div>
					<?php endif ?>
				</div>

				<div class="comment-body r9-review-content">
					<?php if( !$comment->comment_approved ) : ?>
						<p><em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'my-listing') ?></em></p>
					<?php else: ?>
						<?php comment_text() ?>
					<?php endif; ?>
					<div class="reply comment-info r9-review-actions">
						<?php
						comment_reply_link( array_merge( $args, array(
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'reply_text' => '<i class="mi chat_bubble_outline"></i>' . __( 'Reply', 'my-listing' ),
							))); ?>
						<?php if ( ! $is_reply && $shareable_review_text !== '' ): ?>
							<button
								type="button"
								class="r9-review-share-trigger"
								data-review-id="<?php echo esc_attr( get_comment_ID() ); ?>"
								data-review-business="<?php echo esc_attr( $listing_title ); ?>"
								data-review-location="<?php echo esc_attr( $listing_location ); ?>"
								data-review-rating="<?php echo esc_attr( number_format( (float) $review_rating_display, 1, '.', '' ) ); ?>"
								data-review-author="<?php echo esc_attr( $author_name ); ?>"
								data-review-author-initial="<?php echo esc_attr( $initial ); ?>"
								data-review-date="<?php echo esc_attr( get_comment_date( '', $comment ) ); ?>"
								data-review-verified="<?php echo esc_attr( $is_verified ? '1' : '0' ); ?>"
								data-review-text="<?php echo esc_attr( $shareable_review_text ); ?>"
							>
								<i class="mi share"></i>
								<span><?php esc_html_e( 'Share review', 'my-listing' ); ?></span>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php if (!$args['has_children']): ?>
			</li>
		<?php endif ?>

	<?php }

	function end_el(&$output, $comment, $depth = 0, $args = array() ) {
		?></li><?php
	}

	private function get_avatar_color( $letter ) {
		$palette = [
			'#e0f2fe',
			'#fef3c7',
			'#ede9fe',
			'#dcfce7',
			'#ffe4e6',
			'#f3e8ff',
			'#e2e8f0',
			'#ffedd5',
			'#dbeafe',
			'#ccfbf1',
			'#fce7f3',
			'#e0e7ff',
		];
		$letter = (string) $letter;
		if ( $letter === '' ) {
			$letter = 'A';
		}
		$code = function_exists( 'mb_ord' ) ? mb_ord( $letter ) : ord( $letter );
		$index = $code % count( $palette );
		return $palette[ $index ];
	}

	private function get_listing_location( $post_id ) {
		$location = (string) get_post_meta( $post_id, 'geolocation_formatted_address', true );

		if ( $location === '' ) {
			$location = (string) get_post_meta( $post_id, '_job_location', true );
		}

		return trim( $location );
	}

	private function get_shareable_review_text( $text ) {
		$text = wp_strip_all_tags( (string) $text, true );
		$text = preg_replace( '/\s+/', ' ', $text );

		return trim( (string) $text );
	}

	function __destruct() {
		?></ul><?php
	}
}
