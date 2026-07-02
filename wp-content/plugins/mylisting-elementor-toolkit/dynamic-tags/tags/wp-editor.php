<?php
namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class WP_Editor extends Tag {
    /**
    * Get Name
    */
    public function get_name() {
        return 'yw-my-listing-wp-editor';
    }

    /**
    * Get Title
    */
    public function get_title() {
        return __( 'WP Editor field', 'elementor-pro' );
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
			Module::URL_CATEGORY,
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

        if ( $field_name === 'job_title' ) {
            $value = get_the_title();
        }
        else if ( $field_name === 'job_description' ) {
            $value = nl2br(get_the_content());
        }
        else{
            $value = get_post_meta( get_the_ID(), '_'.$field_name, true );
            $value = is_array($value) ? implode(', ', $value) : $value;
            $value = wpautop( $value );
        }

        echo $value;
    }

    public function get_supported_fields() {
		return [
            'text',
            'textarea',
            'texteditor',
            'wp-editor'
        ];
	}
}

