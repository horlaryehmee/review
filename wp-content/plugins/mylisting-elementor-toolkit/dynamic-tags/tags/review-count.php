<?php
namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Core\DynamicTags\Tag;
use ML_Elementor_Toolkit\DynamicTags\Module;
use \MyListing\Ext\Reviews\Reviews;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Review_Count extends Tag {
	public function get_name() {
		return 'yw-my-listing-review-count';
	}

	public function get_title() {
		return __( 'Number of reviews', 'elementor-pro' );
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
		echo get_post_meta(get_the_ID(), '_case27_review_count', true);
	}
}
