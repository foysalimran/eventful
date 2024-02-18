<?php
/**
 * The main class for Settings configurations.
 *
 * @package Eventful
 * @subpackage Eventful/admin/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access pages directly.

/**
 * Settings.
 */
class EFP_Settings {

	/**
	 * Create a settings page.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function settings( $prefix ) {

		$capability = eventful_dashboard_capability(); // TODO: filter is not working.

		EFP::createOptions(
			$prefix,
			array(
				'menu_title'       => esc_html__( 'Settings', 'eventful' ),
				'menu_parent'      => 'edit.php?post_type=eventful',
				'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
				'menu_slug'        => 'eventful_settings',
				'theme'            => 'light',
				'show_all_options' => false,
				'show_search'      => false,
				'show_footer'      => false,
				'show_bar_menu'           => false,
				'class'            => 'ta-pc-settings',
				'framework_title'  => esc_html__( 'Eventful', 'eventful' ),
				'menu_capability'  => $capability,
			)
		);
		EFP_ScriptsAndStyles::section( $prefix );
		EFP_Accessibility::section( $prefix );
		EFP_CustomCSS::section( $prefix );
	}

}
