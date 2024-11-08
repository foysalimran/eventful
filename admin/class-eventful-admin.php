<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeatelier.net
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
class Eful_Admin
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

		EFUL_Metaboxes::eful_layout_metabox('ta_efp_layouts');
		EFUL_Metaboxes::eful_option_metabox('eful_view_options');
		EFUL_Metaboxes::eful_shortcode_metabox('eful_display_shortcode');
		EFUL_Settings::settings('eful_settings');

		$active_plugins = get_option('active_plugins');
		foreach ($active_plugins as $active_plugin) {
			$_temp = strpos($active_plugin, 'eventful.php');
			if (false != $_temp) {
				add_filter('plugin_action_links_' . $active_plugin, array($this, 'eful_add_plugin_action_links'));
			}
		}
	}

	public function eful_add_plugin_action_links($links)
	{
		$new_links = array(
			sprintf('<a href="%s">%s</a>', admin_url('post-new.php?post_type=eventful'), esc_html__('Add New', 'eventful')),
			sprintf('<a href="%s">%s</a>', admin_url('edit.php?post_type=eventful'), esc_html__('Settings', 'eventful')),
			sprintf('<a target="_blank" style="font-weight:bold;color:#0015B5" href="%s">%s</a>', 'https://1.envato.market/eventful', esc_html__('Get Pro!', 'eventful')),
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
			$eful_config_paths = array('views/', 'views/configs/settings/', 'views/configs/generator/');
			foreach ($eful_config_paths as $eful_path) {
				$filename = plugin_dir_path(__FILE__) . '/' . $eful_path . 'class-eventful-' . $class_name . '.php';
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
			wp_enqueue_style('eventful-admin', EFUL_URL . 'admin/assets/css/eventful-admin' . $this->suffix . '.css', array(), $this->version, 'all');
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
			wp_enqueue_script('eventful-admin', EFUL_URL . 'admin/assets/js/eventful-admin' . $this->suffix . '.js', array('jquery'), $this->version, true);
		}
	}

	/**
	 * Add eventful admin columns.
	 *
	 * @since 2.0.0
	 * @return statement
	 */
	public function eful_filter_admin_column()
	{

		$admin_columns['cb']         = '<input type="checkbox" />';
		$admin_columns['title']      = esc_html__('Title', 'eventful');
		$admin_columns['shortcode']  = esc_html__('Shortcode', 'eventful');
		$admin_columns['eful_layout'] = esc_html__('Layout', 'eventful');
		$admin_columns['date']       = esc_html__('Date', 'eventful');

		return $admin_columns;
	}

	/**
	 * Display admin columns for the eventfuls.
	 *
	 * @param mix    $column The columns.
	 * @param string $post_id The post ID.
	 * @return void
	 */
	public function eful_display_admin_fields($column, $post_id)
	{
		$ta_efp_layouts     = get_post_meta($post_id, 'ta_efp_layouts', true);

		$eventfuls_types = isset($ta_efp_layouts['eful_layout_preset']) ? $ta_efp_layouts['eful_layout_preset'] : '';
		switch ($column) {
			case 'shortcode':
				$allowed_tags = array(
					'input' => array(
						'class' => array(),
						'style' => array(),
						'type' => array(),
						'onClick' => array(),
						'readonly' => array(),
						'value' => array(),
					),
					'div' => array(
						'class' => array(),
					),
					'i' => array(
						'class' => array(),
					),
				);
				$column_field = '<input  class="eful_input" style="width: 230px;padding: 4px 8px;cursor: pointer;" type="text" onClick="this.select();" readonly="readonly" value="[eventful id=&quot;' . $post_id . '&quot;]"/> <div class="eventful-after-copy-text"><i class="far fa-check-circle"></i> ' . esc_html('Shortcode Copied to Clipboard!', 'eventful') . ' </div>';
				echo wp_kses($column_field, $allowed_tags);
				break;
			case 'eful_layout':
				$layout = ucwords(str_replace('_layout', ' ', $eventfuls_types));
				esc_html($layout);
				break;
		} // end switch.
	}

	

	public function filter_eventful_admin_column()
	{

		$admin_columns['cb']         = '<input type="checkbox" />';
		$admin_columns['title']      = esc_html__('Title', 'eventful');
		$admin_columns['shortcode']  = esc_html__('Shortcode', 'eventful');
		$admin_columns['efp_layout'] = esc_html__('Layout', 'eventful');
		$admin_columns['date']       = esc_html__('Date', 'eventful');

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
		$eventfuls_types = isset($efp_layouts['eful_layout_preset']) ? $efp_layouts['eful_layout_preset'] : '';
		switch ($column) {
			case 'shortcode':
				$column_field = '<input  class="ta_efp_input" style="width: 230px;padding: 4px 8px;cursor: pointer;" type="text" onClick="this.select();" readonly="readonly" value="[eventful id=&quot;' . $post_id . '&quot;]"/> <div class="eventful-after-copy-text"><i class="far fa-check-circle"></i> '.esc_html('Shortcode Copied to Clipboard!', 'eventful').' </div>';
				echo $column_field;
				break;
			case 'efp_layout':
				$layout = ucwords(str_replace('_layout', ' ', $eventfuls_types));
				esc_html_e($layout, 'eventful');
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
function eful_dashboard_capability()
{
	return apply_filters('eful_dashboard_capability', 'manage_options');
}
