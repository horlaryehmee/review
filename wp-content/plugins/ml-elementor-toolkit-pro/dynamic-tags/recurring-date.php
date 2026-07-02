<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class Recurring_Date extends Tag {

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
        return 'yw-my-listing-recurring-date';
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
        return __( 'Recurring Date', 'elementor-pro' );
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
			'start_end',
			[
				'label' => __( 'Start or end date?', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => array(
                    'start' => 'Start date/time',
                    'end'   => 'End date/time'
                ),
			]
		);

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
        $start_end = $this->get_settings('start_end');

        if ( ! $field_name ) {
            return;
        }

        $listing = \MyListing\Src\Listing::get( get_the_ID() );

        if ($listing && $listing->type) {
            $recurring_date = $listing->get_field($field_name);

            if(!$recurring_date || !\is_array($recurring_date) || !count($recurring_date) > 1){
                return;
            }

            $upcoming_date = \MyListing\Src\Recurring_Dates\get_upcoming_instances( $recurring_date, 1 );
            if (count($upcoming_date) == 1) {
                $timestamp = ! empty( $upcoming_date[0][$start_end] ) ? strtotime( $upcoming_date[0][$start_end] ) : false;
                echo date_i18n( $formatting, $timestamp );
            }
        }
    }

    public function get_supported_fields() {
		return [
            'recurring-date'
        ];
	}
}

