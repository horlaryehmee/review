<?php
namespace ML_Elementor_Toolkit_Pro\Skins;

use Elementor\Widget_Base;
use ElementorPro\Modules\Posts\Skins\Skin_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Skin_Preview_Card extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		// add_action( 'elementor/element/posts/preview_card_section_design_layout/after_section_end', [ $this, 'register_additional_design_controls' ] );
	}

	public function get_id() {
		return 'preview_card';
	}

	public function get_title() {
		return __( 'Preview Card', 'elementor-pro' );
	}

	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_columns_controls();
		$this->register_post_count_control();
		// $this->register_thumbnail_controls();
		// $this->register_title_controls();
		// $this->register_excerpt_controls();
		// $this->register_meta_data_controls();
		// $this->register_read_more_controls();
		// $this->register_link_controls();
	}

	public function register_additional_design_controls() {
		
	}

    protected function render_post() {
        echo \MyListing\get_preview_card( get_the_ID() );
    }
}
