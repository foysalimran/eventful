<?php

/**
 * Read more
 *
 * This template can be overridden by copying it to yourtheme/eventful-pro/templates/item/read-more.php
 *
 * @package    Eventful_Pro
 * @subpackage Eventful_Pro/public
 */

if ('text_link' === $read_more_type) {
?>

    <?php if ('none' === $efp_page_link_type) { ?>
        <a class="eventful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" <?php echo esc_html($efp_link_rel_text); ?>>
        <?php } else { ?>
            <a class="eventful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" ta rel="<?php echo esc_attr($efp_link_rel); ?>" href="<?php the_permalink($post); ?>" <?php echo esc_html($efp_link_rel_text); ?>>
            <?php } ?>

            <?php echo esc_html($efp_read_label); ?> </a>

        <?php
    } else {
        ?>
            <div class="eventful__item__content__readmore">
                <?php if ('none' === $efp_page_link_type) { ?>
                    <a class="eventful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" <?php echo esc_html($efp_link_rel_text); ?>>
                    <?php } else { ?>
                        <a class="eventful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" href="<?php the_permalink($post); ?>" <?php echo esc_html($efp_link_rel_text); ?>>
                        <?php } ?>
                        <?php echo esc_html($efp_read_label); ?> </a>
            </div>
        <?php
    }
