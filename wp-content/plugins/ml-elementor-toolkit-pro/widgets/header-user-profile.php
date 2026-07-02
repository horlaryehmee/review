<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use MyListing\Src\Bookmarks;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Verified badge widget.
 */
class Header_User_Profile extends Widget_Base {

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
        return 'mlt-header-user-profile';
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
        return __( 'User Profile Sign In / Register', 'ml-elementor-toolkit-pro' );
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
        return 'fas fa-user';
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
        return [ 'header', 'login', 'user', 'signup', 'cart', 'messages', 'mylisting' ];
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
			'content_section',
			[
				'label' => __( 'Content', 'ml-elementor-toolkit-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'show_avatar',
			[
				'label' => __( 'Show Avatar', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ml-elementor-toolkit-pro' ),
				'label_off' => __( 'Hide', 'ml-elementor-toolkit-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_signin_icon_style',
			[
				'label' => __( 'Sign in Icon', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_responsive_control(
			'signin_icon_size',
			[
				'label' => __( 'Icon Size', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .user-profile-dropdown > i.user-area-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
        );
        
        $this->add_control(
			'signin_icon_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .user-profile-dropdown > i.user-area-icon' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_avatar_style',
			[
				'label' => __( 'Avatar', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_responsive_control(
			'avatar_size',
			[
				'label' => __( 'Avatar Size', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mlt-user-profile-name .mlt-avatar' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mlt-user-profile-name .mlt-avatar .avatar' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'avatar_border',
				'selector' => '{{WRAPPER}} .mlt-user-profile-name .mlt-avatar',
				'separator' => 'before',
			]
        );
        
        $this->add_control(
			'avatar_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .mlt-user-profile-name .mlt-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_text_style',
			[
				'label' => __( 'Text style', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .signin-area a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mlt-user-profile-name' => 'color: {{VALUE}};',
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_2,
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .mlt-user-profile-name',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_submenu_icon_style',
			[
				'label' => __( 'Submenu Toggle', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_responsive_control(
			'submenu_icon_size',
			[
				'label' => __( 'Icon Size', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mlt-user-profile-name .submenu-toggle' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mlt-user-profile-name .submenu-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
        );
        
        $this->add_control(
			'submenu_icon_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mlt-user-profile-name .submenu-toggle' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
			]
        );
        
        $this->add_control(
			'submenu_icon_opacity',
			[
				'label' => __( 'Icon Opacity', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.5,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mlt-user-profile-name .submenu-toggle' => 'opacity: {{SIZE}};',
				],
			]
        );
        
        $this->add_responsive_control(
			'dropdown_menu_top',
			[
				'label' => __( 'Dropdown Menu Top position', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.dropdown-menu' => 'top: {{SIZE}}{{UNIT}};',
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
        $settings = $this->get_settings_for_display();

        ?>
        <?php if ( is_user_logged_in() ): $current_user = wp_get_current_user(); ?>
			<div class="user-profile-dropdown dropdown">
				<a class="mlt-user-profile-name" href="#" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<?php if( $settings['show_avatar'] ): ?>
						<div class="mlt-avatar">
							<?php echo get_avatar( $current_user->ID ) ?>
						</div>
					<?php endif; ?>
					<?php echo esc_attr( $current_user->display_name ) ?>
					<?php if ( class_exists('WooCommerce') ): ?>
						<div class="submenu-toggle"><i class="material-icons">arrow_drop_down</i></div>
					<?php endif; ?>
				</a>

				<?php if ( has_nav_menu( 'mylisting-user-menu' ) ) : ?>
					<?php wp_nav_menu([
						'theme_location' => 'mylisting-user-menu',
						'container' 	 => false,
						'depth'     	 => 0,
						'menu_class'	 => 'i-dropdown dropdown-menu',
						'items_wrap' 	 => '<ul class="%2$s" aria-labelledby="user-dropdown-menu">%3$s</ul>'
						]); ?>
				<?php elseif ( class_exists('WooCommerce') ) : ?>
					<ul class="i-dropdown dropdown-menu" aria-labelledby="user-dropdown-menu">
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
							<?php do_action( "case27/user-menu/{$endpoint}/before" ) ?>
							<li class="user-menu-<?php echo esc_attr( $endpoint ) ?>">
								<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
							</li>
							<?php do_action( "case27/user-menu/{$endpoint}/after" ) ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
        <?php else: ?>
            <div class="user-area signin-area">
                <i class="mi person user-area-icon"></i>
                <a href="<?php echo esc_url( \MyListing\get_login_url() ) ?>">
					<?php _e( 'Sign in', 'my-listing' ) ?>
				</a>
				<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ): ?>
					<span><?php _e( 'or', 'my-listing' ) ?></span>
					<a href="<?php echo esc_url( \MyListing\get_register_url() ) ?>">
						<?php _e( 'Register', 'my-listing' ) ?>
					</a>
				<?php endif ?>
            </div>
            <div class="mob-sign-in">
				<a href="<?php echo esc_url( \MyListing\get_login_url() ) ?>">
				<i class="mi person"></i></a>
			</div>
        <?php endif ?>

		

        <?php
    }
}
