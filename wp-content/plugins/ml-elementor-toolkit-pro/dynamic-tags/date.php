<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Date extends Tag {

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
        return 'yw-my-listing-date';
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
        return __( 'Date', 'elementor-pro' );
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
        Module::add_key_control( $this );

        $this->add_control(
			'formatting',
			[
				'label' => __( 'Formatting', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'placeholder' => 'e.g. d-m-Y H:i',
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
        $formatting = $this->get_settings( 'formatting' ) ?: get_option('date_format').' '.get_option('time_format');

        if ( ! $field_name ) {
            return;
        }

        $listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ($listing && $listing->type) {
            $field_value = $listing->get_field( $field_name );
            if($field_value){
                echo date_i18n( $formatting, strtotime($field_value) );
            }
        }
    }


    public function get_supported_fields() {
		return [
            'date'
        ];
	}
}

