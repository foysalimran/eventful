<?php

/**
 * Read more
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/read-more.php
 *
 * @package    Eventful_Pro
 * @subpackage Eventful_Pro/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ('text_link' === $read_more_type) {
?>

    <?php if ('none' === $eful_page_link_type) { ?>
        <a class="eful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" <?php echo esc_html($eful_link_rel_text); ?>>
        <?php } else { ?>
            <a class="eful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" ta rel="<?php echo esc_attr($eful_link_rel); ?>" href="<?php the_permalink($post); ?>" <?php echo esc_html($eful_link_rel_text); ?>>
            <?php } ?>

            <?php echo esc_html($eful_read_label); ?> </a>

        <?php
    } else {
        ?>
            <div class="eful__item__content__readmore">
                <?php if ('none' === $eful_page_link_type) { ?>
                    <a class="eful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" <?php echo esc_html($eful_link_rel_text); ?>>
                    <?php } else { ?>
                        <a class="eful__item__btn" target="<?php echo esc_attr($readmore_target); ?>" href="<?php the_permalink($post); ?>" <?php echo esc_html($eful_link_rel_text); ?>>
                        <?php } ?>
                        <?php echo esc_html($eful_read_label); ?> </a>
            </div>
        <?php
    }
