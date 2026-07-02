<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


/**
 * Elementor shortcode widget.
 *
 * Elementor widget that insert any shortcodes into the page.
 *
 * @since 1.0.0
 */
class Shortcode extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve shortcode widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mlt-shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve shortcode widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'MyListing Shortcode', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve shortcode widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-shortcode';
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
		return [ 'ml-elementor-toolkit', 'shortcode', 'code' ];
    }
    
    /**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
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
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Register shortcode widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_shortcode',
			[
				'label' => __( 'Shortcode', 'elementor' ),
			]
		);

		$this->add_control(
			'shortcode',
			[
				'label' => __( 'Enter your shortcode', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
                'placeholder' => '[[field]]',
                'description' => __( 'You can use MyListing shortcodes in here, using the double bracket [[field]] syntax! Examples: [[title]] [[tagline]] [[website]] ', 'elementor' ),
				'default' => '[[title]] [[tagline]] [[website]]',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render shortcode widget output on the frontend.
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
        
        $shortcode = $listing->compile_string( $settings['shortcode'] );
        $shortcode = do_shortcode( shortcode_unautop( $shortcode ) );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['link'] );

			$shortcode = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $shortcode );
		}
        
		?>
		<div class="elementor-shortcode"><?php echo $shortcode; ?></div>
		<?php
	}

	/**
	 * Render shortcode widget as plain content.
	 *
	 * Override the default behavior by printing the shortcode instead of rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content() {
		// In plain mode, render without shortcode
		echo $this->get_settings( 'shortcode' );
	}

	/**
	 * Render shortcode widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {}
}
