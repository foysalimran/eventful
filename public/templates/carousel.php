<?php

/**
 *  Carousel view
 *
 * @package    Eventful
 * @subpackage Eventful/public/template
 */

if (!defined('ABSPATH')) {
	exit;
}
$carousel_mode        = isset( $view_options['eful_carousel_mode'] ) ? $view_options['eful_carousel_mode'] : 'standard';
$carousel_autoplay    = ( isset( $view_options['eful_autoplay'] ) && ( $view_options['eful_autoplay'] ) ) ? 'true' : 'false';
$autoplay_speed       = isset($view_options['eful_autoplay_speed']) ? $view_options['eful_autoplay_speed'] : '2000';
$carousel_speed       = isset($view_options['eful_carousel_speed']) ? $view_options['eful_carousel_speed'] : '600';
$ticker_speed         = isset( $view_options['eful_ticker_speed'] ) ? $view_options['eful_ticker_speed'] : '3000';
$pause_hover          = (isset($view_options['eful_pause_hover']) && ($view_options['eful_pause_hover'])) ? 'true' : 'false';
$slide_effect         = isset( $view_options['eful_slide_effect'] ) ? $view_options['eful_slide_effect'] : 'slide';
$_slides_to_scroll    = isset( $view_options['eful_slides_to_scroll'] ) ? $view_options['eful_slides_to_scroll'] : array(
	'lg_desktop'       => '1',
	'desktop'          => '1',
	'tablet'           => '1',
	'mobile_landscape' => '1',
	'mobile'           => '1',
);



$infinite_loop        = (isset($view_options['eful_infinite_loop']) && ($view_options['eful_infinite_loop'])) ? 'true' : 'false';
$carousel_auto_height = (isset($view_options['eful_adaptive_height']) && ($view_options['eful_adaptive_height'])) ? 'true' : 'false';
$number_of_columns    = isset( $view_options['eful_number_of_columns'] ) ? $view_options['eful_number_of_columns'] : array(
	'lg_desktop'       => '4',
	'desktop'          => '4',
	'tablet'           => '3',
	'mobile_landscape' => '2',
	'mobile'           => '1',
);
$ticker_slide_width   = isset( $view_options['eful_ticker_slide_width'] ) ? $view_options['eful_ticker_slide_width'] : '250';
$lazy_load            = (isset($view_options['eful_lazy_load']) && ($view_options['eful_lazy_load'])) ? 'true' : 'false';
if ( 'cube' === $slide_effect || 'flip' === $slide_effect ) {
	$carousel_auto_height = 'false';
	$lazy_load            = 'false';
}
$spta_fade_class = '';
if ( 'fade' === $slide_effect ) {
	$spta_fade_class = ' eventful-carousel-fade';
}
// Direction.
$carousel_direction = ( isset( $view_options['eful_carousel_direction'] ) ) ? $view_options['eful_carousel_direction'] : 'ltr';
if ( 'ticker' === $carousel_mode ) {
	$carousel_direction = 'rtl' === $carousel_direction ? 'prev' : 'next';
}
$is_carousel_accessibility            = ( isset( $eful_settings['accessibility'] ) && ( $eful_settings['accessibility'] ) ) ? 'true' : 'false';
$accessibility_prev_slide_text        = isset( $eful_settings['prev_slide_message'] ) ? $eful_settings['prev_slide_message'] : '';
$accessibility_next_slide_text        = isset( $eful_settings['next_slide_message'] ) ? $eful_settings['next_slide_message'] : '';
$accessibility_first_slide_text       = isset( $eful_settings['first_slide_message'] ) ? $eful_settings['first_slide_message'] : '';
$accessibility_last_slide_text        = isset( $eful_settings['last_slide_message'] ) ? $eful_settings['last_slide_message'] : '';
$accessibility_pagination_bullet_text = isset( $eful_settings['pagination_bullet_message'] ) ? $eful_settings['pagination_bullet_message'] : '';

$eful_responsive_screen_setting = isset( $eful_settings['eful_responsive_screen_setting'] ) ? $eful_settings['eful_responsive_screen_setting'] : '';
$desktop_screen_size           = isset( $eful_responsive_screen_setting ['desktop'] ) ? $eful_responsive_screen_setting ['desktop'] : '1200';
$tablet_screen_size            = isset( $eful_responsive_screen_setting ['tablet'] ) ? $eful_responsive_screen_setting ['tablet'] : '980';
$mobile_land_screen_size       = isset( $eful_responsive_screen_setting ['mobile_landscape'] ) ? $eful_responsive_screen_setting ['mobile_landscape'] : '736';
$mobile_screen_size            = isset( $eful_responsive_screen_setting ['mobile'] ) ? $eful_responsive_screen_setting ['mobile'] : '576';
// Row.
$carousel_row = ( isset( $view_options['eful_number_of_row'] ) ) ? $view_options['eful_number_of_row'] : array(
	'lg_desktop'       => '1',
	'desktop'          => '1',
	'tablet'           => '1',
	'mobile_landscape' => '1',
	'mobile'           => '1',
);

if ($eful_settings['eful_swiper_js']) {
	wp_enqueue_script('eful_swiper');
}
if ($eful_settings['eful_bx_js']) {
	wp_enqueue_script('eful_bxslider');
}
// Navigation.
$_navigation = isset($view_options['eful_navigation']) ? $view_options['eful_navigation'] : 'hide';
$navigation        = 'true';
$navigation_mobile = 'true';
switch ($_navigation) {
	case 'show':
		$navigation        = 'true';
		$navigation_mobile = 'true';
		break;
	case 'hide':
		$navigation        = 'false';
		$navigation_mobile = 'false';
		break;
	case 'hide_on_mobile':
		$navigation        = 'true';
		$navigation_mobile = 'false';
		break;
}

$navigation_icons      = isset( $view_options['navigation_icons'] ) ? $view_options['navigation_icons'] : 'fa-angle';
$carousel_nav_position = isset( $view_options['eful_carousel_nav_position'] ) ? $view_options['eful_carousel_nav_position'] : 'top_right';

// Pagination Settings.
$_pagination = isset($view_options['eful_pagination']) ? $view_options['eful_pagination'] : 'hide';
$pagination        = 'true';
$pagination_mobile = 'true';
switch ($_pagination) {
	case 'show':
		$pagination        = 'true';
		$pagination_mobile = 'true';
		break;
	case 'hide':
		$pagination        = 'false';
		$pagination_mobile = 'false';
		break;
	case 'hide_on_mobile':
		$pagination        = 'true';
		$pagination_mobile = 'false';
		break;
}
$dynamic_bullets    = ( isset( $view_options['eful_dynamicBullets'] ) && ( $view_options['eful_dynamicBullets'] ) ) ? 'true' : 'false';
$bullet_types       = ( isset( $view_options['bullet_types'] ) ) ? $view_options['bullet_types'] : '';
$eful_accessibility  = ( isset( $view_options['eful_accessibility'] ) && ( $view_options['eful_accessibility'] ) ) ? 'true' : 'false';
$touch_swipe        = ( isset( $view_options['touch_swipe'] ) && ( $view_options['touch_swipe'] ) ) ? 'true' : 'false';
$slider_draggable   = ( isset( $view_options['slider_draggable'] ) && ( $view_options['slider_draggable'] ) ) ? 'true' : 'false';
$slider_mouse_wheel = ( isset( $view_options['slider_mouse_wheel'] ) && ( $view_options['slider_mouse_wheel'] ) ) ? 'true' : 'false';
$center_mode        = 'false';
$mobile_landscape   = isset( $number_of_columns['mobile_landscape'] ) ? $number_of_columns['mobile_landscape'] : '2';
if ( 'center' === $carousel_mode ) {
	$center_mode = 'true';
}

?>
<!-- Markup Starts -->
<div id="eful_wrapper-<?php echo esc_html( $eful_gl_id ); ?>" class="<?php self::eful_wrapper_classes( $layout_preset, $eful_gl_id, $pagination_type, $item_same_height_class ); ?> <?php self::wrapper_data( $pagination_type, $pagination_type_mobile, $eful_gl_id ); ?> <?php echo esc_html( $carousel_mode ); ?>" data-sid="<?php echo esc_html( $eful_gl_id ); ?>">

<?php
	EFUL_HTML::eful_section_title( $section_title, $show_section_title );
	EFUL_HTML::eful_preloader( $show_preloader );
?>
<?php require EFUL_Functions::eful_locate_template('filter-bar.php'); ?>
	<div class="eventful">
		<div id="ta-eventful-id-<?php echo esc_html($eful_gl_id); ?>" class="swiper-container ta-eventful-carousel <?php echo esc_html($carousel_nav_position . $spta_fade_class); ?>" dir="<?php echo esc_html($carousel_direction); ?>" data-carousel='{"mode":"<?php echo esc_html($carousel_mode); ?>", "speed":<?php echo esc_html($carousel_speed); ?>, "ticker_speed":<?php echo esc_html($ticker_speed); ?>, "ticker_width":<?php echo esc_html($ticker_slide_width); ?>, "items":<?php echo esc_html($number_of_columns['lg_desktop']); ?>, "spaceBetween":<?php echo esc_html($margin_between_post); ?>, "navigation":<?php echo esc_html($navigation); ?>, "pagination": <?php echo esc_html($pagination); ?>, "autoplay": <?php echo esc_html($carousel_autoplay); ?>, "autoplay_speed": <?php echo esc_html($autoplay_speed); ?>, "loop": <?php echo esc_html($infinite_loop); ?>, "autoHeight": <?php echo esc_html($carousel_auto_height); ?>, "lazy":  <?php echo esc_html($lazy_load); ?>, "effect": "<?php echo esc_html($slide_effect); ?>", "simulateTouch": <?php echo esc_html($slider_draggable); ?>, "slider_mouse_wheel": <?php echo esc_html($slider_mouse_wheel); ?>, "allowTouchMove": <?php echo esc_html($touch_swipe); ?>, "dynamicBullets": <?php echo esc_html($dynamic_bullets); ?>, "bullet_types": "<?php echo esc_html($bullet_types); ?>", "center_mode": <?php echo esc_html($center_mode); ?>, "slidesRow": {"lg_desktop": <?php echo esc_html($carousel_row['lg_desktop']); ?>, "desktop": <?php echo esc_html($carousel_row['desktop']); ?>, "tablet": <?php echo esc_html($carousel_row['tablet']); ?>, "mobile_landscape": <?php echo esc_html($carousel_row['mobile_landscape']); ?>, "mobile": <?php echo esc_html($carousel_row['mobile']); ?>}, "responsive": {"lg_desktop": <?php echo esc_html($desktop_screen_size); ?>, "desktop": <?php echo esc_html($tablet_screen_size); ?>, "tablet": <?php echo esc_html($mobile_land_screen_size); ?>, "mobile_landscape": <?php echo esc_html($mobile_screen_size); ?>}, "slidesPerView": {"lg_desktop": <?php echo esc_html($number_of_columns['lg_desktop']); ?>, "desktop": <?php echo esc_html($number_of_columns['desktop']); ?>, "tablet": <?php echo esc_html($number_of_columns['tablet']); ?>, "mobile_landscape": <?php echo esc_html($mobile_landscape); ?>, "mobile": <?php echo esc_html($number_of_columns['mobile']); ?>}, "slideToScroll": {"lg_desktop": <?php echo esc_html($_slides_to_scroll['lg_desktop']); ?>, "desktop": <?php echo esc_html($_slides_to_scroll['desktop']); ?>, "tablet": <?php echo esc_html($_slides_to_scroll['tablet']); ?>, "mobile_landscape": <?php echo esc_html($_slides_to_scroll['mobile_landscape']); ?>, "mobile": <?php echo esc_html($_slides_to_scroll['mobile']); ?> }, "navigation_mobile": <?php echo esc_html($navigation_mobile); ?>, "pagination_mobile": <?php echo esc_html($pagination_mobile); ?>, "stop_onHover": <?php echo esc_html($pause_hover); ?>, "enabled": <?php echo esc_html($is_carousel_accessibility); ?>, "prevSlideMessage": "<?php echo esc_html($accessibility_prev_slide_text); ?>", "nextSlideMessage": "<?php echo esc_html($accessibility_next_slide_text); ?>", "firstSlideMessage": "<?php echo esc_html($accessibility_first_slide_text); ?>", "lastSlideMessage": "<?php echo esc_html($accessibility_last_slide_text); ?>","keyboard": "<?php echo esc_html($eful_accessibility); ?>", "paginationBulletMessage": "<?php echo esc_html($accessibility_pagination_bullet_text); ?>" }'>
			<div class="swiper-wrapper">
				<?php self::eful_get_posts($options, $layout_preset, $post_content_sorter, $eful_query, $eful_gl_id); ?>
			</div>
			<?php
			if ('true' === $pagination && 'ticker' !== $carousel_mode) {
			?>
				<div class="eventful-pagination swiper-pagination <?php echo esc_html($bullet_types); ?>"></div>
			<?php } ?>
			<?php if ('true' === $navigation && 'ticker' !== $carousel_mode) { ?>
				<div class="eventful-button-next swiper-button-next <?php echo esc_html($carousel_nav_position); ?>"><i class="fa <?php echo esc_html($navigation_icons); ?>-right"></i></div>
				<div class="eventful-button-prev swiper-button-prev <?php echo esc_html($carousel_nav_position); ?>"><i class="fa <?php echo esc_html($navigation_icons); ?>-left"></i></div><?php } ?>
		</div>
	</div>
</div>