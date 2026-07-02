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

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class Location extends Widget_Base {

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
		return 'location';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Location', 'ml-elementor-toolkit-pro' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-map-pin';
	}

     /**
     * Get widget categories.
     *
     * Retrieve the list of categories the icon widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'location', 'map', 'mylisting', 'my listing' ];
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

		$control_options = [
			'label' => __( 'Location field', 'elementor-pro' ),
			'type' => Controls_Manager::SELECT,
		];

		$listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ( $listing && $listing->type) {
			$control_options['options'] = DynamicTagsModule::get_ml_fields_options( ['location'] );
		} else{
			$control_options['groups'] = DynamicTagsModule::get_ml_fields_groups( ['location'] );
		}

		$this->add_control(
			'key',
			$control_options
		);

		$this->add_control(
			'zoom',
			[
				'label' => __( 'Zoom', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 11,
			]
		);

		$this->add_control(
			'map_skin',
			[
				'label' => __( 'Map skin', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => \MyListing\Apis\Maps\get_skins(),
				'default' => 'skin12'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Map', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Map height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
					'unit'	=> 'px'
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .c27-map' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .c27-map' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
            echo "<div style='color:red;'>This widget is not working in Elementor editor/preview, please check the live page.</div>";
            return;
        } 

		$listing = \MyListing\Src\Listing::get( get_the_ID() );

		if ( !$listing || !$listing->type ) {
			return;
		}

        require __DIR__ . '/views/location.php';
	}
}
