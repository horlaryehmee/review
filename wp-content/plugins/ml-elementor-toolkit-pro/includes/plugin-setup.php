<?php
namespace ML_Elementor_Toolkit_Pro;

// This code is based on CX DB updater

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly
 
class Plugin_Setup {

    private $nonce_action = 'ml-toolkit-pro-setup-nonce';

    private $min_plugin_version = '1.0.9';
    private $min_theme_version = '2.4.5';

    /**
     * Constructor for the plugin setup
     * adds the required notices and actions
     */
    public function __construct() {

        // Check for location & capabilities
        if ( ! is_admin() || ! current_user_can( 'update_plugins' ) ) {
            return;
        }
        
        // Add rerun setup in plugin actions
        add_filter( 'plugin_action_links_' . 'ml-elementor-toolkit-pro/ml-elementor-toolkit-pro.php', [ $this, 'plugin_action_setup' ] );

        add_action( 'admin_notices', array( $this, 'init_notices' ) );
        add_action( 'admin_init',    array( $this, 'do_update' ) );
    }

    public function plugin_action_setup( $links ) {

        $format = '<a href="%1s">%2$s</a>';
        $label  = 'Re-run setup wizard';
        $url    = add_query_arg(
            array(
                'ml-toolkit-pro-setup' => true,
                '_nonce'               => wp_create_nonce('ml-toolkit-pro-setup-nonce'),
            ),
            esc_url( admin_url( 'plugins.php' ) )
        );

        $setup_link = sprintf( $format, $url, $label );

        $links = array_merge( array(
            $setup_link
        ), $links );
    
        return $links;
    
    }

    public function init_notices() {
        if ( $this->is_update_required() ) {
            $this->show_notice();
        }

        if ( $this->is_updated() ) {
            $this->show_updated_notice();
        }
    }

    /**
     * Process DB update.
     *
     * @since 1.0.0
     */
    public function do_update() {
        if ( ! $this->is_current_update() ) {
            return;
        }

        $theme_root = get_theme_root();
        // error_log($theme_root);
        if(!file_exists($theme_root . '/my-listing-child')){
            $src = plugin_dir_path( dirname(__FILE__) ) . 'assets/my-listing-child';
            $dest = $theme_root . '/my-listing-child';
            self::copy_dir($src, $dest);
        }
        else{
            $src = plugin_dir_path( dirname(__FILE__) ) . 'assets/my-listing-child/partials';
            $dest = $theme_root . '/my-listing-child/partials';
            self::copy_dir($src, $dest);
            $src = plugin_dir_path( dirname(__FILE__) ) . 'assets/my-listing-child/templates';
            $dest = $theme_root . '/my-listing-child/templates';
            self::copy_dir($src, $dest);
        }

        $this->set_updated();
    }

    /**
     * Finalize update.
     *
     * @since 1.0.0
     */
    public function set_updated() {
        $this->updated = true;
        $plugin_version = \ML_Elementor_Toolkit_Pro::VERSION;
        update_option( 'ml-toolkit-pro-file-version', $plugin_version );
    }

    /**
     * Check if we processed update for plugin passed in arguments.
     *
     * @since 1.0.0
     * @return bool
     */
    private function is_current_update() {
        if ( empty( $_GET['ml-toolkit-pro-setup'] ) || empty( $_GET['_nonce'] ) ) {
            return false;
        }

        if ( ! wp_verify_nonce( $_GET['_nonce'], $this->nonce_action ) ) {
            return false;
        }

        return true;
    }

    public function show_notice() {
        ?>
        <div class="notice notice-error">
            <h3>MyListing Elementor Toolkit</h3>
            <p>The <b>preview card</b> &amp; <b>quick view</b> locations won't work unless you copy some files to your child theme.</p>
            <p>To be more precise, this wizard will copy to your child theme the following files:</p>
            <p><em>partials/listing-preview.php</em> and <em>partials/listing-quick-view.php</em></p>
            <p>If you don't have a child theme, we will add that for you.</p>
            <p>After this wizard has completed, you need to activate the MyListing Child Theme yourself.</p>
            <p>
                <?php 
                $format = '<a href="%1s" class="button button-primary">%2$s</a>';
                $label  = 'Start setup wizard';
                $url    = add_query_arg(
                        array(
                            'ml-toolkit-pro-setup' => true,
                        '_nonce'                   => $this->create_nonce(),
                        ),
                        esc_url( admin_url( 'index.php' ) )
                    );

                printf( $format, $url, $label ); ?>
            </p>
        </div>
        <?php
    }

    /**
     * Show update notice.
     *
     * @since 1.0.0
     * @return void
     */
    private function show_updated_notice() {
        $current_theme = wp_get_theme();
        $child_theme_active = $current_theme->get( 'TextDomain' ) == 'my-listing-child';
        ?>
        <div class="notice notice-success is-dismissible">
        <h3>MyListing Elementor Toolkit Setup Wizard</h3>
            <p>
                The setup ran succesfully. You are good to go now!
            </p>
            <?php
                if(!$child_theme_active){
                    echo '<p>You still need to activate the MyListing Child Theme</p><p>';
                    $format = '<a href="%1s" class="">%2$s</a>';
                    $label  = 'Go to Appearance - Themes to activate.';
                    $url    = admin_url( 'themes.php' );
                    printf( $format, $url, $label ); 
                    echo '</p>';
                }
            ?>
        </div>
        <?php
    }

    /**
     * Check if database requires update.
     *
     * @since 1.0.0
     * @return bool
     */
    private function is_update_required() {
        $latest_plugin_version = get_option( 'ml-toolkit-pro-file-version' );
        $theme_version = wp_get_theme( get_template() )->get('Version');
        if(version_compare( $theme_version, $this->min_theme_version, '>=' )){
            if (!$latest_plugin_version) {
                return true;
            }

            return version_compare( $latest_plugin_version, $this->min_plugin_version, '<' );
        }
        return false;
    }

    /**
     * Check if update was successfully done.
     *
     * @since 1.0.0
     * @return bool
     */
    private function is_updated() {
        if ( ! $this->is_current_update() ) {
            return false;
        }

        return (bool) $this->updated;
    }

    /**
     * Create DB update nonce.
     *
     * @since  1.0.0
     * @param  string $slug Plugin slug.
     * @return string
     */
    private function create_nonce( ) {
        return wp_create_nonce( $this->nonce_action );
    }

    public static function copy_dir($src, $dst) {  
  
        // open the source directory 
        $dir = opendir($src);  
        
        // Make the destination directory if not exist 
        @mkdir($dst);  
        
        // Loop through the files in source directory 
        while( $file = readdir($dir) ) {  
        
            if (( $file != '.' ) && ( $file != '..' )) {  
                if ( is_dir($src . '/' . $file) )  
                {  
        
                    // Recursively calling custom copy function 
                    // for sub directory  
                    self::copy_dir($src . '/' . $file, $dst . '/' . $file);  
        
                }  
                else {  
                    copy($src . '/' . $file, $dst . '/' . $file);  
                }  
            }  
        }  
        
        closedir($dir); 
    }  


}