<?php
/**
 *  Shuffle filter bar file
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/filter-bar.php
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */

if ( is_array( $advanced_filter ) && ! $eventful_query->is_main_query() ) {
	ob_start();
		EFUL_Live_Filter::eventful_live_filter( $view_options, $query_args, $eventful_gl_id );
		EFUL_Live_Filter::eful_author_filter( $view_options, $query_args );
		EFUL_Live_Filter::eful_custom_filter_filter( $view_options, $query_args, $eventful_gl_id );
	$filter_bar = ob_get_clean();

	ob_start();
		EFUL_Live_Filter::eful_orderby_filter_bar( $view_options, $eventful_query, $eventful_gl_id );
		EFUL_Live_Filter::eful_order_filter_bar( $view_options, $eventful_gl_id );
		EFUL_Live_Filter::eful_live_search_bar( $view_options, $eventful_gl_id );
	$ex_filter_bar = ob_get_clean();


	if ( ! empty( $filter_bar ) ) { ?>
		<div class="eventful-filter-bar">
			<?php echo $filter_bar; ?>
		</div>
	<?php } if ( ! empty( $ex_filter_bar ) ) { ?>
			<div class="eventful_ex_filter_bar">
			<?php echo $ex_filter_bar; ?>
			</div>
	<?php }
} ?>
