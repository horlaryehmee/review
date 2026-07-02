<?php
namespace ML_Elementor_Toolkit_Pro\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Utils;
use ML_Elementor_Toolkit\DynamicTags\Module;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Social_Networks extends Tag {

	/**
	* Get Name
	*
	* Returns the Name of the tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
    public function get_name() {
        return 'mlt-social-networks';
    }

    /**
    * Get Title
    *
    * Returns the title of the Tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return string
    */
    public function get_title() {
        return __( 'Social Networks', 'ml-elementor-toolkit-pro' );
    }
   
    /**
    * Get Group
    *
    * Returns the Group of the tag
    *
    * @since 2.0.0
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
    * @since 2.0.0
    * @access public
    *
    * @return array
    */
    public function get_categories() {
        return [ 
			Module::TEXT_CATEGORY,
		];
    }

    /**
    * Register Controls
    *
    * Registers the Dynamic tag controls
    *
    * @since 2.0.0
    * @access protected
    *
    * @return void
    */
    protected function _register_controls() {
        $this->add_control(
			'source',
			[
				'label' => __( 'Icons source', 'ml-elementor-toolkit-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'listing',
				'options' => [
					'listing'  	=> __( 'Listing', 'ml-elementor-toolkit-pro' ),
					'author' 	=> __( 'Author', 'ml-elementor-toolkit-pro' ),
				],
			]
		);
    }

    /**
    * Render
    *
    * Prints out the value of the Dynamic tag
    *
    * @since 2.0.0
    * @access public
    *
    * @return void
    */
    public function render() {
        $listing = \MyListing\Src\Listing::get( get_the_ID() );

        if (!$listing || !$listing->type) {
            return;
        }

        if($this->get_settings('source') == 'author'){
			$author = $listing->get_author();
			if ( ! ( $author instanceof \MyListing\Src\User && $author->exists() ) ) {
				return;
			}

			$networks = $author->get_social_links();
		} else{
			$networks = $listing->get_social_networks();
		}
		if ( empty( $networks ) ) {
			return;
		}
        
        $networks = array_map(function($network){
            return $network['name'];
        }, $networks);

        echo \implode(", ", $networks);


    }

}

