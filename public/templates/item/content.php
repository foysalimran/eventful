<?php
/**
 * Content
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/content.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

?>
<div class="eventful__item__content">
	<?php
	if ( $show_post_content ) {

		echo wp_kses( EFP_Functions::efp_content( $post_content_setting, $efp_content_type, $post ), apply_filters( 'ta_wp_efp_allowed_tags', EFP_Functions::allowed_tags() ) );
	}
	?>
</div>
