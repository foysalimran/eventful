<?php
/**
 * Pagination display provider
 *
 * This template can be overridden by copying it to yourtheme/eventful-pro/templates/pagination.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $show_pagination && ! $efp_query->is_main_query() ) {
	// Paged argument.
	if ( get_query_var( 'paged' ) ) {
		$efp_paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$efp_paged = get_query_var( 'page' );
	} else {
		$efp_paged = 1;
	}
	$load_more_button_text    = isset( $view_options['load_more_button_text'] ) ? $view_options['load_more_button_text'] : 'Load More';
	$load_more_ending_message = isset( $view_options['load_more_ending_message'] ) ? $view_options['load_more_ending_message'] : 'No more events available';
	?>
	<span class="ta-efp-pagination-data" style="display:none;" data-loadmoretext="<?php echo esc_attr( $load_more_button_text ); ?>" data-endingtext="<?php echo esc_attr( $load_more_ending_message ); ?>"></span>

		<nav class="efp-post-pagination efp-on-desktop <?php echo esc_attr( $pagination_type ); ?>">
		<?php EFP_HTML::efp_pagination_bar( $efp_query, $view_options, $layout, $efp_gl_id, $efp_paged ); ?>
		</nav>
		<?php if ( 'filter_layout' !== $layout_preset ) { ?>
			<nav class="efp-post-pagination efp-on-mobile <?php echo esc_attr( $pagination_type_mobile ); ?>">
				<?php EFP_HTML::efp_pagination_bar( $efp_query, $view_options, $layout, $efp_gl_id, $efp_paged, 'on_mobile' ); ?>
			</nav>
			<?php
		}
		?>
	<?php
}
?>
