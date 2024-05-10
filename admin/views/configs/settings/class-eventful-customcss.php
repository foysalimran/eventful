<?php if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

class EFUL_CustomCSS {

	/**
	 * Custom CSS & JS settings.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFUL::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Custom CSS & JS', 'eventful' ),
				'icon'   => 'fas fa-css3',
				'fields' => array(
					array(
						'id'       => 'eful_custom_css',
						'type'     => 'code_editor',
						'title'    => esc_html__( 'Custom CSS', 'eventful' ),
						'settings' => array(
							'icon'  => 'fas fa-sliders',
							'theme' => 'mbo',
							'mode'  => 'css',
						),
					),
					array(
						'id'       => 'eful_custom_js',
						'type'     => 'code_editor',
						'title'    => esc_html__( 'Custom JS', 'eventful' ),
						'settings' => array(
							'icon'  => 'fas fa-sliders',
							'theme' => 'monokai',
							'mode'  => 'javascript',
						),
					),
				),
			)
		);
	}
}
