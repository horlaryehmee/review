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

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class Related_Listings extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'related-listings';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Related Listings', 'ml-elementor-toolkit-pro' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fas fa-layer-group';
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
        return [ 'related listings', 'mylisting', 'my listing' ];
    }

    public function show_in_panel() {
		return false;
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

		$control_options = [
			'label' => __( 'Related listing field', 'elementor-pro' ),
			'type' => Controls_Manager::SELECT,
		];

		$listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ( $listing && $listing->type) {
			$control_options['options'] = DynamicTagsModule::get_ml_fields_options( ['related-listing'] );
		} else{
			$control_options['groups'] = DynamicTagsModule::get_ml_fields_groups( ['related-listing'] );
		}

		$this->add_control(
			'key',
			$control_options
		);

        $this->end_controls_section();
    }

    /**
     * Render icon list widget output on the frontend.
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
        
        if( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
            echo "<div style='color:red;'>Related listings are not working in Elementor editor/preview, please check the live page.</div>";
            return;
        } 

        ?>

		<input type="hidden" id="case27-post-id" value="<?php echo get_the_ID() ?>">
		<input type="hidden" id="case27-author-id" value="<?php echo get_the_author_meta('ID') ?>">
		<a id="listing_tab_<?php echo $this->get_id() ?>_toggle" data-section-id="<?php echo $this->get_id() ?>" class="listing-tab-toggle toggle-tab-type-related_listings"
			data-options="{&quot;field_key&quot;:&quot;<?php echo $settings['key'] ?>&quot;}">
		</a>
		<section class="tab-type-related_listings" id="listing_tab_<?php echo $this->get_id() ?>">

			<div class="c27-related-listings-wrapper">
				<div class="row listings-loading tab-loader">
					<div class="loader-bg">
						<?php c27()->get_partial( 'spinner', [
								'color' => '#777',
								'classes' => 'center-vh',
								'size' => 28,
								'width' => 3,
							] ) ?>
					</div>
				</div>
				<div class="row section-body i-section">
					<div class="c27-related-listings tab-contents"></div>
				</div>
				<div class="row">
					<div class="c27-related-listings-pagination tab-pagination"></div>
				</div>
			</div>
		</section>

<?php
    }
}
