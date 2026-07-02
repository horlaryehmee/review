<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class Related_Listing_Field extends Tag {

    /**
    * Get Name
    */
    public function get_name() {
        return 'mlt-related-listing-field';
    }

    /**
    * Get Title
    */
    public function get_title() {
        return __( 'Field from related listing', 'ml-elementor-toolkit-pro' );
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
	protected function _register_controls() {
        $related_listing_control = [
			'label'     => __( 'Related Listing relation', 'ml-elementor-toolkit-pro' ),
            'type'      => Controls_Manager::SELECT,
            'groups'    =>  Module::get_ml_fields_groups( ['related-listing'] )
		];

		$this->add_control(
			'related_listing_relation',
			$related_listing_control
		);

        $key_control = [
			'label'     => __( 'Key', 'ml-elementor-toolkit-pro' ),
            'type'      => Controls_Manager::SELECT,
            'groups'    =>  Module::get_ml_fields_groups( $this->get_supported_fields() )
		];

		$this->add_control(
			'key',
			$key_control
		);
	}

    /**
    * Render
    *
    * Prints out the value of the Dynamic tag
    */
    public function render() {
		$settings = $this->get_settings_for_display();

        $field_name = $settings[ 'key' ];
        $related_listing_relation = $settings['related_listing_relation'];

        if ( ! $field_name || !$related_listing_relation ) {
            return;
        }

        $listing = \MyListing\Src\Listing::get( get_the_ID() );
        if (!$listing || !$listing->type) {
            return;
        }
        $related_items = $listing->get_field( $related_listing_relation );
        $related_item = \is_array($related_items) && isset($related_items[0]) ? $related_items[0] : $related_items;

        $host = \MyListing\Src\Listing::get( $related_item );
        if(!$host) return;
        $field = $host->get_field_object( $field_name );

        if(!$field) return;

        echo $field->get_value();
    }

    public function get_supported_fields() {
		return [
            'checkbox',
            'email',
            // 'file',
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

