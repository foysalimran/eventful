<?php

/**
 *  Shuffle filter view file
 *
 * This template can be overridden by copying it to yourtheme/eventful-pro/templates/filter.php
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<div id="efp_wrapper-<?php echo esc_attr($efp_gl_id); ?>" class="<?php self::efp_wrapper_classes($layout_preset, $efp_gl_id, $pagination_type, $item_same_height_class); ?>" data-sid="<?php echo esc_attr($efp_gl_id); ?>" <?php self::wrapper_data($pagination_type, $pagination_type_mobile, $efp_gl_id); ?> data-grid="<?php echo esc_attr($grid_style); ?>" data-lang="<?php echo esc_attr($spta_lang); ?>">
	<?php
	EFP_HTML::efp_section_title($section_title, $show_section_title);
	EFP_HTML::efp_preloader($show_preloader);
	$categories = get_categories(
		array(
			'orderby' => 'name',
			'parent'  => 0,
		)
	);
	if (is_array($advanced_filter) && !$efp_query->is_main_query()) {
	?>
		<div class="efp-shuffle-filter">
			<?php
			$filter_type = isset($view_options['efp_filter_type']) ? $view_options['efp_filter_type'] : '';
			Eventful_Shuffle_Filter::efp_shuffle_filter($view_options, $layout_preset, $efp_query, $filter_type);
			?>
		</div>
	<?php }; ?>
	<div class="ta-row grid">
		<?php self::efp_get_posts($options, $layout_preset, $post_content_sorter, $efp_query, $efp_gl_id); ?>
	</div>
	<?php require EFP_Functions::efp_locate_template('pagination.php'); ?>
</div>