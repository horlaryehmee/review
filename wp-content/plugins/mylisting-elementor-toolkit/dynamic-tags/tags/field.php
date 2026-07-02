<?php
namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class Field extends Tag {
    /**
    * Get Name
    */
    public function get_name() {
        return 'yw-my-listing-field';
    }

    /**
    * Get Title
    */
    public function get_title() {
        return __( 'Regular field', 'elementor-pro' );
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

        $this->add_control(
			'word_limit',
			[
				'label' => __( 'Word limit', 'mylisting-elementor-toolkit' ),
                'description' => __( 'Trims text to a certain number of words.' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'step' => 1,
				'default' => '',
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

        if ( $field_name === 'job_title' ) {
            $value = get_the_title();
        }
        else if ( $field_name === 'job_description' ) {
            $value = nl2br(get_the_content());
        }
        else{
            $value = get_post_meta( get_the_ID(), '_'.$field_name, true );
            $value = is_array($value) ? implode(', ', $value) : $value;
            $value =  wp_kses( nl2br( $value ), ['br' => []] );
        }

        if($settings['word_limit'] > 0){
            echo wp_trim_words($value, $settings['word_limit'], '');
        } else{
            echo $value;
        }
    }

    public function get_supported_fields() {
		return [
            'checkbox',
            'email',
            'file',
            'location',
            'multiselect',
            'number',
            'password',
            'radio',
            'select',
            'text',
            'textarea',
            'texteditor',
            'url',
            'wp-editor'
        ];
	}
}

