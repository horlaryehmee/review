<?php
namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Image extends Data_Tag {

	public function get_name() {
		return 'yw-my-listing-image';
	}

	public function get_title() {
		return __( 'Image', 'elementor-pro' );
	}

	public function get_group() {
		return Module::ML_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY	];
    }
    
    protected function register_controls() {
		Module::add_key_control( $this );

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

		if ( empty( $key ) ) {
			$key = $settings['custom_key'];
		}

		if ( empty( $key ) ) {
			return [];
		}

		$url = get_post_meta( get_the_ID(), '_' . $key, true );
		
		if(empty($url)){
			$image_data = $this->get_settings( 'fallback' );
		} else{
			if ( is_array( $url ) ) {
				$url = array_shift( $url );
			}
			$image_id = (int) attachment_url_to_postid($url);
			$image_url = c27()->get_resized_image( $url, $settings['image_size'] );
			$image_data = [
				'id' => $image_id,
				'url' => $image_url,
			];
		}
			
		return $image_data;
	}

    public function get_supported_fields() {
		return [
            'file'
        ];
	}
}
