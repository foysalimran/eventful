<?php

/**
 *  Shuffle filter view file
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/filter.php
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<div id="eventful_wrapper-<?php echo esc_attr($eventful_gl_id); ?>" class="<?php self::eventful_wrapper_classes($layout_preset, $eventful_gl_id, $pagination_type, $item_same_height_class); ?>" data-sid="<?php echo esc_attr($eventful_gl_id); ?>" <?php self::wrapper_data($pagination_type, $pagination_type_mobile, $eventful_gl_id); ?> data-grid="<?php echo esc_attr($grid_style); ?>" data-lang="<?php echo esc_attr($spta_lang); ?>">
	<?php
	EFUL_HTML::eful_section_title($section_title, $show_section_title);
	EFUL_HTML::eventful_preloader($show_preloader);
	$categories = get_categories(
		array(
			'orderby' => 'name',
			'parent'  => 0,
		)
	);
	if (is_array($advanced_filter) && !$eventful_query->is_main_query()) {
	?>
		<div class="eventful-shuffle-filter">
			<?php
			$filter_type = isset($view_options['eventful_filter_type']) ? $view_options['eventful_filter_type'] : '';
			Eventful_Shuffle_Filter::eventful_shuffle_filter($view_options, $layout_preset, $eventful_query, $filter_type);
			?>
		</div>
	<?php }; ?>
	<div class="ta-row grid">
		<?php self::eventful_get_posts($options, $layout_preset, $post_content_sorter, $eventful_query, $eventful_gl_id); ?>
	</div>
	<?php require EFUL_Functions::eventful_locate_template('pagination.php'); ?>
</div>