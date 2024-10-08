<?php

/**
 *  Shuffle filter bar file
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/filter-bar.php
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (is_array($advanced_filter) && !$eful_query->is_main_query()) {
	ob_start();
	EFUL_Live_Filter::eful_live_filter($view_options, $query_args, $eful_gl_id);
	EFUL_Live_Filter::eful_author_filter($view_options, $query_args);
	$filter_bar = ob_get_clean();

	ob_start();
	EFUL_Live_Filter::eful_orderby_filter_bar($view_options, $eful_query, $eful_gl_id);
	EFUL_Live_Filter::eful_order_filter_bar($view_options, $eful_gl_id);
	EFUL_Live_Filter::eful_live_search_bar($view_options, $eful_gl_id);
	$ex_filter_bar = ob_get_clean();


	if (!empty($filter_bar)) { ?>
		<div class="eventful-filter-bar">
			<?php
			$allowed_tags = array(
				'form'  => array(
					'class' => array(),
					'style' => array(),
				),
				'p'     => array(),
				'div'   => array(
					'style' => array(),
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

			echo wp_kses(
				$filter_bar,
				$allowed_tags
			);
			?>
		</div>
	<?php }
	if (!empty($ex_filter_bar)) { ?>
		<div class="eful_ex_filter_bar">
			<?php
			$allowed_tags = array(
				'form'  => array(
					'class' => array(),
					'style' => array(),
				),
				'p'     => array(),
				'div'   => array(
					'style' => array(),
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

			echo wp_kses(
				$ex_filter_bar,
				$allowed_tags
			);
			?>
		</div>
<?php }
} ?>