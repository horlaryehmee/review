<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Related_Listing_Image extends Data_Tag {

	public function get_name() {
		return 'mlt-related-listing-image';
	}

	public function get_title() {
		return __( 'Image from related listing', 'elementor-pro' );
	}

	public function get_group() {
		return Module::ML_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY	];
    }
    
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

		$this->add_control(
			'custom_key',
			[
				'label' => __( 'Custom Key', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'placeholder' => 'key',
				'condition' => [
					'key' => '',
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'mylisting-elementor-toolkit' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => self::get_image_sizes(),
			]
		);

        $this->add_control(
			'fallback',
			[
				'label' => __( 'Fallback', 'elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
			]
        );
        
	}

	public static function get_image_sizes(){
		$sizes = [];
		foreach ( \MyListing\get_image_sizes() as $key => $size ){
			$sizes[ $key ] = esc_html( sprintf( '%s (%s x %s)', $key, $size['width'], $size['height'] ?: 'auto' ) );
		}
		return $sizes;
	}

	public function get_value( array $options = [] ) {
		$settings = $this->get_settings_for_display();

        $key = $settings['key'];
        $related_listing_relation = $settings['related_listing_relation'];

		if ( empty( $key ) ) {
			$key = $settings['custom_key'];
		}

		if ( empty( $key ) || !$related_listing_relation ) {
			return [];
        }
        
		$listing = \MyListing\Src\Listing::get( get_the_ID() );
		if (!$listing || !$listing->type) {
            return;
        }
		$related_items = $listing->get_field( $related_listing_relation );
        $related_item = \is_array($related_items) && isset($related_items[0]) ? $related_items[0] : $related_items;

		$url = get_post_meta( $related_item, '_' . $key, true );

        if(empty($url)){
			$image_data = $this->get_settings( 'fallback' );
		} elseif(!is_array($url)){
			$image_id = (int) attachment_url_to_postid($url);
			$image_url = wp_get_attachment_image_src($image_id,  $this->get_settings( 'image_size' ));
			$image_data = [
				'id' => $image_id,
				'url' => $image_url[0],
			];
		} elseif( is_array($url) && isset($url[0]) ){
			$image_id = (int) attachment_url_to_postid($url[0]);
			$image_url = wp_get_attachment_image_src($image_id,  $this->get_settings( 'image_size' ));
			$image_data = [
				'id' => $image_id,
				'url' => $image_url[0],
			];
		}
		else {
			$image_data = $this->get_settings( 'fallback' );
		}
			
		return $image_data;
	}

    public function get_supported_fields() {
		return [
            'file'
        ];
	}
}
