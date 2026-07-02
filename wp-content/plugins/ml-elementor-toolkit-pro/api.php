<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use ElementorPro\Modules\ThemeBuilder\Module;

/**
 * Custom theme location function to allow template multiple times on same page.
 * @param location Slug of location (string)
 * @param postid Specific post id of post to be used in dynamic tags.
 */
function yellowwave_elementor_theme_location($location, $postid) {
    global $wp_query, $post, $yw_render_preview_cards; 

    if ( ! function_exists( 'elementor_theme_do_location' ) ) {
        return false;
    }

    $old_query = $wp_query;
    $wp_query = new WP_Query( array(
         'p' => $postid,
         'post_type' => 'job_listing'
    ) );
    
    $old_post = $post;
    $post = get_post( $postid, OBJECT );
    setup_postdata( $post );

    $wp_query->queried_object = $post;

    $documents_by_conditions = yw_get_documents_for_location( $location );
    // $documents_by_conditions = Module::instance()->get_conditions_manager()->get_documents_for_location( $location );

    foreach ( $documents_by_conditions as $document_id => $document ) {
        $yw_render_preview_cards = $document_id;

        $classes = array(
            'yw-post-' . $postid
        );

        if($location == 'mylisting-quick-view'){
            $classes[] = 'listing-preview';
        }

        $is_link = mlt_get_option('mlt_checkbox_add_link_to_card') && $location == 'mylisting-preview-card';

        if($is_link){
            echo '<a href="'. get_permalink($postid) .'" class="' . implode(" ", $classes) . '">';
        } else{
            echo '<div class="' . implode(" ", $classes) . '">';

        }
        echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $document_id, true );
        echo $is_link ? '</a>': '</div>';
    }

    $post = $old_post;
    setup_postdata( $old_post );
    $wp_query = $old_query;

    return count($documents_by_conditions) > 0;
}

function yw_get_documents_for_location( $location ) {

    /** @var Module $theme_builder_module */
    $theme_builder_module = Module::instance();

    $theme_templates_ids = $theme_builder_module->get_conditions_manager()->get_theme_templates_ids( $location );

    $location_settings = $theme_builder_module->get_locations_manager()->get_location( $location );

    $documents = [];

    foreach ( $theme_templates_ids as $theme_template_id => $priority ) {
        $document = $theme_builder_module->get_document( $theme_template_id );
        if ( $document ) {
            $documents[ $theme_template_id ] = $document;
        }

        if ( empty( $location_settings['multiple'] ) ) {
            break;
        }
    }

    return $documents;
}