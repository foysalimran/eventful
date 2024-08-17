<?php

/**
 * The file of query insides.
 *
 * @package Eventful
 * @subpackage public
 *
 * @since 2.2.0
 */

/**
 * The query inside class to process the query.
 *
 * @since 2.2.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class EFUL_QueryInside
{

	/**
	 * The post ID.
	 *
	 * @var string post ID.
	 */

	/**
	 * Filtered content.
	 *
	 * @param integer $eful_gl_id Shortcode ID.
	 * @return statement
	 */
	public static function eful_get_filtered_content($view_options, $id = '', $layout_preset = 'default', $on_screen = null)
	{
		$eful_post_type                 = 'tribe_events';

		$post_limit      = isset($view_options['eful_post_limit']) ? $view_options['eful_post_limit'] : 10000;
		$post_per_page   = isset($view_options['post_per_page']) ? $view_options['post_per_page'] : 12;
		$post_offset     = isset($view_options['eful_post_offset']) ? $view_options['eful_post_offset'] : 0;
		$eful_sticky_post = isset($view_options['eful_sticky_post']) ? $view_options['eful_sticky_post'] : 0;
		$show_pagination = isset($view_options['show_post_pagination']) ? $view_options['show_post_pagination'] : false;
		$post_per_page   = ($post_per_page > $post_limit) ? $post_limit : $post_per_page;
		$post_per_page   = (!$show_pagination) ? $post_limit : $post_per_page;

		if ('filter_layout' === $layout_preset) {
			$pagination_type = isset($view_options['filter_pagination_type']) ? $view_options['filter_pagination_type'] : '';
		} else {
			$pagination_type = isset($view_options['post_pagination_type']) ? $view_options['post_pagination_type'] : '';
			if ('on_mobile' === $on_screen) {
				$pagination_type = isset($view_options['post_pagination_type_mobile']) ? $view_options['post_pagination_type_mobile'] : '';
			}
		}

		if ('no_ajax' === $pagination_type) {
			$paged_var = 'paged' . $id;
			$paged     = isset($_GET["$paged_var"]) ? sanitize_text_field(wp_unslash($_GET["$paged_var"])) : 1;
		} else {
			$paged            = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash(sanitize_text_field($_SERVER['QUERY_STRING'])) : '';
			if (!empty($filter_url_value)) {
				$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
				if ($shortcode_id == $id) {
					$eful_page = isset($_GET['eful_page']) ? wp_unslash(sanitize_text_field($_GET['eful_page'])) : '1';
					if (!empty($eful_page)) {
						$paged = $eful_page;
					}
				}
			}
		}

		$post_per_page = EFUL_Functions::eful_post_per_page($post_limit, $post_per_page, $paged);
		if ($post_per_page < 1) {
			$post_per_page = isset($view_options['post_per_page']) ? $view_options['post_per_page'] : 12;
		}
		$offset               = (int) $post_per_page * ($paged - 1);
		$sticky_post_position = 'top_list' === $eful_sticky_post ? 0 : 1;
		if ('carousel_layout' === $layout_preset) {
			$post_per_page = ($post_limit > 0) ? $post_limit : 999999;
			$args          = array(
				'post_type'           => $eful_post_type,
				'suppress_filters'    => false,
				'ignore_sticky_posts' => $sticky_post_position,
				'posts_per_page'      => $post_per_page,
				'offset'              => (int) $post_offset,
			);
		} else {
			$args = array(
				'post_type'           => $eful_post_type,
				'suppress_filters'    => false,
				'ignore_sticky_posts' => $sticky_post_position,
				'posts_per_page'      => $post_per_page,
				'paged'               => $paged,
				'offset'              => (int) $offset + (int) $post_offset,
			);

		}
		// Include specific posts.
		$include_posts = isset($view_options['eful_include_only_posts']) ? $view_options['eful_include_only_posts'] : '';
	
		// Exclude posts.
		$exclude_post_set  = isset($view_options['eful_exclude_post_set']) ? $view_options['eful_exclude_post_set'] : '';
		// Array ( [eful_exclude_posts] => Array ( [0] => 1263 ) )

		$exclude_too       = !empty($exclude_post_set['eful_exclude_too']) ? $exclude_post_set['eful_exclude_too'] : array();
		$current_post_id   = in_array('current', $exclude_too, true) ? array(get_the_ID()) : array();

		

		$exclude_posts     = !empty($exclude_post_set['eful_exclude_posts']) && isset($exclude_post_set['eful_exclude_posts']) ? $exclude_post_set['eful_exclude_posts'] : '';
		$exclude_posts_int = array();
		if (!empty($exclude_posts)) {
			foreach ($exclude_posts as $exclude_post) {
				$exclude_posts_int[] = intval($exclude_post);
			}
		}
		$exclude_post_list = array_merge($exclude_posts_int, $current_post_id);
		if (!empty($exclude_post_list) && !empty($include_posts)) {
			$include_posts = array_diff($include_posts, $exclude_post_list);
		} elseif (!empty($exclude_post_list)) {
			$args['post__not_in'] = ($exclude_post_list);
		}
		// Include specific posts.
		if (!empty($include_posts)) {
			$args['post__in'] = $include_posts;
		}


		// Exclude password protected posts.
		$password_protected = in_array('password_protected', $exclude_too, true);
		if ($password_protected) {
			$args['has_password'] = false;
		}
		// Exclude children posts.
		$exclude_children = in_array('children', $exclude_too, true);
		if ($exclude_children) {
			$args['post_parent'] = 0;
		}
		$args['post_status'] = 'publish';
		$advanced_filters    = isset($view_options['eful_advanced_filter']) && !empty($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : '';
		if ($advanced_filters) {
			foreach ($advanced_filters as $advanced_filter) {

				switch ($advanced_filter) {
					case 'taxonomy':
						$taxonomy_types = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomy_and_terms']) && !empty($view_options['eful_filter_by_taxonomy']['eful_taxonomy_and_terms']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomy_and_terms'] : '';
						if (!$taxonomy_types) {
							break;
						}
						$tax_settings = array();
						foreach ($taxonomy_types as $tax_type) {
							$taxonomy         = isset($tax_type['eful_select_taxonomy']) ? $tax_type['eful_select_taxonomy'] : '';
							$all_terms = get_terms($taxonomy);
							$all_terms = wp_list_pluck($all_terms, 'term_id');
							
							$terms            = isset($tax_type['eful_select_terms']) && !empty($tax_type['eful_select_terms']) ? $tax_type['eful_select_terms'] : $all_terms;
							$all_button_label = isset($tax_type['ajax_filter_options']['ajax_rename_all_text']) ? $tax_type['ajax_filter_options']['ajax_rename_all_text'] : '';

							if ($taxonomy) {
								if ($terms) {
									$operator = isset($tax_type['eful_taxonomy_term_operator']) ? $tax_type['eful_taxonomy_term_operator'] : '';
									if ('AND' === $operator && 1 == count($terms)) {
										$operator = 'IN';
									}
									$tax_settings[] = array(
										'taxonomy'         => $taxonomy,
										'field'            => 'term_id',
										'terms'            => $all_button_label ? $terms : $terms[0],
										'operator'         => $operator,
										'include_children' => ('AND' === $operator ? 'false' : 'true'),
									);
								}
							}
						}
						if (count($tax_settings) > 1) {
							$tax_settings['relation'] = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';
						}
						$args = array_merge($args, array('tax_query' => $tax_settings));
						break;
					case 'author':
						$author_include = isset($view_options['eful_filter_by_author']['eful_select_author_by']) ? $view_options['eful_filter_by_author']['eful_select_author_by'] : '';
						$author_exclude = isset($view_options['eful_filter_by_author']['eful_select_author_not_by']) ? $view_options['eful_filter_by_author']['eful_select_author_not_by'] : '';
						$wp37           = EFUL_Functions::wp_version_compare('3.7');
						if ($author_include) {
							$args = array_merge(
								$args,
								$wp37 ? array('author__in' => array_map('intval', $author_include)) : array('author' => intval($author_include[0]))
							);
						}
						if ($author_exclude && $wp37) {
							$args = array_merge(
								$args,
								array('author__not_in' => array_map('intval', $author_exclude))
							);
						}
						break;
					case 'sortby':
						$orderby = isset($view_options['eful_filter_by_order']['eful_select_filter_orderby']) ? $view_options['eful_filter_by_order']['eful_select_filter_orderby'] : '';
						$order   = isset($view_options['eful_filter_by_order']['eful_select_filter_order']) ? $view_options['eful_filter_by_order']['eful_select_filter_order'] : '';

						
							if ('rand' === $orderby) {
								if ($paged && get_query_var('paged') === 0 && get_query_var('paged') !== null) {
									set_transient('eful_rand', wp_rand());
								}
							}
							$order_settings = array(
								'orderby' => ('rand' === $orderby) ? 'rand(' . get_transient('eful_rand') . ')' : $orderby,
								'order'   => $orderby ? $order : '',
							);
							$args           = array_merge($args, $order_settings);
						

						break;
					case 'status':
						$eful_post_status = isset($view_options['eful_filter_by_status']['eful_select_post_status']) && !empty($view_options['eful_filter_by_status']['eful_select_post_status']) ? $view_options['eful_filter_by_status']['eful_select_post_status'] : 'publish';
						$args            = array_merge($args, array('post_status' => $eful_post_status));
						break;
					case 'date':
						self::eful_filter_by_date($args, $view_options);
						break;
					case 'keyword':
						$keyword_value = isset($view_options['eful_filter_by_keyword']['eful_set_post_keyword']) && !empty($view_options['eful_filter_by_keyword']['eful_set_post_keyword']) ? $view_options['eful_filter_by_keyword']['eful_set_post_keyword'] : '';
						if ($keyword_value) {
							$args = array_merge(
								$args,
								array(
									's' => $keyword_value,
								)
							);
						}
						break;
				}
			}
		}


		$filter_url_value = isset($_SERVER['QUERY_STRING']) ? wp_unslash(sanitize_text_field($_SERVER['QUERY_STRING'])) : '';
		if (!empty($filter_url_value)) {
			$shortcode_id = isset($_GET['eventful']) ? wp_unslash(sanitize_text_field($_GET['eventful'])) : '';
			if ($shortcode_id == $id) {
				$url_args           = $args;
				$url_args['fields'] = 'ids';
				$relation           = isset($view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation']) ? $view_options['eful_filter_by_taxonomy']['eful_taxonomies_relation'] : 'AND';

				$taxonomies          = get_object_taxonomies($eful_post_type);
				$tax_settings_by_url = array();
				foreach ($taxonomies as $taxonomy) {
					$filter_url_value = isset($_GET["tx_$taxonomy"]) ? wp_unslash(sanitize_text_field($_GET["tx_$taxonomy"])) : '';
					if (!empty($filter_url_value)) {
						if (strpos($filter_url_value, ',') !== false) {
							$filter_url_value = explode(',', $filter_url_value);
						}
						$tax_settings_by_url[] = array(
							'taxonomy' => $taxonomy,
							'field'    => 'term_id',
							'terms'    => $filter_url_value,
							'operator' => 'IN',
						);
					}
				}
				if (!empty($tax_settings_by_url)) {

					if (count($tax_settings_by_url) > 1) {
						$tax_settings_by_url['relation'] = $relation;
					}
					if ('OR' === $relation) {
						$url_args['posts_per_page'] = '10000';
					}
					$url_post_ids     = get_posts($url_args);
					$args             = array_merge($args, array('tax_query' => $tax_settings_by_url));
					$args['post__in'] = $url_post_ids;
				}
				$final_author_url_value = isset($_GET['eful_author_id']) ? sanitize_text_field(wp_unslash($_GET['eful_author_id'])) : '';
				if (!empty($final_author_url_value)) {
					$args['author__in'] = $final_author_url_value;
				}
				$final_orderby_url_value = isset($_GET['eful_orderby']) ? sanitize_text_field(wp_unslash($_GET['eful_orderby'])) : '';
				if (!empty($final_orderby_url_value)) {
					$args['orderby'] = $final_orderby_url_value;
				}
				$final_order_url_value = isset($_GET['eful_order']) ? sanitize_text_field(wp_unslash($_GET['eful_order'])) : '';
				if (!empty($final_order_url_value)) {
					$args['order'] = $final_order_url_value;
				}
				$final_search_url_value = isset($_GET['eful_keyword']) ? sanitize_text_field(wp_unslash($_GET['eful_keyword'])) : '';
				if (!empty($final_search_url_value)) {
					$args['s'] = $final_search_url_value;
				}
			}
		}
		return $args;
	}

	/**
	 * Filter posts with date.
	 *
	 * @param array $args The arguments of the query.
	 * @param array $view_options The Array of the Metabox fields.
	 * @return void
	 */
	public static function eful_filter_by_date(&$args, $view_options)
	{

		$advanced_filters = isset($view_options['eful_advanced_filter']) && !empty($view_options['eful_advanced_filter']) ? $view_options['eful_advanced_filter'] : '';

		if (in_array('date', $advanced_filters, true)) {
			$_date_type_to_filter = isset($view_options['eful_filter_by_date']['eful_select_post_date_type']) && !empty($view_options['eful_filter_by_date']['eful_select_post_date_type']) ? $view_options['eful_filter_by_date']['eful_select_post_date_type'] : '';
			$now                  = new \DateTime('now');
			$today                = $now->format('j'); // A numeric representation of a month without 0.
			$this_month           = $now->format('n'); // A numeric representation of a month without 0.
			$this_year            = $now->format('Y');
			$date_query           = array();
			if ($_date_type_to_filter) {
				switch ($_date_type_to_filter) {
					case 'yesterday':
						$yesterday = gmdate('Y-m-d', strtotime('yesterday'));
						$date      = date_parse($yesterday);

						$date_query = array(
							'year'  => $date['year'],
							'month' => $date['month'],
							'day'   => $date['day'],
						);
						break;

					case 'today_only':
						$date_query = array(
							'year'  => $this_year,
							'month' => $this_month,
							'day'   => $today,
						);
						break;

					case 'today_onwards':
						$yesterday  = gmdate('Y-m-d', strtotime('yesterday'));
						$date_query = array(
							'after' => $yesterday,
						);
						break;

					case 'this_week':
						$date_query = array(
							'year' => $this_year,
							'week' => $now->format('W'),
						);
						break;

					case 'this_month':
						$date_query = array(
							'year'  => $this_year,
							'month' => $this_month,
						);
						break;

					case 'this_year':
						$date_query = array(
							'year' => $this_year,
						);
						break;

					case 'week_ago':
					case 'month_ago':
					case 'year_ago':
						$date_query = array(
							'column' => 'post_date',
							'after'  => sprintf('1 %s ago', str_replace('_ago', '', $_date_type_to_filter)),
						);
						break;

					case 'specific_date':
						$_specific_date = isset($view_options['eful_filter_by_date']['eful_select_post_specific_date']) && !empty($view_options['eful_filter_by_date']['eful_select_post_specific_date']) ? $view_options['eful_filter_by_date']['eful_select_post_specific_date'] : '';
						$specific_date  = date_parse($_specific_date);
						$date_query     = array(
							'year'  => $specific_date['year'],
							'month' => $specific_date['month'],
							'day'   => $specific_date['day'],
						);
						break;

					case 'specific_month':
						$post_published_in_month = isset($view_options['eful_filter_by_date']['eful_select_specific_month']) && !empty($view_options['eful_filter_by_date']['eful_select_specific_month']) ? $view_options['eful_filter_by_date']['eful_select_specific_month'] : '';
						$date_query              = array(
							'month' => $post_published_in_month,
						);
						break;

					case 'specific_year':
						$post_published_in_year = isset($view_options['eful_filter_by_date']['eful_select_post_specific_year']['all']) && !empty($view_options['eful_filter_by_date']['eful_select_post_specific_year']['all']) ? $view_options['eful_filter_by_date']['eful_select_post_specific_year']['all'] : '';

						$date_query = array(
							'year' => $post_published_in_year,
						);
						break;

					case 'specific_period':
						$_date_from_to = isset($view_options['eful_filter_by_date']['eful_select_post_date_from_to']) && !empty($view_options['eful_filter_by_date']['eful_select_post_date_from_to']) ? $view_options['eful_filter_by_date']['eful_select_post_date_from_to'] : '';
						$_date_from    = isset($_date_from_to) ? $_date_from_to['from'] : $today;
						$_date_to      = isset($_date_from_to) ? $_date_from_to['to'] : $today;
						$date_from     = date_parse($_date_from);
						$date_to       = date_parse($_date_to);
						if ($date_from && $date_to) {
							$date_query = array(
								'after'     => array(
									'year'  => $date_from['year'],
									'month' => $date_from['month'],
									'day'   => $date_from['day'],
								),
								'before'    => array(
									'year'  => $date_to['year'],
									'month' => $date_to['month'],
									'day'   => $date_to['day'],
								),
								'inclusive' => true,
							);
						}
						break;
				}
				if ($date_query) {
					$args['date_query'] = array($date_query);
				}
			}
		}
	}
}
