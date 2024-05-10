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
class EFUL_Settings {

	/**
	 * Create a settings page.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function settings( $prefix ) {

		$capability = eful_dashboard_capability(); // TODO: filter is not working.

		EFUL::createOptions(
			$prefix,
			array(
				'menu_title'       => esc_html__( 'Settings', 'eventful' ),
				'menu_parent'      => 'edit.php?post_type=eventful',
				'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
				'menu_slug'        => 'eful_settings',
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
		EFUL_ScriptsAndStyles::section( $prefix );
		EFUL_Accessibility::section( $prefix );
		EFUL_CustomCSS::section( $prefix );
	}

}
