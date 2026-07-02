<?php
/**
 * Template for rendering a `upcoming-dates` block in single listing page.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

if ( empty( $dates ) ) {
	return;
} ?>

<ul class="event-dates-timeline">
	<?php foreach ( $dates as $date ): ?>
		<li class="upcoming-event-date">
			<i class="fa fa-calendar-alt"></i>
			<span>
				<?php echo \MyListing\Src\Recurring_Dates\display_instance( $date ) ?>
			</span>

			<?php if ( $settings['show_add_to_gcal'] ): ?>
				<a class="add-to-google-cal" target="_blank" rel="nofollow" href="<?php echo esc_url( $date['gcal_link'] ) ?>">
					<i class="fab fa-google"></i>
					<?php _e( 'Add to Google Calendar', 'my-listing' ) ?>
				</a>
			<?php endif ?>
		</li>
	<?php endforeach ?>
</ul>