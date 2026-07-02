<?php
/**
 * Reviews block template with review summary for listing pages.
 */
if ( ! defined('ABSPATH') ) {
    exit;
}

$comments = get_comments( array(
    'post_id' => $listing->get_id(),
    'order' => get_option( 'comment_order' ) === 'DESC' ? 'DESC' : 'ASC',
    'status' => 'approve',
) );

$commenter = wp_get_current_commenter();

if ( ! comments_open() || ( ! $block->get_prop('display_review_form') && empty( $comments ) ) ) {
    return;
}

$rating_enabled = \MyListing\is_rating_enabled( $listing->get_id() );
$rating_counts = [ 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0 ];
$total_ratings = 0;
$avg_display = 0;
$rating_label = '';

if ( $rating_enabled ) {
    $max_rating = \MyListing\Ext\Reviews\Reviews::max_rating( $listing->get_id() );
    $avg_raw = \MyListing\Ext\Reviews\Reviews::get_listing_rating_optimized( $listing->get_id() );
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

    foreach ( $comments as $comment ) {
        $rating_meta = \MyListing\Ext\Reviews\Reviews::sanitize_rating(
            get_comment_meta( $comment->comment_ID, '_case27_post_rating', true )
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

<div class="<?php echo esc_attr( $block->get_wrapper_classes() ) ?>" id="<?php echo esc_attr( $block->get_wrapper_id() ) ?>">
    <div class="element content-block reviews-list">
        <div class="pf-head">
            <div class="title-style-1">
                <i class="<?php echo esc_attr( $block->get_icon() ) ?>"></i>
                <h5><?php echo esc_html( $block->get_title() ) ?></h5>
            </div>
        </div>
        <div class="pf-body">
            <?php if ( $rating_enabled ): ?>
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

            <div class="comments-list-wrapper" data-current-page="<?php echo esc_attr( get_option( 'default_comments_page' ) === 'newest' ? get_comment_pages_count($comments) : 1 ) ?>" data-page-count="<?php echo esc_attr( get_comment_pages_count($comments) ) ?>">
                <?php if ( empty( $comments ) ): ?>
                    <div class="no-results-wrapper">
                        <i class="no-results-icon material-icons mood_bad"></i>
                        <li class="no_job_listings_found"><?php _e( 'No reviews added yet.', 'my-listing' ); ?></li>
                    </div>
                <?php else: ?>
                    <?php
                    wp_list_comments( array(
                        'walker' => new MyListing\Ext\Reviews\Walker,
                        'type' => 'all',
                        'page' => get_option( 'default_comments_page' ) === 'newest' ? get_comment_pages_count($comments) : 1,
                    ), $comments );
                    ?>
                <?php endif; ?>

                <?php
                if ( get_comment_pages_count( $comments ) > 1 && get_option( 'page_comments' ) ):
                    ?>
                <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                    <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'my-listing' ); ?></h2>
                    <div class="nav-links">
                        <div class="nav-next load-more"><a href="#" class="buttons button-5 full-width"><?php echo esc_html__( 'Load more', 'my-listing' ); ?></a></div>
                    </div>
                </nav>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($block->get_prop('display_review_form')): ?>
    <?php include(locate_template('partials/review-form.php')); ?>
    <?php endif ?>
</div>
