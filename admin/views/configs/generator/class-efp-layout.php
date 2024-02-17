<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The Layout building class.
 */
class EFP_Layout
{

	/**
	 * Layout metabox section.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section($prefix)
	{
		EFP::createSection(
			$prefix,
			array(
				'fields' => array(
					array(
						'type'  => 'metabox_branding',
						'image' => EFP_URL . 'admin/assets/img/eventful-logo.svg',
						'after' => '<i class="fas fa-life-ring"></i> Support',
						'link'  => 'https://themeatelier.net/',
						'class' => 'efp-admin-header',
					),
					array(
						'id'      => 'efp_layout_preset',
						'type'    => 'layout_preset',
						'title'   => esc_html__('Layout Preset', 'eventful-pro'),
						'class'   => 'efp-layout-preset',
						'options' => array(
							'grid_layout'      => array(
								'image' => EFP_URL . 'admin/assets/img/grid.png',
								'text'  => esc_html__('Grid', 'eventful-pro'),
							),
							'carousel_layout'  => array(
								'image' => EFP_URL . 'admin/assets/img/carousel.png',
								'text'  => esc_html__('Carousel', 'eventful-pro'),
							),
						),
						'default' => 'grid_layout',
					),
				), // End of fields array.
			)
		);
	}
}
