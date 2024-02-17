<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The Shortcode display class.
 */
class EFP_Shortcode
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
			EFP::createSection(
				$prefix,
				array(
					'fields' => array(
						array(
							'type'  => 'shortcode',
							'class' => 'efp-admin-sidebar',
						),
					),
				)
			);
		}
	}
}
