<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use MyListing\Src\Bookmarks;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Verified badge widget.
 */
class Verified_Badge extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'mlt-verified-badge';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Verified Badge', 'ml-elementor-toolkit-pro' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fas fa-check-circle';
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
        return [ 'verified', 'badge', 'mylisting' ];
    }

    /**
     * Register icon widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
			'section_icon_style',
			[
				'label' => __( 'Icon', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 18,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img.verified-listing' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
       
    }

    /**
     * Render icon widget output on the frontend.
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

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || $listing->is_verified() ){
            ?>
            <span class="verified-badge" data-toggle="tooltip" data-title="<?php echo esc_attr( _x( 'Verified listing', 'Single listing', 'my-listing' ) ) ?>">
                <img class="verified-listing" data-toggle="tooltip" src="<?php echo esc_url( c27()->image('tick.svg') ) ?>">
            </span>
            <?php
        }
    }
}
