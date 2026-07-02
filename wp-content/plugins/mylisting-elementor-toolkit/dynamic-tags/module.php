<?php

namespace ML_Elementor_Toolkit\DynamicTags;

use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Module extends \Elementor\Modules\DynamicTags\Module
{

	const ML_GROUP = 'my-listing';

	/**
	 * @param array $types
	 *
	 * @return array
	 */
	public static function get_ml_fields_options($field_types = [], $fields = false)
	{
		if (!$fields) {
			$listing = \MyListing\Src\Listing::get(get_the_ID());
			if ($listing && $listing->type) {
				$fields = $listing->get_fields();
			} else {
				return [];
			}
		}

		$option_fields = [];

		if (!is_array($fields)) return;
		foreach ($fields as $key => $value) {
			if ($value && (empty($field_types) || in_array($value->get_type(), $field_types))) {
				$option_fields[$key] = $value->get_label() . ' (' . $key . ' - ' . $value->get_type() . ')';
			}
		}
		return $option_fields;
	}

	/**
	 * @param array $types
	 *
	 * @return array
	 */
	public static function get_ml_fields_groups($field_types = [])
	{
		$groups = [];
		$types = get_posts([
			'post_type' => 'case27_listing_type',
			'fields' => 'ids',
			'posts_per_page' => 50,
		]);
		foreach ($types as $type_id) {

			$type = \MyListing\Src\Listing_Type::get($type_id);
			if (! $type) {
				continue;
			}
			// error_log(print_r($type->get_fields(),true));

			$groups[] = [
				'label' => $type->get_name(),
				'options' => self::get_ml_fields_options($field_types, $type->get_fields()),
			];
		}

		return $groups;
	}

	public static function add_key_control($tag)
	{
		$control_options = [
			'label' => __('Key', 'elementor-pro'),
			'type' => Controls_Manager::SELECT,
		];

		$listing = \MyListing\Src\Listing::get(get_the_ID());
		if ($listing && $listing->type) {
			$control_options['options'] = self::get_ml_fields_options($tag->get_supported_fields());
		} else {
			$control_options['groups'] = self::get_ml_fields_groups($tag->get_supported_fields());
		}

		$tag->add_control(
			'key',
			$control_options
		);
	}

	public function get_groups()
	{
		return [
			self::ML_GROUP => [
				'title' => __('My Listing', 'elementor-pro'),
			],
		];
	}
}
