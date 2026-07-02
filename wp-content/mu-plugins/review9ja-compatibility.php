<?php
/**
 * Plugin Name: Review9ja Compatibility Fixes
 * Description: Suppresses known third-party debug notices that are harmless on newer WordPress/PHP versions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'doing_it_wrong_trigger_error', function( $trigger, $function_name, $message, $version ) {
	if ( $function_name !== '_load_textdomain_just_in_time' ) {
		return $trigger;
	}

	return false;
}, 10, 4 );
