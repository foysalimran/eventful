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
class EFP_Live_Filter
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 */
	public function __construct()
	{
		add_action('wp_ajax_efp_live_filter_reset', array($this, 'efp_live_filter_reset'));
		add_action('wp_ajax_efp_admin_live_filter_reset', array($this, 'efp_admin_live_filter_reset'));
		add_action('wp_ajax_nopriv_efp_live_filter_reset', array($this, 'efp_live_filter_reset'));
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
	public static function efp_filter_style($btn_type, $taxonomy, $label, $all_text, $align = 'center', $show_count = false, $term = null, $name = null, $p_count = null, $id = '', $pre_selected = '', $pre_checked = '')
	{
		if ($show_count) {
			$post_count_markup = '<span class="efp-count">(' . $p_count . ')</span>';
		} else {
			$post_count_markup = '';
		}
		$is_checked       = $pre_checked;
		$is_selected      = $pre_selected;
		$checked          = $pre_checked;
		$selected         = $pre_selected;
		$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash($_SERVER['QUERY_STRING']) : '';
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

			$first_item = '<form class="efp-filter-by-checkbox efp-bar" data-taxonomy="' . $taxonomy . '" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_checkbox"><label><input ' . $is_checked . ' name="' . $taxonomy . '" type="checkbox" ' . $checked . ' data-taxonomy="' . $taxonomy . '" value="' . $term . '">' . $name . $post_count_markup . '</span></label></div>';
		} elseif ('fl_radio' === $btn_type) {
			$all_label  = !empty($all_text) ? $all_text : '';
			$all_button = !empty($all_text) ? '<div class="fl_radio"><label><input checked type="radio" name="' . $taxonomy . '" data-taxonomy="' . $taxonomy . '"value="all">' . $all_label . '</label></div>' : '';
			$first_item = '<form class="efp-filter-by efp-bar" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p>' . $all_button;
			$push_item  = '<div class="fl_radio"><label><input ' . $is_checked . ' name="' . $taxonomy . '" type="radio" ' . $checked . ' data-taxonomy="' . $taxonomy . '" value="' . $term . '">' . $name . $post_count_markup . '</span></label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$all_label  = !empty($all_text) ? '<div>' . $all_text . '</div>' : '';
			$all_button = !empty($all_text) ? '<div class="fl_radio"><label><input checked type="radio" name="' . $taxonomy . '" data-taxonomy="' . $taxonomy . '" value="all">' . $all_label . '</label></div>' : '';

			$first_item = '<form class="efp-filter-by efp-bar fl_button filter-' . $taxonomy . '" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p>' . $all_button;
			$push_item  = '<div class="fl_radio"><label><input ' . $is_checked . ' name="' . $taxonomy . '" type="radio" ' . $checked . ' data-taxonomy="' . $taxonomy . '" value="' . $term . '"><div>' . $name . $post_count_markup . '</div></label></div>';
		} else {
			$all_label  = !empty($all_text) ? $all_text : '';
			$all_button = !empty($all_text) ? '<option value="all"  data-taxonomy="' . $taxonomy . '">' . $all_label . '</option>' : '';

			$first_item = '<form class="efp-filter-by efp-bar" style="text-align:' . esc_attr($align) . ';"> <label class="efp-label">' . esc_html($label) . '</label> <select>' . $all_button;
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
	public static function array_flatten($array)
	{
		if (!is_array($array)) {
			return false;
		}
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, self::array_flatten($value));
			} else {
				$result[$key] = $value;
			}
		}
		return $result;
	}
	/**
	 * Term id list after ajax filter.
	 *
	 * @param object $eventful_query Post query array.
	 * @param object $taxonomies select Taxonomies.
	 * @return Array
	 */
	public static function efp_all_other_taxonomy_term($eventful_query, $taxonomies)
	{
		$post_ids         = $eventful_query;
		$y                = 0;
		$final_term_list  = array();
		$taxonomies_count = count($taxonomies);
		while ($y < $taxonomies_count) {
			$term_list = array();
			foreach ($post_ids as $key => $id) {
				$ct_term = wp_get_post_terms($id, $taxonomies[$y], array('fields' => 'ids'));
				if (is_array($ct_term) && !empty($ct_term)) {
					array_push($term_list, $ct_term);
				}
			}
			$term_list                            = array_unique(self::array_flatten($term_list));
			$final_term_list[$taxonomies[$y]] = $term_list;
			$y++;
		}
		return $final_term_list;
	}

	/**
	 * All terms form the query
	 *
	 * @param  array  $eventful_query query arg.
	 * @param  string $taxonomy taxonomy.
	 * @return array
	 */
	public static function efp_all_taxonomy_terms_form_the_query($eventful_query, $taxonomy)
	{
		$post_ids  = $eventful_query;
		$term_list = array();
		foreach ($post_ids as $key => $id) {
			$ct_term = wp_get_post_terms($id, $taxonomy, array('fields' => 'ids'));
			if (is_array($ct_term) && !empty($ct_term)) {
				array_push($term_list, $ct_term);
			}
		}
		return array_unique(self::array_flatten($term_list));
	}
	/**
	 * Live Filter reset after ajax request.
	 */
	public static function efp_live_filter_reset()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'spefp_nonce')) {
			return false;
		}
		$eventful_gl_id           = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$eventful_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$last_filter         = isset($_POST['last_filter']) ? sanitize_text_field(wp_unslash($_POST['last_filter'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$custom_fields_array = isset($_POST['custom_fields_array']) ? wp_unslash($_POST['custom_fields_array']) : ''; //phpcs:ignore
		$selected_term_list  = isset($_POST['term_list']) ? wp_unslash($_POST['term_list']) : ''; //phpcs:ignore

		$view_options                 = get_post_meta($eventful_gl_id, 'ta_eventful_view_options', true);
		$query_args                   = EFP_QueryInside::get_filtered_content($view_options, $eventful_gl_id);
		$query_args['fields']         = 'ids';
		$post_limit                   = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$query_args['posts_per_page'] = $post_limit;
		$query_post_ids               = get_posts($query_args);
		$relation                     = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
		$is_term_intersect            = true;
		if ('AND' !== $relation) {
			$is_term_intersect = false;
		}
		$query_args = EFP_Functions::modify_query_params($query_args, $keyword, $author_id, $custom_fields_array, $orderby, $order, $selected_term_list, 0, $relation, $query_post_ids, $eventful_lang);
		$eventful_query  = array();
		self::efp_live_filter($view_options, $query_args, $eventful_gl_id, $is_term_intersect, $selected_term_list, $last_filter);
		self::efp_author_filter($view_options, $query_args, $author_id);
		self::efp_custom_filter_filter($view_options, $query_args, '', $custom_fields_array, $last_filter);

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
	public static function efp_live_filter($view_options, $query_args = '', $id = '', $is_term_intersect = true, $selected_term_list = array(), $last_filter = '')
	{
		$filter_by                    = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
		$post_limit                   = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$query_args['posts_per_page'] = $post_limit;
		$query_args['fields']         = 'ids';
		if (in_array('taxonomy', $filter_by, true)) {
			$taxonomy_types = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomy_and_terms']) && !empty($view_options['efp_filter_by_taxonomy']['efp_taxonomy_and_terms']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomy_and_terms'] : '';
			$relation       = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
			if (!empty($taxonomy_types)) {
				$output         = '';
				$newterm_array  = array();
				$index          = 0;
				$taxonomies     = array();
				$taxonomy_count = count($taxonomy_types);
				while ($index < $taxonomy_count) {
					$add_filter = isset($taxonomy_types[$index]['add_filter_post']) ? $taxonomy_types[$index]['add_filter_post'] : '';
					if ($add_filter) {
						$taxonomy        = isset($taxonomy_types[$index]['efp_select_taxonomy']) ? $taxonomy_types[$index]['efp_select_taxonomy'] : '';			
					$all_terms = get_terms($taxonomy);
					$all_terms = wp_list_pluck($all_terms, 'term_id');
					
						$terms           = isset($taxonomy_types[$index]['efp_select_terms']) ? $taxonomy_types[$index]['efp_select_terms'] : $all_terms;
						$all_post_ids    = get_posts($query_args);
						$post_limit      = count($all_post_ids);
						$url_last_filter = isset($_GET['slf']) ? wp_unslash(sanitize_text_field($_GET['slf'])) : ''; //phpcs:ignore

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
							$new_terms = self::efp_all_taxonomy_terms_form_the_query($all_post_ids, $taxonomy);
							$terms     = is_array($terms) ? $terms : array($terms);
							$terms     = array_intersect($terms, $new_terms);
						}

						$btn_style          = isset($filter_options['ajax_filter_style']) ? $filter_options['ajax_filter_style'] : 'fl_dropdown';
						$hide_taxonomy_name = isset($taxonomy_types[$index]['hide_taxonomy_name']) ? $taxonomy_types[$index]['hide_taxonomy_name'] : false;
						$show_taxonomy      = !$hide_taxonomy_name ? $taxonomy : '';
						$label              = isset($filter_options['ajax_filter_label']) && !empty($filter_options['ajax_filter_label']) ? $filter_options['ajax_filter_label'] : $show_taxonomy;

						$hide_empty = isset($filter_options['ajax_hide_empty']) ? $filter_options['ajax_hide_empty'] : '';
						$show_count = isset($filter_options['ajax_show_count']) ? $filter_options['ajax_show_count'] : '';

						$eventful_live_filter_align = isset($filter_options['efp_live_filter_align']) ? $filter_options['efp_live_filter_align'] : 'center';
						if ($add_filter && !empty($terms) && !empty($taxonomy)) {
							$filter_item             = self::efp_filter_style($btn_style, $taxonomy, $label, $all_text, $eventful_live_filter_align);
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
										$push_item = self::efp_filter_style($btn_style, $taxonomy, $label, $all_text, $eventful_live_filter_align, $show_count, $term, $p_term->name, $term_post_count, $id, $selected, $checked)['push_item'];
										array_push($newterm_array[$index], $push_item);
									} elseif ($hide_empty && $term_post_count > 0) {
										$push_item = self::efp_filter_style($btn_style, $taxonomy, $label, $all_text, $eventful_live_filter_align, $show_count, $term, $p_term->name, $term_post_count, $id, $selected, $checked)['push_item'];
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
				echo $output; //phpcs:ignore
			}
		}
	}

	/**
	 * Live Filter reset after ajax request.
	 */
	public static function efp_admin_live_filter_reset()
	{
		if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'spefp_nonce')) {
			return false;
		}
		$eventful_gl_id           = isset($_POST['id']) ? absint($_POST['id']) : '';
		$keyword             = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
		$orderby             = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : '';
		$order               = isset($_POST['order']) ? sanitize_text_field(wp_unslash($_POST['order'])) : '';
		$taxonomy            = isset($_POST['taxonomy']) ? sanitize_text_field(wp_unslash($_POST['taxonomy'])) : '';
		$eventful_lang            = isset($_POST['lang']) ? sanitize_text_field(wp_unslash($_POST['lang'])) : '';
		$term_id             = isset($_POST['term_id']) ? sanitize_text_field(wp_unslash($_POST['term_id'])) : '';
		$author_id           = isset($_POST['author_id']) ? sanitize_text_field(wp_unslash($_POST['author_id'])) : '';
		$last_filter         = isset($_POST['last_filter']) ? sanitize_text_field(wp_unslash($_POST['last_filter'])) : '';
		$paged               = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : '';
		$custom_fields_array = isset($_POST['custom_fields_array']) ? wp_unslash($_POST['custom_fields_array']) : ''; //phpcs:ignore
		$selected_term_list  = isset($_POST['term_list']) ? wp_unslash($_POST['term_list']) : '';
		$settings            = array(); //phpcs:ignore
		parse_str($_POST['data'], $settings); //phpcs:ignore
		$layout                       = $settings['ta_eventful_layouts'];
		$layout_preset                = isset($layout['eventful_layout_preset']) ? $layout['eventful_layout_preset'] : '';
		$view_options                 = $settings['ta_eventful_view_options'];
		$query_args                   = EFP_QueryInside::get_filtered_content($view_options, $eventful_gl_id);
		$query_args['fields']         = 'ids';
		$new_query_args               = $query_args;
		$post_limit                   = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;
		$query_args['posts_per_page'] = $post_limit;
		$query_post_ids               = get_posts($new_query_args);

		$relation          = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomies_relation'] : 'AND';
		$is_term_intersect = true;
		if ('AND' !== $relation) {
			$is_term_intersect = false;
		}
		$query_args = EFP_Functions::modify_query_params($query_args, $keyword, $author_id, $custom_fields_array, $orderby, $order, $selected_term_list, 0, $relation, $query_post_ids, $eventful_lang);
		self::efp_live_filter($view_options, $query_args, $eventful_gl_id, $is_term_intersect, $selected_term_list, $last_filter);
		self::efp_author_filter($view_options, $query_args, $author_id);
		self::efp_custom_filter_filter($view_options, $query_args, '', $custom_fields_array, $last_filter);
		wp_die();
	}


	/**
	 * Final showing terms list
	 *
	 * @param string $taxonomy taxonomy.
	 * @param string $selected_taxonomy Selected taxonomy.
	 * @param array  $all_term all terms id.
	 * @param array  $terms terms.
	 * @param int    $tax_settings_count taxonomy count.
	 * @param array  $selected_taxs Selected taxonomys.
	 * @param array  $is_other_query_active query.
	 * @return object
	 */
	public static function efp_showing_term($taxonomy, $selected_taxonomy, $all_term, $terms, $tax_settings_count, $selected_taxs, $is_other_query_active = false)
	{
		if ($selected_taxs) {
			if (($selected_taxonomy === $taxonomy && $tax_settings_count < 1) || (count($selected_taxs) <= 1 && $selected_taxs[0] === $taxonomy)) {
				$final_terms = $terms;
			} else {
				$final_terms = array_intersect($all_term, $terms);
			}
		} else {
			if ($is_other_query_active) {
				$final_terms = array_intersect($all_term, $terms);
			} else {
				$final_terms = $terms;
			}
		}

		return $final_terms;
	}

	/**
	 * Author filter bar.
	 *
	 * @param mixed  $view_options options.
	 * @param array  $query_args custom query array.
	 * @param string $current_author current author.
	 * @return void
	 */
	public static function efp_author_filter($view_options, $query_args, $current_author = '')
	{
		$filter_by            = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
		$post_limit           = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;

		if (in_array('author', $filter_by, true)) {
			$eventful_filter_by_author  = isset($view_options['efp_filter_by_author']) ? $view_options['efp_filter_by_author'] : '';
			$add_filter_post       = isset($eventful_filter_by_author['add_author_filter_post']) ? $eventful_filter_by_author['add_author_filter_post'] : '';
			$eventful_select_author_by  = isset($eventful_filter_by_author['efp_select_author_by']) ? $eventful_filter_by_author['efp_select_author_by'] : '';
			$ajax_filter_options   = isset($eventful_filter_by_author['ajax_filter_options']) ? $eventful_filter_by_author['ajax_filter_options'] : '';
			$btn_type              = isset($ajax_filter_options['ajax_filter_style']) ? $ajax_filter_options['ajax_filter_style'] : '';
			$label                 = isset($ajax_filter_options['ajax_filter_label']) && !empty($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : 'Author';
			$all_text              = isset($ajax_filter_options['ajax_rename_all_text']) ? $ajax_filter_options['ajax_rename_all_text'] : '';
			$hide_empty            = isset($ajax_filter_options['ajax_hide_empty']) ? $ajax_filter_options['ajax_hide_empty'] : '';
			$show_count            = isset($ajax_filter_options['ajax_show_count']) ? $ajax_filter_options['ajax_show_count'] : '';
			$eventful_live_filter_align = isset($ajax_filter_options['efp_live_filter_align']) ? $ajax_filter_options['efp_live_filter_align'] : 'center';
			if ($add_filter_post && is_array($eventful_select_author_by)) {
				$filter_item   = self::efp_author_filter_style($btn_type, $label, $all_text, $eventful_live_filter_align);
				$newterm_array = array($filter_item['first_item']);
				foreach ($eventful_select_author_by as $author_id) {
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
						$push_item = self::efp_author_filter_style($btn_type, $label, $all_text, $eventful_live_filter_align, $author_id, $author_name, $author_post_count, $show_count, $selected, $checked)['push_item'];
						array_push($newterm_array, $push_item);
					} elseif ($hide_empty && $author_post_count > 0) {
						$push_item = self::efp_author_filter_style($btn_type, $label, $all_text, $eventful_live_filter_align, $author_id, $author_name, $author_post_count, $show_count, $selected, $checked)['push_item'];
						array_push($newterm_array, $push_item);
					}
				}
				$tax_html = implode('', $newterm_array);
				$output   = '';
				$output   = $output . force_balance_tags($tax_html);
				echo $output;
			}
		}
	}

	/**
	 * Custom filter
	 *
	 * @param  array  $view_options options.
	 * @param  array  $query_args query args.
	 * @param  string $sid shortcode id.
	 * @param  array  $custom_fields_array fields array.
	 * @param  string $last_filter last filter.
	 * @return void
	 */
	public static function efp_custom_filter_filter($view_options, $query_args, $sid = '', $custom_fields_array = array(), $last_filter = '')
	{
		$filter_by                    = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
		$post_limit                   = isset($view_options['efp_post_limit']) && !empty($view_options['efp_post_limit']) ? $view_options['efp_post_limit'] : 10000;

		$query_args['fields']         = 'ids';
		$query_args['posts_per_page'] = $post_limit;
		$old_all_post_ids             = get_posts($query_args);
		if (in_array('custom_field', $filter_by)) {
			$custom_field_groups = isset($view_options['efp_filter_custom_field']['efp_filter_by_custom_field_group']) ? $view_options['efp_filter_custom_field']['efp_filter_by_custom_field_group'] : '';
			if (!empty($custom_field_groups)) {
				$groups_count    = count($custom_field_groups);
				$newcustom_array = array();
				$output          = '';
				$index           = 0;

				while ($index < $groups_count) {
					$add_filter = isset($custom_field_groups[$index]['add_filter_post']) ? $custom_field_groups[$index]['add_filter_post'] : '';
					if ($add_filter) {
						$all_post_ids = get_posts($query_args);
						$field_key    = isset($custom_field_groups[$index]['efp_select_custom_field_key']) ? $custom_field_groups[$index]['efp_select_custom_field_key'] : '';

						$ajax_filter_options   = isset($custom_field_groups[$index]['ajax_filter_options']) ? $custom_field_groups[$index]['ajax_filter_options'] : '';
						$btn_style             = isset($ajax_filter_options['ajax_filter_style']) ? $ajax_filter_options['ajax_filter_style'] : 'fl_btn';
						$ajax_filter_label     = isset($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : '';
						$all_text              = isset($ajax_filter_options['ajax_rename_all_text']) ? $ajax_filter_options['ajax_rename_all_text'] : '';
						$eventful_live_filter_align = isset($ajax_filter_options['efp_live_filter_align']) ? $ajax_filter_options['efp_live_filter_align'] : '';
						$hide_empty            = isset($ajax_filter_options['ajax_hide_empty']) ? $ajax_filter_options['ajax_hide_empty'] : '';
						$show_count            = isset($ajax_filter_options['ajax_show_count']) ? $ajax_filter_options['ajax_show_count'] : '';
						$meta_values           = array();
						$url_last_filter       = isset($_GET['slf']) ? wp_unslash(sanitize_text_field($_GET['slf'])) : '';

						if ($last_filter == $field_key || $url_last_filter == $field_key) {
							$new_query  = $query_args;
							$meta_query = isset($new_query['meta_query']) ? $new_query['meta_query'] : '';
							if (!empty($meta_query)) {
								foreach ($meta_query as $key => $value) {
									if (is_array($value)) {
										if ($value['key'] == $field_key) {
											unset($meta_query[$key]);
										}
									}
								}
								$new_query['meta_query'] = $meta_query;
								$all_post_ids            = get_posts($new_query);
							}
						}
						if (!empty($all_post_ids)) {
							foreach ($all_post_ids as $key => $id) {
								$meta_value = get_post_meta($id, $field_key, true);
								if (!empty($meta_value) && !is_array($meta_value)) {
									$meta_values[] = $meta_value;
								}
							}
						}

						$post_counts_by_value = array_count_values($meta_values);
						$meta_values          = array_unique($meta_values);
						if ('fl_slider' == $btn_style) {
							$total_meta_values = array();
							if (!empty($old_all_post_ids)) {
								foreach ($old_all_post_ids as $key => $id) {
									$meta_value = get_post_meta($id, $field_key, true);
									if (!empty($meta_value) && !is_array($meta_value)) {
										$total_meta_values[] = $meta_value;
									}
								}
							}
							if (is_array($total_meta_values) && is_array($meta_values) && !empty($meta_values)) {
								$crmin = absint(min($meta_values));
								$crmax = absint(max($meta_values));
								$max   = absint(max($total_meta_values));
								$min   = absint(min($total_meta_values));
								if (!wp_script_is('jquery-ui-slider')) {
									wp_enqueue_script('jquery-ui-slider');
								}
								$newcustom_array[$index] = array(
									'<div class="efp-custom-field-filter-slider efp-bar" style="text-align:' . $eventful_live_filter_align . ';"><p>
							<label>' . esc_html($ajax_filter_label) . '</label>
							<input value="' . $min . '-' . $max . '" type="text" name=' . esc_attr($field_key) . ' class="efp-input" data-crmin="' . $crmin . '" data-min="' . $min . '" data-crmax="' . $crmax . '" data-max="' . $max . '" readonly>
						 </p> <div class="efp-slider"></div></div>',
								);
							}
						} else {
							$filter_item               = self::efp_custom_field_filter_style($btn_style, $ajax_filter_label, $all_text, $eventful_live_filter_align, $field_key);
							$newcustom_array[$index] = array($filter_item['first_item']);
							if (!empty($meta_values)) {
								foreach ($meta_values as $key => $value) {
									$selected = '';
									$checked  = '';
									if (!empty($custom_fields_array)) {
										foreach ($custom_fields_array as $key => $_custom_field) {
											$c_field_key   = $_custom_field['custom_field_key'];
											$c_field_value = $_custom_field['custom_field_value'];
											if (strpos($c_field_value, ',') !== false) {
												$c_field_value = explode(',', $c_field_value);
											} else {
												$c_field_value = array($c_field_value);
											}
											if ($field_key === $c_field_key && in_array($value, $c_field_value)) {
												$selected = 'selected';
												$checked  = 'checked';
												break;
											}
										}
									}

									if (!$hide_empty) {
										$push_item = self::efp_custom_field_filter_style($btn_style, $ajax_filter_label, $all_text, $eventful_live_filter_align, $field_key, $value, $post_counts_by_value[$value], $sid, $selected, $checked, $show_count)['push_item'];
										array_push($newcustom_array[$index], $push_item);
									} elseif ($post_counts_by_value[$value] > 0) {
										$push_item = self::efp_custom_field_filter_style($btn_style, $ajax_filter_label, $all_text, $eventful_live_filter_align, $field_key, $value, $post_counts_by_value[$value], $sid, $selected, $checked, $show_count)['push_item'];
										array_push($newcustom_array[$index], $push_item);
									}
								}
							}
						}
					}
					if (isset($newcustom_array[$index]) && !empty($newcustom_array[$index])) {
						$newcustom_html = implode('', $newcustom_array[$index]);
						$output         = $output . force_balance_tags($newcustom_html);
					}
					$index++;
				}
				echo $output; //phpcs:ignore
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
	public static function efp_orderby_filter_bar($view_options, $query_args, $sid = null)
	{
		$filter_by = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
		if (in_array('sortby', $filter_by, true)) {
			$eventful_filter_by_order    = isset($view_options['efp_filter_by_order']) ? $view_options['efp_filter_by_order'] : '';
			$add_filter_post        = isset($eventful_filter_by_order['add_orderby_filter_post']) ? $eventful_filter_by_order['add_orderby_filter_post'] : '';
			$ajax_filter_options    = isset($eventful_filter_by_order['orderby_ajax_filter_options']) ? $eventful_filter_by_order['orderby_ajax_filter_options'] : '';
			$eventful_add_filter_orderby = isset($ajax_filter_options['efp_add_filter_orderby']) ? $ajax_filter_options['efp_add_filter_orderby'] : '';
			$btn_type               = isset($ajax_filter_options['orderby_filter_style']) ? $ajax_filter_options['orderby_filter_style'] : 'fl_dropdown';
			$label                  = isset($ajax_filter_options['ajax_filter_label']) && !empty($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : 'Filter by';
			$all_text               = isset($ajax_filter_options['ajax_rename_all_text']) ? $ajax_filter_options['ajax_rename_all_text'] : '';
			$eventful_live_filter_align  = isset($ajax_filter_options['efp_live_filter_align']) ? $ajax_filter_options['efp_live_filter_align'] : 'center';
			if ($add_filter_post && is_array($eventful_add_filter_orderby)) {
				$filter_item   = self::efp_orderby_filter_style($btn_type, $label, $eventful_live_filter_align);
				$newterm_array = array($filter_item['first_item']);
				foreach ($eventful_add_filter_orderby as $orderby) {
					$push_item = self::efp_orderby_filter_style($btn_type, $label, $eventful_live_filter_align, $orderby, $sid)['push_item'];
					array_push($newterm_array, $push_item);
				}
				$tax_html = implode('', $newterm_array);
				$output   = '';
				$output   = $output . force_balance_tags($tax_html);
				echo $output; //phpcs:ignore
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
	public static function efp_order_filter_bar($view_options, $sid = null)
	{
		$filter_by = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
		if (in_array('sortby', $filter_by)) {
			$eventful_filter_by_order     = isset($view_options['efp_filter_by_order']) ? $view_options['efp_filter_by_order'] : '';
			$add_filter_post         = isset($eventful_filter_by_order['add_order_filter_post']) ? $eventful_filter_by_order['add_order_filter_post'] : '';
			$ajax_filter_options     = isset($eventful_filter_by_order['order_filter_options']) ? $eventful_filter_by_order['order_filter_options'] : '';
			$eventful_select_filter_order = isset($eventful_filter_by_order['efp_select_filter_order']) ? $eventful_filter_by_order['efp_select_filter_order'] : '';
			$eventful_add_filter_orderby  = array('DESC', 'ASC');
			$btn_type                = isset($ajax_filter_options['order_filter_style']) ? $ajax_filter_options['order_filter_style'] : '';
			$label                   = isset($ajax_filter_options['order_filter_label']) ? $ajax_filter_options['order_filter_label'] : '';
			$eventful_live_filter_align   = isset($ajax_filter_options['efp_live_filter_align']) ? $ajax_filter_options['efp_live_filter_align'] : 'center';
			if ($add_filter_post) {
				$filter_item   = self::efp_order_filter_style($btn_type, $label, $eventful_live_filter_align);
				$newterm_array = array($filter_item['first_item']);
				foreach ($eventful_add_filter_orderby as $order) {
					$push_item = self::efp_order_filter_style($btn_type, $label, $eventful_live_filter_align, $order, $eventful_select_filter_order, $sid)['push_item'];
					array_push($newterm_array, $push_item);
				}
				$tax_html = implode('', $newterm_array);
				$output   = '';
				$output   = $output . force_balance_tags($tax_html);
				echo $output;
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
	public static function efp_author_filter_style($btn_type, $label, $all_text, $align = 'center', $author_id = null, $author_name = null, $author_post_count = null, $show_count = true, $selected = '', $checked = '')
	{
		if ($show_count) {
			$post_count_markup = '<span class="efp-count">(' . $author_post_count . ')</span>';
		} else {
			$post_count_markup = '';
		}

		$final_author_url_value = isset($_GET['efp_author_id']) ? wp_unslash(sanitize_text_field($_GET['efp_author_id'])) : '';
		if ($final_author_url_value == $author_id) {
			$a_selected = 'selected';
			$a_checked  = 'checked';
		} else {
			$a_selected = $selected;
			$a_checked  = $checked;
		}
		if ('fl_radio' === $btn_type) {
			$all_label  = !empty($all_text) ? $all_text : '';
			$first_item = '<div class="efp-author-filter efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="author" value="all">' . $all_label . '</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="author" type="radio" ' . $a_checked . ' value="' . esc_attr($author_id) . '">' . esc_attr($author_name) . $post_count_markup . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$all_label  = !empty($all_text) ? '<div>' . $all_text . '</div>' : '';
			$first_item = '<div class="efp-author-filter efp-bar fl_button" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="author" value="all">' . $all_label . '</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="author" type="radio" ' . $a_checked . ' value="' . esc_attr($author_id) . '"><div>' . esc_attr($author_name) . $post_count_markup . '</div></label></div>';
		} else {
			$all_label  = !empty($all_text) ? $all_text : '';
			$first_item = '<div class="efp-author-filter efp-bar" style="text-align:' . esc_attr($align) . ';"> <label class="efp-label">' . esc_html($label) . '</label><select><option  name="author" value="all">' . $all_label . '</option>';
			$push_item  = '<option name="author" value="' . esc_attr($author_id) . '" ' . $a_selected . '>' . esc_attr($author_name) . $post_count_markup . ' </option>';
		}
		$filter_output = array(
			'first_item' => $first_item,
			'push_item'  => $push_item,
		);
		return $filter_output;
	}

	/**
	 * Custom field filter style
	 *
	 * @param  string $btn_type btn_type.
	 * @param  string $label label.
	 * @param  string $all_text all text.
	 * @param  string $align alignment.
	 * @param  string $field_key key.
	 * @param  string $value  field value.
	 * @param  string $p_count post count.
	 * @param  string $id shortcode id.
	 * @param  string $selected selected text.
	 * @param  string $checked checked.
	 * @param  bool   $show_count is show post count.
	 * @return statement
	 */
	public static function efp_custom_field_filter_style($btn_type, $label = 'Custom field', $all_text = 'All', $align = 'center', $field_key = null, $value = null, $p_count = '', $id = '', $selected = '', $checked = '', $show_count = false)
	{
		$post_count_markup = '';
		if ($show_count) {
			$post_count_markup = '<span class="efp-count">(' . $p_count . ')</span>';
		}
		$a_selected       = $selected;
		$a_checked        = $checked;
		$capitalize_value = ucfirst(apply_filters('ta_efp_custom_meta_filter_value', $value, $field_key)) . $post_count_markup;

		$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash($_SERVER['QUERY_STRING']) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $id) {
				$filter_value = isset($_GET["cf$field_key"]) ? wp_unslash(sanitize_text_field($_GET["cf$field_key"])) : '';
				if (!empty($filter_value)) {
					if (strpos($filter_value, ',') !== false) {
						$filter_value = explode(',', $filter_value);
					}

					if (is_array($filter_value)) {
						if (in_array($value, $filter_value)) {
							$a_checked  = 'checked';
							$a_selected = 'selected';
						} else {
							$is_checked  = $checked;
							$is_selected = $selected;
						}
					} else {
						if ($filter_value == $value) {
							$a_checked  = 'checked';
							$a_selected = 'selected';
						} else {
							$a_checked  = $checked;
							$a_selected = $selected;
						}
					}
				}
			}
		}

		if ('fl_checkbox' === $btn_type) {
			$first_item = '<div class="efp-custom-field-filter-checkbox efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_checkbox"><label><input name="' . esc_attr($field_key) . '" type="checkbox" ' . $a_checked . '  value="' . esc_attr($value) . '">' . wp_kses_post($capitalize_value) . '</span></label></div>';
		} elseif ('fl_radio' === $btn_type) {
			$all_label  = !empty($all_text) ? $all_text : '';
			$first_item = '<div class="efp-custom-field-filter efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="' . esc_attr($field_key) . '" value="all">' . $all_label . '</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="' . esc_attr($field_key) . '" type="radio" ' . $a_checked . ' value="' . esc_attr($value) . '">' . wp_kses_post($capitalize_value) . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$all_label  = !empty($all_text) ? '<div>' . esc_html($all_text) . '</div>' : '';
			$first_item = '<div class="efp-custom-field-filter efp-bar fl_button filter-' . $field_key . '" style="text-align:' . esc_attr($align) . ';"> <p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="' . esc_attr($field_key) . '" value="all">' . $all_label . '</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="' . esc_attr($field_key) . '" type="radio" ' . $a_checked . ' value="' . esc_attr($value) . '"><div>' . wp_kses_post($capitalize_value) . '</div></label></div>';
		} else {
			$all_label  = !empty($all_text) ? $all_text : '';
			$first_item = '<div class="efp-custom-field-filter efp-bar" style="text-align:' . esc_attr($align) . ';"> <label class="efp-label">' . esc_html($label) . '</label><select><option  name="' . $field_key . '" value="all">' . $all_label . '</option>';
			$push_item  = '<option name="' . $field_key . '" value="' . $value . '" ' . $a_selected . '>' . wp_kses_post($capitalize_value) . ' </option>';
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
	public static function efp_orderby_filter_style($btn_type, $label, $align = 'center', $orderby = null, $sid = null)
	{
		$filter_url_value        = isset($_SERVER['QUERY_STRING']) ? wp_unslash($_SERVER['QUERY_STRING']) : '';
		$final_orderby_url_value = '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $sid) {
				$final_orderby_url_value = isset($_GET['efp_orderby']) ? sanitize_text_field(wp_unslash($_GET['efp_orderby'])) : '';
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
			$first_item = '<div class="efp-order-by efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><div class="fl_radio"><label><input checked type="radio" name="orderby" value="">None</label></div>';
			$push_item  = '<div class="fl_radio"><label><input name="orderby" type="radio"  ' . $is_checked . ' value="' . $orderby . '">' . $orderby . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$first_item = '<div class="efp-order-by efp-bar fl-btn" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p> <div class="fl_radio"><label><input checked type="radio" name="orderby" value=""><div>None</div></label></div>';
			$push_item  = '<div class="fl_radio"><label><input type="radio" name="orderby" ' . $is_checked . ' value="' . $orderby . '"><div>' . $orderby . '</div></label></div>';
		} else {
			$first_item = '<div class="efp-order-by efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><select><option  name="orderby" value="">None</option>';
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
	public static function efp_order_filter_style($btn_type, $label, $align = 'center', $order = null, $select_order = null, $sid = null)
	{
		$final_order_url_value = '';
		$filter_url_value      = isset($_SERVER['QUERY_STRING']) ? wp_unslash($_SERVER['QUERY_STRING']) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $sid) {
				$final_order_url_value = isset($_GET['efp_order']) ? sanitize_text_field(wp_unslash($_GET['efp_order'])) : '';
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
			$first_item = '<div class="efp-order efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_radio"><label><input name="order" ' . $checked . ' type="radio" value="' . $order . '">' . $order . '</label></div>';
		} elseif ('fl_btn' === $btn_type) {
			$first_item = '<div class="efp-order efp-bar fl-btn" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p>';
			$push_item  = '<div class="fl_radio"><label><input type="radio" ' . $checked . ' name="order" value="' . $order . '"><div>' . $order . '</div></label></div>';
		} else {
			$first_item = '<div class="efp-order efp-bar" style="text-align:' . esc_attr($align) . ';"><p>' . esc_html($label) . '</p><select>';
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
	public static function efp_live_search_bar($view_options, $sid = null)
	{
		$filter_by        = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
		$final_keyword    = '';
		$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash($_SERVER['QUERY_STRING']) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $sid) {
				$final_keyword = isset($_GET['efp_keyword']) ? sanitize_text_field(wp_unslash($_GET['efp_keyword'])) : '';
			}
		}
		if (in_array('keyword', $filter_by, true)) {
			$eventful_filter_by_keyword = isset($view_options['efp_filter_by_keyword']) ? $view_options['efp_filter_by_keyword'] : '';
			$add_filter_post       = isset($eventful_filter_by_keyword['add_search_filter_post']) ? $eventful_filter_by_keyword['add_search_filter_post'] : '';
			if ($add_filter_post) {
				$ajax_filter_options   = isset($eventful_filter_by_keyword['ajax_filter_options']) ? $eventful_filter_by_keyword['ajax_filter_options'] : '';
				$label                 = isset($ajax_filter_options['ajax_filter_label']) && !empty($ajax_filter_options['ajax_filter_label']) ? $ajax_filter_options['ajax_filter_label'] : '';
				$eventful_live_filter_align = isset($ajax_filter_options['efp_live_filter_align']) ? $ajax_filter_options['efp_live_filter_align'] : 'center';
				echo '<div class="efp-ajax-search efp-bar" style="text-align:' . esc_attr($eventful_live_filter_align) . ';"><label class="efp-label">' . wp_kses_post($label) . ' <input type="text" value="' . esc_attr($final_keyword) . '" class="efp-search-field" placeholder="Search..."></label></div>';
			}
		}
	}
}
