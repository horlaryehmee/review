<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;

class Reviews_List extends Widget_Base {

    public function get_name() {
        return 'mlt-reviews-list';
    }

    public function get_title() {
        return __( 'Reviews List', 'ml-elementor-toolkit-pro' );
    }

    public function get_icon() {
        return 'fas fa-star';
    }

    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

    public function get_keywords() {
        return [ 'reviews list', 'comments list', 'all reviews', 'mylisting', 'my listing' ];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ml-elementor-toolkit-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $listing = \MyListing\Src\Listing::get( get_the_ID() );

        if ( !$listing || !$listing->type ) {
            return;
        } 

        $GLOBALS['case27_reviews_allow_rating'] = $listing->type->is_rating_enabled();

        require __DIR__ . '/views/reviews-list.php';

    }

    public static function list_comments( $args = array(), $comments = null ) {
        global $wp_query, $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage;
    
        $comment_alt        = 0;
        $comment_thread_alt = 0;
        $comment_depth      = 1;
    
        $defaults = array(
            'walker'            => null,
            'max_depth'         => '',
            'style'             => 'ul',
            'callback'          => null,
            'end-callback'      => null,
            'type'              => 'all',
            'page'              => '',
            'per_page'          => '',
            'avatar_size'       => 32,
            'reverse_top_level' => null,
            'reverse_children'  => '',
            'format'            => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml',
            'short_ping'        => false,
            'echo'              => true,
        );
    
        $parsed_args = wp_parse_args( $args, $defaults );
    
        /**
         * Filters the arguments used in retrieving the comment list.
         *
         * @since 4.0.0
         *
         * @see wp_list_comments()
         *
         * @param array $parsed_args An array of arguments for displaying comments.
         */
        $parsed_args = apply_filters( 'wp_list_comments_args', $parsed_args );
        
        $_comments = get_comments( array(
            'post_id' => get_the_ID()
        ));
    
        if ( '' === $parsed_args['per_page'] && get_option( 'page_comments' ) ) {
            $parsed_args['per_page'] = get_query_var( 'comments_per_page' );
        }
    
        if ( empty( $parsed_args['per_page'] ) ) {
            $parsed_args['per_page'] = 0;
            $parsed_args['page']     = 0;
        }
    
        if ( '' === $parsed_args['max_depth'] ) {
            if ( get_option( 'thread_comments' ) ) {
                $parsed_args['max_depth'] = get_option( 'thread_comments_depth' );
            } else {
                $parsed_args['max_depth'] = -1;
            }
        }
    
        if ( '' === $parsed_args['page'] ) {
            if ( empty( $overridden_cpage ) ) {
                $parsed_args['page'] = get_query_var( 'cpage' );
            } else {
                $threaded            = ( -1 != $parsed_args['max_depth'] );
                $parsed_args['page'] = ( 'newest' == get_option( 'default_comments_page' ) ) ? get_comment_pages_count( $_comments, $parsed_args['per_page'], $threaded ) : 1;
                set_query_var( 'cpage', $parsed_args['page'] );
            }
        }
        // Validation check.
        $parsed_args['page'] = intval( $parsed_args['page'] );
        if ( 0 == $parsed_args['page'] && 0 != $parsed_args['per_page'] ) {
            $parsed_args['page'] = 1;
        }
    
        if ( null === $parsed_args['reverse_top_level'] ) {
            $parsed_args['reverse_top_level'] = ( 'desc' == get_option( 'comment_order' ) );
        }
    
        wp_queue_comments_for_comment_meta_lazyload( $_comments );
    
        if ( empty( $parsed_args['walker'] ) ) {
            $walker = new Walker_Comment;
        } else {
            $walker = $parsed_args['walker'];
        }
    
        $output = $walker->paged_walk( $_comments, $parsed_args['max_depth'], $parsed_args['page'], $parsed_args['per_page'], $parsed_args );

        return $output;
    }
}