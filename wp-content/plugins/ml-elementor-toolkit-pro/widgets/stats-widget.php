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

class Stats_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'mlt-stats-widget';
    }

    public function get_title() {
        return __( 'Stats Widget', 'ml-elementor-toolkit-pro' );
    }

    public function get_icon() {
        return 'fas fa-chart-bar';
    }

    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

    public function get_keywords() {
        return [ 'stats', 'dashboard', 'account', 'mylisting', 'my listing' ];
    }

    /**
     * Add styling dependency
     */
    public function get_style_depends() {
        return [ 'mylisting-dashboard', 'chartist' ];
    }

    /**
     * Add script dependency
     */
    public function get_script_depends() {
        return [ 'mylisting-dashboard', 'chartist' ];
    }

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        // Include charting library.
        wp_register_script( 'chartist', c27()->template_uri( 'assets/vendor/chartist/chartist.js' ), [], \MyListing\get_assets_version(), true );
        wp_register_style( 'chartist', c27()->template_uri( 'assets/vendor/chartist/chartist.css' ), [], \MyListing\get_assets_version() );
 
     }

    /**
     * Register icon list widget controls.
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
        
        $this->add_control(
			'stats_name',
			[
				'label' => __( 'Which statistic do you want to show?', 'ml-elementor-toolkit-pro' ),
                'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => '',
				'options' => [
                    '' => __( 'Choose', 'elementor-pro' ),
                    'browsers' => __('Browsers', 'ml-elementor-toolkit-pro' ),
                    'countries' => __('Countries', 'ml-elementor-toolkit-pro' ),
                    'devices' => __('Devices', 'ml-elementor-toolkit-pro' ),
                    'platforms' => __('Platforms', 'ml-elementor-toolkit-pro' ),
                    'referrers' => __('Referrers', 'ml-elementor-toolkit-pro' ),
                    'unique-views' => __('Unique Views', 'ml-elementor-toolkit-pro' ),
                    'views' => __('Views', 'ml-elementor-toolkit-pro' ),
                    'visits-chart' => __('Visits Charts', 'ml-elementor-toolkit-pro' ),
				],
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

        if ( !is_user_logged_in() ) {
            return;
        } 

        if ( ! empty( $_GET['listing'] ) && ( $listing = \MyListing\Src\Listing::get( $_GET['listing'] ) ) && $listing->editable_by_current_user() ) {
            $stats = mylisting()->stats()->get_listing_stats( $listing->get_id() );
        } else{
            $stats = mylisting()->stats()->get_user_stats( get_current_user_id() );
        }

        if ($settings['stats_name'] && $file = locate_template( sprintf('templates/dashboard/stats/widgets/%s.php', $settings['stats_name']) )) {
            require $file;
        }
    }
}