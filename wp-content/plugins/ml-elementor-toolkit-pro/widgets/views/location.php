<?php
/**
 * Template for rendering a `location` block in single listing page.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

use Elementor\Icons_Manager;

// get the field instance
$field = $listing->get_field_object( $settings['key'] );
if ( ! ( $field && $field->get_value() ) ) {
	return;
}

// use the listing logo for the marker image, with fallback to a marker icon
if ( ! ( $marker_image = $listing->get_logo( 'thumbnail' ) ) ) {
    $marker_image = c27()->image( 'marker.jpg' );
}

// use the listing address to display the marker, which would then get geocoded by the map service
$location_arr = [
    'address' => $field->get_value(),
    'marker_image' => [ 'url' => $marker_image ],
];

// if we're displaying the location field, we can directly retrieve the coordinates from database
if ( $settings['key'] === 'job_location' && ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) {
    $location_arr = [
        'marker_lat' => $lat,
        'marker_lng' => $lng,
        'marker_image' => [ 'url' => $marker_image ],
    ];
}

$mapargs = [
	'items_type' => 'custom-locations',
	'marker_type' => 'basic',
	'locations' => [ $location_arr ],
	'skin' => $settings['map_skin'],
	'zoom' => $settings['zoom'],
	'draggable' => true,
];
?>
	<div class="c27-map map" data-options="<?php echo c27()->encode_attr( $mapargs ) ?>"></div>
