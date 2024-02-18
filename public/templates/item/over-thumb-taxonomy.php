<?php
/**
 * Section title
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/over-thumb-taxonomy.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

?>
<div class="efp-category <?php echo esc_attr( $meta_over_thumb_position ) . ' ' . esc_attr( $taxonomy ); ?>">
	<?php echo wp_kses_post( $terms ); ?>
</div>
