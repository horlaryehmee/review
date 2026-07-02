<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Edit_Link extends Tag {

    /**
    * Get Name
    *
    * Returns the Name of the tag
    *
    * @since 1.0.0
    * @access public
    *
    * @return string
    */
    public function get_name() {
        return 'mlt-edit-link';
    }

    /**
    * Get Title
    *
    * Returns the title of the Tag
    *
    * @since 1.0.0
    * @access public
    *
    * @return string
    */
    public function get_title() {
        return __( 'Listing Edit Link', 'ml-elementor-toolkit-pro' );
    }
   
    /**
    * Get Group
    *
    * Returns the Group of the tag
    *
    * @since 1.0.0
    * @access public
    *
    * @return string
    */
    public function get_group() {
        return Module::ML_GROUP;
    }

    /**
    * Get Categories
    *
    * Returns an array of tag categories
    *
    * @since 1.0.0
    * @access public
    *
    * @return array
    */
    public function get_categories() {
        return [ 
			Module::URL_CATEGORY,
		];
    }

    public function render() {
        $listing = \MyListing\Src\Listing::get( get_the_ID() );

        if (!$listing || !$listing->type) {
            return;
        }

        if ( $listing->editable_by_current_user() && function_exists( 'wc_get_account_endpoint_url' ) ) {
            $edit_link = add_query_arg( [
                'action' => 'edit',
                'job_id' => $listing->get_id(),
            ], wc_get_account_endpoint_url( 'my-listings' ) );
            echo $edit_link;
        }
    }
}

