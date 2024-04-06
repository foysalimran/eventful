<?php
/**
 * Meta over title
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/meta-over-title.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="eventful-category above_title <?php echo esc_attr( $taxonomy ); ?>">
	<?php echo wp_kses_post( $terms ); ?>
</div>
