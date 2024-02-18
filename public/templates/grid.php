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
<div id="eventful_wrapper-<?php echo esc_attr($eventful_gl_id); ?>" class="<?php self::eventful_wrapper_classes($layout_preset, $eventful_gl_id, $grid_style, $item_same_height_class); ?>" <?php self::wrapper_data( $pagination_type, $pagination_type_mobile, $eventful_gl_id ); ?> data-lang="<?php echo esc_attr( $spsp_lang ); ?>">

	<?php
	EFP_HTML::eventful_section_title($section_title, $show_section_title);
	EFP_HTML::eventful_preloader($show_preloader);
	?>
	<?php require EFP_Functions::eventful_locate_template('filter-bar.php'); ?>
	<div class="eventful">
		<div class="ta-row">
			<?php self::eventful_get_posts($options, $layout_preset, $post_content_sorter, $eventful_query, $eventful_gl_id); ?>
		</div>
	</div>
	<?php require EFP_Functions::eventful_locate_template( 'pagination.php' ); ?>
</div>