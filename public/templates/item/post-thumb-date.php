<?php

/**
 * Thumb taxonomy
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/over-thumb-taxonomy.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
?>
<div class="eventful__item--archive <?php echo esc_attr($post_thumb_meta_position); ?>">
    <?php
    $start_tag      = $is_table ? '<td>' : '<li>';
    $end_tag        = $is_table ? '</td>' : '</li>';
    $meta_tag_start = apply_filters('eventful_post_meta_html_tag_start', $start_tag);
    $meta_tag_end   = apply_filters('eventful_post_meta_html_tag_end', $end_tag);
    
    
    echo wp_kses_post($meta_tag_start);
    if ('default' === $meta_date_format) {
        $post_date = esc_html(date_i18n(get_option('date_format'), strtotime($post->post_date)));
    } elseif ('time_ago' === $meta_date_format) {
        $post_date = human_time_diff(date_i18n('U', strtotime($post->post_date)), current_time('timestamp')) . esc_html__(' ago', 'eventful');
    } elseif ('custom' === $meta_date_format) {
        $post_date = esc_html(date_i18n($custom_date_format, strtotime($post->post_date)));
    }
    ?>
    <time class="entry-date published updated"><?php echo wp_kses_post($post_date); ?></time>
    <?php
    echo wp_kses_post($meta_tag_end);
    ?>
</div>
