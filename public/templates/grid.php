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
<div id="eful_wrapper-<?php echo esc_attr($eful_gl_id); ?>" class="<?php self::eful_wrapper_classes($layout_preset, $eful_gl_id, $grid_style, $item_same_height_class); ?>" <?php self::wrapper_data( $pagination_type, $pagination_type_mobile, $eful_gl_id ); ?> data-lang="<?php echo esc_attr( $spsp_lang ); ?>">

	<?php
	EFUL_HTML::eful_section_title($section_title, $show_section_title);
	EFUL_HTML::eful_preloader($show_preloader);
	?>
	<?php require EFUL_Functions::eful_locate_template('filter-bar.php'); ?>
	<div class="eventful">
		<div class="ta-row">
			<?php self::eful_get_posts($options, $layout_preset, $post_content_sorter, $eful_query, $eful_gl_id); ?>
		</div>
	</div>
	<?php require EFUL_Functions::eful_locate_template( 'pagination.php' ); ?>
</div>