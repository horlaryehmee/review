<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class GeoLocation extends Tag {

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
        return 'mlt-geolocation';
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
        return __( 'Location', 'ml-elementor-toolkit-pro' );
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
		return Module::ML_GROUP;
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
        $this->add_control(
			'key',
			[
				'label' => __( 'Key', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'full'  	=> __( 'Full address', 'ml-elementor-toolkit-pro' ),
					'short'  	=> __( 'Short address', 'ml-elementor-toolkit-pro' ),
					'lat'  	=> __( 'Latitude', 'ml-elementor-toolkit-pro' ),
					'lng' 	=> __( 'Longitude', 'ml-elementor-toolkit-pro' ),
					'part_0' 	=> __( 'Street / Address part 1', 'ml-elementor-toolkit-pro' ),
					'part_1' 	=> __( 'Address part 2', 'ml-elementor-toolkit-pro' ),
					'part_2' 	=> __( 'Address part 3', 'ml-elementor-toolkit-pro' ),
					'part_3' 	=> __( 'Address part 4', 'ml-elementor-toolkit-pro' ),
					'country' 	=> __( 'Country', 'ml-elementor-toolkit-pro' ),
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
        $listing = \MyListing\Src\Listing::get( get_the_ID() );

        if (!$listing || !$listing->type) {
            return;
        }

        $key = $this->get_settings('key');

        if ( $key == 'lat' || $key == 'geolocation_lat' ) {
			echo $listing->get_special_key(':lat');
            return;
		}
		if ( $key == 'lng' || $key == 'geolocation_long'  ) {
			echo $listing->get_special_key(':lng');
            return;
		}

        $address = $listing->get_field( 'job_location' );

        if ( $key == 'full' ) {
            echo $address;
            return;
		}

        $parts = explode(',', $address);

        if ( $key == 'short' ) {
            echo trim( $parts[0] );
            return;
		}
        if ( $key == 'country' ) {
            echo trim( end($parts) );
            return;
		}
        $split = explode('_', $key);
        if($split[0] == 'part' && isset($split[1])){
            echo trim( $parts[$split[1]] );
            return;
        }

    }

}

