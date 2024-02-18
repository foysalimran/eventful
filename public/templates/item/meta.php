<?php
/**
 * Meta
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/meta.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

 echo '<div class="eventful__item--meta">';

EFP_Functions::eventful_get_post_meta( $post, $post_meta_fields, $visitor_count, $_meta_separator, $is_table );

echo '</div>';
