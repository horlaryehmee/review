<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use MyListing\Src\Bookmarks;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Verified badge widget.
 */
class Header_Messaging_Center extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'mlt-header-messaging-center';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Messaging Center', 'ml-elementor-toolkit-pro' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fas fa-inbox';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the icon widget belongs to.
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

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'header', 'messages', 'inbox', 'mylisting' ];
    }
    
    /**
     * Register icon widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-inbox',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'stacked' => __( 'Stacked', 'elementor' ),
					'framed' => __( 'Framed', 'elementor' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'elementor' ),
					'square' => __( 'Square', 'elementor' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover svg' => 'fill: {{VALUE}};',
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

		$this->add_responsive_control(
			'size',
			[
				'label' => __( 'Size', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'rotate',
			[
				'label' => __( 'Rotate', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_count_badge',
			[
				'label' => __( 'Count Badge', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'count_badge_background_color',
			[
				'label' => __( 'Background Color', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .chat-counter-container' => 'background-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
			]
		);

        $this->add_control(
			'count_badge_text_color',
			[
				'label' => __( 'Text Color', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
                    '{{WRAPPER}} .chat-counter-container span' => 'color: {{VALUE}} !important;',
				],
			]
		);

        $this->add_responsive_control(
			'count_badge_size',
			[
				'label' => __( 'Badge Size', 'ml-elementor-toolkit-pro' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .chat-counter-container' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
        );

        $this->add_responsive_control(
			'count_badge_text_size',
			[
				'label' => __( 'Text Size', 'ml-elementor-toolkit-pro' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .chat-counter-container' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
        );
        
        
        $this->add_responsive_control(
			'count_badge_pos_x',
			[
				'label' => __( 'Position Horizontal', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'size' => '-7',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .chat-counter-container' => 'right: {{SIZE}}{{UNIT}};',
				]
			]
        );
        
        $this->add_responsive_control(
			'count_badge_pos_y',
			[
				'label' => __( 'Position Vertical', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'size' => '-8',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .chat-counter-container' => 'bottom: {{SIZE}}{{UNIT}} !important;',
                ],
                'separator' => 'before',
			]
		);

        $this->end_controls_section();
	}

    /**
     * Render icon widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        if ( !is_user_logged_in() || c27()->get_setting( 'messages_enabled', true ) == false ){
            return;
        }


        $settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-icon-wrapper' );

		$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );

		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }
        
		$icon_tag = 'a';
        $this->add_link_attributes( 'icon-wrapper', [
			'url' => '#'
		] );
        $this->add_render_attribute( 'icon-wrapper', 'id', 'messages-modal-toggle' );
        $this->add_render_attribute( 'icon-wrapper', 'data-toggle', 'modal' );
        $this->add_render_attribute( 'icon-wrapper', 'data-target', '#ml-messages-modal' );

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<<?php echo $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
			<?php if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
			else : ?>
				<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
			<?php endif; ?>
                <div class="chat-counter-container" id="ml-chat-activities">
                    <?php 
                        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ){
                            ?> <span>1</span> <?php
                        }
                    ?>
                </div>
			</<?php echo $icon_tag; ?>>
		</div>
        <?php
    }

    /**
	 * Render icon widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
				iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' ),
				iconTag = link ? 'a' : 'div';
		#>
		<div class="elementor-icon-wrapper">
			<{{{ iconTag }}} class="elementor-icon elementor-animation-{{ settings.hover_animation }}" {{{ link }}}>
				<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
					{{{ iconHTML.value }}}
				<# } else { #>
					<i class="{{ settings.icon }}" aria-hidden="true"></i>
				<# } #>
			</{{{ iconTag }}}>
		</div>
		<?php
	}
}
