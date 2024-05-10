<?php

/**
 * Thumb taxonomy
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/over-thumb-taxonomy.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="eful__item--archive <?php echo esc_attr($post_thumb_meta_position); ?>">
    <?php
    $term = EFUL_Functions::eful_post_thumb_taxonomy($taxonomy_name, $post->ID);
    $start_tag      = $is_table ? '<td class="ta-eventful-post-meta">' : '<li>';
    $end_tag        = $is_table ? '</td>' : '</li>';
    $meta_tag_start = apply_filters('eful_post_meta_html_tag_start', $start_tag);
    $meta_tag_end   = apply_filters('eful_post_meta_html_tag_end', $end_tag);

    if (!empty($term)) {
        echo wp_kses_post($meta_tag_start);
        echo wp_kses_post($term);
        echo wp_kses_post($meta_tag_end);
    }
    ?>
</div>