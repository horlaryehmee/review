<?php
namespace ML_Elementor_Toolkit_Pro\Conditions;

use ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use ElementorPro\Modules\Woocommerce\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Woocommerce_MyAccount extends Condition_Base {

	public static function get_type() {
		return 'singular';
	}

	public function get_name() {
		return 'woocommerce-account';
	}

	public static function get_priority() {
		return 30;
	}

	public function get_label() {
		return esc_html__( 'MyListing Account', 'elementor-pro' );
	}

	public function check( $args ) {
		return is_account_page();
	}
}
