<?php
/**
 * Content
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/content.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="eful__item__content">
	<?php
	if ( $show_post_content ) {

		echo wp_kses( EFUL_Functions::eful_content( $post_content_setting, $eful_content_type, $post ), apply_filters( 'eful_allowed_tags', EFUL_Functions::allowed_tags() ) );
	}
	?>
</div>
