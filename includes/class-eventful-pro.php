<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://https://themeatelier.net
 * @since      1.0.0
 *
 * @package    Eventful
 * @subpackage Eventful/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Eventful
 * @subpackage Eventful/includes
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */
class Eventful
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Eventful_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name = EVENTFUL_BASENAME;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		$this->define_constants();
		$this->load_dependencies();
		$this->define_common_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->set_locale();
	}

	/**
	 * Define constant if not already set
	 *
	 * @since 2.2.0
	 *
	 * @param string      $name Define constant.
	 * @param string|bool $value Define constant.
	 */
	public function define($name, $value)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}

	/**
	 * Define constants
	 *
	 * @since 2.2.0
	 */
	public function define_constants()
	{
		$this->define('EFP_VERSION', $this->version);
		$this->define('EFP_PLUGIN_NAME', $this->plugin_name);
		$this->define('EFP_PATH', plugin_dir_path(dirname(__FILE__)));
		$this->define('EFP_TEMPLATE_PATH', plugin_dir_path(dirname(__FILE__)) . 'public/templates/');
		$this->define('EFP_URL', plugin_dir_url(dirname(__FILE__)));
		$this->define('EVENTFUL_BASENAME', EVENTFUL_BASENAME);
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Eventful_Loader. Orchestrates the hooks of the plugin.
	 * - Eventful_i18n. Defines internationalization functionality.
	 * - Eventful_Admin. Defines all hooks for the admin area.
	 * - Eventful_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once EFP_PATH . 'includes/class-eventful-pro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once EFP_PATH . 'includes/class-eventful-pro-post-types.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once EFP_PATH . 'includes/class-eventful-pro-i18n.php';

		require_once EFP_PATH . 'admin/views/ta-framework/classes/setup.class.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once EFP_PATH . 'admin/class-eventful-pro-admin.php';

		/**
		 * The class responsible for defining metabox config that occur in the admin area.
		 */
		require_once EFP_PATH . 'admin/helpers/class-eventful-pro-image-resizer.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once EFP_PATH . 'public/class-eventful-pro-public.php';

		$this->loader = new Eventful_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Eventful_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Eventful_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register common hooks.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function define_common_hooks()
	{
		$common_hooks = new Eventful_Post_Type(EFP_PLUGIN_NAME, EFP_VERSION);
		$this->loader->add_action('init', $common_hooks, 'register_eventful_post_type', 10);
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Eventful_Admin(EFP_PLUGIN_NAME, EFP_VERSION);

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		$this->loader->add_filter('manage_eventful_posts_columns', $plugin_admin, 'filter_eventful_admin_column');
		$this->loader->add_action('manage_eventful_posts_custom_column', $plugin_admin, 'display_eventful_admin_fields', 10, 2);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Eventful_Public(EFP_PLUGIN_NAME, EFP_VERSION);

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Eventful_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
