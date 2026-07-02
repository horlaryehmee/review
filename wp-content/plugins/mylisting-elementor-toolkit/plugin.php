<?php
namespace ML_Elementor_Toolkit;


/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {
 
  /**
   * Instance
   *
   * @since 1.0.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
    private static $_instance = null;
 
    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
           
        return self::$_instance;
	}
	
	/**
	 * Sets elementor settings to enable elementor for this post type. 
	 */
	function elementor_post_types( $post_types ) {
		$post_types['job_listing'] = 'Listings';
		return $post_types;
	}

    /**
     * Register cherry category for elementor if not exists
     *
     * @return void
     */
    public function register_category( $elements_manager ) {

        $elements_manager->add_category(
            'ml-elementor-toolkit',
            [
                'title' => __( 'MyListing Elementor Toolkit', 'ml-elementor-toolkit' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
 
    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        require_once( __DIR__ . '/widgets/related-listings-host.php' );
        require_once( __DIR__ . '/widgets/header-wc-navigation.php' );
 
        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Related_Listings_Host() );
        \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Header_WC_Navigation() );
    }
 
    /**
     * Register Tags
     *
     * Register new Elementor tags.
     *
     */
    public function register_tags( $tag_manager ) {
        // In our Dynamic Tag we use a group named request-variables so we need 
        // To register that group as well before the tag
        $tag_manager->register_group( 'my-listing', [
			'title' => 'MyListing' 
		] );

        // Its is now safe to include Tags files
        require_once( __DIR__ . '/dynamic-tags/tags/field.php' );
        require_once( __DIR__ . '/dynamic-tags/tags/wp-editor.php' );
        require_once( __DIR__ . '/dynamic-tags/tags/number.php' );
        require_once( __DIR__ . '/dynamic-tags/tags/image.php' );
        require_once( __DIR__ . '/dynamic-tags/tags/rating.php' );
        require_once( __DIR__ . '/dynamic-tags/tags/review-count.php' );
     
        // Finally register the tags
        // $tag_manager->add_component( 'my-listing', new ML_Elementor_Toolkit\DynamicTags\tag_manager() );

        $tag_manager->register_tag( 'ML_Elementor_Toolkit\DynamicTags\Field' );
        $tag_manager->register_tag( 'ML_Elementor_Toolkit\DynamicTags\WP_Editor' );
        $tag_manager->register_tag( 'ML_Elementor_Toolkit\DynamicTags\Number' );
        $tag_manager->register_tag( 'ML_Elementor_Toolkit\DynamicTags\Image' );
        $tag_manager->register_tag( 'ML_Elementor_Toolkit\DynamicTags\Rating' );
        $tag_manager->register_tag( 'ML_Elementor_Toolkit\DynamicTags\Review_Count' );
    }

    /**
     * Register Conditions
     *
     * Register new Elementor display conditions.
     *
     */
    public function register_conditions( $conditions_manager ) {
        require_once( __DIR__ . '/conditions/listing-type.php' );
	
        $job_listing = $conditions_manager->get_condition( 'job_listing' );
        if($job_listing){
            $job_listing->register_sub_condition( new Conditions\Listing_Type() );
        }
    }

    /**
     * Register the MyListing Preview Card theme location. 
     */
    public function register_theme_locations( $elementor_theme_manager ) {
        $elementor_theme_manager->register_location(
			'mylisting-preview-card',
			[
				'label' => __( 'MyListing Preview Card', 'yellowwave-mylisting-elementor' ),
				'multiple' => false,
				'edit_in_content' => true,
			]
        );
        $elementor_theme_manager->register_location(
			'mylisting-quick-view',
			[
				'label' => __( 'MyListing Quick View', 'yellowwave-mylisting-elementor' ),
				'multiple' => false,
				'edit_in_content' => true,
			]
		);
    }


    public function enqueue_scripts(){
        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_enqueue_style( 'mylisting-single-listing' );
			wp_enqueue_style( 'mylisting-countdown-widget' );
		}
    }

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct() {

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 50 );

		// Add listings post type support for Elementor
		add_filter( 'elementor_pro/utils/get_public_post_types', [ $this, 'elementor_post_types'], 50 );
 
    	// Register widget scripts
        // add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
 
        require_once( __DIR__ . '/dynamic-tags/module.php' );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );

        // Register widgets
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	
        // Register dynamic tags
        add_action( 'elementor/dynamic_tags/register', [ $this, 'register_tags' ] );

        // Register conditions
        add_action( 'elementor/theme/register_conditions', [ $this, 'register_conditions' ] );

        // Register theme location for MyListing Preview Card
        add_action( 'elementor/theme/register_locations', [ $this, 'register_theme_locations'] );

    }
}
 
// Instantiate Plugin Class
Plugin::instance();