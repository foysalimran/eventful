<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://https://themeatelier.net
 * @since      1.0.0
 *
 * @package    Eventful
 * @subpackage Eventful/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Eventful
 * @subpackage Eventful/admin
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */
class Eventful_Admin
{

	protected $suffix;
	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{
		$this->suffix      = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG || defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Autoload system.
		spl_autoload_register(array($this, 'autoload'));

		EFP_Metaboxes::layout_metabox('ta_efp_layouts');
		EFP_Metaboxes::option_metabox('ta_efp_view_options');
		EFP_Metaboxes::shortcode_metabox('ta_efp_display_shortcode');
		EFP_Settings::settings('ta_eventful_settings');

		$active_plugins = get_option('active_plugins');
		foreach ($active_plugins as $active_plugin) {
			$_temp = strpos($active_plugin, 'eventful-pro.php');
			if (false != $_temp) {
				add_filter('plugin_action_links_' . $active_plugin, array($this, 'add_plugin_action_links'));
			}
		}
	}

	public function add_plugin_action_links($links)
	{
		$new_links = array(
			sprintf('<a href="%s">%s</a>', admin_url('post-new.php?post_type=eventful'), esc_html__('Add New', 'eventful-pro')),
			sprintf('<a href="%s">%s</a>', admin_url('edit.php?post_type=eventful'), esc_html__('Settings', 'eventful-pro')),
		);
		return array_merge($new_links, $links);
	}

	/**
	 * Autoload class files on demand
	 *
	 * @param string $class requested class name.
	 * @since 2.2.0
	 */
	private function autoload($class)
	{
		$name = explode('_', $class);
		if (isset($name[1])) {
			$class_name       = strtolower($name[1]);
			$efp_config_paths = array('views/', 'views/configs/settings/', 'views/configs/generator/');
			foreach ($efp_config_paths as $ta_efp_path) {
				$filename = plugin_dir_path(__FILE__) . '/' . $ta_efp_path . 'class-efp-' . $class_name . '.php';
				if (file_exists($filename)) {
					require_once $filename;
				}
			}
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Eventful_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Eventful_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$current_screen        = get_current_screen();
		$the_current_post_type = $current_screen->post_type;
		if ('eventful' == $the_current_post_type) {
			wp_enqueue_style('eventful-admin', EFP_URL . 'admin/assets/css/eventful-admin' . $this->suffix . '.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Eventful_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Eventful_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$current_screen        	= get_current_screen();
		$the_current_post_type 	= $current_screen->post_type;
		if ('eventful' == $the_current_post_type) {
			wp_enqueue_script('eventful-admin', EFP_URL . 'admin/assets/js/eventful-admin' . $this->suffix . '.js', array('jquery'), $this->version, false);
		}
	}

	/**
	 * Add eventful admin columns.
	 *
	 * @since 2.0.0
	 * @return statement
	 */
	public function filter_eventful_admin_column()
	{

		$admin_columns['cb']         = '<input type="checkbox" />';
		$admin_columns['title']      = esc_html__('Title', 'eventful-pro');
		$admin_columns['shortcode']  = esc_html__('Shortcode', 'eventful-pro');
		$admin_columns['efp_layout'] = esc_html__('Layout', 'eventful-pro');
		$admin_columns['date']       = esc_html__('Date', 'eventful-pro');

		return $admin_columns;
	}

	/**
	 * Display admin columns for the eventfuls.
	 *
	 * @param mix    $column The columns.
	 * @param string $post_id The post ID.
	 * @return void
	 */
	public function display_eventful_admin_fields($column, $post_id)
	{

		$efp_layouts     = get_post_meta($post_id, 'ta_efp_layouts', true);
		$eventfuls_types = isset($efp_layouts['efp_layout_preset']) ? $efp_layouts['efp_layout_preset'] : '';
		switch ($column) {
			case 'shortcode':
				$column_field = '<input  class="ta_efp_input" style="width: 230px;padding: 4px 8px;cursor: pointer;" type="text" onClick="this.select();" readonly="readonly" value="[eventful id=&quot;' . $post_id . '&quot;]"/> <div class="efp-after-copy-text"><i class="far fa-check-circle"></i> Shortcode Copied to Clipboard! </div>';
				echo $column_field;
				break;
			case 'efp_layout':
				$layout = ucwords(str_replace('_layout', ' ', $eventfuls_types));
				esc_html_e($layout, 'eventful-pro');
				break;
		} // end switch.
	}

	/**
	 * If it is the plugins page.
	 *
	 * @since 2.2.0
	 * @access private
	 */
	private function is_plugins_screen()
	{
		return in_array(get_current_screen()->id, ['plugins', 'plugins-network']);
	}
}

/**
 * Eventful dashboard capability.
 *
 * @return string
 */
function efp_dashboard_capability()
{
	return apply_filters('efp_dashboard_capability', 'manage_options');
}