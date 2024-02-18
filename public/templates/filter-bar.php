<?php
/**
 *  Shuffle filter bar file
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/filter-bar.php
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */

if ( is_array( $advanced_filter ) && ! $efp_query->is_main_query() ) {
	ob_start();
		EFP_Live_Filter::efp_live_filter( $view_options, $query_args, $efp_gl_id );
		EFP_Live_Filter::efp_author_filter( $view_options, $query_args );
		EFP_Live_Filter::efp_custom_filter_filter( $view_options, $query_args, $efp_gl_id );
	$filter_bar = ob_get_clean();

	ob_start();
		EFP_Live_Filter::efp_orderby_filter_bar( $view_options, $efp_query, $efp_gl_id );
		EFP_Live_Filter::efp_order_filter_bar( $view_options, $efp_gl_id );
		EFP_Live_Filter::efp_live_search_bar( $view_options, $efp_gl_id );
	$ex_filter_bar = ob_get_clean();


	if ( ! empty( $filter_bar ) ) { ?>
		<div class="efp-filter-bar">
			<?php echo $filter_bar; ?>
		</div>
	<?php } if ( ! empty( $ex_filter_bar ) ) { ?>
			<div class="efp_ex_filter_bar">
			<?php echo $ex_filter_bar; ?>
			</div>
	<?php }
} ?>
