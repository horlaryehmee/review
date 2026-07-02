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
 * Priority badge
 */
class Priority_Badge extends Widget_Base {

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
        return 'mlt-priority-badge';
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
        return __( 'Priority Badge', 'elementor' );
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
        return 'fas fa-bolt';
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
        return [ 'promoted', 'featured', 'priority', 'mylisting' ];
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

        $listing = \MyListing\Src\Listing::get( get_the_ID() );
        
        if ( !$listing || !$listing->type ) {
            return;
        }

        if ( $listing->get_priority() >= 2 ) {
            $promotion_tooltip = _x( 'Promoted', 'Listing Preview Card: Promoted Tooltip Title', 'my-listing' );
        } elseif ( $listing->get_priority() === 1 ) {
            $promotion_tooltip = _x( 'Featured', 'Listing Preview Card: Promoted Tooltip Title', 'my-listing' );
        } else {
            $promotion_tooltip = '';
        }

        if ( $listing->get_priority() >= 1 ): ?>
        <div class="lf-head-btn ad-badge" data-toggle="tooltip" data-placement="bottom"
            data-original-title="<?php echo esc_attr( $promotion_tooltip ) ?>">
            <span><i class="icon-flash"></i></span>
        </div>
        <?php endif;
       
    }
}
