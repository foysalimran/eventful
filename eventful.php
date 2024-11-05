<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeatelier.net
 * @since             1.0.0
 * @package           Eventful
 *
 * @wordpress-plugin
 * Plugin Name:       Eventful
 * Plugin URI:        https://wp-plugins.themeatelier.net/eventful
 * Description:       Professional Event Post Layouts Addon For WordPress
 * Version:           1.0.5
 * Author:            ThemeAtelier
 * Author URI:        https://themeatelier.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eventful
 * Domain Path:       /languages
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require __DIR__ . '/vendor/autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EFUL_VERSION', '1.0.5' );
define('EFUL_BASENAME', plugin_basename(__FILE__));
define('EFUL_DIR_PATH', plugin_dir_path(__FILE__));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-eventful-activator.php
 */
function eful_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-eventful-activator.php';
	Eventful_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-eventful-deactivator.php
 */
function eful_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-eventful-deactivator.php';
	Eventful_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'eful_activate' );
register_deactivation_hook( __FILE__, 'eful_deactivate' );

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
function eful_run() {
	$plugin = new Eventful();
	$plugin->run();
}
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( ! ( is_plugin_active( 'eventful-pro/eventful-pro.php' ) || is_plugin_active_for_network( 'eventful-pro/eventful-pro.php' ) ) ) {
	eful_run();
}


// Appsero init

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_eventful()
{
	if (!class_exists('EventfulAppSero\Insights')) {
		require_once  EFUL_DIR_PATH . 'admin/appsero/Client.php';
	}
	$client = new EventfulAppSero\Client('82e15bff-56c3-4809-bee3-51d69e047387', 'Eventful - Events Showcase For The Events Calendar', __FILE__);
	// Active insights
	$client->insights()->init();
}

appsero_init_tracker_eventful();