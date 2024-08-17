<?php

/**
 * Item thumbnail
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/thumbnail.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$lazy_load = isset($_post_thumb_setting['eful_img_lazy_load']) ? $_post_thumb_setting['eful_img_lazy_load'] : true;
$lazy_load = apply_filters('eful_img_lazy_load', $lazy_load);

if ('carousel_layout' !== $layout && $lazy_load && !is_admin()) {

	wp_enqueue_script('eventful-lazy');
	$image = sprintf('<img data-eful_src="%1$s" %5$s class="eventful-lazyload" width="%2$s"  height="%3$s" alt="%4$s">', $thumb_url, $eful_image_attr['width'], $eful_image_attr['height'], $alter_text, $retina_img_attr);

} else {

	$image = sprintf('<img %5$s src="%1$s" width="%2$s" height="%3$s" alt="%4$s">', $thumb_url, $eful_image_attr['width'], $eful_image_attr['height'], $alter_text, $retina_img_attr);
}



?>
<div class="eful__item--thumbnail">
	<?php if ('none' === $eful_page_link_type) { ?>
		<a class="ta-eventful-thumb" aria-label="<?php echo esc_attr($eful_image_attr['aria_label']); ?>" <?php echo esc_attr($eful_link_rel_text); ?>>
		<?php } else { ?>
			<a class="ta-eventful-thumb" aria-label="<?php echo esc_attr($eful_image_attr['aria_label']); ?>" href="<?php the_permalink($post); ?>" target="<?php echo esc_attr($eful_link_target); ?>" <?php echo esc_attr($eful_link_rel_text); ?>>
			<?php
		}
		if (empty($eful_image_attr['video']) && empty($eful_image_attr['audio'])) {
			echo wp_kses_post($image);
		} elseif ($eful_image_attr['video']) {
			?>
				<div class='ta-eventful-post-video-thumb-area'><?php echo wp_kses_post($eful_image_attr['video']); ?></div>
			<?php
		} elseif ($eful_image_attr['audio']) {
			?>
				<div class='ta-eventful-post-audio-thumb-area'><?php echo wp_kses_post($eful_image_attr['audio']); ?></div>
			<?php } ?>
			</a>
			<?php

			// Taxonomy terms over thumbnail.
			self::over_thumb_meta_taxonomy($post_meta_fields, $show_post_meta, $post);

			if ($post_thumb_meta == 'category') {
				ob_start();
				echo wp_kses($td['start'], $allow_tag);
				include EFUL_Functions::eful_locate_template('item/post-thumb-taxonomy.php');
				echo wp_kses($td['end'], $allow_tag);
				$item_thumb = apply_filters('eful_thumb_taxonomy', ob_get_clean());
				echo wp_kses_post($item_thumb);
			} elseif ($post_thumb_meta == 'date') {
				ob_start();
				echo wp_kses($td['start'], $allow_tag);
				include EFUL_Functions::eful_locate_template('item/post-thumb-date.php');
				echo wp_kses($td['end'], $allow_tag);
				$item_thumb = apply_filters('eful_thumb_archive', ob_get_clean());
				echo wp_kses_post($item_thumb);
			}
			?>

</div>