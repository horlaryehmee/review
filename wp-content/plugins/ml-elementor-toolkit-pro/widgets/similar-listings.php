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

class Similar_Listings extends Widget_Base {

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
        return 'mlt-similar-listings';
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
        return __( 'Similar Listings', 'ml-elementor-toolkit-pro' );
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
        return 'fas fa-layer-group';
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
        return [ 'related listings', 'mylisting', 'my listing' ];
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
			'important_note',
			[
				'label' => __( 'Important Note', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'The number of similar listings and other settings can be changed in the Listing Type Editor.', 'ml-elementor-toolkit-pro' ),
			]
        );
        
        $this->add_control(
			'number_of_columns',
			[
				'label' => __( 'Number of columns', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'4'     => __( '3 columns', 'ml-elementor-toolkit-pro' ),
					'6'     => __( '2 columns', 'ml-elementor-toolkit-pro' ),
					'12'    => __( '1 column', 'ml-elementor-toolkit-pro' ),
				],
			]
        );
        
        $this->add_control(
			'number_of_columns_mobile',
			[
				'label' => __( 'Number of columns (mobile)', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '12',
				'options' => [
					'4'     => __( '3 columns', 'ml-elementor-toolkit-pro' ),
					'6'     => __( '2 columns', 'ml-elementor-toolkit-pro' ),
					'12'    => __( '1 column', 'ml-elementor-toolkit-pro' ),
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

        $listing = \MyListing\Src\Listing::get( get_the_ID() );

        if ( !$listing || !$listing->type ) {
            return;
        } 

        $similar_listings = \MyListing\Src\Queries\Similar_Listings::instance()->run( $listing->get_id() );
        if ( ! ( is_a( $similar_listings, 'WP_Query') && $similar_listings->posts ) ) {
            return;
        }

        $column_number = $settings['number_of_columns'];
        $column_number_mobile = $settings['number_of_columns_mobile'];
        $card_wrapper_classes = "col-lg-$column_number col-md-$column_number col-sm-$column_number_mobile col-xs-$column_number_mobile grid-item";

        ?>
        <div class="grid">
        <?php foreach ( $similar_listings->posts as $similar_listing_id ) {
            printf(
                '<div class="%s">%s</div>',
                apply_filters( 'mylisting/similar-listings/wrapper-class', $card_wrapper_classes ),
                \MyListing\get_preview_card( $similar_listing_id )
            );
        } ?>
        </div>
        <?php
    }
}