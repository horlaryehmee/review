<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Work_Hours extends Tag {

    /**
    * Get Name
    *
    * Returns the Name of the tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_name() {
        return 'yw-my-listing-work-hours';
    }

    /**
    * Get Title
    *
    * Returns the title of the Tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_title() {
        return __( 'Work Hours', 'elementor-pro' );
    }
   
    /**
    * Get Group
    *
    * Returns the Group of the tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_group() {
        return 'my-listing';
    }

    /**
    * Get Categories
    *
    * Returns an array of tag categories
    *
    * @since 2.0.0
    * @access public
    *
    * @return array
    */
    public function get_categories() {
        return [ 
			Module::TEXT_CATEGORY,
		];
    }

    /**
    * Register Controls
    *
    * Registers the Dynamic tag controls
    *
    * @since 2.0.0
    * @access protected
    *
    * @return void
    */
    protected function _register_controls() {
        Module::add_key_control( $this );
        
        $this->add_control(
			'display_type',
			[
				'label' => __( 'Display Type', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'todays_schedule'   => __( 'Todays Schedule', 'elementor-pro' ),
                    'open_now'          => __( 'Open Now', 'elementor-pro' ),
                ],
			]
		);
    }

    /**
    * Render
    *
    * Prints out the value of the Dynamic tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return void
    */
    public function render() {
        $field_name = $this->get_settings( 'key' );
        $display_type = $this->get_settings( 'display_type' );

        if ( ! $field_name ) {
            return;
        }

        $listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ($listing && $listing->type) {
            if ($display_type == 'open_now') {
                if ( $listing->schedule->get_status() !== 'not-available' ) {
                    $open_now = $listing->get_schedule()->get_open_now();
                    echo $open_now ? __( 'Open', 'my-listing' ) : __( 'Closed', 'my-listing' );
                }
            } elseif ($display_type == 'todays_schedule') {
                echo $listing->schedule->get_todays_schedule();
            }
        }
    }

    public function get_supported_fields() {
		return [
            'work-hours'
        ];
	}
}

