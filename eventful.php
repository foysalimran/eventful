<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://https://themeatelier.net
 * @since             1.0.0
 * @package           Eventful
 *
 * @wordpress-plugin
 * Plugin Name:       Eventful
 * Plugin URI:        https://https://wp-plugins.themeatelier.net/eventful
 * Description:       Professional Event Post Layouts Addon For WordPress
 * Version:           1.1.0
 * Author:            ThemeAtelier
 * Author URI:        https://https://https://themeatelier.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eventful-pro
 * Domain Path:       /languages
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EVENTFUL_VERSION', '1.0.0' );
define('EVENTFUL_BASENAME', plugin_basename(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-eventful-activator.php
 */
function eventful_pro_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-eventful-activator.php';
	Eventful_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-eventful-deactivator.php
 */
function eventful_pro_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-eventful-deactivator.php';
	Eventful_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'eventful_pro_activate' );
register_deactivation_hook( __FILE__, 'eventful_pro_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-eventful.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function eventful_pro_run() {

	$plugin = new Eventful();
	$plugin->run();

}
eventful_pro_run();
