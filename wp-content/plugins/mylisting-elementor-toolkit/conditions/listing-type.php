<?php
namespace ML_Elementor_Toolkit\Conditions;

use ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Listing_Type extends Condition_Base {

    private $listing_type;

	public static function get_type() {
		return 'singular';
	}

	public static function get_priority() {
		return 40;
	}

	public function get_name() {
		return 'listing_type_';
	}

	public function get_label() {
        return 'By Listing Type';
        // return $this->listing_type->get_name();
		// return __( '', 'elementor-pro' );
	}

	public function check( $args ) {
        $current_listing_type = get_post_meta(get_the_ID(), '_case27_listing_type', true);
        return ($args['id'] && $args['id'] == $current_listing_type);
    }
    
    protected function register_controls() {
        $types = get_posts( [
			'post_type' => 'case27_listing_type',
			// 'fields' => 'ids',
			'posts_per_page' => 100,
        ] );
        
        $options = [];

        foreach ($types as $type) {
            $options[$type->post_name] = $type->post_title;
        }

		$this->add_control(
            'listing_type',
            [
                'section' => 'settings',
                'label' => __( 'Listing Type' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
            ]
		);
	}
}
