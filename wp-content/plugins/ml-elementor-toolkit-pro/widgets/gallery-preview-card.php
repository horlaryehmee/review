<?php

namespace ML_Elementor_Toolkit_Pro\Widgets;

use Elementor\Core\Schemes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \ML_Elementor_Toolkit\DynamicTags\Module as DynamicTagsModule;


if (!defined('ABSPATH')) {
    exit; // Exit if aaccessed directly.
}

/**
 * Verified badge widget.
 */
class Gallery_Preview_Card extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve icon widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'mlt-gallery-preview-card';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Toolkit > Gallery (Preview Card)', 'ml-elementor-toolkit-pro');
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fas fa-image';
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
    public function get_categories()
    {
        return ['ml-elementor-toolkit'];
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
    public function get_keywords()
    {
        return ['gallery', 'carousel', 'grid', 'mylisting'];
    }

    /**
     * Register icon widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ml-elementor-toolkit-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $control_options = [
            'label' => __('Gallery field', 'elementor-pro'),
            'type' => Controls_Manager::SELECT,
        ];

        $listing = \MyListing\Src\Listing::get(get_the_ID());
        if ($listing && $listing->type) {
            $control_options['options'] = DynamicTagsModule::get_ml_fields_options(['file']);
        } else {
            $control_options['groups'] = DynamicTagsModule::get_ml_fields_groups(['file']);
        }

        $this->add_control(
            'key',
            $control_options
        );

        $this->add_control(
			'gallery_count',
			[
				'label' => __( 'Gallery count', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'dynamic' => [
					'active' => true,
				],
				'default' => 3,
				'step'  => 1,
                'min'   => 2,
                'max'   => 25,
			]
		);

        $this->add_control(
			'navigation_opacity',
			[
				'label' => __( 'Navigation opacity', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
                'default' => [
                    'size'  => 0
                ],
				'selectors' => [
					'{{WRAPPER}} .gallery-nav' => 'opacity: {{SIZE}};',
					'{{WRAPPER}}:hover .gallery-nav' => 'opacity: 1;',
				],
			]
		);
    }

    /**
     * Render icon widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $listing = \MyListing\Src\Listing::get(get_the_ID());

        if (!$listing || !$listing->type) {
            return;
        }

        $gallery = $listing->get_field($settings['key']);

?>
        <div class="owl-carousel lf-background-carousel">
            <?php foreach (array_slice($gallery, 0, $settings['gallery_count']) as $gallery_image) : ?>
                <div class="item">
                    <div class="lf-background" style="background-image: url('<?php echo esc_url(c27()->get_resized_image($gallery_image, $bg_size)) ?>');"></div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="gallery-nav">
            <ul>
                <li><a href="#" class="mlt-carousel-prev-btn"><i class="mi keyboard_arrow_left"></i></a></li>
                <li><a href="#" class="mlt-carousel-next-btn"><i class="mi keyboard_arrow_right"></i></a></li>
            </ul>
        </div>
<?php
    }
}
