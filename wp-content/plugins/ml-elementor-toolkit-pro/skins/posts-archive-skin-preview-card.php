<?php
namespace ML_Elementor_Toolkit_Pro\Skins;

use ElementorPro\Modules\ThemeBuilder\Skins\Posts_Archive_Skin_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Posts_Archive_Skin_Preview_Card extends Skin_Preview_Card {
	use Posts_Archive_Skin_Base;

	protected function _register_controls_actions() {
		add_action( 'elementor/element/archive-posts/section_layout/before_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/archive-posts/section_layout/after_section_end', [ $this, 'register_style_sections' ] );
	}

	public function get_id() {
		return 'archive_preview_card';
	}

	public function get_title() {
		return __( 'Preview Card', 'elementor-pro' );
	}

	public function get_container_class() {
		// Use parent class and parent css.
		return 'elementor-posts--skin-preview-card';
	}

	/* Remove `posts_per_page` control */
	protected function register_post_count_control(){}
}
