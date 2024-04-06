<?php

/**
 * Shuffle filter helper method file.
 *
 * @package Eventful
 * @subpackage Eventful/public/helper
 *
 * @since 2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Shuffle filter helper class.
 *
 * @since 2.0.0
 */
class Eventful_Shuffle_Filter
{


	/**
	 * Shuffle filter markup style.
	 *
	 * @param string $filter_type Filter type.
	 * @param string $taxonomy Current taxonomy to view.
	 * @param string $all_text all text.
	 * @param bool   $show_count show/hide post count.
	 * @param int    $term term id.
	 * @param string $name term name.
	 * @param string $slug term slug.
	 * @param int    $p_count term found post.
	 * @param array  $selected_term selected terms.
	 * @param array  $selected_taxs selected taxonomys.
	 * @param int    $selected_term_id selected term id.

	 * @return array
	 */
	public static function eful_filter_style($filter_type, $taxonomy, $all_text, $show_count = false, $term = null, $name = null, $slug = null, $p_count = null, $selected_term = null, $selected_taxs = null, $selected_term_id = null)
	{
		if ($show_count) {
			$post_count_markup = '<span class="eventful-count">(' . $p_count . ')</span>';
		} else {
			$post_count_markup = '';
		}

		$taxonomy_name = ('post_tag' === $taxonomy) ? 'tag' : $taxonomy;
		$slug          = trim(sanitize_html_class($slug, $term), '-') ? sanitize_html_class($slug, $term) : $term;
		// Shuffle Filter.
		if ('button' === $filter_type) {
			$first_item = $all_text ? '<button class="eventful-button is-active" data-termid="all" data-filter="">' . $all_text . '</button>' : '';
			$push_item  = '<button class="eventful-button" data-termid="' . $term . '" data-filter=".' . $taxonomy_name . '-' . $slug . '">' . $name . $post_count_markup . '</button>';
		} else {
			$all_item_text = $all_text ? '<option value="*">' . $all_text . '</option>' : '';
			$first_item    = '<select>' . $all_item_text;
			$push_item     = '<option value=".' . $taxonomy_name . '-' . $slug . '">' . $name . $post_count_markup . '</option>';
		}

		$filter_output = array(
			'first_item' => $first_item,
			'push_item'  => $push_item,
		);
		return $filter_output;
	}

	/**
	 * Shuffle filter.
	 *
	 * @param array  $view_options Shortcode options.
	 * @param array  $layout_preset layout preset.
	 * @param object $eventful_query wp query object.
	 * @param string $filter_type Filter type.
	 * @return void
	 */
	public static function eventful_shuffle_filter($view_options, $layout_preset, $eventful_query, $filter_type)
	{
		$filter_by    = isset($view_options['eventful_advanced_filter']) ? $view_options['eventful_advanced_filter'] : '';
		$filter_type  = isset($view_options['eventful_filter_type']) ? $view_options['eventful_filter_type'] : '';
		$filer_align  = isset($view_options['eventful_filer_align']) ? $view_options['eventful_filer_align'] : 'eventful-align-center';
		$all_text_btn = isset($view_options['eventful_filter_all_btn_switch']) ? $view_options['eventful_filter_all_btn_switch'] : true;
		$all_text     = isset($view_options['eventful_rename_all_text']) ? $view_options['eventful_rename_all_text'] : 'All';
		$all_text     = $all_text_btn ? $all_text : '';
		$show_count   = isset($view_options['eventful_post_count']) ? $view_options['eventful_post_count'] : '';
		$post_limit   = isset($view_options['eventful_post_limit']) && !empty($view_options['eventful_post_limit']) ? $view_options['eventful_post_limit'] : 10000;
		if ('filter_layout' === $layout_preset && in_array('taxonomy', $filter_by, true)) {
			$taxonomy_types   = isset($view_options['eventful_filter_by_taxonomy']['eventful_taxonomy_and_terms']) && !empty($view_options['eventful_filter_by_taxonomy']['eventful_taxonomy_and_terms']) ? $view_options['eventful_filter_by_taxonomy']['eventful_taxonomy_and_terms'] : '';
			$total_post_count = $eventful_query->post_count;
			if (!empty($taxonomy_types)) {
				$output         = '';
				$newterm_array  = array();
				$count          = 0;
				$taxonomies     = array();
				$taxonomy_count = count($taxonomy_types);
				while ($count < $taxonomy_count) {
					$taxonomy = isset($taxonomy_types[$count]['eventful_select_taxonomy']) ? $taxonomy_types[$count]['eventful_select_taxonomy'] : '';

					$all_terms = get_terms($taxonomy);
					$all_terms = wp_list_pluck($all_terms, 'term_id');
					$terms     = isset($taxonomy_types[$count]['eventful_select_terms']) ? $taxonomy_types[$count]['eventful_select_terms'] : $all_terms;

					if (!empty($terms)) {
						$filter_item             = self::eful_filter_style($filter_type, $taxonomy, $all_text);
						$newterm_array[$count] = array($filter_item['first_item']);
						foreach ($terms as $term) {
							$p_term          = get_term($term, $taxonomy);
							$term_post_count = $p_term->count;
							$term_post_count = $term_post_count > $post_limit ? $post_limit : $term_post_count;
							if ($term_post_count) {
								$push_item = self::eful_filter_style($filter_type, $taxonomy, $all_text, $show_count, $term, $p_term->name, $p_term->slug, $term_post_count)['push_item'];
								array_push($newterm_array[$count], $push_item);
							}
						}
						$tax_html = implode(' ', $newterm_array[$count]);
						$output   = $output . '<div class="taxonomy-group" style="text-align:' . $filer_align . '" data-filter-group="' . $taxonomy . '">' . force_balance_tags($tax_html) . '</div>';
					}
					$count++;
				}
			}

			echo wp_kses_post($output);
		}
	}
}
