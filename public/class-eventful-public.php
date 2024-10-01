<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net/
 * @since      1.0.0
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Eventful
 * @subpackage Eventful/public
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */
class Eventful_Public
{

	/**
	 * Script and style suffix
	 *
	 * @since 2.2.0
	 * @access protected
	 * @var string
	 */
	protected $suffix;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct()
	{
		$this->load_public_dependencies();
		$this->eful_public_action();
	}

	private function load_public_dependencies()
	{
		require_once EFUL_PATH . 'public/helpers/class-post-functions.php';
		require_once EFUL_PATH . 'public/helpers/class-eventful-user-like.php';
		new EFUL_User_Like();
		require_once EFUL_PATH . 'public/helpers/class-eventful-queryinside.php';
		require_once EFUL_PATH . 'public/helpers/class-eventful-customfieldprocess.php';
		require_once EFUL_PATH . 'public/helpers/class-eventful-shuffle-filter.php';
		require_once EFUL_PATH . 'public/helpers/class-eventful-live-filter.php';
		new EFUL_Live_Filter();
		require_once EFUL_PATH . 'public/helpers/class-loop-html.php';
	}

	private function eful_public_action()
	{

		add_action('wp_ajax_post_grid_ajax', array($this, 'post_grid_ajax'));
		add_action('wp_ajax_nopriv_post_grid_ajax', array($this, 'post_grid_ajax'));

		add_action('wp_ajax_eful_post_eventfulup', array($this, 'eful_post_eventfulup'));
		add_action('wp_ajax_nopriv_eful_post_eventfulup', array($this, 'eful_post_eventfulup'));

		add_action('wp_ajax_eful_post_eventfulup_next_prev', array($this, 'eful_post_eventfulup_next_prev'));
		add_action('wp_ajax_nopriv_eful_post_eventfulup_next_prev', array($this, 'eful_post_eventfulup_next_prev'));

		add_action('wp_ajax_post_pagination_bar', array($this, 'post_pagination_bar'));
		add_action('wp_ajax_nopriv_post_pagination_bar', array($this, 'post_pagination_bar'));

		add_action('wp_ajax_post_pagination_bar_mobile', array($this, 'post_pagination_bar_mobile'));
		add_action('wp_ajax_nopriv_post_pagination_bar_mobile', array($this, 'post_pagination_bar_mobile'));

		add_action('wp_ajax_eful_post_order', array($this, 'eful_post_order'));
		add_action('wp_ajax_nopriv_eful_post_order', array($this, 'eful_post_order'));

		add_shortcode('eventful', array($this, 'eful_shortcode_render'));

		$this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) || (defined('WP_DEBUG') && WP_DEBUG) ? '' : '.min';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.0.0
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

		$eful_settings        = get_option('eful_settings');
		$eful_fontawesome_css = isset($eful_settings['eful_fontawesome_css']) ? $eful_settings['eful_fontawesome_css'] : true;
		$eful_swiper_css      = isset($eful_settings['eful_swiper_css']) ? $eful_settings['eful_swiper_css'] : true;
		$eful_bxslider_css    = isset($eful_settings['eful_bxSlider_css']) ? $eful_settings['eful_bxSlider_css'] : true;
		$eful_like_css        = isset($eful_settings['eful_like_css']) ? $eful_settings['eful_like_css'] : true;
		$eful_magnific_css    = isset($eful_settings['eful_magnific_css']) ? $eful_settings['eful_magnific_css'] : true;
		if ($eful_fontawesome_css) {
			wp_enqueue_style('eventful-font-awesome', EFUL_URL . 'public/assets/css/fontawesome.min.css', array(), EFUL_VERSION, 'all');
		}
		if ($eful_swiper_css) {
			wp_enqueue_style('eful_swiper', EFUL_URL . 'public/assets/css/swiper-bundle' . $this->suffix . '.css', array(), EFUL_VERSION, 'all');
		}
		if ($eful_bxslider_css) {
			wp_enqueue_style('eventful-bxslider', EFUL_URL . 'public/assets/css/jquery.bxslider' . $this->suffix . '.css', array(), EFUL_VERSION, 'all');
		}
		if ($eful_like_css) {
			wp_enqueue_style('eventful-likes', EFUL_URL . 'public/assets/css/eventful-likes-public' . $this->suffix . '.css', array(), EFUL_VERSION, 'all');
		}
		wp_enqueue_style('eventful-grid', EFUL_URL . 'public/assets/css/ta-grid' . $this->suffix . '.css', array(), EFUL_VERSION, 'all');
		wp_enqueue_style('eventful-style', EFUL_URL . 'public/assets/css/style' . $this->suffix . '.css', array(), EFUL_VERSION, 'all');

		$eful_posts       = new WP_Query(
			array(
				'post_type'      => 'eventful',
				'posts_per_page' => 900,
			)
		);
		$post_ids        = wp_list_pluck($eful_posts->posts, 'ID');

		$custom_css      = '';
		$enqueue_fonts   = array();
		$setting_options = get_option('eful_settings');
		$eful_custom_css  = isset($setting_options['eful_custom_css']) ? $setting_options['eful_custom_css'] : '';

		$eful_enqueue_google_font = isset($setting_options['eful_enqueue_google_font']) ? $setting_options['eful_enqueue_google_font'] : true;
		foreach ($post_ids as $eful_id) {
			// Include dynamic style file.
			$view_options = get_post_meta($eful_id, 'eful_view_options', true);
			$layouts      = get_post_meta($eful_id, 'eful_layouts', true);
			include 'dynamic-css/dynamic-css.php';
			if ($eful_enqueue_google_font) {
				// Google fonts.
				$view_options     = get_post_meta($eful_id, 'eful_view_options', true);
				$all_fonts        = array();
				$eful_typography   = array();
			
				$eful_typography[] = isset($view_options['section_title_typography']) ? $view_options['section_title_typography'] : array();

				$eful_typography[] = isset($view_options['post_title_typography']) ? $view_options['post_title_typography'] : '';
				$eful_typography[] = isset($view_options['post_meta_typography']) ? $view_options['post_meta_typography'] : '';
				$eful_typography[] = isset($view_options['post_content_typography']) ? $view_options['post_content_typography'] : '';
				$eful_typography[] = isset($view_options['read_more_typography']) ? $view_options['read_more_typography'] : array(
					'font-family'        => '',
					'font-weight'        => '600',
					'subset'             => '',
					'font-size'          => '12',
					'tablet-font-size'   => '12',
					'mobile-font-size'   => '10',
					'line-height'        => '18',
					'tablet-line-height' => '18',
					'mobile-line-height' => '16',
					'letter-spacing'     => '0',
					'text-align'         => 'left',
					'text-transform'     => 'uppercase',
					'type'               => '',
					'unit'               => 'px',
				);
				if (!empty($eful_typography)) {
					foreach ($eful_typography as $font) {
						if (isset($font['font-family']) && isset($font['type']) && 'google' === $font['type']) {
							$variant     = (isset($font['font-weight']) && '' !== $font['font-weight']) ? ':' . $font['font-weight'] : '';
							$all_fonts[] = $font['font-family'] . $variant;
						}
					}
				}
				if ($all_fonts) {
					$enqueue_fonts[] = $all_fonts;
				}
			}
		}
		// Enqueue Google fonts.
		if ($eful_enqueue_google_font && !empty($enqueue_fonts)) {
			wp_enqueue_style('eventful-google-fonts', esc_url(add_query_arg('family', rawurlencode(implode('|', array_merge(...$enqueue_fonts))), '//fonts.googleapis.com/css')), array(), EFUL_VERSION, false);
		}
		include 'dynamic-css/responsive-css.php';
		if (!empty($eful_custom_css)) {
			$custom_css .= $eful_custom_css;
		}
		// Add dynamic style.
		wp_add_inline_style('eventful-style', $custom_css);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.2.0
	 */
	public function enqueue_scripts()
	{
		wp_register_script('eventful-swiper', EFUL_URL . 'public/assets/js/swiper-bundle' . $this->suffix . '.js', array('jquery'), '6.5.7', true);
		wp_register_script('eventful-isotope', EFUL_URL . 'public/assets/js/isotope' . $this->suffix . '.js', array('jquery'), '4.1.4', true);
		wp_register_script('eventful-bxslider', EFUL_URL . 'public/assets/js/jquery.bxslider' . $this->suffix . '.js', array('jquery'), '4.2.1d', true);
		wp_register_script('eventful-lazy', EFUL_URL . 'public/assets/js/eventful-lazyload' . $this->suffix . '.js', array('jquery'), EFUL_VERSION, true);
		wp_register_script('eventful-script', EFUL_URL . 'public/assets/js/scripts' . $this->suffix . '.js', array('eventful-swiper', 'eventful-bxslider'), EFUL_VERSION, true);
		wp_localize_script(
			'eventful-script',
			'speventful',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce'   => wp_create_nonce('speful_nonce'),
			)
		);
	}

	/**
	 * Post Ajax Pagination.
	 */
	public static function post_grid_ajax()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'speful_nonce')) {
			return false;
		}
		$views_id            = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$eful_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$selected_term_list  = isset($_POST['term_list']) ? rest_sanitize_array(wp_unslash($_POST['term_list'])) : '';
		$layout        = get_post_meta($views_id, 'eful_layouts', true);
		$layout_preset = isset($layout['eful_layout_preset']) ? $layout['eful_layout_preset'] : '';
		$view_options  = get_post_meta($views_id, 'eful_view_options', true);
		// Post display settings.
		if ('filter_layout' === $layout_preset) {
			$pagination_type        = isset($view_options['filter_pagination_type']) ? $view_options['filter_pagination_type'] : '';
			$pagination_type_mobile = isset($view_options['filter_pagination_type']) ? $view_options['filter_pagination_type'] : '';
		} else {
			$pagination_type        = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
			$pagination_type_mobile = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		}

		if ('ajax_number' === $pagination_type) {
			if (empty($paged)) {
				$paged = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
			}
		}
		$post_content_sorter              = isset($view_options['post_content_sorter']) ? $view_options['post_content_sorter'] : '';
		$query_args                       = EFUL_QueryInside::eful_get_filtered_content($view_options, $views_id, $layout_preset);
		$post_limit                       = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$post_offset                      = isset($view_options['eful_post_offset']) ? $view_options['eful_post_offset'] : 0;
		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);
		$relation                         = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
		$query_args                       = EFUL_Functions::eful_modify_query_params($query_args, $keyword, $author_id, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $eful_lang);
		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$new_query_args['posts_per_page'] = $post_limit;
		$total_posts                      = count(get_posts($new_query_args));
		$post_limit                       = $total_posts;
		if ($post_limit > 0) {
			$post_per_page = isset($view_options['post_per_page']) ? $view_options['post_per_page'] : '';
			$post_per_page = ($post_per_page > $post_limit) ? $post_limit : $post_per_page;
			if ($post_limit < 1) {
				$total_page = 0;
			} else {
				$total_page = EFUL_Functions::eful_max_pages($post_limit, $post_per_page);
			}
			$eful_last_page_post   = EFUL_Functions::eful_last_page_post($post_limit, $post_per_page, $total_page);
			$offset               = (int) $post_per_page * ($paged - 1);
			$query_args['offset'] = (int) $offset + (int) $post_offset;
			if ($total_page == $paged) {
				$query_args['posts_per_page'] = $eful_last_page_post;
			}
			if ($paged > $total_page) {
				return false;
			}
		}
		$query_args['paged'] = $paged;
		$eful_query           = new WP_Query($query_args);
		EFUL_HTML::eful_get_posts($view_options, $layout_preset, $post_content_sorter, $eful_query, $views_id);
		die();
	}

	/**
	 * Post Ajax Pagination.
	 */
	public static function post_pagination_bar()
	{
		if (!current_user_can('manage_options')) {
			return;
		}
		
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'speful_nonce')) {
			return false;
		}
		$views_id            = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$eful_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$selected_term_list  = isset($_POST['term_list']) ? rest_sanitize_array(wp_unslash($_POST['term_list'])) : '';
		$view_options        = get_post_meta($views_id, 'eful_view_options', true);
		$layout              = get_post_meta($views_id, 'eful_layouts', true);
		$layout_preset       = isset($layout['eful_layout_preset']) ? $layout['eful_layout_preset'] : '';
		$pagination_type     = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
		$pagination_type     = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		$query_args          = EFUL_QueryInside::eful_get_filtered_content($view_options, $views_id, $layout_preset);

		$post_offset                      = isset($view_options['eful_post_offset']) ? $view_options['eful_post_offset'] : 0;
		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$post_limit                       = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);

		$relation           = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
		$query_args         = EFUL_Functions::eful_modify_query_params($query_args, $keyword, $author_id, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $eful_lang);
		$query_args['lang'] = '';
		$eful_query          = new WP_Query($query_args);
		EFUL_HTML::eful_pagination_bar($eful_query, $view_options, $layout, $views_id, $paged);
		die();
	}

	/**
	 * Post Ajax mobile Pagination.
	 */
	public static function post_pagination_bar_mobile()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'speful_nonce')) {
			return false;
		}
		$views_id            = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$eful_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$selected_term_list  = isset($_POST['term_list']) ? rest_sanitize_array(wp_unslash($_POST['term_list'])) : '';
		$view_options        = get_post_meta($views_id, 'eful_view_options', true);
		$layout              = get_post_meta($views_id, 'eful_layouts', true);
		$layout_preset       = isset($layout['eful_layout_preset']) ? $layout['eful_layout_preset'] : '';
		$pagination_type     = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
		$pagination_type     = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		$query_args          = EFUL_QueryInside::eful_get_filtered_content($view_options, $views_id, $layout_preset, 'on_mobile');
		$tax_settings        = array();
		$post_offset         = isset($view_options['eful_post_offset']) ? $view_options['eful_post_offset'] : 0;

		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$post_limit                       = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);
		$query_post_ids                   = array('');

		$relation   = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
		$query_args = EFUL_Functions::eful_modify_query_params($query_args, $keyword, $author_id, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $eful_lang);
		$eful_query  = new WP_Query($query_args);
		EFUL_HTML::eful_pagination_bar($eful_query, $view_options, $layout, $views_id, $paged, 'on_mobile');
		die();
	}

	/**
	 * Post Ajax filter.
	 */
	public static function eful_post_order()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'speful_nonce')) {
			return false;
		}
		$views_id               = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword                = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby                = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order                  = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy               = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id                = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$eful_lang               = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id              = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$selected_term_list     = isset($_POST['term_list']) ? rest_sanitize_array(wp_unslash($_POST['term_list'])) : '';
		$layout                 = get_post_meta($views_id, 'eful_layouts', true);
		$layout_preset          = isset($layout['eful_layout_preset']) ? $layout['eful_layout_preset'] : '';
		$view_options           = get_post_meta($views_id, 'eful_view_options', true);
		$pagination_type        = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
		$pagination_type_mobile = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		$post_content_sorter    = isset($view_options['post_content_sorter']) ? $view_options['post_content_sorter'] : '';
		$query_args             = EFUL_QueryInside::eful_get_filtered_content($view_options, $views_id, $layout_preset);
		$post_offset            = isset($view_options['eful_post_offset']) ? $view_options['eful_post_offset'] : 0;

		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$post_limit                       = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);
		$relation                         = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
		$query_args                       = EFUL_Functions::eful_modify_query_params($query_args, $keyword, $author_id, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $eful_lang);
		$eful_query                        = new WP_Query($query_args);
		EFUL_HTML::eful_get_posts($view_options, $layout_preset, $post_content_sorter, $eful_query, $views_id);
		die();
	}



	/**
	 * Function get layout from atts and create class depending on it.
	 *
	 * @since 2.0
	 * @param array $attribute attribute of this shortcode.
	 */
	public function eful_shortcode_render($attribute)
	{
		if (empty($attribute['id'])) {
			return;
		}
		$eful_gl_id = $attribute['id']; // Eventful global ID for Shortcode metaboxes.
		// Preset Layouts.
		$layout        = get_post_meta($eful_gl_id, 'eful_layouts', true);
		$view_options  = get_post_meta($eful_gl_id, 'eful_view_options', true);
		$section_title = get_the_title($eful_gl_id);
		ob_start();
		EFUL_HTML::eful_html_show($view_options, $layout, $eful_gl_id, $section_title);
		return ob_get_clean();
	}
}
