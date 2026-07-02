<?php
namespace ML_Elementor_Toolkit_Pro\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class Upcoming_Dates extends Widget_Base {

	/**
	 * Listing object which this block belongs to.
	 *
	 * @since 1.0
	 */
	public $listing;

	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'upcoming-dates';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Upcoming Dates', 'ml-elementor-toolkit-pro' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'far fa-calendar-alt';
	}

     /**
     * Get widget categories.
     *
     * Retrieve the list of categories the icon widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'ml-elementor-toolkit' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'upcoming dates', 'mylisting', 'my listing' ];
	}

	/**
	 * Register icon list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ml-elementor-toolkit-pro' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$key_control_options = [
			'label' => __( 'Key', 'elementor-pro' ),
			'type' => Controls_Manager::SELECT,
		];

		$listing = \MyListing\Src\Listing::get( get_the_ID() );
        if ( $listing && $listing->type) {
			$key_control_options['options'] = DynamicTagsModule::get_ml_fields_options( ['recurring-date'] );
		} else{
			$key_control_options['groups'] = DynamicTagsModule::get_ml_fields_groups( ['recurring-date'] );
		}

		$this->add_control(
			'key',
			$key_control_options
		);

		$this->add_control(
			'count',
			[
				'label' => __( 'Count', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'show_add_to_gcal',
			[
				'label' => __( 'Show Add to Google Calendar', 'ml-elementor-toolkit-pro' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ml-elementor-toolkit-pro' ),
				'label_off' => __( 'Hide', 'ml-elementor-toolkit-pro' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$listing = \MyListing\Src\Listing::get( get_the_ID() );

		if ( !$listing || !$listing->type ) {
			return;
		}

		$this->listing = $listing; 

		$dates = $this->get_dates();

        require __DIR__ . '/views/upcoming-dates.php';
	}

	public function get_dates() {
		$settings = $this->get_settings_for_display();

		$dates = [];
		$field = $this->listing->get_field_object( $settings['key'] );
		if ( ! $field ) {
			return $dates;
		}

		if ( $field->get_type() === 'date' ) {
			$date = $field->get_value();
			if ( ! empty( $date ) && strtotime( $date ) ) {
				$dates[] = [
					'start' => $date,
					'end' => '',
					'gcal_link' => $this->get_google_calendar_link( $date ),
				];
			}
		}

		if ( $field->get_type() === 'recurring-date' ) {
			$dates = \MyListing\Src\Recurring_Dates\get_upcoming_instances(
				$field->get_value(),
				$count = $settings['count']
			);

			foreach ( $dates as $key => $date ) {
				$dates[$key]['gcal_link'] = $this->get_google_calendar_link( $date['start'], $date['end'] );
			}
		}

		return $dates;
	}

	public function get_google_calendar_link( $start_date, $end_date = '' ) {
		// &dates=20170101T180000Z/20170101T190000Z
		$template = 'https://calendar.google.com/calendar/render?action=TEMPLATE&';
		$template .= 'text={title}&dates={dates}&details={description}&location={location}&trp=true&ctz={timezone}';

		// generate a description
		if ( $tagline = $this->listing->get_field( 'tagline' ) ) {
			$description = wp_kses( $tagline, [] );
		} else {
			$description = wp_kses( $this->listing->get_field( 'description' ), [] );
			$description = mb_strimwidth( $description, 0, 150, '...' );
		}

		if ( ! empty( $description ) ) {
			$description .= ' ';
		}

		// append listing link to the description
		$description .= $this->listing->get_link();

		// generate date string
		$dates = date( 'Ymd\THis', strtotime( $start_date ) );
		if ( ! empty( $end_date ) ) {
			$dates .= date( '/Ymd\THis', strtotime( $end_date ) );
		} else {
			// if no end date, just duplicate the start date as the link
			// doesn't work with just a start date
			$dates .= date( '/Ymd\THis', strtotime( $start_date ) );
		}

		$values = [
			'{title}' => $this->listing->get_title(),
			'{description}' => $description,
			'{location}' => $this->listing->get_field('location'),
			'{dates}' => $dates,
			'{timezone}' => c27()->get_timezone_string(),
		];

		return str_replace( array_keys( $values ), array_values( $values ), $template );
	}
}
