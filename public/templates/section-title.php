<?php
/**
 * Section title
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/section-title.php
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */

if ( ! empty( $section_title_text ) ) {
	?>
<h2 class="eventful-section-title"><?php echo wp_kses_post( $section_title_text ); ?> </h2>
<?php } ?>
