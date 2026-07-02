<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;

class Stats_Select_Listing extends Widget_Base {

    public function get_name() {
        return 'mlt-stats-select-listing';
    }

    public function get_title() {
        return __( 'Stats - Select Listing', 'ml-elementor-toolkit-pro' );
    }

    public function get_icon() {
        return 'fas fa-caret-down';
    }

    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

    public function get_keywords() {
        return [ 'stats select listing', 'dashboard', 'account', 'mylisting', 'my listing' ];
    }

    /**
     * Add styling dependency
     */
    public function get_style_depends() {
        return [ 'mylisting-dashboard' ];
    }

    /**
     * Add script dependency
     */
    public function get_script_depends() {
        return [ 'mylisting-dashboard', 'chartist' ];
    }

    /**
     * Register icon list widget controls.
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

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( !is_user_logged_in() ) {
            return;
        } 
        global $wp;

        ?>
        <select
            name="listing"
            class="custom-select dashboard-filter-stats"
            data-mylisting-ajax="true"
            data-mylisting-ajax-url="mylisting_list_posts"
            data-mylisting-ajax-params="<?php echo c27()->encode_attr( [ 'cts_author' => get_current_user_id() ] ) ?>"
            placeholder="<?php echo esc_attr( _x( 'Filter by listing', 'User dashboard', 'my-listing' ) ) ?>"
            data-url="<?php echo esc_url( home_url( $wp->request ) ) ?>"
        >
        
        <?php if ( ! empty( $_GET['listing'] ) && ( $listing = \MyListing\Src\Listing::get( $_GET['listing'] ) ) && $listing->editable_by_current_user() ): ?>
            <option value="<?php echo esc_attr( $listing->get_id() ) ?>" selected="selected"><?php echo esc_attr( $listing->get_name() ) ?></option>
        <?php endif ?>
        </select>
        <?php
    }
}