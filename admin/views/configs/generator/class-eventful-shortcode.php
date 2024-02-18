<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The Shortcode display class.
 */
class EFUL_Shortcode
{

	/**
	 * Shortcode display metabox section.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section($prefix)
	{
		if (isset($_GET['post'])) {
			EFUL::createSection(
				$prefix,
				array(
					'fields' => array(
						array(
							'type'  => 'shortcode',
							'class' => 'eventful-admin-sidebar',
						),
					),
				)
			);
		}
	}
}
