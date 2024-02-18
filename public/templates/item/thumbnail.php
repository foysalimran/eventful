<?php

/**
 * Item thumbnail
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/thumbnail.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

$lazy_load = isset($_post_thumb_setting['efp_img_lazy_load']) ? $_post_thumb_setting['efp_img_lazy_load'] : true;
$lazy_load = apply_filters('efp_img_lazy_load', $lazy_load);

if ('carousel_layout' !== $layout && $lazy_load && !is_admin()) {

	wp_enqueue_script('efp-lazy');
	$image = sprintf('<img data-efp_src="%1$s" %5$s class="efp-lazyload" width="%2$s"  height="%3$s" alt="%4$s">', $thumb_url, $efp_image_attr['width'], $efp_image_attr['height'], $alter_text, $retina_img_attr);

} else {

	$image = sprintf('<img %5$s src="%1$s" width="%2$s" height="%3$s" alt="%4$s">', $thumb_url, $efp_image_attr['width'], $efp_image_attr['height'], $alter_text, $retina_img_attr);
}



?>
<div class="eventful__item--thumbnail">
	<?php if ('none' === $efp_page_link_type) { ?>
		<a class="ta-efp-thumb" aria-label="<?php echo esc_attr($efp_image_attr['aria_label']); ?>" <?php echo esc_attr($efp_link_rel_text); ?>>
		<?php } else { ?>
			<a class="ta-efp-thumb" aria-label="<?php echo esc_attr($efp_image_attr['aria_label']); ?>" href="<?php the_permalink($post); ?>" target="<?php echo esc_attr($efp_link_target); ?>" <?php echo esc_attr($efp_link_rel_text); ?>>
			<?php
		}
		if (empty($efp_image_attr['video']) && empty($efp_image_attr['audio'])) {
			echo $image;
		} elseif ($efp_image_attr['video']) {
			?>
				<div class='ta-efp-post-video-thumb-area'><?php echo $efp_image_attr['video']; ?></div>
			<?php
		} elseif ($efp_image_attr['audio']) {
			?>
				<div class='ta-efp-post-audio-thumb-area'><?php echo $efp_image_attr['audio']; ?></div>
			<?php } ?>
			</a>
			<?php

			// Taxonomy terms over thumbnail.
			self::over_thumb_meta_taxonomy($post_meta_fields, $show_post_meta, $post);

			if ($post_thumb_meta == 'category') {
				ob_start();
				echo wp_kses($td['start'], $allow_tag);
				include EFP_Functions::efp_locate_template('item/post-thumb-taxonomy.php');
				echo wp_kses($td['end'], $allow_tag);
				$item_thumb = apply_filters('efp_thumb_taxonomy', ob_get_clean());
				echo $item_thumb;
			} elseif ($post_thumb_meta == 'date') {
				ob_start();
				echo wp_kses($td['start'], $allow_tag);
				include EFP_Functions::efp_locate_template('item/post-thumb-date.php');
				echo wp_kses($td['end'], $allow_tag);
				$item_thumb = apply_filters('efp_thumb_archive', ob_get_clean());
				echo $item_thumb;
			}
			?>

</div>