<?php
/**
 * Pagination display provider
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/pagination.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $show_pagination && ! $eventful_query->is_main_query() ) {
	// Paged argument.
	if ( get_query_var( 'paged' ) ) {
		$eventful_paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$eventful_paged = get_query_var( 'page' );
	} else {
		$eventful_paged = 1;
	}
	$load_more_button_text    = isset( $view_options['load_more_button_text'] ) ? $view_options['load_more_button_text'] : 'Load More';
	$load_more_ending_message = isset( $view_options['load_more_ending_message'] ) ? $view_options['load_more_ending_message'] : 'No more events available';
	?>
	<span class="ta-eventful-pagination-data" style="display:none;" data-loadmoretext="<?php echo esc_attr( $load_more_button_text ); ?>" data-endingtext="<?php echo esc_attr( $load_more_ending_message ); ?>"></span>

		<nav class="eventful-post-pagination eventful-on-desktop <?php echo esc_attr( $pagination_type ); ?>">
		<?php EFUL_HTML::eful_pagination_bar( $eventful_query, $view_options, $layout, $eventful_gl_id, $eventful_paged ); ?>
		</nav>
		<?php if ( 'filter_layout' !== $layout_preset ) { ?>
			<nav class="eventful-post-pagination eventful-on-mobile <?php echo esc_attr( $pagination_type_mobile ); ?>">
				<?php EFUL_HTML::eful_pagination_bar( $eventful_query, $view_options, $layout, $eventful_gl_id, $eventful_paged, 'on_mobile' ); ?>
			</nav>
			<?php
		}
		?>
	<?php
}
?>
