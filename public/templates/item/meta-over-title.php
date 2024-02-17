<?php
/**
 * Meta over title
 *
 * This template can be overridden by copying it to yourtheme/eventful-pro/templates/item/meta-over-title.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

?>
<div class="efp-category above_title <?php echo esc_attr( $taxonomy ); ?>">
	<?php echo wp_kses_post( $terms ); ?>
</div>
