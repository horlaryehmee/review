<?php

namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Table_Block extends \Elementor\Widget_Base {

	public function get_name() {
		return 'mlt-table-block-widget';
	}

	public function get_title() {
		return __( 'Toolkit > Table Block', 'my-listing' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_block',
			[
				'label' => esc_html__( 'Content', 'my-listing' ),
			]
		);

		$this->add_control(
			'the_rows',
			[
				'label' => __( 'Table Rows', 'my-listing' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'title',
						'label' => __( 'Row Title', 'my-listing' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '',
						'dynamic' => [
							'active' => true,
						],
					],
					[
						'name' => 'content',
						'label' => __( 'Content', 'my-listing' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '',
						'dynamic' => [
							'active' => true,
						],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_heading_style',
			[
				'label' => __( 'Table Heading', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extra-details .item-attr' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_2,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_text_typography',
				'selector' => '{{WRAPPER}} .extra-details .item-attr',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_property_style',
			[
				'label' => __( 'Table Values', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'property_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extra-details .item-property' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_2,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'property_text_typography',
				'selector' => '{{WRAPPER}} .extra-details .item-property',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		 <ul class="extra-details">

			<?php foreach ( $settings['the_rows'] as $index => $row): 
				if(empty($row['content'])){
					continue;
				}
				?>
				<li>
					<div class="item-attr"><?php echo $row['title'] ?></div>
					<div class="item-property"><?php echo $row['content'] ?></div>
				</li>
			<?php endforeach ?>

			</ul>
		<?php
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}
