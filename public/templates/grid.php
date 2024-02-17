<?php

/**
 *  Carousel view
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */
if (!defined('ABSPATH')) {
	exit;
}
?>
<div id="efp_wrapper-<?php echo esc_attr($efp_gl_id); ?>" class="<?php self::efp_wrapper_classes($layout_preset, $efp_gl_id, $grid_style, $item_same_height_class); ?>" <?php self::wrapper_data( $pagination_type, $pagination_type_mobile, $efp_gl_id ); ?> data-lang="<?php echo esc_attr( $spsp_lang ); ?>">

	<?php
	EFP_HTML::efp_section_title($section_title, $show_section_title);
	EFP_HTML::efp_preloader($show_preloader);
	?>
	<?php require EFP_Functions::efp_locate_template('filter-bar.php'); ?>
	<div class="eventful">
		<div class="ta-row">
			<?php self::efp_get_posts($options, $layout_preset, $post_content_sorter, $efp_query, $efp_gl_id); ?>
		</div>
	</div>
	<?php require EFP_Functions::efp_locate_template( 'pagination.php' ); ?>
</div>