<?php
/**
 * WPML integration class.
 *
 * @package jeg-kit
 */

namespace Jeg\Elementor_Kit\Integrations;

use Jeg\Elementor_Kit\Integrations\WPML\Accordion_Module;
use Jeg\Elementor_Kit\Integrations\WPML\Animated_Text_Module;
use Jeg\Elementor_Kit\Integrations\WPML\Portfolio_Gallery_Module;
use Jeg\Elementor_Kit\Integrations\WPML\Testimonials_Module;

/**
 * Class WPML
 *
 * @package Jeg\Elementor_Kit\Integrations
 */
class WPML {
	/**
	 * Instance
	 *
	 * @var WPML|null
	 */
	private static $instance;

	/**
	 * Get instance
	 *
	 * @return WPML
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'register_widgets' ) );
		add_action( 'init', array( $this, 'register_repeater_modules' ) );
	}

	/**
	 * Register Jeg Kit widget fields for WPML Elementor translation.
	 *
	 * @param array $widgets Registered Elementor widgets.
	 *
	 * @return array
	 */
	public function register_widgets( $widgets ) {
		/** Jeg Kit - Icon Box Widget */
		$widgets['jkit_icon_box'] = array(
			'conditions' => array( 'widgetType' => 'jkit_icon_box' ),
			'fields'     => array(
				$this->field( 'sg_icon_text', __( 'Jeg Kit Icon Box: Icon Box: Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_icon_description', __( 'Jeg Kit Icon Box: Icon Box: Description', 'jeg-elementor-kit' ), 'AREA' ),
				$this->field( 'sg_readmore_button_label', __( 'Jeg Kit Icon Box: Read More: Button Label', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_badge_text', __( 'Jeg Kit Icon Box: Badge: Text', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Off Canvas Widget */
		$widgets['jkit_off_canvas'] = array(
			'conditions' => array( 'widgetType' => 'jkit_off_canvas' ),
			'fields'     => array(
				$this->field( 'sg_setting_open_text', __( 'Jeg Kit Off Canvas: Setting: Open Text', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Search Widget */
		$widgets['jkit_search'] = array(
			'conditions' => array( 'widgetType' => 'jkit_search' ),
			'fields'     => array(
				$this->field( 'sg_search_placeholder', __( 'Jeg Kit Search: Search: Placeholder', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_search_text', __( 'Jeg Kit Search: Search: Text', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Nav Menu Widget */
		$widgets['jkit_nav_menu'] = array(
			'conditions' => array( 'widgetType' => 'jkit_nav_menu' ),
			'fields'     => array(
				'sg_mobile_menu_custom_link' => $this->field( 'url', __( 'Jeg Kit Nav Menu: Mobile Menu: Custom Link', 'jeg-elementor-kit' ), 'LINK' ),
			),
		);

		/** Jeg Kit - Progress Bar Widget */
		$widgets['jkit_progress_bar'] = array(
			'conditions' => array( 'widgetType' => 'jkit_progress_bar' ),
			'fields'     => array(
				$this->field( 'sg_progress_title', __( 'Jeg Kit Progress Bar: Progress Bar: Title', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Countdown Widget */
		$widgets['jkit_countdown'] = array(
			'conditions' => array( 'widgetType' => 'jkit_countdown' ),
			'fields'     => array(
				$this->field( 'sg_content_day_label', __( 'Jeg Kit Countdown: Content: Day Label', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_hour_label', __( 'Jeg Kit Countdown: Content: Hour Label', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_minute_label', __( 'Jeg Kit Countdown: Content: Minute Label', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_second_label', __( 'Jeg Kit Countdown: Content: Second Label', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_expire_title', __( 'Jeg Kit Countdown: Expired Action: Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_expire_content', __( 'Jeg Kit Countdown: Expired Action: Content', 'jeg-elementor-kit' ), 'AREA' ),
				$this->field( 'sg_expire_link', __( 'Jeg Kit Countdown: Expired Action: Redirect Link', 'jeg-elementor-kit' ), 'LINK' ),
			),
		);

		/** Jeg Kit - Dual Button Widget */
		$widgets['jkit_dual_button'] = array(
			'conditions' => array( 'widgetType' => 'jkit_dual_button' ),
			'fields'     => array(
				$this->field( 'sg_dual_middle_text', __( 'Jeg Kit Dual Button: Dual Button: Middle Text', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_one_text', __( 'Jeg Kit Dual Button: Button One: Text', 'jeg-elementor-kit' ) ),
				'sg_one_link' => $this->field( 'url', __( 'Jeg Kit Dual Button: Button One: Link', 'jeg-elementor-kit' ), 'LINK' ),
				$this->field( 'sg_two_text', __( 'Jeg Kit Dual Button: Button Two: Text', 'jeg-elementor-kit' ) ),
				'sg_two_link' => $this->field( 'url', __( 'Jeg Kit Dual Button: Button Two: Link', 'jeg-elementor-kit' ), 'LINK' ),
			),
		);

		/** Jeg Kit - Accordion Widget */
		$widgets['jkit_accordion'] = array(
			'conditions'        => array( 'widgetType' => 'jkit_accordion' ),
			'fields'            => array(),
			'integration-class' => Accordion_Module::class,
		);

		/** Jeg Kit - Portfolio Gallery Widget */
		$widgets['jkit_portfolio_gallery'] = array(
			'conditions'        => array( 'widgetType' => 'jkit_portfolio_gallery' ),
			'fields'            => array(),
			'integration-class' => Portfolio_Gallery_Module::class,
		);

		/** Jeg Kit - Testimonials Widget */
		$widgets['jkit_testimonials'] = array(
			'conditions'        => array( 'widgetType' => 'jkit_testimonials' ),
			'fields'            => array(),
			'integration-class' => Testimonials_Module::class,
		);

		/** Jeg Kit - Heading Widget */
		$widgets['jkit_heading'] = array(
			'conditions' => array( 'widgetType' => 'jkit_heading' ),
			'fields'     => array(
				$this->field( 'sg_title_before', __( 'Jeg Kit Heading: Title: Before Focused Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_title_focused', __( 'Jeg Kit Heading: Title: Focused Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_title_after', __( 'Jeg Kit Heading: Title: After Focused Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_title_text', __( 'Jeg Kit Heading: Title: Highlight Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_subtitle_heading', __( 'Jeg Kit Heading: Subtitle: Heading Sub Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_description', __( 'Jeg Kit Heading: Description: Heading Description', 'jeg-elementor-kit' ), 'VISUAL' ),
				$this->field( 'sg_shadow_content', __( 'Jeg Kit Heading: Shadow Text: Content', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Image Box Widget */
		$widgets['jkit_image_box'] = array(
			'conditions' => array( 'widgetType' => 'jkit_image_box' ),
			'fields'     => array(
				'sg_image_link'  => $this->field( 'sg_image_link', __( 'Jeg Kit Image Box: Image: Link', 'jeg-elementor-kit' ), 'LINK' ),
				$this->field( 'sg_body_title', __( 'Jeg Kit Image Box: Body: Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_body_description', __( 'Jeg Kit Image Box: Body: Description', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_button_label', __( 'Jeg Kit Image Box: Button: Label', 'jeg-elementor-kit' ) ),
				'sg_button_link' => $this->field( 'url', __( 'Jeg Kit Image Box: Button: Link', 'jeg-elementor-kit' ), 'LINK' ),
			),
		);

		/** Jeg Kit - Button Widget */
		$widgets['jkit_button'] = array(
			'conditions' => array( 'widgetType' => 'jkit_button' ),
			'fields'     => array(
				$this->field( 'sg_content_label', __( 'Jeg Kit Button: Content: Label', 'jeg-elementor-kit' ) ),
				'sg_content_link' => $this->field( 'url', __( 'Jeg Kit Button: Content: Link', 'jeg-elementor-kit' ), 'LINK' ),
				$this->field( 'sg_content_class', __( 'Jeg Kit Button: Content: Class', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_id', __( 'Jeg Kit Button: Content: ID', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Animated Text Widget */
		$widgets['jkit_animated_text'] = array(
			'conditions'        => array( 'widgetType' => 'jkit_animated_text' ),
			'fields'            => array(
				$this->field( 'sg_text_before', __( 'Jeg Kit Animated Text: Text: Before Text', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_text_animated', __( 'Jeg Kit Animated Text: Text: Animated Text', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_text_after', __( 'Jeg Kit Animated Text: Text: After Text', 'jeg-elementor-kit' ) ),
			),
			'integration-class' => Animated_Text_Module::class,
		);

		/** Jeg Kit - Pie Chart Widget */
		$widgets['jkit_pie_chart'] = array(
			'conditions' => array( 'widgetType' => 'jkit_pie_chart' ),
			'fields'     => array(
				$this->field( 'sg_content_title', __( 'Jeg Kit Pie Chart: Content: Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_description', __( 'Jeg Kit Pie Chart: Content: Description', 'jeg-elementor-kit' ), 'AREA' ),
			),
		);

		/** Jeg Kit - Fun Fact Widget */
		$widgets['jkit_fun_fact'] = array(
			'conditions' => array( 'widgetType' => 'jkit_fun_fact' ),
			'fields'     => array(
				$this->field( 'sg_content_number_prefix', __( 'Jeg Kit Fun Fact: Content: Number Prefix', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_number', __( 'Jeg Kit Fun Fact: Content: Number', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_number_suffix', __( 'Jeg Kit Fun Fact: Content: Number Suffix', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_title', __( 'Jeg Kit Fun Fact: Content: Title', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_super', __( 'Jeg Kit Fun Fact: Content: Super', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Team Widget */
		$widgets['jkit_team'] = array(
			'conditions' => array( 'widgetType' => 'jkit_team' ),
			'fields'     => array(
				$this->field( 'sg_member_name', __( 'Jeg Kit Team: Team Member: Member Name', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_member_position', __( 'Jeg Kit Team: Team Member: Position', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_member_description', __( 'Jeg Kit Team: Team Member: Description', 'jeg-elementor-kit' ), 'AREA' ),
				$this->field( 'sg_popup_phone', __( 'Jeg Kit Team: Team Member: Phone', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_popup_email', __( 'Jeg Kit Team: Team Member: Email', 'jeg-elementor-kit' ) ),
			),
		);

		/** Jeg Kit - Post Block Widget */
		$widgets['jkit_post_block'] = array(
			'conditions' => array( 'widgetType' => 'jkit_post_block' ),
			'fields'     => array(
				$this->field( 'sg_content_excerpt_more', __( 'Jeg Kit Post Block: Content Setting: Excerpt More', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_readmore_text', __( 'Jeg Kit Post Block: Content Setting: Read More Text', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_meta_author_by_text', __( 'Jeg Kit Post Block: Content Setting: Meta Author "by" Text', 'jeg-elementor-kit' ) ),
				$this->field( 'sg_content_meta_date_format_custom', __( 'Jeg Kit Post Block: Content Setting: Post Date Custom Format', 'jeg-elementor-kit' ) ),
				$this->field( 'pagination_prev_text', __( 'Jeg Kit Post Block: Pagination: Previous Text', 'jeg-elementor-kit' ) ),
				$this->field( 'pagination_next_text', __( 'Jeg Kit Post Block: Pagination: Next Text', 'jeg-elementor-kit' ) ),
				$this->field( 'pagination_loadmore_text', __( 'Jeg Kit Post Block: Pagination: Load More Text', 'jeg-elementor-kit' ) ),
				$this->field( 'pagination_loading_text', __( 'Jeg Kit Post Block: Pagination: Loading Text', 'jeg-elementor-kit' ) ),
			),
		);

		return $widgets;
	}

	/**
	 * Register WPML module classes for repeater-based widgets.
	 */
	public function register_repeater_modules() {
		if ( ! class_exists( '\WPML_Elementor_Module_With_Items' ) ) {
			return;
		}

		require_once JEG_ELEMENTOR_KIT_DIR . 'class/integrations/wpml/class-accordion-module.php';
		require_once JEG_ELEMENTOR_KIT_DIR . 'class/integrations/wpml/class-portfolio-gallery-module.php';
		require_once JEG_ELEMENTOR_KIT_DIR . 'class/integrations/wpml/class-testimonials-module.php';
		require_once JEG_ELEMENTOR_KIT_DIR . 'class/integrations/wpml/class-animated-text-module.php';
	}

	/**
	 * Build a WPML field definition.
	 *
	 * @param string $field       Field key.
	 * @param string $type        Field label.
	 * @param string $editor_type WPML editor type.
	 *
	 * @return array
	 */
	private function field( $field, $type, $editor_type = 'LINE' ) {
		return array(
			'field'       => $field,
			'type'        => $type,
			'editor_type' => $editor_type,
		);
	}
}
