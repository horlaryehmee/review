<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if aaccessed directly.
}

/**
 * Verified badge widget.
 */
class Gallery extends Widget_Base {

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
        return 'mlt-gallery';
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
        return __( 'Toolkit > Gallery', 'ml-elementor-toolkit-pro' );
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
        return 'fas fa-image';
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
        return [ 'gallery', 'carousel', 'grid', 'mylisting' ];
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
			'label' => __( 'Gallery field', 'elementor-pro' ),
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
			'gallery_type',
			[
				'label' => __( 'Gallery Type', 'my-listing' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'carousel',
				'options' => [
					'carousel' => __( 'Carousel', 'my-listing' ),
					'carousel-with-preview' => __( 'Carousel with item preview', 'my-listing' ),
					'grid' => __( 'Grid', 'my-listing' ),
				],
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
		
        $field_value = $listing->get_field( $settings['key'] );
        $gallery_type = $settings['gallery_type'];

        // validate all images and format values for use in templates
        $gallery_items = [];
        foreach ( (array) $field_value as $gallery_item ) {
            $image_url = c27()->get_resized_image(
                $gallery_item,
                $gallery_type === 'carousel-with-preview' ? 'large' : 'medium'
            );

            if ( ! $image_url ) {
                continue;
            }

            $full_image_url = c27()->get_resized_image( $gallery_item, 'full' );
            $image_attachment_id = c27()->get_attachment_by_guid( $gallery_item );

            $gallery_items[] = [
                'url' => $image_url,
                'full_size_url' => $full_image_url ?: $image_url,
                'alt' => $image_attachment_id
                    ? get_post_meta( $image_attachment_id, '_wp_attachment_image_alt', true )
                    : '',
            ];
        }

        // if no valid images are found, don't display the block
        if ( empty( $gallery_items ) ) {
            return;
        }

        if ( $gallery_type === 'carousel-with-preview' ) {
            require __DIR__ . '/views/gallery/carousel-with-preview.php';
        } elseif ( $gallery_type === 'grid' ) {
            require __DIR__ . '/views/gallery/grid.php';
        } else {
            require __DIR__ . '/views/gallery/carousel.php';
        }
    }
}
