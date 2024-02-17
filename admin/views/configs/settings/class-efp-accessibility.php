<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The accessibility setting class.
 */
class EFP_Accessibility
{

	/**
	 * Accessibility setting section.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function section($prefix)
	{
		EFP::createSection(
			$prefix,
			array(
				'title'  => esc_html__('Accessibility', 'eventful-pro'),
				'icon'   => 'fas fa-braille',
				'fields' => array(
					array(
						'id'         => 'accessibility',
						'type'       => 'switcher',
						'title'      => esc_html__('Carousel Accessibility', 'eventful-pro'),
						'text_on'    => esc_html__('Enabled', 'eventful-pro'),
						'text_off'   => esc_html__('Disabled', 'eventful-pro'),
						'text_width' => 100,
						'default'    => true,
					),
					array(
						'id'         => 'prev_slide_message',
						'type'       => 'text',
						'title'      => esc_html__('Previous Slide Message', 'eventful-pro'),
						'default'    => esc_html__('Previous slide', 'eventful-pro'),
						'dependency' => array('accessibility', '==', 'true'),
					),
					array(
						'id'         => 'next_slide_message',
						'type'       => 'text',
						'title'      => esc_html__('Next Slide Message', 'eventful-pro'),
						'default'    => esc_html__('Next slide', 'eventful-pro'),
						'dependency' => array('accessibility', '==', 'true'),
					),
					array(
						'id'         => 'first_slide_message',
						'type'       => 'text',
						'title'      => esc_html__('First Slide Message', 'eventful-pro'),
						'default'    => esc_html__('This is the first slide', 'eventful-pro'),
						'dependency' => array('accessibility', '==', 'true'),
					),
					array(
						'id'         => 'last_slide_message',
						'type'       => 'text',
						'title'      => esc_html__('Last Slide Message', 'eventful-pro'),
						'default'    => esc_html__('This is the last slide', 'eventful-pro'),
						'dependency' => array('accessibility', '==', 'true'),
					),
					array(
						'id'         => 'pagination_bullet_message',
						'type'       => 'text',
						'title'      => esc_html__('Pagination Bullet Message', 'eventful-pro'),
						'default'    => esc_html__('Go to slide {{index}}', 'eventful-pro'),
						'dependency' => array('accessibility', '==', 'true'),
					),
				),
			)
		);
	}
}
