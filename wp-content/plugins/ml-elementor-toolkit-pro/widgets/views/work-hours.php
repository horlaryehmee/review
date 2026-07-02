<?php
/**
 * Template for rendering a `work_hours` block in single listing page.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

use Elementor\Icons_Manager;

// get work hours
$work_hours = $listing->get_field( 'work_hours' ) ;
$schedule = new MyListing\Src\Work_Hours( $work_hours );

// validate
if ( ! $work_hours || $schedule->is_empty() ) {
	return;
}
?>

<div class="work-hours-block">
	<div class="pf-head" data-toggle="collapse" data-target="#<?php echo esc_attr( $this->get_id().'-toggle' ) ?>">
		<div class="title-style-1">
			<?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );  ?> 
			<h5>
				<span class="<?php echo esc_attr( $schedule->get_status() ) ?> work-hours-status">
					<?php echo esc_html( $schedule->get_message() ) ?>
				</span>
			</h5>
			<div class="timing-today">
				<?php echo $schedule->get_todays_schedule() ?>
				<span class="mi expand_more" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Toggle weekly schedule', 'my-listing' ) ?>"></span>
			</div>
		</div>
	</div>
	<div class="open-hours-wrapper pf-body <?php echo $settings['collapse_hours'] == 'yes' ? 'collapse' : ''; ?>" id="<?php echo esc_attr( $this->get_id().'-toggle' ) ?>">
		<div id="open-hours">
			<ul class="extra-details">

				<?php foreach ( $schedule->get_schedule() as $weekday ): ?>
					<li>
						<p class="item-attr"><?php echo esc_html( $weekday['day_l10n'] ) ?></p>
						<p class="item-property"><?php echo $schedule->get_day_schedule( $weekday['day'] ) ?></p>
					</li>
				<?php endforeach ?>

				<?php if ( ! empty( $work_hours['timezone'] ) ):
					$localTime = new DateTime( 'now', new DateTimeZone( $work_hours['timezone'] ) );
					?>
					<p class="work-hours-timezone">
						<em><?php printf(
							__( '%s local time', 'my-listing' ),
							date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
							strtotime( $localTime->format('Y-m-d H:i:s') ) )
						) ?></em>
					</p>
				<?php endif ?>

			</ul>
		</div>
	</div>
</div>
