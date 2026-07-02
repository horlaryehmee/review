<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Gallery extends Data_Tag {


	public function get_name() {
		return 'yw-my-listing-gallery';
	}

	public function get_title() {
		return __( 'Gallery', 'elementor-pro' );
	}

	public function get_group() {
		return Module::ML_GROUP;
	}

	public function get_categories() {
		return [ Module::GALLERY_CATEGORY ];
    }
    
    protected function _register_controls() {
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
			'fallback',
			[
				'label' => __( 'Fallback', 'elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
			]
        );
	}

	public function get_value( array $options = [] ) {
        $key = $this->get_settings( 'key' );

		if ( empty( $key ) ) {
			$key = $this->get_settings( 'custom_key' );
		}

		if ( empty( $key ) ) {
			return;
		}

		$urls = get_post_meta( get_the_ID(), '_' . $key, true );

		if ( $urls && $urls[0] ) {
			foreach($urls as $url){
				$image_data[] = [
					'id' => (int) attachment_url_to_postid($url),
					'url' => $url,
				];
			}
		}
		else {
			$image_data = [ $this->get_settings( 'fallback' ) ];
		}

		return $image_data;
	}

	public function get_supported_fields() {
		return [
            'file'
        ];
	}
}
