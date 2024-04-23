<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * Custom post class to register the carousel.
 */
class Eventful_Post_Type
{

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since 2.2.0
	 */
	private static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 2.2.0
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 2.2.0
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since 2.2.0
	 * @static
	 * @return self Main instance.
	 */
	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Eventful post type
	 */
	public function eful_register_post_type()
	{
		if (post_type_exists('eventful')) {
			return;
		}
		$capability = eful_dashboard_capability();
		// Set the Eventful post type labels.
		$labels = apply_filters(
			'eful_post_type_labels',
			array(
				'name'               => esc_html__('Eventful Shortcode', 'eventful'),
				'singular_name'      => esc_html__('Shortcode', 'eventful'),
				'menu_name'          => esc_html__('Eventful', 'eventful'),
				'all_items'          => esc_html__('All Layouts', 'eventful'),
				'add_new'            => esc_html__('Add Layout', 'eventful'),
				'add_new_item'       => esc_html__('Generate New Shortcode', 'eventful'),
				'new_item'           => esc_html__('Generate New Shortcode', 'eventful'),
				'edit_item'          => esc_html__('Edit Generated Shortcode', 'eventful'),
				'view_item'          => esc_html__('View Generated Shortcode', 'eventful'),
				'name_admin_bar'     => esc_html__('Eventful Generator', 'eventful'),
				'search_items'       => esc_html__('Search Generated Shortcode', 'eventful'),
				'parent_item_colon'  => esc_html__('Parent Generated Shortcode:', 'eventful'),
				'not_found'          => esc_html__('No Shortcode found.', 'eventful'),
				'not_found_in_trash' => esc_html__('No Shortcode found in Trash.', 'eventful')
			)
		);

		$args      = apply_filters(
			'eful_post_type_args',
			array(
				'label'           => esc_html__('Eventful Shortcode', 'eventful'),
				'description'     => esc_html__('Eventful Shortcode', 'eventful'),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-calendar',
				'hierarchical'    => false,
				'query_var'       => false,
				'menu_position'   => 5,
				'supports'        => array('title'),
				'capabilities'    => array(
					'publish_posts'       => $capability,
					'edit_posts'          => $capability,
					'edit_others_posts'   => $capability,
					'delete_posts'        => $capability,
					'delete_others_posts' => $capability,
					'read_private_posts'  => $capability,
					'edit_post'           => $capability,
					'delete_post'         => $capability,
					'read_post'           => $capability,
				),
				'capability_type' => 'post',
				// 'rewrite'         => true,
				'labels'          => $labels,
			)
		);

		register_post_type('eventful', $args);
	}
}
