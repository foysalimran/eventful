<?php
/**
 * Section title
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/over-thumb-taxonomy.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="eventful-category <?php echo esc_attr( $meta_over_thumb_position ) . ' ' . esc_attr( $taxonomy ); ?>">
	<?php echo wp_kses_post( $terms ); ?>
</div>
