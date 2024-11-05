<?php

/**
 * The file of live filter.
 *
 * @package Eventful
 * @subpackage Eventful/public/helper
 *
 * @since 2.0.0
 */

/**
 * Live filter helper method.
 *
 * @since 2.0.0
 */
class EFUL_Live_Filter
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 */
	public function __construct()
	{
		add_action('wp_ajax_eful_live_filter_reset', array($this, 'eful_live_filter_reset'));
		add_action('wp_ajax_eful_admin_live_filter_reset', array($this, 'eful_admin_live_filter_reset'));
		add_action('wp_ajax_nopriv_eful_live_filter_reset', array($this, 'eful_live_filter_reset'));
	}
	/**
	 * Live filter markup style.
	 *
	 * @param string $btn_type Filter type.
	 * @param string $taxonomy Current taxonomy to view.
	 * @param string $label filter label.
	 * @param string $all_text all text.
	 * @param string $align alignment.
	 * @param bool   $show_count show hide post count.
	 * @param int    $term term id.
	 * @param string $name term name.
	 * @param int    $p_count term found post.
	 * @param int    $id   post id.
	 * @param string $pre_selected selected.
	 * @param string $pre_checked  checked.
	 * @return array
	 */
	public static function eful_filter_style($btn_type, $taxonomy, $label, $all_text, $align = 'center', $show_count = false, $term = null, $name = null, $p_count = null, $id = '', $pre_selected = '', $pre_checked = '')
	{
		if ($show_count) {
			$post_count_markup = '<span class="eventful-count">(' . $p_count . ')</span>';
		} else {
			$post_count_markup = '';
		}
		$is_checked       = $pre_checked;
		$is_selected      = $pre_selected;
		$checked          = $pre_checked;
		$selected         = $pre_selected;
		$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash(sanitize_text_field($_SERVER['QUERY_STRING'])) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $id) {
				$filter_url_value = isset($_GET["tx_$taxonomy"]) ? wp_unslash(sanitize_text_field($_GET["tx_$taxonomy"])) : '';
				if (!empty($filter_url_value)) {
					if (strpos($filter_url_value, ',') !== false) {
						$filter_url_value = explode(',', $filter_url_value);
					}
					if (is_array($filter_url_value)) {
						if (in_array($term, $filter_url_value)) {
							$is_checked  = 'checked';
							$is_selected = 'selected';
						} else {
							$is_checked  = $pre_checked;
							$is_selected = $pre_selected;
						}
					} else {
						if ($filter_url_value == $term) {
							$is_checked  = 'checked';
							$is_selected = 'selected';
						} else {
							$is_checked  = $pre_checked;
							$is_selected = $pre_selected;
						}
					}
				}
			}
		}

		$checked  = $pre_checked;
		$selected = $pre_selected;

		if ('fl_checkbox' === $btn_type) {
			$all_label  = !empty($all_text) ? $all_text : '';
			$all_button = !empty($all_text) ? '<div class="fl_checkbox"><label><input checked type="checkbox" name="' . $taxonomy . '" data-taxonomy="' . $taxonomy . '"value="all">' . $all_label . '</label></div>' : '';

			$first_item = '<form class="eventful-filter-by-checkbox eventful-bar" data-taxonomy="' . $taxonomy . '" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_checkbox"><label><input ' . $is_checked . ' name="' . $taxonomy . '" type="checkbox" ' . $checked . ' data-taxonomy="' . $taxonomy . '" value="' . $term . '">' . $name . $post_count_markup . '</span></label></div>';
		} elseif ('fl_radio' === $btn_type) {
			$all_label  = !empty($all_text) ? $all_text : '';
			$all_button = !empty($all_text) ? '<div class="fl_radio"><label><input checked type="radio" name="' . $taxonomy . '" data-taxonomy="' . $taxonomy . '"value="all">' . $all_label . '</label></div>' : '';
			$first_item = '<form class="eventful-filter-by eventful-bar" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p>' . $all_button;
			$push_item  = '<div class="fl_radio"><label><input ' . $is_checked . ' name="' . $taxonomy . '" type="radio" ' . $checked . ' data-taxonomy="' . $taxonomy . '" value="' . $term . '">' . $name . $post_count_markup . '</span></label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$all_label  = !empty($all_text) ? '<div>' . $all_text . '</div>' : '';
			$all_button = !empty($all_text) ? '<div class="fl_radio"><label><input checked type="radio" name="' . $taxonomy . '" data-taxonomy="' . $taxonomy . '" value="all">' . $all_label . '</label></div>' : '';

			$first_item = '<form class="eventful-filter-by eventful-bar fl_button filter-' . $taxonomy . '" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p>' . $all_button;
			$push_item  = '<div class="fl_radio"><label><input ' . $is_checked . ' name="' . $taxonomy . '" type="radio" ' . $checked . ' data-taxonomy="' . $taxonomy . '" value="' . $term . '"><div>' . $name . $post_count_markup . '</div></label></div>';
		} else {
			$all_label  = !empty($all_text) ? $all_text : '';
			$all_button = !empty($all_text) ? '<option value="all"  data-taxonomy="' . $taxonomy . '">' . $all_label . '</option>' : '';

			$first_item = '<form class="eventful-filter-by eventful-bar" style="text-align:' . esc_attr($align) . ';"> <label class="eventful-label">' . esc_html($label) . '</label> <select>' . $all_button;
			$push_item  = '<option data-taxonomy="' . $taxonomy . '" ' . $selected . ' ' . $is_selected . ' value="' . $term . '">' . $name . $post_count_markup . '</option>';
		}
		$filter_output = array(
			'first_item' => $first_item,
			'push_item'  => $push_item,
		);
		return $filter_output;
	}
	/**
	 * Multi dimensional to flatten array.
	 *
	 * @param array $array input array.
	 * @return array
	 */
	public static function eful_array_flatten($array)
	{
		if (!is_array($array)) {
			return false;
		}
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, self::eful_array_flatten($value));
			} else {
				$result[$key] = $value;
			}
		}
		return $result;
	}

	/**
	 * All terms form the query
	 *
	 * @param  array  $eful_query query arg.
	 * @param  string $taxonomy taxonomy.
	 * @return array
	 */
	public static function eful_all_taxonomy_terms_form_the_query($eful_query, $taxonomy)
	{
		$post_ids  = $eful_query;
		$term_list = array();
		foreach ($post_ids as $key => $id) {
			$ct_term = wp_get_post_terms($id, $taxonomy, array('fields' => 'ids'));
			if (is_array($ct_term) && !empty($ct_term)) {
				array_push($term_list, $ct_term);
			}
		}
		return array_unique(self::eful_array_flatten($term_list));
	}
	/**
	 * Live Filter reset after ajax request.
	 */
	public static function eful_live_filter_reset()
	{
		if (!current_user_can('manage_options')) {
			return;
		}

		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'speful_nonce')) {
			return false;
		}
		$eful_gl_id           = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$eful_lang       = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$last_filter         = isset($_POST['last_filter']) ? sanitize_text_field(wp_unslash($_POST['last_filter'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$selected_term_list  = isset($_POST['term_list']) ? rest_sanitize_array(wp_unslash($_POST['term_list'])) : '';

		$view_options                 = get_post_meta($eful_gl_id, 'eful_view_options', true);
		$query_args                   = EFUL_QueryInside::eful_get_filtered_content($view_options, $eful_gl_id);
		$query_args['fields']         = 'ids';
		$post_limit                   = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$query_args['posts_per_page'] = $post_limit;
		$query_post_ids               = get_posts($query_args);
		$relation                     = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
		$is_term_intersect            = true;
		if ('AND' !== $relation) {
			$is_term_intersect = false;
		}
		$query_args = EFUL_Functions::eful_modify_query_params($query_args, $keyword, $author_id, $orderby, $order, $selected_term_list, 0, $relation, $query_post_ids, $eful_lang);
		$eful_query  = array();
		self::eful_live_filter($view_options, $query_args, $eful_gl_id, $is_term_intersect, $selected_term_list, $last_filter);
		self::eful_author_filter($view_options, $query_args, $author_id);
		wp_die();
	}

	/**
	 * Taxonomy Filter.
	 *
	 * @param array  $view_options options array.
	 * @param  array  $query_args  query array.
	 * @param  string $id shortcode id.
	 * @param  bool   $is_term_intersect is_ajax.
	 * @param  array  $selected_term_list selected term list.
	 * @param  string $last_filter last filter.
	 * @return void
	 */
	public static function eful_live_filter($view_options, $query_args = '', $id = '', $is_term_intersect = true, $selected_term_list = array(), $last_filter = '')
	{
		$filter_by                    = isset($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : array();
		$post_limit                   = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$query_args['posts_per_page'] = $post_limit;
		$query_args['fields']         = 'ids';
		if (in_array('taxonomy', $filter_by, true)) {
			$taxonomy_types = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomy_and_terms']) && !empty($view_options['eful_filter_by_taxonomy']['eful_taxonomy_and_terms']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomy_and_terms'] : '';
			$relation       = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
			if (!empty($taxonomy_types)) {
				$output         = '';
				$newterm_array  = array();
				$index          = 0;
				$taxonomies     = array();
				$taxonomy_count = count($taxonomy_types);
				while ($index < $taxonomy_count) {
					$add_filter = isset($taxonomy_types[$index]['add_filter_post']) ? $taxonomy_types[$index]['add_filter_post'] : '';
					if ($add_filter) {
						$taxonomy        = isset($taxonomy_types[$index]['eful_select_taxonomy']) ? $taxonomy_types[$index]['eful_select_taxonomy'] : '';
						$all_terms = get_terms($taxonomy);
						$all_terms = wp_list_pluck($all_terms, 'term_id');

						$terms           = isset($taxonomy_types[$index]['eful_select_terms']) ? $taxonomy_types[$index]['eful_select_terms'] : $all_terms;
						$all_post_ids    = get_posts($query_args);
						$post_limit      = count($all_post_ids);
						$url_last_filter = isset($_GET['slf']) ? wp_unslash(sanitize_text_field($_GET['slf'])) : ''; 

						if (!empty($selected_term_list) && is_array($selected_term_list)) {
							if ($last_filter == $taxonomy && 'AND' === $relation) {
								$new_query = $query_args;
								$tax_query = isset($new_query['tax_query']) ? $new_query['tax_query'] : array();
								if (!empty($tax_query)) {
									foreach ($tax_query as $key => $value) {
										if (is_array($value)) {
											if ($value['taxonomy'] == $taxonomy) {
												unset($tax_query[$key]);
											}
										}
									}
									$new_query['tax_query'] = $tax_query;
									$all_post_ids           = get_posts($new_query);
									$post_limit             = count($all_post_ids);
								}
							}
						} elseif ($url_last_filter == $taxonomy && 'AND' === $relation) {
							$new_query = $query_args;
							$tax_query = isset($new_query['tax_query']) ? $new_query['tax_query'] : array();
							if (!empty($tax_query)) {
								foreach ($tax_query as $key => $value) {
									if (is_array($value)) {
										if ($value['taxonomy'] == $taxonomy) {
											unset($tax_query[$key]);
										}
									}
								}
								$new_query['tax_query'] = $tax_query;
								$all_post_ids           = get_posts($new_query);
								$post_limit             = count($all_post_ids);
							}
						}
						$filter_options = isset($taxonomy_types[$index]['ajax_filter_options']) ? $taxonomy_types[$index]['ajax_filter_options'] : '';
						$all_text       = isset($filter_options['ajax_rename_all_text']) && !empty($filter_options['ajax_rename_all_text']) ? $filter_options['ajax_rename_all_text'] : '';
						if ($is_term_intersect) {
							$new_terms = self::eful_all_taxonomy_terms_form_the_query($all_post_ids, $taxonomy);
							$terms     = is_array($terms) ? $terms : array($terms);
							$terms     = array_intersect($terms, $new_terms);
						}

						$btn_style          = isset($filter_options['ajax_filter_style']) ? $filter_options['ajax_filter_style'] : 'fl_dropdown';
						$hide_taxonomy_name = isset($taxonomy_types[$index]['hide_taxonomy_name']) ? $taxonomy_types[$index]['hide_taxonomy_name'] : false;
						$show_taxonomy      = !$hide_taxonomy_name ? $taxonomy : '';
						$label              = isset($filter_options['ajax_filter_label']) && !empty($filter_options['ajax_filter_label']) ? $filter_options['ajax_filter_label'] : $show_taxonomy;

						$hide_empty = isset($filter_options['ajax_hide_empty']) ? $filter_options['ajax_hide_empty'] : '';
						$show_count = isset($filter_options['ajax_show_count']) ? $filter_options['ajax_show_count'] : '';

						$eful_live_filter_align = isset($filter_options['eful_live_filter_align']) ? $filter_options['eful_live_filter_align'] : 'center';
						if ($add_filter && !empty($terms) && !empty($taxonomy)) {
							$filter_item             = self::eful_filter_style($btn_style, $taxonomy, $label, $all_text, $eful_live_filter_align);
							$newterm_array[$index] = array($filter_item['first_item']);
							foreach ($terms as $term) {
								$selected = '';
								$checked  = '';
								if (!empty($selected_term_list) && is_array($selected_term_list)) {
									foreach ($selected_term_list as $key => $tax_type) {
										$cr_taxonomy = $tax_type['taxonomy'];
										$cr_terms    = $tax_type['term_id'];
										if (strpos($cr_terms, ',') !== false) {
											$cr_terms = explode(',', $cr_terms);
										} else {
											$cr_terms = array($cr_terms);
										}
										if ($cr_taxonomy == $taxonomy && in_array($term, $cr_terms)) {
											$selected = 'selected';
											$checked  = 'checked';
											break;
										}
									}
								}
								$p_term = get_term($term, $taxonomy);
								if (!is_wp_error($p_term) && !empty($p_term)) {
									$term_post_count = $p_term->count;
									$term_post_count = $term_post_count > $post_limit ? $post_limit : $term_post_count;
									if ($show_count && 'AND' == $relation) {
										$count_query              = $query_args;
										$count_query['tax_query'] = array(
											array(
												'taxonomy' => $taxonomy,
												'field'    => 'term_id',
												'terms'    => $term,
											),
										);
										$count_post_posts         = get_posts($count_query);
										$term_post_count          = count(array_intersect($count_post_posts, $all_post_ids));
									}

									if (!$hide_empty) {
										$push_item = self::eful_filter_style($btn_style, $taxonomy, $label, $all_text, $eful_live_filter_align, $show_count, $term, $p_term->name, $term_post_count, $id, $selected, $checked)['push_item'];
										array_push($newterm_array[$index], $push_item);
									} elseif ($hide_empty && $term_post_count > 0) {
										$push_item = self::eful_filter_style($btn_style, $taxonomy, $label, $all_text, $eful_live_filter_align, $show_count, $term, $p_term->name, $term_post_count, $id, $selected, $checked)['push_item'];
										array_push($newterm_array[$index], $push_item);
									}
								}
							}
							if (!$all_text) {
								$newterm_array[$index][1] = preg_replace('/ type=/i', ' selected checked type=', $newterm_array[$index][1]);
							}
							$tax_html = implode('', $newterm_array[$index]);
							$output   = $output . force_balance_tags($tax_html);
						}
					}
					$index++;
				}
				$allowed_tags = array(
					'form'  => array(
						'class' => array(),
						'style' => array(),
					),
					'p'     => array(),
					'div'   => array(
						'class' => array(),
						'style' => array(),
					),
					'label' => array(),
					'input' => array(
						'checked'       => array(),
						'type'          => array(),
						'name'          => array(),
						'data-taxonomy' => array(),
						'value'         => array(),
					),
				);

				echo wp_kses($output, $allowed_tags);
			}
		}
	}

	/**
	 * Live Filter reset after ajax request.
	 */
	public static function eful_admin_live_filter_reset()
	{
		if (!current_user_can('manage_options')) {
			return;
		}
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'speful_nonce')) {
			return false;
		}
		$eful_gl_id           = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$eful_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$last_filter         = isset($_POST['last_filter']) ? sanitize_text_field(wp_unslash($_POST['last_filter'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$selected_term_list  = isset($_POST['term_list']) ? rest_sanitize_array(wp_unslash($_POST['term_list'])) : '';
		$settings            = array();
		parse_str(wp_kses_post($_POST['data']), $settings);
		$layout                       = $settings['ta_efp_layouts'];
		$layout_preset                = isset($layout['eful_layout_preset']) ? $layout['eful_layout_preset'] : '';
		$view_options                 = $settings['eful_view_options'];
		$query_args                   = EFUL_QueryInside::eful_get_filtered_content($view_options, $eful_gl_id);
		$query_args['fields']         = 'ids';
		$new_query_args               = $query_args;
		$post_limit                   = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$query_args['posts_per_page'] = $post_limit;
		$query_post_ids               = get_posts($new_query_args);

		$relation          = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
		$is_term_intersect = true;
		if ('AND' !== $relation) {
			$is_term_intersect = false;
		}
		$query_args = EFUL_Functions::eful_modify_query_params($query_args, $keyword, $author_id, $orderby, $order, $selected_term_list, 0, $relation, $query_post_ids, $eful_lang);
		self::eful_live_filter($view_options, $query_args, $eful_gl_id, $is_term_intersect, $selected_term_list, $last_filter);
		self::eful_author_filter($view_options, $query_args, $author_id);
		wp_die();
	}

	/**
	 * Author filter bar.
	 *
	 * @param mixed  $view_options options.
	 * @param array  $query_args custom query array.
	 * @param string $current_author current author.
	 * @return void
	 */
	public static function eful_author_filter($view_options, $query_args, $current_author = '')
	{
		$filter_by            = isset($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : array();
		$post_limit           = isset($view_options['eful_post_limit']) && !empty($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;

		if (in_array('author', $filter_by, true)) {
			$eful_filter_by_author  = isset($view_options['eful_filter_by_author']) ? $view_options['eful_filter_by_author'] : '';
			$add_filter_post       = isset($eful_filter_by_author['add_author_filter_post']) ? $eful_filter_by_author['add_author_filter_post'] : '';
			$eful_select_author_by  = isset($eful_filter_by_author['eful_select_author_by']) ? $eful_filter_by_author['eful_select_author_by'] : '';
			$ajax_filter_options   = isset($eful_filter_by_author['ajax_filter_options']) ? $eful_filter_by_author['ajax_filter_options'] : '';
			$btn_type              = isset($ajax_filter_options['ajax_filter_style']) ? $ajax_filter_options['ajax_filter_style'] : '';
			$label                 = isset($ajax_filter_options['ajax_filter_label']) && !empty($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : 'Author';
			$all_text              = isset($ajax_filter_options['ajax_rename_all_text']) ? $ajax_filter_options['ajax_rename_all_text'] : '';
			$hide_empty            = isset($ajax_filter_options['ajax_hide_empty']) ? $ajax_filter_options['ajax_hide_empty'] : '';
			$show_count            = isset($ajax_filter_options['ajax_show_count']) ? $ajax_filter_options['ajax_show_count'] : '';
			$eful_live_filter_align = isset($ajax_filter_options['eful_live_filter_align']) ? $ajax_filter_options['eful_live_filter_align'] : 'center';
			if ($add_filter_post && is_array($eful_select_author_by)) {
				$filter_item   = self::eful_author_filter_style($btn_type, $label, $all_text, $eful_live_filter_align);
				$newterm_array = array($filter_item['first_item']);
				foreach ($eful_select_author_by as $author_id) {
					$author_name = get_the_author_meta('nicename', $author_id);
					// Prepare the query arguments.
					$query_args['posts_per_page'] = (int) $post_limit;
					$query_args['author__in']     = $author_id;
					$query_args['fields']         = 'ids';
					// Get all the posts.
					if ($current_author === $author_id) {
						$selected = 'selected';
						$checked  = 'checked';
					} else {
						$selected = '';
						$checked  = '';
					}
					$author_posts      = get_posts($query_args);
					$author_post_count = count($author_posts);
					if (!$hide_empty) {
						$push_item = self::eful_author_filter_style($btn_type, $label, $all_text, $eful_live_filter_align, $author_id, $author_name, $author_post_count, $show_count, $selected, $checked)['push_item'];
						array_push($newterm_array, $push_item);
					} elseif ($hide_empty && $author_post_count > 0) {
						$push_item = self::eful_author_filter_style($btn_type, $label, $all_text, $eful_live_filter_align, $author_id, $author_name, $author_post_count, $show_count, $selected, $checked)['push_item'];
						array_push($newterm_array, $push_item);
					}
				}
				$tax_html = implode('', $newterm_array);
				$output   = '';
				$output   = $output . force_balance_tags($tax_html);
				$allowed_tags = array(
					'form'  => array(
						'class' => array(),
						'style' => array(),
					),
					'p'     => array(),
					'div'   => array(
						'class' => array(),
						'style' => array(),
					),
					'label' => array(),
					'input' => array(
						'checked'       => array(),
						'type'          => array(),
						'name'          => array(),
						'data-taxonomy' => array(),
						'value'         => array(),
					),
				);

				echo wp_kses($output, $allowed_tags);
			}
		}
	}

	/**
	 * Orderby filter bar
	 *
	 * @param mixed  $view_options options.
	 * @param array  $query_args custom query.
	 * @param string $sid shortcode id.
	 * @return void
	 */
	public static function eful_orderby_filter_bar($view_options, $query_args, $sid = null)
	{
		$filter_by = isset($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : array();
		if (in_array('sortby', $filter_by, true)) {
			$eful_filter_by_order    = isset($view_options['eful_filter_by_order']) ? $view_options['eful_filter_by_order'] : '';
			$add_filter_post        = isset($eful_filter_by_order['add_orderby_filter_post']) ? $eful_filter_by_order['add_orderby_filter_post'] : '';
			$ajax_filter_options    = isset($eful_filter_by_order['orderby_ajax_filter_options']) ? $eful_filter_by_order['orderby_ajax_filter_options'] : '';
			$eful_add_filter_orderby = isset($ajax_filter_options['eful_add_filter_orderby']) ? $ajax_filter_options['eful_add_filter_orderby'] : '';
			$btn_type               = isset($ajax_filter_options['orderby_filter_style']) ? $ajax_filter_options['orderby_filter_style'] : 'fl_dropdown';
			$label                  = isset($ajax_filter_options['ajax_filter_label']) && !empty($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : 'Filter by';
			$all_text               = isset($ajax_filter_options['ajax_rename_all_text']) ? $ajax_filter_options['ajax_rename_all_text'] : '';
			$eful_live_filter_align  = isset($ajax_filter_options['eful_live_filter_align']) ? $ajax_filter_options['eful_live_filter_align'] : 'center';
			if ($add_filter_post && is_array($eful_add_filter_orderby)) {
				$filter_item   = self::eful_orderby_filter_style($btn_type, $label, $eful_live_filter_align);
				$newterm_array = array($filter_item['first_item']);
				foreach ($eful_add_filter_orderby as $orderby) {
					$push_item = self::eful_orderby_filter_style($btn_type, $label, $eful_live_filter_align, $orderby, $sid)['push_item'];
					array_push($newterm_array, $push_item);
				}
				$tax_html = implode('', $newterm_array);
				$output   = '';
				$output   = $output . force_balance_tags($tax_html);
				$allowed_tags = array(
					'form'  => array(
						'class' => array(),
						'style' => array(),
					),
					'p'     => array(),
					'div'   => array(
						'class' => array(),
						'style' => array(),
					),
					'label' => array(),
					'input' => array(
						'checked'       => array(),
						'type'          => array(),
						'name'          => array(),
						'data-taxonomy' => array(),
						'value'         => array(),
					),
				);

				echo wp_kses($output, $allowed_tags);
			}
		}
	}

	/**
	 * Order filter button.
	 *
	 * @param mixed  $view_options options.
	 * @param string $sid shortcode id.
	 * @return void
	 */
	public static function eful_order_filter_bar($view_options, $sid = null)
	{
		$filter_by = isset($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : array();
		if (in_array('sortby', $filter_by)) {
			$eful_filter_by_order     = isset($view_options['eful_filter_by_order']) ? $view_options['eful_filter_by_order'] : '';
			$add_filter_post         = isset($eful_filter_by_order['add_order_filter_post']) ? $eful_filter_by_order['add_order_filter_post'] : '';
			$ajax_filter_options     = isset($eful_filter_by_order['order_filter_options']) ? $eful_filter_by_order['order_filter_options'] : '';
			$eful_select_filter_order = isset($eful_filter_by_order['eful_select_filter_order']) ? $eful_filter_by_order['eful_select_filter_order'] : '';
			$eful_add_filter_orderby  = array('DESC', 'ASC');
			$btn_type                = isset($ajax_filter_options['order_filter_style']) ? $ajax_filter_options['order_filter_style'] : '';
			$label                   = isset($ajax_filter_options['order_filter_label']) ? $ajax_filter_options['order_filter_label'] : '';
			$eful_live_filter_align   = isset($ajax_filter_options['eful_live_filter_align']) ? $ajax_filter_options['eful_live_filter_align'] : 'center';
			if ($add_filter_post) {
				$filter_item   = self::eful_order_filter_style($btn_type, $label, $eful_live_filter_align);
				$newterm_array = array($filter_item['first_item']);
				foreach ($eful_add_filter_orderby as $order) {
					$push_item = self::eful_order_filter_style($btn_type, $label, $eful_live_filter_align, $order, $eful_select_filter_order, $sid)['push_item'];
					array_push($newterm_array, $push_item);
				}
				$tax_html = implode('', $newterm_array);
				$output   = '';
				$output   = $output . force_balance_tags($tax_html);
				$allowed_tags = array(
					'form'  => array(
						'class' => array(),
						'style' => array(),
					),
					'p'     => array(),
					'div'   => array(
						'class' => array(),
					),
					'label' => array(),
					'input' => array(
						'checked'       => array(),
						'type'          => array(),
						'name'          => array(),
						'data-taxonomy' => array(),
						'value'         => array(),
					),
				);

				echo wp_kses($output, $allowed_tags);
			}
		}
	}

	/**
	 * Author filter type.
	 *
	 * @param string  $btn_type button type.
	 * @param string  $label author filter label.
	 * @param string  $all_text all text.
	 * @param int     $align alignment.
	 * @param int     $author_id author id.
	 * @param string  $author_name user name.
	 * @param int     $author_post_count  user post count.
	 * @param boolean $show_count show/hide post count.
	 * @param string  $selected select.
	 * @param string  $checked check.
	 */
	public static function eful_author_filter_style($btn_type, $label, $all_text, $align = 'center', $author_id = null, $author_name = null, $author_post_count = null, $show_count = true, $selected = '', $checked = '')
	{
		if ($show_count) {
			$post_count_markup = '<span class="eventful-count">(' . $author_post_count . ')</span>';
		} else {
			$post_count_markup = '';
		}

		$final_author_url_value = isset($_GET['eful_author_id']) ? wp_unslash(sanitize_text_field($_GET['eful_author_id'])) : '';
		if ($final_author_url_value == $author_id) {
			$a_selected = 'selected';
			$a_checked  = 'checked';
		} else {
			$a_selected = $selected;
			$a_checked  = $checked;
		}
		if ('fl_radio' === $btn_type) {
			$all_label  = !empty($all_text) ? $all_text : '';
			$first_item = '<div class="eventful-author-filter eventful-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="author" value="all">' . $all_label . '</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="author" type="radio" ' . $a_checked . ' value="' . esc_attr($author_id) . '">' . esc_attr($author_name) . $post_count_markup . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$all_label  = !empty($all_text) ? '<div>' . $all_text . '</div>' : '';
			$first_item = '<div class="eventful-author-filter eventful-bar fl_button" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="author" value="all">' . $all_label . '</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="author" type="radio" ' . $a_checked . ' value="' . esc_attr($author_id) . '"><div>' . esc_attr($author_name) . $post_count_markup . '</div></label></div>';
		} else {
			$all_label  = !empty($all_text) ? $all_text : '';
			$first_item = '<div class="eventful-author-filter eventful-bar" style="text-align:' . esc_attr($align) . ';"> <label class="eventful-label">' . esc_html($label) . '</label><select><option  name="author" value="all">' . $all_label . '</option>';
			$push_item  = '<option name="author" value="' . esc_attr($author_id) . '" ' . $a_selected . '>' . esc_attr($author_name) . $post_count_markup . ' </option>';
		}
		$filter_output = array(
			'first_item' => $first_item,
			'push_item'  => $push_item,
		);

		return $filter_output;
	}

	/**
	 * Order by filter bar style.
	 *
	 * @param string $btn_type button type.
	 * @param string $label order by label.
	 * @param string $align alignment.
	 * @param string $orderby order text.
	 * @param string $sid shortcode id.
	 * @return array
	 */
	public static function eful_orderby_filter_style($btn_type, $label, $align = 'center', $orderby = null, $sid = null)
	{
		$filter_url_value        = isset($_SERVER['QUERY_STRING']) ? wp_unslash(sanitize_text_field($_SERVER['QUERY_STRING'])) : '';
		$final_orderby_url_value = '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $sid) {
				$final_orderby_url_value = isset($_GET['eful_orderby']) ? sanitize_text_field(wp_unslash($_GET['eful_orderby'])) : '';
			}
		}

		if ($final_orderby_url_value == $orderby) {
			$is_selected = 'selected';
			$is_checked  = 'checked';
		} else {
			$is_selected = '';
			$is_checked  = '';
		}

		if ('fl_radio' === $btn_type) {
			$first_item = '<div class="eventful-order-by eventful-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="orderby" value="">None</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="orderby" type="radio"  ' . $is_checked . ' value="' . $orderby . '">' . $orderby . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$first_item = '<div class="eventful-order-by eventful-bar fl-btn" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p> <div class="fl_radio"><label><input checked type="radio" name="orderby" value=""><div>None</div></label></div>';
			$push_item  = '<div class="fl_radio"><label><input type="radio" name="orderby" ' . $is_checked . ' value="' . $orderby . '"><div>' . $orderby . '</div></label></div>';
		} else {
			$first_item = '<div class="eventful-order-by eventful-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><select><option  name="orderby" value="">None</option>';
			$push_item  = '<option name="orderby" ' . $is_selected . ' value="' . $orderby . '">' . $orderby . '</option>';
		}
		$filter_output = array(
			'first_item' => $first_item,
			'push_item'  => $push_item,
		);
		
		return $filter_output;
	}

	/**
	 * Order filter style
	 *
	 * @param string $btn_type button type.
	 * @param string $label order filter label.
	 * @param string $align alignment text.
	 * @param string $order order text.
	 * @param string $select_order selected order.
	 * @param string $sid shortcode id.
	 */
	public static function eful_order_filter_style($btn_type, $label, $align = 'center', $order = null, $select_order = null, $sid = null)
	{
		$final_order_url_value = '';
		$filter_url_value      = isset($_SERVER['QUERY_STRING']) ? wp_unslash(sanitize_text_field($_SERVER['QUERY_STRING'])) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $sid) {
				$final_order_url_value = isset($_GET['eful_order']) ? sanitize_text_field(wp_unslash($_GET['eful_order'])) : '';
			}
		}

		if ($final_order_url_value == $order) {
			$checked  = 'checked';
			$selected = 'selected';
		} else {
			$selected = '';
			$checked  = '';
		}
		if ('fl_radio' === $btn_type) {
			$first_item = '<div class="eventful-order eventful-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_radio"><label><input name="order" ' . $checked . ' type="radio" value="' . $order . '">' . $order . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$first_item = '<div class="eventful-order eventful-bar fl-btn" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_radio"><label><input type="radio" ' . $checked . ' name="order" value="' . $order . '"><div>' . $order . '</div></label></div>';
		} else {
			$first_item = '<div class="eventful-order eventful-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><select>';
			$push_item  = '<option name="order" ' . $selected . ' value="' . $order . '">' . $order . '</option>';
		}
		$filter_output = array(
			'first_item' => $first_item,
			'push_item'  => $push_item,
		);
		return $filter_output;
	}

	/**
	 * Live search bar
	 *
	 * @param int    $view_options options.
	 * @param string $sid shortcode id.
	 * @return void
	 */
	public static function eful_live_search_bar($view_options, $sid = null)
	{
		$filter_by        = isset($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : array();
		$final_keyword    = '';
		$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash(sanitize_text_field($_SERVER['QUERY_STRING'])) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $sid) {
				$final_keyword = isset($_GET['eful_keyword']) ? sanitize_text_field(wp_unslash($_GET['eful_keyword'])) : '';
			}
		}
		if (in_array('keyword', $filter_by, true)) {
			$eful_filter_by_keyword = isset($view_options['eful_filter_by_keyword']) ? $view_options['eful_filter_by_keyword'] : '';
			$add_filter_post       = isset($eful_filter_by_keyword['add_search_filter_post']) ? $eful_filter_by_keyword['add_search_filter_post'] : '';
			if ($add_filter_post) {
				$ajax_filter_options   = isset($eful_filter_by_keyword['ajax_filter_options']) ? $eful_filter_by_keyword['ajax_filter_options'] : '';
				$label                 = isset($ajax_filter_options['ajax_filter_label']) && !empty($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : '';
				$eful_live_filter_align = isset($ajax_filter_options['eful_live_filter_align']) ? $ajax_filter_options['eful_live_filter_align'] : 'center';
				echo '<div class="eventful-ajax-search eventful-bar" style="text-align:' . esc_attr($eful_live_filter_align) . ';"><label class="eventful-label">' . wp_kses_post($label) . ' <input type="text" value="' . esc_attr($final_keyword) . '" class="eventful-search-field" placeholder="Search..."></label></div>';
			}
		}
	}
}
