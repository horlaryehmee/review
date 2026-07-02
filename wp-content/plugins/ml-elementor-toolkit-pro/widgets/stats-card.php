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

class Stats_Card extends Widget_Base {

    public function get_name() {
        return 'mlt-stats-card';
    }

    public function get_title() {
        return __( 'Stats Card', 'ml-elementor-toolkit-pro' );
    }

    public function get_icon() {
        return 'fas fa-ruler';
    }

    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

    public function get_keywords() {
        return [ 'stats card', 'dashboard', 'account', 'mylisting', 'my listing' ];
    }

    /**
     * Add styling dependency
     */
    public function get_style_depends() {
        return [ 'mylisting-dashboard' ];
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
				'label' => __( 'Which statistic (number value) do you want to show?', 'ml-elementor-toolkit-pro' ),
                'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => '',
				'options' => [
                    '' => __( 'Choose', 'elementor-pro' ),
                    'visits.views.lastday' => 'visits.views.lastday',
                    'visits.views.lastweek' => 'visits.views.lastweek',
                    'visits.views.lastmonth' => 'visits.views.lastmonth',
                    'visits.unique_views.lastday' => 'visits.unique_views.lastday',
                    'visits.unique_views.lastweek' => 'visits.unique_views.lastweek',
                    'visits.unique_views.lastmonth' => 'visits.unique_views.lastmonth',
                    'listings.published' => 'listings.published',
                    'listings.pending_approval' => 'listings.pending_approval',
                    'listings.pending_payment' => 'listings.pending_payment',
                    'listings.preview' => 'listings.preview',
                    'listings.expired' => 'listings.expired',
                    'listings.pending' => 'listings.pending',
                    'promotions.count' => 'promotions.count',
				],
			]
        );

        $this->add_control(
			'stats_description',
			[
				'label' => __( 'Description', 'ml-elementor-toolkit-pro' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				// 'default' => __( 'Current statistics', 'ml-elementor-toolkit-pro' ),
				'placeholder' => __( 'Enter a description here', 'ml-elementor-toolkit-pro' ),
			]
        );
        
        $this->add_control(
			'stats_icon',
			[
				'label' => __( 'Stats Icon', 'ml-elementor-toolkit-pro' ),
				'description' => __( 'Find the icon code under theme tools - shortcode. Copy the text in the icon="" part.', 'ml-elementor-toolkit-pro' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
				'default' => 'mi graphic_eq',
				'placeholder' => __( 'Enter a description here', 'ml-elementor-toolkit-pro' ),
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'card_style',
			[
				'label' => __( 'Card', 'ml-elementor-toolkit-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .mlduo-stat-box' => 'background-color: {{VALUE}} !important;',
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

        $data = [
            'icon' =>  $settings['stats_icon'],
            'value' => number_format_i18n( absint( $stats->get( $settings['stats_name'] ) ) ),
            'description' => $settings['stats_description'],
            'background' => $settings['background_color'],
        ];

        $data = c27()->merge_options( [
            'value' => '',
            'description' => '',
            'icon' => 'icon-window',
            'background' => '',
        ], $data ) ?>
        
        <div class="mlduo-stat-box second" style="background: <?php echo esc_attr( $data['background'] ) ?>;">
            <h2><?php echo $data['value'] ?></h2>
            <p><?php echo $data['description'] ?></p>
            <?php echo c27()->get_icon_markup( $data['icon'] ) ?>
        </div>

        <?php
    }
}