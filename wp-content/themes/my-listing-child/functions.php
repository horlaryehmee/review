<?php

// Enqueue child theme style.css
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'child-style', get_stylesheet_uri() );

    if ( is_rtl() ) {
    	wp_enqueue_style( 'mylisting-rtl', get_template_directory_uri() . '/rtl.css', [], wp_get_theme()->get('Version') );
    }
}, 500 );

// Happy Coding :)

function r9_get_child_asset_version( $relative_path ) {
    $path = trailingslashit( get_stylesheet_directory() ) . ltrim( $relative_path, '/\\' );

    if ( file_exists( $path ) ) {
        return (string) filemtime( $path );
    }

    return wp_get_theme()->get( 'Version' );
}

function r9_get_review_share_logo_url() {
    if ( function_exists( 'c27' ) ) {
        $theme_logo = c27()->get_setting( 'general_site_logo' );

        if ( is_array( $theme_logo ) ) {
            if ( ! empty( $theme_logo['ID'] ) ) {
                $logo_url = (string) wp_get_attachment_image_url( (int) $theme_logo['ID'], 'full' );
                if ( $logo_url !== '' ) {
                    return $logo_url;
                }
            }

            if ( ! empty( $theme_logo['sizes']['large'] ) ) {
                return (string) $theme_logo['sizes']['large'];
            }

            if ( ! empty( $theme_logo['url'] ) ) {
                return (string) $theme_logo['url'];
            }
        }
    }

    $custom_logo_id = (int) get_theme_mod( 'custom_logo' );

    if ( $custom_logo_id ) {
        $logo_url = (string) wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $logo_url !== '' ) {
            return $logo_url;
        }
    }

    $site_icon_url = (string) get_site_icon_url( 192 );
    if ( $site_icon_url !== '' ) {
        return $site_icon_url;
    }

    return '';
}

function r9_prevent_primary_menu_page_fallback( $args ) {
    if ( empty( $args['theme_location'] ) || $args['theme_location'] !== 'primary' ) {
        return $args;
    }

    $args['fallback_cb'] = false;

    if ( ! has_nav_menu( 'primary' ) ) {
        $main_menu = wp_get_nav_menu_object( 'main-menu' );

        if ( $main_menu ) {
            $args['menu'] = $main_menu->term_id;
        }
    }

    return $args;
}
add_filter( 'wp_nav_menu_args', 'r9_prevent_primary_menu_page_fallback' );

function r9_enqueue_review_share_assets() {
    if ( ! is_singular( 'job_listing' ) ) {
        return;
    }

    $style_handle = 'r9-review-share';
    $script_handle = 'r9-review-share';

    wp_enqueue_style(
        $style_handle,
        trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/review-share.css',
        [ 'child-style' ],
        r9_get_child_asset_version( 'assets/css/review-share.css' )
    );

    wp_add_inline_style( $style_handle, implode( "\n", [
        '.r9-review-actions .comment-reply-link, button.r9-review-share-trigger{display:inline-flex!important;align-items:center!important;justify-content:flex-start!important;gap:6px!important;min-height:34px!important;padding:0 12px!important;border-radius:999px!important;border:1px solid rgba(0,0,0,.08)!important;background:rgba(0,0,0,.03)!important;color:#242429!important;font-size:12px!important;font-weight:600!important;line-height:1!important;white-space:nowrap!important;width:auto!important;flex:0 0 auto!important;box-shadow:none!important;transform:none!important;text-decoration:none!important;}',
        '.r9-review-actions .comment-reply-link:hover,.r9-review-actions .comment-reply-link:focus,button.r9-review-share-trigger:hover,button.r9-review-share-trigger:focus{background:rgba(0,0,0,.06)!important;border-color:rgba(0,0,0,.14)!important;color:#242429!important;box-shadow:none!important;transform:none!important;}',
        'button.r9-review-share-trigger span{display:inline-block!important;visibility:visible!important;opacity:1!important;color:inherit!important;font-size:12px!important;line-height:1.1!important;}',
        '.r9-review-actions .comment-reply-link i,button.r9-review-share-trigger i{font-size:15px!important;margin:0!important;float:none!important;top:0!important;color:inherit!important;flex:0 0 auto!important;}',
        '@media (max-width:640px){.r9-review-actions .comment-reply-link,button.r9-review-share-trigger{min-height:32px!important;padding:0 10px!important;font-size:11px!important;}button.r9-review-share-trigger span{font-size:11px!important;}.r9-review-actions .comment-reply-link i,button.r9-review-share-trigger i{font-size:14px!important;}}',
    ] ) );

    wp_enqueue_script(
        $script_handle,
        trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/review-share.js',
        [],
        r9_get_child_asset_version( 'assets/js/review-share.js' ),
        true
    );

    wp_localize_script( $script_handle, 'review9jaReviewShare', [
        'siteName' => wp_strip_all_tags( html_entity_decode( get_bloginfo( 'name' ), ENT_QUOTES, get_bloginfo( 'charset' ) ) ),
        'logoUrl' => r9_get_review_share_logo_url(),
        'downloadFilenamePrefix' => sanitize_title( get_bloginfo( 'name' ) ) ?: 'review9ja',
        'labels' => [
            'dialogTitle' => __( 'Social Media Preview', 'my-listing' ),
            'dialogDescription' => __( 'Choose a format and download a shareable PNG.', 'my-listing' ),
            'download' => __( 'Download High-Res PNG', 'my-listing' ),
            'formatLabel' => __( 'Formats', 'my-listing' ),
            'formatPortrait' => __( '4:5 Portrait', 'my-listing' ),
            'formatSquare' => __( '1:1 Square', 'my-listing' ),
            'formatStory' => __( '9:16 Story', 'my-listing' ),
            'formatLandscape' => __( '16:9 Landscape', 'my-listing' ),
            'presetLabel' => __( 'Presets', 'my-listing' ),
            'close' => __( 'Close preview', 'my-listing' ),
            'verified' => __( 'Verified Reviewer', 'my-listing' ),
            'customerReview' => __( 'Customer Review', 'my-listing' ),
            'topRated' => __( 'Top Rated Business', 'my-listing' ),
            'fallbackLocation' => __( 'Nigeria', 'my-listing' ),
        ],
    ] );
}
add_action( 'wp_enqueue_scripts', 'r9_enqueue_review_share_assets', 520 );

function r9_render_review_share_modal() {
    if ( ! is_singular( 'job_listing' ) ) {
        return;
    }
    ?>
    <div class="r9-review-share-modal" id="r9-review-share-modal" hidden aria-hidden="true">
        <div class="r9-review-share-backdrop" data-review-share-close></div>
        <div class="r9-review-share-dialog" role="dialog" aria-modal="true" aria-labelledby="r9-review-share-title">
            <button type="button" class="r9-review-share-close" data-review-share-close aria-label="<?php echo esc_attr__( 'Close preview', 'my-listing' ); ?>">
                <i class="mi close" aria-hidden="true"></i>
            </button>

            <div class="r9-review-share-heading">
                <h3 id="r9-review-share-title"><?php esc_html_e( 'Social Media Preview', 'my-listing' ); ?></h3>
                <p id="r9-review-share-description"><?php esc_html_e( 'Choose a format and download a shareable PNG.', 'my-listing' ); ?></p>
            </div>

            <div class="r9-review-share-preview-shell">
                <canvas
                    class="r9-review-share-canvas"
                    id="r9-review-share-canvas"
                    width="1080"
                    height="1350"
                ></canvas>
            </div>

            <div class="r9-review-share-formats">
                <span class="r9-review-share-formats-label"><?php esc_html_e( 'Formats', 'my-listing' ); ?></span>
                <div class="r9-review-share-format-list" id="r9-review-share-format-list"></div>
            </div>

            <div class="r9-review-share-actions">
                <button type="button" class="buttons button-2 r9-review-share-download">
                    <i class="mi file_download" aria-hidden="true"></i>
                    <?php esc_html_e( 'Download High-Res PNG', 'my-listing' ); ?>
                </button>
            </div>

            <div class="r9-review-share-presets">
                <span class="r9-review-share-presets-label"><?php esc_html_e( 'Presets', 'my-listing' ); ?></span>
                <div class="r9-review-share-preset-list" id="r9-review-share-preset-list"></div>
            </div>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'r9_render_review_share_modal' );






function sync_comments_to_product_reviews( $comment_ID, $comment_approved ) {
    $comment = get_comment( $comment_ID );

    // Check if the comment is approved
    if ( $comment_approved === '1' ) {
        // Get the comment details
        $comment_author = $comment->comment_author;
        $comment_author_email = $comment->comment_author_email;
        $comment_content = $comment->comment_content;

        // Get the comment parent details if it exists
        $parent_comment = get_comment( $comment->comment_parent );
        if ( $parent_comment ) {
            $parent_author = $parent_comment->comment_author;
            $parent_content = $parent_comment->comment_content;
        }

        // Create WooCommerce review data
        $review_data = array(
            'comment_post_ID' => $comment->comment_post_ID,
            'comment_author' => $comment_author,
            'comment_author_email' => $comment_author_email,
            'comment_content' => $comment_content,
            'comment_type' => 'review',
            'comment_approved' => 1,
        );

        // Insert the WooCommerce review
        $review_id = wp_insert_comment( $review_data );

        // If a parent comment exists, add it as a response to the review
        if ( $review_id && isset( $parent_author ) && isset( $parent_content ) ) {
            $response_data = array(
                'comment_post_ID' => $comment->comment_post_ID,
                'comment_author' => $parent_author,
                'comment_content' => $parent_content,
                'comment_parent' => $review_id,
                'comment_type' => 'review',
                'comment_approved' => 1,
            );

            wp_insert_comment( $response_data );
        }
    }
}
add_action( 'comment_post', 'sync_comments_to_product_reviews', 10, 2 );





function display_rating_statistics() {
    global $wpdb;

    $query = "
        SELECT meta_value, COUNT(meta_value) AS rating_count
        FROM {$wpdb->comments} c
        JOIN {$wpdb->commentmeta} cm ON c.comment_ID = cm.comment_id
        WHERE cm.meta_key = 'rating'
        GROUP BY meta_value
        ORDER BY meta_value DESC
    ";

    $results = $wpdb->get_results($query);

    if ($results) {
        echo '<ul class="rating-bar">';

        for ($i = 5; $i >= 0; $i--) {
            $rating_found = false;
            $rating_count = 0;

            foreach ($results as $result) {
                if ($result->meta_value == $i) {
                    $rating_count = $result->rating_count;
                    $rating_found = true;
                    break;
                }
            }

            echo '<li>';
            echo '<span class="rating-label">' . $i . ' Stars</span>';
            echo '<div class="rating-bar-container">';
            echo '<div class="rating-bar-fill" style="width: ' . ($rating_count * 20) . '%;"></div>';
            echo '</div>';
            echo '</li>';

            if (!$rating_found) {
                echo '<li>';
                echo '<span class="rating-label">' . $i . ' Stars</span>';
                echo '<div class="rating-bar-container">';
                echo '<div class="rating-bar-fill" style="width: 0%;"></div>';
                echo '</div>';
                echo '</li>';
            }
        }

        echo '</ul>';
    } else {
        echo 'No ratings found.';
    }
}












function horizontal_reviews_slider_shortcode_safe() {
    $comments = get_comments([
        'number' => 12,
        'status' => 'approve',
    ]);

    ob_start(); ?>

    <style>
        .hrs-wrapper {
            position: relative;
            overflow: hidden;
           
            padding: 40px 0;
        }

        .hrs-track {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    gap: 20px;
    padding: 0 10px;
    scrollbar-width: none;          /* Firefox */
    -ms-overflow-style: none;       /* IE/Edge */
}

.hrs-track::-webkit-scrollbar {
    display: none;                  /* Chrome, Safari */
}

        .hrs-card {
            flex: 0 0 300px;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            box-sizing: border-box;
        }

        .hrs-stars {
            color: #facc15;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .hrs-content {
            color: #374151;
            font-size: 14px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3em;
        }

        .hrs-author {
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
            color: #111827;
        }

        .hrs-post {
            font-size: 12px;
            color: #6b7280;
        }

        .hrs-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            z-index: 10;
            border-radius: 50%;
        }

        .hrs-prev { left: 10px; }
        .hrs-next { right: 10px; }

        @media (max-width: 768px) {
            .hrs-card { flex: 0 0 90%; }
            .hrs-btn { padding: 8px; }
        }
        .hrs-post-link {
    display: inline-block;
    max-width: 100%;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    color: #2563eb;
    text-decoration: none;
}

.hrs-post-link:hover {
    text-decoration: underline;
}

.hrs-post-link {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 13px;
    color: #2563eb;
    text-decoration: none;
    line-height: 1.4;
    max-height: 2.8em; /* approx 2 lines */
}

.hrs-post-link:hover {
    text-decoration: underline;
}

.hrs-arrow-controls {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.hrs-btn-inline {
    background: #1f2937;
    color: #fff;
    border: none;
    padding: 12px 16px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.2s;
}

.hrs-btn-inline:hover {
    background: #111827;
}


    </style>

    <div class="hrs-wrapper">

        <div class="hrs-track" id="hrsSliderTrack">
            <?php foreach ($comments as $comment):
                $raw = get_comment_meta($comment->comment_ID, '_case27_ratings', true);
                $rating_data = maybe_unserialize($raw);
                if (!is_array($rating_data) || empty($rating_data['rating'])) continue;

                $raw_rating = intval($rating_data['rating']);
                $rating = min(5, ceil($raw_rating / 2)); // Convert 10 → 5 star scale
            ?>
            
            
                <div class="hrs-card">
                    <div class="hrs-stars">
                        <?php for ($i = 1; $i <= 5; $i++) echo $i <= $rating ? '★' : '☆'; ?>
                    </div>
                    <div class="hrs-content"><?php echo esc_html(wp_trim_words($comment->comment_content, 20)); ?></div>
                    <div class="hrs-author">— <?php echo esc_html($comment->comment_author); ?></div>
                    
                    <?php
$post_title = get_the_title($comment->comment_post_ID);
$trimmed_title = mb_strimwidth($post_title, 0, 30, '...');
?>
<div class="hrs-post">
    <a href="<?php echo esc_url(get_permalink($comment->comment_post_ID)); ?>" target="_blank" class="hrs-post-link">
        <?php echo esc_html($trimmed_title); ?>
    </a>
</div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="hrs-arrow-controls">
    <button class="hrs-btn-inline" onclick="hrsScrollSlider('left')">&#10094;</button>
    <button class="hrs-btn-inline" onclick="hrsScrollSlider('right')">&#10095;</button>
</div>
        
    </div>

   <script>
    function hrsScrollSlider(direction) {
        const track = document.getElementById("hrsSliderTrack");
        const cards = track.querySelectorAll(".hrs-card");
        const card = cards[0];
        const cardWidth = card.offsetWidth + 20;

        const maxScroll = track.scrollWidth - track.clientWidth;
        const currentScroll = track.scrollLeft;

        let targetScroll;

        if (direction === "left") {
            targetScroll = currentScroll - cardWidth;
            // Loop to end if at beginning
            if (currentScroll <= 0) {
                targetScroll = maxScroll;
            }
        } else {
            targetScroll = currentScroll + cardWidth;
            // Loop to start if at end
            if (currentScroll >= maxScroll - cardWidth) {
                targetScroll = 0;
            }
        }

        track.scrollTo({
            left: targetScroll,
            behavior: "smooth"
        });
    }
</script>


    <?php return ob_get_clean();
}
add_shortcode('horizontal_reviews', 'horizontal_reviews_slider_shortcode_safe');
