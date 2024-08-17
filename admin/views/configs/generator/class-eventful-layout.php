<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The Layout building class.
 */
class EFUL_Layout
{

	/**
	 * Layout metabox section.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section($prefix)
	{
		EFUL::createSection(
			$prefix,
			array(
				'fields' => array(
					array(
						'type'  => 'metabox_branding',
						'image' => EFUL_URL . 'admin/assets/img/eventful-logo.svg',
						'after' => '<i class="fas fa-life-ring"></i> Support',
						'link'  => 'https://themeatelier.net/',
						'class' => 'eventful-admin-header',
					),
					array(
						'id'      => 'eful_layout_preset',
						'type'    => 'layout_preset',
						'title'   => esc_html__('Layout Preset', 'eventful'),
						'class'   => 'eventful-layout-preset',
						'options' => array(
							'grid_layout'      => array(
								'image' => EFUL_URL . 'admin/assets/img/grid.png',
								'text'  => esc_html__('Grid', 'eventful'),
							),
							'carousel_layout'  => array(
								'image' => EFUL_URL . 'admin/assets/img/carousel.png',
								'text'  => esc_html__('Carousel', 'eventful'),
							),
						),
						'default' => 'grid_layout',
					),
				), // End of fields array.
			)
		);
	}
}
