<?php
namespace ML_Elementor_Toolkit_Pro;

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
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
    public function widget_scripts() {
        wp_register_script( 'mlt-general', plugins_url( '/assets/js/general.js', __FILE__ ), [ 'jquery' ], false, true );

        // Enqueue directly, because preview cards dont enqueue because AJAX load
        wp_enqueue_script( 'mlt-general' );
    }

    /**
     * plugin_styles
     *
     * Load required plugin stylesheets
     *
     * @since 1.0.0
     * @access public
     */
    public function plugin_styles() {
        wp_enqueue_style( 
            'ml-elementor-toolkit-pro-general', 
            plugins_url( 'assets/css/general.css', __FILE__ ),
            [],
            \ML_Elementor_Toolkit_Pro::VERSION
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

        $directory = plugin_dir_path( __FILE__ )  . DIRECTORY_SEPARATOR . 'widgets';
        if(is_dir($directory)) {
            foreach(glob($directory . DIRECTORY_SEPARATOR . '*.php') as $filePath) {

                $class = \basename($filePath, '.php');

                $class = str_replace('-', '_', $class);
                $class = 'ML_Elementor_Toolkit_Pro\Widgets\\' . ucwords($class, '_');

                \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class() );
            }
        }
    }
 
    /**
     * Register Tags
     *
     * Register new Elementor tags.
     *
     */
    public function register_tags( $dynamic_tags ) {
        // In our Dynamic Tag we use a group named request-variables so we need 
        // To register that group as well before the tag
        $dynamic_tags->register_group( 'my-listing', [
			'title' => 'MyListing' 
        ] );
        
        $directory = plugin_dir_path( __FILE__ )  . DIRECTORY_SEPARATOR . 'dynamic-tags';
        if(is_dir($directory)) {
            foreach(glob($directory . DIRECTORY_SEPARATOR . '*.php') as $filePath) {

                $class = \basename($filePath, '.php');

                $class = str_replace('-', '_', $class);
                $class = 'ML_Elementor_Toolkit_Pro\DynamicTags\\' . ucwords($class, '_');

                $dynamic_tags->register_tag( $class );
            }
        }
    }

    /**
     * Register Conditions
     *
     * Register new Elementor display conditions.
     *
     */
    public function register_conditions( $conditions_manager ) {
        $condition_woocommerce = $conditions_manager->get_condition( 'singular' );
        if($condition_woocommerce){
            $condition_woocommerce->register_sub_condition( new Conditions\Woocommerce_MyAccount() );
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
        $elementor_theme_manager->register_location(
			'mylisting-account-bookmarks',
			[
				'label' => __( 'MyListing Account Bookmarks', 'yellowwave-mylisting-elementor' ),
				'multiple' => false,
				'edit_in_content' => true,
			]
		);
    }

    public function register_skins_posts($widget){
        $widget->add_skin(new Skins\Skin_Preview_Card($widget));
    }

    public function register_skins_archive_posts($widget){
        $widget->add_skin(new Skins\Posts_Archive_Skin_Preview_Card($widget));
    }

    public function fix_comments_allowed($comment_template) {
        $GLOBALS['case27_reviews_allow_rating'] = true;

        $listing = \MyListing\Src\Listing::get( get_the_ID() );
		if ( !$listing || !$listing->type ) {
			return $comment_template;
        }
        
        $GLOBALS['case27_reviews_allow_rating'] = $listing->type->is_rating_enabled();

        return $comment_template;
    }

    public function preview_card_templates( $templates ){
        $templates['mlt-elementor'] = 'Elementor - MyListing Toolkit';
        return $templates;
    }

    public function add_preview_card_output($listing, $listing_type){
        yellowwave_elementor_theme_location('mylisting-preview-card', $listing->get_id());
    }

    public function quick_view_templates( $templates ){
        $templates['mlt-elementor'] = 'Elementor - MyListing Toolkit';
        return $templates;
    }

    public function add_quick_view_output($listing, $listing_type){
        $options = $listing->type->get_preview_options();
        if($options['quick_view']['template'] == 'mlt-elementor'){
            yellowwave_elementor_theme_location('mylisting-quick-view', $listing->get_id());
        }
    }

    public function override_preview_step($steps){
        if(isset($steps['preview']['view'] )){
            $steps['preview']['view'] = [$this, 'preview_listing_output'];
        }
        return $steps;
    }

    public function preview_listing_output() {
		$form = \MyListing\Src\Forms\Add_Listing_Form::instance();

		if ( ! $form->get_job_id() ) {
			mlog()->warn( 'No listing id provided.' );
			return;
		}

		// refresh cache for listing
		\MyListing\Src\Listing::force_get( $form->get_job_id() );

		global $post;
		$post = get_post( $form->get_job_id() );
		$post->post_status = 'preview';
		setup_postdata( $post );
        include __DIR__ . '/templates/preview.php';
		wp_reset_postdata();
	}

    

    public function add_post_id_author_id(){
        if ( is_singular('job_listing') ) {
            ?>
            <input type="hidden" id="case27-post-id" value="<?php echo esc_attr( get_the_ID() ) ?>">
            <input type="hidden" id="case27-author-id" value="<?php echo esc_attr( get_the_author_meta('ID') ) ?>">
            <?php
        }
    }

    public function elementor_bookmarks_page(){
        if (mlt_get_option('mlt_checkbox_use_elementor_bookmarks')) {
            remove_all_actions('woocommerce_account_my-bookmarks_endpoint');
            add_action('woocommerce_account_my-bookmarks_endpoint', function($query_value){
                elementor_theme_do_location('mylisting-account-bookmarks');
            }, 10, 1);
        }
    }

    public function elementor_taxonomy_page() {
        if (mlt_get_option('mlt_checkbox_use_elementor_taxonomy')) {
            remove_action(  'init', [ 'MyListing\Src\Explore', 'add_rewrite_rules' ], 5 );
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
    	// Register widget scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'plugin_styles' ] );
 
        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	
        // Register dynamic tags
        add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'register_tags' ] );

        // Register conditions
        add_action( 'elementor/theme/register_conditions', [ $this, 'register_conditions' ] , 11);

        // Register theme location for MyListing Preview Card
        add_action( 'elementor/theme/register_locations', [ $this, 'register_theme_locations'] );

        // Register skins for post and archive post widget
        add_action('elementor/widget/posts/skins_init', [ $this, 'register_skins_posts'], 10, 1);
        add_action('elementor/widget/archive-posts/skins_init', [ $this, 'register_skins_archive_posts'], 10, 1);

        // Fix comment form
        add_filter( 'comments_template', [ $this, 'fix_comments_allowed'] );

        // Fix MyListing listing submission preview
        add_filter('mylisting/submission-steps', [$this, 'override_preview_step']);

        // Add Elementor Template to preview card options.
        add_filter( 'mylisting/type-editor/preview-card-templates', [$this, 'preview_card_templates']);

        // Add Elementor Template to quick view options.
        add_filter( 'mylisting/type-editor/quick-view-templates', [$this, 'quick_view_templates']);

        // Output Elementor Template
        add_action( 'mylisting/preview-card-template:mlt-elementor' , [$this, 'add_preview_card_output'], 10, 3);

        // Output Elementor Template
        add_action( 'mylisting/quick-view-template:mlt-elementor' , [$this, 'add_quick_view_output'], 10, 3);
        add_action( 'mylisting/quick-view-template:default' , [$this, 'add_quick_view_output'], 10, 3);
        add_action( 'mylisting/quick-view-template:alternate' , [$this, 'add_quick_view_output'], 10, 3);


        add_action( 'init', [$this, 'elementor_taxonomy_page'], 4);
        add_action( 'init', [$this, 'elementor_bookmarks_page'], 11);

        if ( is_admin() && defined('CASE27_THEME_VERSION') && \version_compare(CASE27_THEME_VERSION, '2.6', '<')) {
            require_once( __DIR__ . '/includes/plugin-setup.php' );

            // Init Setup
            new Plugin_Setup();
        }

        // Temporary schema fix
        add_action( 'wp_head', [$this, 'add_post_id_author_id'] );

    }
}
 
// Instantiate Plugin Class
Plugin::instance();