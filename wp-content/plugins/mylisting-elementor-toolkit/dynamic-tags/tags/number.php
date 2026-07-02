<?php
namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class Number extends Tag {
    /**
    * Get Name
    */
    public function get_name() {
        return 'yw-my-listing-number';
    }

    /**
    * Get Title
    */
    public function get_title() {
        return __( 'Number field', 'mylisting-elementor-toolkit' );
    }
   
    /**
    * Get Group
    *
    * Returns the Group of the tag
    */
    public function get_group() {
		return Module::ML_GROUP;
    }

    /**
    * Get Categories
    *
    * Returns an array of tag categories
    */
    public function get_categories() {
        return [ 
			Module::TEXT_CATEGORY,
			Module::POST_META_CATEGORY,
		];
    }

    /**
    * Register Controls
    *
    * Registers the Dynamic tag controls
    */
	protected function register_controls() {
        Module::add_key_control( $this );
        
        $this->add_control(
			'decimals',
			[
				'label' => __( 'Decimals', 'mylisting-elementor-toolkit' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 2,
			]
        );
        
        $this->add_control(
			'dec_point',
			[
				'label' => __( 'Decimal separator', 'mylisting-elementor-toolkit' ),
				'type' => Controls_Manager::TEXT,
				'default' => '.',
			]
        );

        $this->add_control(
			'thousands_sep',
			[
				'label' => __( 'Thousands separator', 'mylisting-elementor-toolkit' ),
				'type' => Controls_Manager::TEXT,
				'default' => ',',
			]
        );
	}

    /**
    * Render
    *
    * Prints out the value of the Dynamic tag
    */
    public function render() {
        $settings = $this->get_settings_for_display();

        $field_name = $settings['key'];

        if ( ! $field_name ) {
            return;
        }

        $value = get_post_meta( get_the_ID(), '_'.$field_name, true );
        if($value == "") {
            return;
        }

        echo number_format((float) $value, $settings['decimals'], $settings['dec_point'], $settings['thousands_sep']);
    }

    public function get_supported_fields() {
		return [
            'number',
            'text',
        ];
	}
}

