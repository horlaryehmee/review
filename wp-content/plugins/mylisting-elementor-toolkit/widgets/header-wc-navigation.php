<?php
namespace ML_Elementor_Toolkit\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;

class Header_WC_Navigation extends Widget_Base {

    public function get_name() {
        return 'mlt-header-wc-navigation';
    }

    public function get_title() {
        return __( 'WooCommerce Menu/Nav', 'mylisting-elementor-toolkit' );
    }

    public function get_icon() {
        return 'fas fa-bars';
    }

    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

    public function get_keywords() {
        return [ 'woocommerce menu', 'wc menu', 'account menu', 'navigation', 'mylisting', 'my listing' ];
    }

    /**
     * Add styling dependency
     */
    public function get_style_depends() {
        return [ 'mylisting-dashboard' ];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'mylisting-elementor-toolkit' ),
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

        ?>
        <div class="woocommerce-account woocommerce-page woocommerce-js woocommerce">
            <div class="mlduo-account-menu">
                    <?php do_action( 'woocommerce_account_navigation' ) ?>
                    <div class="cts-prev">prev</div>
                    <div class="cts-next">next</div>
            </div>
        </div>
        <?php

    }

}