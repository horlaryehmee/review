<div class="<?php // echo esc_attr( $comments_wrapper ) ?>">
   
    <?php if (!comments_open()): ?>
        <div class="no-results-wrapper">
            <i class="no-results-icon material-icons">mood_bad</i>
            <li class="no_job_listings_found"><?php _e( 'Comments are closed.', 'my-listing' ) ?></li>
        </div>
    <?php else: ?>
        <?php if (!get_comments_number()): ?>
            <div class="no-results-wrapper">
                <i class="no-results-icon material-icons">mood_bad</i>
                <li class="no_job_listings_found"><?php _e( 'No comments yet.', 'my-listing' ) ?></li>
            </div>
        <?php else: ?>
            <?php
            echo self::list_comments( [
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
                <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'my-listing' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'my-listing' ) ); ?></div>
            </div>
        </nav>
    <?php endif; ?>
</div>