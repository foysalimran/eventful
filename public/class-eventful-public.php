<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://themeatelier.net/
 * @since      1.0.0
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

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
		$this->efp_public_action();
	}

	private function load_public_dependencies()
	{
		require_once EFP_PATH . 'public/helpers/class-post-functions.php';
		require_once EFP_PATH . 'public/helpers/class-efp-user-like.php';
		new EFP_User_Like();
		require_once EFP_PATH . 'public/helpers/class-efp-queryinside.php';
		require_once EFP_PATH . 'public/helpers/class-efp-customfieldprocess.php';
		require_once EFP_PATH . 'public/helpers/class-efp-shuffle-filter.php';
		require_once EFP_PATH . 'public/helpers/class-efp-live-filter.php';
		new EFP_Live_Filter();
		require_once EFP_PATH . 'public/helpers/class-loop-html.php';
	}

	private function efp_public_action()
	{

		add_action('wp_ajax_post_grid_ajax', array($this, 'post_grid_ajax'));
		add_action('wp_ajax_nopriv_post_grid_ajax', array($this, 'post_grid_ajax'));

		add_action('wp_ajax_efp_post_efpup', array($this, 'efp_post_efpup'));
		add_action('wp_ajax_nopriv_efp_post_efpup', array($this, 'efp_post_efpup'));

		add_action('wp_ajax_efp_post_efpup_next_prev', array($this, 'efp_post_efpup_next_prev'));
		add_action('wp_ajax_nopriv_efp_post_efpup_next_prev', array($this, 'efp_post_efpup_next_prev'));

		add_action('wp_ajax_post_pagination_bar', array($this, 'post_pagination_bar'));
		add_action('wp_ajax_nopriv_post_pagination_bar', array($this, 'post_pagination_bar'));

		add_action('wp_ajax_post_pagination_bar_mobile', array($this, 'post_pagination_bar_mobile'));
		add_action('wp_ajax_nopriv_post_pagination_bar_mobile', array($this, 'post_pagination_bar_mobile'));

		add_action('wp_ajax_efp_post_order', array($this, 'efp_post_order'));
		add_action('wp_ajax_nopriv_efp_post_order', array($this, 'efp_post_order'));

		add_shortcode('eventful', array($this, 'efp_shortcode_render'));

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

		$efp_settings        = get_option('ta_eventful_settings');
		$efp_fontawesome_css = isset($efp_settings['efp_fontawesome_css']) ? $efp_settings['efp_fontawesome_css'] : true;
		$efp_swiper_css      = isset($efp_settings['efp_swiper_css']) ? $efp_settings['efp_swiper_css'] : true;
		$efp_bxslider_css    = isset($efp_settings['efp_bxSlider_css']) ? $efp_settings['efp_bxSlider_css'] : true;
		$efp_like_css        = isset($efp_settings['efp_like_css']) ? $efp_settings['efp_like_css'] : true;
		$efp_magnific_css    = isset($efp_settings['efp_magnific_css']) ? $efp_settings['efp_magnific_css'] : true;
		if ($efp_fontawesome_css) {
			wp_enqueue_style('efp-font-awesome', EFP_URL . 'public/assets/css/fontawesome.min.css', array(), EFP_VERSION, 'all');
		}
		if ($efp_swiper_css) {
			wp_enqueue_style('efp_swiper', EFP_URL . 'public/assets/css/swiper-bundle' . $this->suffix . '.css', array(), EFP_VERSION, 'all');
		}
		if ($efp_bxslider_css) {
			wp_enqueue_style('efp-bxslider', EFP_URL . 'public/assets/css/jquery.bxslider' . $this->suffix . '.css', array(), EFP_VERSION, 'all');
		}
		if ($efp_like_css) {
			wp_enqueue_style('efp-likes', EFP_URL . 'public/assets/css/efp-likes-public' . $this->suffix . '.css', array(), EFP_VERSION, 'all');
		}
		wp_enqueue_style('efp-grid', EFP_URL . 'public/assets/css/ta-grid' . $this->suffix . '.css', array(), EFP_VERSION, 'all');
		wp_enqueue_style('efp-style', EFP_URL . 'public/assets/css/style' . $this->suffix . '.css', array(), EFP_VERSION, 'all');

		$efp_posts       = new WP_Query(
			array(
				'post_type'      => 'eventful',
				'posts_per_page' => 900,
			)
		);
		$post_ids        = wp_list_pluck($efp_posts->posts, 'ID');
		$custom_css      = '';
		$enqueue_fonts   = array();
		$setting_options = get_option('ta_eventful_settings');
		$efp_custom_css  = isset($setting_options['efp_custom_css']) ? $setting_options['efp_custom_css'] : '';

		$efp_enqueue_google_font = isset($setting_options['efp_enqueue_google_font']) ? $setting_options['efp_enqueue_google_font'] : true;
		foreach ($post_ids as $efp_id) {
			// Include dynamic style file.
			$view_options = get_post_meta($efp_id, 'ta_eventful_view_options', true);
			$layouts      = get_post_meta($efp_id, 'ta_eventful_layouts', true);
			include 'dynamic-css/dynamic-css.php';

			if ($efp_enqueue_google_font) {
				// Google fonts.
				$view_options     = get_post_meta($efp_id, 'ta_eventful_view_options', true);
				$all_fonts        = array();
				$efp_typography   = array();
				$efp_typography[] = $view_options['section_title_typography'];
				$efp_typography[] = $view_options['post_title_typography'];
				$efp_typography[] = $view_options['post_meta_typography'];
				$efp_typography[] = $view_options['post_content_typography'];
				$efp_typography[] = isset($view_options['read_more_typography']) ? $view_options['read_more_typography'] : array(
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
				if (!empty($efp_typography)) {
					foreach ($efp_typography as $font) {
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
		if ($efp_enqueue_google_font && !empty($enqueue_fonts)) {
			wp_enqueue_style('efp-google-fonts', esc_url(add_query_arg('family', rawurlencode(implode('|', array_merge(...$enqueue_fonts))), '//fonts.googleapis.com/css')), array(), EFP_VERSION, false);
		}
		include 'dynamic-css/responsive-css.php';
		if (!empty($efp_custom_css)) {
			$custom_css .= $efp_custom_css;
		}
		// Add dynamic style.
		wp_add_inline_style('efp-style', $custom_css);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.2.0
	 */
	public function enqueue_scripts()
	{
		wp_register_script('efp-swiper', EFP_URL . 'public/assets/js/swiper-bundle' . $this->suffix . '.js', array('jquery'), EFP_VERSION, true);
		wp_register_script('efp-isotope', EFP_URL . 'public/assets/js/isotope' . $this->suffix . '.js', array('jquery'), EFP_VERSION, true);
		wp_register_script('efp-bxslider', EFP_URL . 'public/assets/js/jquery.bxslider' . $this->suffix . '.js', array('jquery'), EFP_VERSION, true);
		wp_register_script('efp-lazy', EFP_URL . 'public/assets/js/efp-lazyload' . $this->suffix . '.js', array('jquery'), EFP_VERSION, true);
		wp_register_script('efp-script', EFP_URL . 'public/assets/js/scripts' . $this->suffix . '.js', array('efp-swiper', 'efp-bxslider'), EFP_VERSION, true);
		wp_localize_script(
			'efp-script',
			'spefp',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce'   => wp_create_nonce('spefp_nonce'),
			)
		);
	}

	/**
	 * Post Ajax Pagination.
	 */
	public static function post_grid_ajax()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'spefp_nonce')) {
			return false;
		}
		$views_id            = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$efp_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$custom_fields_array = isset($_POST['custom_fields_array']) ? wp_unslash($_POST['custom_fields_array']) : '';
		$selected_term_list  = isset($_POST['term_list']) ? wp_unslash($_POST['term_list']) : '';
		// $efp_search_url     = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( sanitize_text_field( $_SERVER['REQUEST_URI'] ) ) : '';
		$layout        = get_post_meta($views_id, 'ta_eventful_layouts', true);
		$layout_preset = isset($layout['eventful_layout_preset']) ? $layout['eventful_layout_preset'] : '';
		$view_options  = get_post_meta($views_id, 'ta_eventful_view_options', true);
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
		$query_args                       = EFP_QueryInside::get_filtered_content($view_options, $views_id, $layout_preset);
		$post_limit                       = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$post_offset                      = isset($view_options['efp_post_offset']) ? $view_options['efp_post_offset'] : 0;
		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);
		$relation                         = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
		$query_args                       = EFP_Functions::modify_query_params($query_args, $keyword, $author_id, $custom_fields_array, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $efp_lang);
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
				$total_page = EFP_Functions::efp_max_pages($post_limit, $post_per_page);
			}
			$efp_last_page_post   = EFP_Functions::efp_last_page_post($post_limit, $post_per_page, $total_page);
			$offset               = (int) $post_per_page * ($paged - 1);
			$query_args['offset'] = (int) $offset + (int) $post_offset;
			if ($total_page == $paged) {
				$query_args['posts_per_page'] = $efp_last_page_post;
			}
			if ($paged > $total_page) {
				return false;
			}
		}
		$query_args['paged'] = $paged;
		$efp_query           = new WP_Query($query_args);
		EFP_HTML::efp_get_posts($view_options, $layout_preset, $post_content_sorter, $efp_query, $views_id);
		die();
	}

	/**
	 * Post Ajax Pagination.
	 */
	public static function post_pagination_bar()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'spefp_nonce')) {
			return false;
		}
		$views_id            = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$efp_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$custom_fields_array = isset($_POST['custom_fields_array']) ? wp_unslash($_POST['custom_fields_array']) : '';
		$selected_term_list  = isset($_POST['term_list']) ? wp_unslash($_POST['term_list']) : '';
		$view_options        = get_post_meta($views_id, 'ta_eventful_view_options', true);
		$layout              = get_post_meta($views_id, 'ta_eventful_layouts', true);
		$layout_preset       = isset($layout['eventful_layout_preset']) ? $layout['eventful_layout_preset'] : '';
		$pagination_type     = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
		$pagination_type     = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		$query_args          = EFP_QueryInside::get_filtered_content($view_options, $views_id, $layout_preset);

		$post_offset                      = isset($view_options['efp_post_offset']) ? $view_options['efp_post_offset'] : 0;
		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$post_limit                       = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);

		$relation           = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
		$query_args         = EFP_Functions::modify_query_params($query_args, $keyword, $author_id, $custom_fields_array, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $efp_lang);
		$query_args['lang'] = '';
		$efp_query          = new WP_Query($query_args);
		EFP_HTML::efp_pagination_bar($efp_query, $view_options, $layout, $views_id, $paged);
		die();
	}

	/**
	 * Post Ajax mobile Pagination.
	 */
	public static function post_pagination_bar_mobile()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'spefp_nonce')) {
			return false;
		}
		$views_id            = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$efp_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$selected_term_list  = isset($_POST['term_list']) ? wp_unslash($_POST['term_list']) : '';
		$custom_fields_array = isset($_POST['custom_fields_array']) ? wp_unslash($_POST['custom_fields_array']) : '';
		$view_options        = get_post_meta($views_id, 'ta_eventful_view_options', true);
		$layout              = get_post_meta($views_id, 'ta_eventful_layouts', true);
		$layout_preset       = isset($layout['eventful_layout_preset']) ? $layout['eventful_layout_preset'] : '';
		$pagination_type     = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
		$pagination_type     = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		$query_args          = EFP_QueryInside::get_filtered_content($view_options, $views_id, $layout_preset, 'on_mobile');
		$tax_settings        = array();
		$post_offset         = isset($view_options['efp_post_offset']) ? $view_options['efp_post_offset'] : 0;

		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$post_limit                       = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);
		$query_post_ids                   = array('');

		$relation   = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
		$query_args = EFP_Functions::modify_query_params($query_args, $keyword, $author_id, $custom_fields_array, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $efp_lang);
		$efp_query  = new WP_Query($query_args);
		EFP_HTML::efp_pagination_bar($efp_query, $view_options, $layout, $views_id, $paged, 'on_mobile');
		die();
	}

	/**
	 * Post Ajax filter.
	 */
	public static function efp_post_order()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'spefp_nonce')) {
			return false;
		}
		$views_id               = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword                = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby                = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order                  = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy               = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id                = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$efp_lang               = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id              = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$selected_term_list     = isset($_POST['term_list']) ? wp_unslash($_POST['term_list']) : '';
		$custom_fields_array    = isset($_POST['custom_fields_array']) ? wp_unslash($_POST['custom_fields_array']) : '';
		$layout                 = get_post_meta($views_id, 'ta_eventful_layouts', true);
		$layout_preset          = isset($layout['eventful_layout_preset']) ? $layout['eventful_layout_preset'] : '';
		$view_options           = get_post_meta($views_id, 'ta_eventful_view_options', true);
		$pagination_type        = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
		$pagination_type_mobile = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
		$post_content_sorter    = isset($view_options['post_content_sorter']) ? $view_options['post_content_sorter'] : '';
		$query_args             = EFP_QueryInside::get_filtered_content($view_options, $views_id, $layout_preset);
		$post_offset            = isset($view_options['efp_post_offset']) ? $view_options['efp_post_offset'] : 0;

		$new_query_args                   = $query_args;
		$new_query_args['fields']         = 'ids';
		$post_limit                       = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$new_query_args['posts_per_page'] = $post_limit;
		$query_post_ids                   = get_posts($new_query_args);
		$relation                         = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
		$query_args                       = EFP_Functions::modify_query_params($query_args, $keyword, $author_id, $custom_fields_array, $orderby, $order, $selected_term_list, $post_offset, $relation, $query_post_ids, $efp_lang);
		$efp_query                        = new WP_Query($query_args);
		EFP_HTML::efp_get_posts($view_options, $layout_preset, $post_content_sorter, $efp_query, $views_id);
		die();
	}



	/**
	 * Function get layout from atts and create class depending on it.
	 *
	 * @since 2.0
	 * @param array $attribute attribute of this shortcode.
	 */
	public function efp_shortcode_render($attribute)
	{
		if (empty($attribute['id'])) {
			return;
		}
		$efp_gl_id = $attribute['id']; // Eventful global ID for Shortcode metaboxes.
		// Preset Layouts.
		$layout        = get_post_meta($efp_gl_id, 'ta_eventful_layouts', true);
		$view_options  = get_post_meta($efp_gl_id, 'ta_eventful_view_options', true);
		$section_title = get_the_title($efp_gl_id);
		ob_start();
		EFP_HTML::efp_html_show($view_options, $layout, $efp_gl_id, $section_title);
		return ob_get_clean();
	}
}
