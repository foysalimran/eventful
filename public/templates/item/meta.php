<?php
/**
 * Meta
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/meta.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 echo '<div class="eful__item--meta">';

EFUL_Functions::eful_get_post_meta( $post, $post_meta_fields, $visitor_count, $_meta_separator, $is_table );

echo '</div>';
