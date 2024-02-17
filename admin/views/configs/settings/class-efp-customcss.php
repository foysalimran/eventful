<?php if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

class EFP_CustomCSS {

	/**
	 * Custom CSS & JS settings.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFP::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Custom CSS & JS', 'eventful-pro' ),
				'icon'   => 'fas fa-css3',
				'fields' => array(
					array(
						'id'       => 'efp_custom_css',
						'type'     => 'code_editor',
						'title'    => esc_html__( 'Custom CSS', 'eventful-pro' ),
						'settings' => array(
							'icon'  => 'fas fa-sliders',
							'theme' => 'mbo',
							'mode'  => 'css',
						),
					),
					array(
						'id'       => 'efp_custom_js',
						'type'     => 'code_editor',
						'title'    => esc_html__( 'Custom JS', 'eventful-pro' ),
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
