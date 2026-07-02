<?php
namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Core\DynamicTags\Tag;
use ML_Elementor_Toolkit\DynamicTags\Module;
use \MyListing\Ext\Reviews\Reviews;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Rating extends Tag {
	public function get_name() {
		return 'yw-my-listing-rating';
	}

	public function get_title() {
		return __( 'Rating', 'elementor-pro' );
	}

	public function get_group() {
		return Module::ML_GROUP;
	}

	public function get_categories() {
		return [
			Module::TEXT_CATEGORY,
			Module::NUMBER_CATEGORY,
		];
	}

	public function render() {
		$rating = Reviews::get_listing_rating_optimized( get_the_ID() );
		$max_rating = $max_rating = Reviews::max_rating( get_the_ID() );
		echo empty($rating) ? 0 : round($rating * (5 / $max_rating) , 1);
	}
}
