<?php
/**
 * Meta
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/event-fildes.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 echo '<div class="eful__item--meta event_meta">';

EFUL_Functions::eful_get_event_fildes( $post, $event_fildes_fields, $visitor_count, $_event_meta_separator, $is_table );

echo '</div>';
