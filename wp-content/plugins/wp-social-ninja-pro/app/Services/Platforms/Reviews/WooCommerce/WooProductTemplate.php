<?php

namespace WPSocialReviewsPro\App\Services\Platforms\Reviews\WooCommerce;

use WPSocialReviews\Framework\Support\Arr;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle WooCommerce Single Product Template
 * @since 3.11.0
 */
class WooProductTemplate
{
    private $postMetaName = 'wpsr-settings-woo';

    public function init()
    {
        global $post;
        $post_id = isset($post) && isset($post->ID) ? $post->ID : null;

        $settings = get_post_meta($post_id, $this->postMetaName, true);
        $hide_reviews_count = Arr::get($settings, 'hide_reviews_count');
        $hide_reviews_title = Arr::get($settings, 'hide_reviews_title');

        if($hide_reviews_count === 'yes') {
            add_filter('woocommerce_product_tabs', [$this, 'maybeWooProductTabs']);
        }

        if($hide_reviews_title === 'yes'){
            add_filter('woocommerce_reviews_title', [$this, 'maybeReviewsTitle'], 10, 3);
        }

        add_filter('woocommerce_product_review_list_args', [$this, 'displayReviewsInProductTab']);
    }

    public function maybeReviewsTitle($reviews_title, $count, $product)
    {
        return '';
    }

    public function maybeWooProductTabs($tabs = [])
    {
        // Reviews tab - shows comments.
        if ( comments_open() ) {
            $tabs['reviews'] = array(
                /* translators: %s: reviews count */
                'title'    => __( 'Reviews', 'wp-social-ninja-pro' ),
                'priority' => 30,
                'callback' => 'comments_template',
            );
        }

        return $tabs;
    }

    public function displayReviewsInProductTab($args)
    {
        global $product;
        $product_id = $product->get_ID();
        $settings = get_post_meta($product_id, $this->postMetaName, true);
        $selected_template = Arr::get($settings, 'selected_template');

        if($selected_template ){
            echo do_shortcode('[wp_social_ninja id="'.$selected_template.'" platform="reviews"]');
            $args['callback'] = 'woocommerce_comments';
        }

        return $args;
    }
}