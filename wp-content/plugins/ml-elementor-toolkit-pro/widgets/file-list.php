<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Verified badge widget.
 */
class File_List extends Widget_Base {

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
        return 'mlt-file-list';
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
        return __( 'File List', 'ml-elementor-toolkit-pro' );
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
        return 'fas fa-file';
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
        return [ 'files', 'file list', 'mylisting' ];
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
			'content_section',
			[
				'label' => __( 'Content', 'ml-elementor-toolkit-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$control_options = [
			'label' => __( 'File field', 'elementor-pro' ),
			'type' => Controls_Manager::SELECT,
		];

		$listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ( $listing && $listing->type) {
			$control_options['options'] = DynamicTagsModule::get_ml_fields_options( ['file'] );
		} else{
			$control_options['groups'] = DynamicTagsModule::get_ml_fields_groups( ['file'] );
		}

		$this->add_control(
			'key',
			$control_options
		);

		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Show Icon', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ml-elementor-toolkit-pro' ),
				'label_off' => __( 'Hide', 'ml-elementor-toolkit-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_view_button',
			[
				'label' => __( 'Show View Button', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ml-elementor-toolkit-pro' ),
				'label_off' => __( 'Hide', 'ml-elementor-toolkit-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
       
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
		
		if ( ! ( $field = $listing->get_field_object( $settings['key'] ) ) ) {
			return;
		}
		
		// get file list
		$files = array_filter( (array) $field->get_value() );
		if ( empty( $files ) ) {
			return;
		}

		?>
		<div class="files-block">
		<ul class="file-list">
		<?php

		foreach ( $files as $file ) {
		    if ( ! ( $basename = pathinfo( $file, PATHINFO_BASENAME ) ) || ! ( $extension = pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
		        continue;
		    } ?>

			<a href="<?php echo esc_url( $file ) ?>" target="_blank">
				<li class="file">
					<?php if ( $settings['show_icon'] == 'yes' ) : ?>
						<span class="file-icon"><i class="<?php echo esc_attr( \MyListing\Helpers::get_extension_icon( $extension ) ) ?>"></i></span>
					<?php endif; ?>
					<span class="file-name"><?php echo esc_html( $basename ) ?></span>
					<?php if ( $settings['show_view_button'] == 'yes' ) : ?>
						<span class="file-link"><?php _e( 'View', 'my-listing' ) ?><i class="mi open_in_new"></i></span>
					<?php endif; ?>
				</li>
			</a>
		<?php
		}

		?>
		</ul>
		</div>
		<?php


    }
}
