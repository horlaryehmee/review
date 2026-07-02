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

class Review_Form extends Widget_Base {

    public function get_name() {
        return 'mlt-review-form';
    }

    public function get_title() {
        return __( 'Review Form', 'ml-elementor-toolkit-pro' );
    }

    public function get_icon() {
        return 'fas fa-star';
    }

    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

    public function get_keywords() {
        return [ 'review form', 'add review', 'comments', 'mylisting', 'my listing' ];
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
        $commenter = wp_get_current_commenter();

        require __DIR__ . '/views/review-form.php';

    }
}