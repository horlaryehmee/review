<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Button extends Widget_Base{

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mlt-button';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'MyListing Button', 'ml-elementor-toolkit-pro' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
	}

	public function get_keywords() {
		return [ 'quick actions', 'button', 'share', 'directions', 'call', 'mylisting', 'my listing' ];
	}

	/**
	 * Get button sizes.
	 *
	 * Retrieve an array of button sizes for the button widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array An array containing button sizes.
	 */
	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'elementor' ),
			'sm' => __( 'Small', 'elementor' ),
			'md' => __( 'Medium', 'elementor' ),
			'lg' => __( 'Large', 'elementor' ),
			'xl' => __( 'Extra Large', 'elementor' ),
		];
	}

	public static function get_quick_actions(){
		return array (
			'quick-view' 		=> 'Quick view (Preview Card)',
			'get-directions' 	=> 'Get directions',
			'call-now' 			=> 'Call now',
			'direct-message' 	=> 'Direct message',
			'leave-review' 		=> 'Leave a review',
			'bookmark' 			=> 'Bookmark',
			'share' 			=> 'Share',
			'claim-listing' 	=> 'Claim listing',
			'report-listing' 	=> 'Report',
			'visit-website' 	=> 'Website',
			'send-email' 		=> 'Send an email',
		);
	}
	
	/**
	 * Register button widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

        $this->start_controls_section(
			'section_mylisting',
			[
				'label' => __( 'MyListing', 'ml-elementor-toolkit-pro' ),
			]
        );

        $this->add_control(
			'mylisting_action',
			[
				'label' => __( 'Action', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_quick_actions(),
			]
		);

		$this->add_control(
			'hide_if_empty',
			[
				'label' => __('Hide if empty/ field value missing', 'ml-elementor-toolkit-pro'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'ml-elementor-toolkit-pro'),
				'label_off' => __('Hide', 'ml-elementor-toolkit-pro'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'text_bookmarked',
			[
				'label' => __( 'Bookmarked text', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Bookmarked', 'my-listing' ),
				'condition' => [
					'mylisting_action' => 'bookmark',
				]
			]
		);

        $this->end_controls_section();
    
		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'elementor' ),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => __( 'Type', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'elementor' ),
					'info' => __( 'Info', 'elementor' ),
					'success' => __( 'Success', 'elementor' ),
					'warning' => __( 'Warning', 'elementor' ),
					'danger' => __( 'Danger', 'elementor' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click here', 'elementor' ),
				'placeholder' => __( 'Click here', 'elementor' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'elementor' ),
					'right' => __( 'After', 'elementor' ),
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'elementor' ),
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'elementor' ),
				'separator' => 'before',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_bookmarked',
			[
				'label' => __( 'Bookmarked', 'elementor' ),
			]
		);

		$this->add_control(
			'bookmarked_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.bookmarked' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button.bookmarked svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_bookmarked_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.bookmarked' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bookmarked_border_color',
			[
				'label' => __( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button.bookmarked' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	public function get_link_attributes($action){
		$settings = $this->get_settings_for_display();

		$listing = \MyListing\Src\Listing::get( get_the_ID() );

		if ( !$listing || !$listing->type ) {
			return [];
		}

		
		switch ($action) {
			case 'quick-view':
				return array(
					'href' => '#',
					'class' => 'c27-toggle-quick-view-modal',
					'data-id' => $listing->get_id(),
				);
				break;
			case 'get-directions':
				if ( ! ( ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) ) {
					return [];
				}
				
				$query = join( ',', [ $lat, $lng ] );
				$link = sprintf( 'http://maps.google.com/maps?daddr=%s', urlencode( $query ) );
				return array(
					'href' => $link,
					'target' => '_blank',
					'rel' => 'nofollow',
				);
				break;
			case 'call-now':
				if ( ! ( $phone = $listing->get_field('phone') ) ) {
					return [];
				}
				
				$link = sprintf( 'tel:%s', $phone );
				return array(
					'href' => $link,
					'rel' => 'nofollow',
				);
				break;
			case 'direct-message':
				if ( c27()->get_setting( 'messages_enabled', true ) === false ) {
					return [];
				}
				if ( ! is_user_logged_in() ) {
					$url = add_query_arg( [
						'redirect' => get_post_permalink( get_the_ID() ),
						'notice' => 'login-required',
					], \MyListing\get_login_url() );
					return array(
						'href'	=> $url
					);
				}
				$message_post_data = json_encode( [
					'id'	=> $listing->get_id(),
					'image'	=> $listing->get_logo() ? : c27()->image( 'marker.jpg' ),
					'title'	=> $listing->get_name(),
					'link'	=> $listing->get_link(),
					'author'=> $listing->get_author_id()
				] );
				return array(
					'href' => '#',
					'class' => 'cts-open-chat',
					'data-post-data' 	=> esc_attr( $message_post_data ),
					'data-user-id'		=> absint( $listing->get_author_id() )
				);
			break;
			case 'leave-review':
				return array(
					'href' => '#',
					'class' => 'show-review-form'
				);
			break;
			case 'bookmark':
				$is_bookmarked = \MyListing\Src\Bookmarks::exists( $listing->get_id(), get_current_user_id() ) ? 'bookmarked' : '';
				return array(
					'href' => '#',
					'data-label' => $settings['text'],
					'data-active-label' => $settings['text_bookmarked'],
					'class' => $is_bookmarked,
					'rel' => 'nofollow',
					'data-listing-id' => $listing->get_id(),
					'onclick' => "MyListing.Handlers.Bookmark_Button(event, this)",
				);
			break;
			case 'share':
				$links = mylisting()->sharer()->get_links( [
					'permalink' => $listing->get_link(),
					'image' => $listing->get_share_image(),
					'title' => $listing->get_name(),
					'description' => $listing->get_share_description(),
					'icons' => true,
				] );
				
				if ( ! $links ) {
					return;
				}
				/**
				 * Output the markup for the share modal in the site footer,
				 * to prevent layout issues/cutout modal.
				 */
				add_action( 'mylisting/get-footer', function() use ( $links, $listing ) { ?>
					<div id="social-share-modal-<?php echo $listing->get_id(); ?>" class="social-share-modal modal modal-27">
						<ul class="share-options">
							<?php foreach ( $links as $link ):
								if ( empty( trim( $link ) ) ) continue; ?>
								<li><?php mylisting()->sharer()->print_link( $link ) ?></li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php } );
				return array(
					'href' => '#',
					'id' => esc_attr( $listing->get_id() .'-dd' ),
					'data-toggle' => 'modal',
					'data-target' => '#social-share-modal-' . $listing->get_id(),
				);
			break;
			case 'claim-listing':
				$claim_url = \MyListing\Src\Claims\Claims::get_claim_url( $listing->get_id() );
				if ( ! $listing->is_claimable() || empty( trim( $claim_url ) ) ) {
					return [];
				}

				return array(
					'href' => esc_url( $claim_url )
				);
			break;
			case 'report-listing':
				$logged_in = array(
					'href'	=> '#',
					'data-toggle'	=> 'modal',
					'data-target'	=> '#report-listing-modal',
				);

				$logged_out = array(
					'href'	=> esc_url( \MyListing\get_login_url() ),
				);

				$data = is_user_logged_in() ? $logged_in : $logged_out;

				return $data;
			break;
			case 'visit-website':
				if (!($website = $listing->get_field('job_website'))) {
					return [];
				}
				return array(
					'href'	=> $website,
				);
			break;
			case 'send-email':
				if ( ! ( $email = $listing->get_field('email') ) ) {
					return [];
				}
				$link = sprintf( 'mailto:%s', $email );

				return array(
					'href' => $link,
					'rel' => 'nofollow',
				);
			break;
			default:
				return [];
				break;
		}
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $this->get_link_attributes($settings['mylisting_action']) && $settings['hide_if_empty'] == 'yes' ) ) {
			return;
		}
		
		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['mylisting_action'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
			$this->add_render_attribute( 'button', $this->get_link_attributes($settings['mylisting_action']) );
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render button widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );
		view.addInlineEditingAttributes( 'text', 'none' );
		var iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
			migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );
		#>
		<div class="elementor-button-wrapper">
			<a id="{{ settings.button_css_id }}" class="elementor-button elementor-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="#" role="button">
				<span class="elementor-button-content-wrapper">
					<# if ( settings.icon || settings.selected_icon ) { #>
					<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
						<# if ( ( migrated || ! settings.icon ) && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
						<# } else { #>
							<i class="{{ settings.icon }}" aria-hidden="true"></i>
						<# } #>
					</span>
					<# } #>
					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
				</span>
			</a>
		</div>
		<?php
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		if($settings['mylisting_action'] == 'bookmark'){
			$is_bookmarked = \MyListing\Src\Bookmarks::exists( get_the_ID(), get_current_user_id() );
			$text = $is_bookmarked ? $settings['text_bookmarked'] : $settings['text'];
		} else{
			$text = $settings['text'];
		}

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text action-label',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
			<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<?php 
					Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				?>
			</span>
			<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $text; ?></span>
		</span>
		<?php
	}

	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
	}
}
