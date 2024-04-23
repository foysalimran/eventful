<?php
/**
 * The dynamic CSS for Carousel layout.
 *
 * @package Eventful
 * @subpackage Eventful/Public/dynamic-css
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	// Navigation options.
	$eventful_navigation                = isset( $view_options['eventful_navigation'] ) ? $view_options['eventful_navigation'] : '';
	$carousel_mode                 = isset( $view_options['eventful_carousel_mode'] ) ? $view_options['eventful_carousel_mode'] : 'standard';
	$title_text                    = get_the_title( $eventful_id );
	$view_options['section_title'] = empty( $title_text ) ? false : $view_options['section_title'];
	$_nav_colors                   = EFUL_Functions::eful_metabox_value(
		'eventful_nav_colors',
		$view_options,
		array(
			'color'              => '#aaa',
			'hover-color'        => '#fff',
			'bg'                 => '#fff',
			'hover-bg'           => '#263ad0',
			'border-color'       => '#aaa',
			'hover-border-color' => '#263ad0',
		)
	);
	$nav_color                     = EFUL_Functions::eful_metabox_value( 'color', $_nav_colors );
	$nav_color_hover               = EFUL_Functions::eful_metabox_value( 'hover-color', $_nav_colors );
	$nav_color_bg                  = EFUL_Functions::eful_metabox_value( 'bg', $_nav_colors );
	$nav_color_bg_hover            = EFUL_Functions::eful_metabox_value( 'hover-bg', $_nav_colors );
	$nav_color_border              = EFUL_Functions::eful_metabox_value( 'border-color', $_nav_colors );
	$nav_color_border_hover        = EFUL_Functions::eful_metabox_value( 'hover-border-color', $_nav_colors );
	$nav_icon_size                 = EFUL_Functions::eful_metabox_value( 'eventful_nav_icon_size', $view_options );
	$_nav_icon_radius              = EFUL_Functions::eful_metabox_value(
		'navigation_icons_border_radius',
		$view_options,
		array(
			'all'  => '0',
			'unit' => 'px',
		)
	);

	// Pagination options.
	$eventful_pagination                = isset( $view_options['eventful_pagination'] ) ? $view_options['eventful_pagination'] : 'show';
	$_pagination_color_set         = isset( $view_options['eventful_pagination_color_set'] ) ? $view_options['eventful_pagination_color_set'] : '';
	$_pagination_colors            = isset( $_pagination_color_set['eventful_pagination_color'] ) ? $_pagination_color_set['eventful_pagination_color'] : array(
		'color'        => '#cccccc',
		'active-color' => '#263ad0',
	);
	$pagination_color              = $_pagination_colors['color'];
	$pagination_color_active       = $_pagination_colors['active-color'];
	$_pagination_number_colors     = isset( $_pagination_color_set['eventful_pagination_number_color'] ) ? $_pagination_color_set['eventful_pagination_number_color'] : array(
		'color'       => '#ffffff',
		'hover-color' => '#ffffff',
		'bg'          => '#444444',
		'hover-bg'    => '#263ad0',
	);
	$pagination_number_color       = $_pagination_number_colors['color'];
	$pagination_number_hover_color = $_pagination_number_colors['hover-color'];
	$pagination_number_bg          = $_pagination_number_colors['bg'];
	$pagination_number_hover_bg    = $_pagination_number_colors['hover-bg'];

	$classes = get_body_class();
	if ( in_array( 'et_divi_builder', $classes, true ) ) {
		// DB Builder compatibility.
		if ( 'hide_on_mobile' === $eventful_navigation ) {
			$custom_css .= "@media (max-width: 480px) { #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-prev, #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-next { display: none; } }";
		} $custom_css .= "#et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-prev, #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-next{ background-image: none; background-size: auto; background-color: {$nav_color_bg}; font-size: {$nav_icon_size}px; height: 33px; width: 33px; margin-top: 8px; border: 1px solid {$nav_color_border}; text-align: center; line-height: 30px; -webkit-transition: 0.3s; border-radius: {$_nav_icon_radius['all']}{$_nav_icon_radius['unit']}; }";
		$custom_css   .= "#et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-prev:hover, #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-next:hover{ background-color: {$nav_color_bg_hover}; border-color: {$nav_color_border_hover}; } #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-prev .fa, #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-next .fa{ color: {$nav_color}; } #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-prev:hover .fa, #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-button-next:hover .fa{ color: {$nav_color_hover}; } #et-boc .et-l #eventful_wrapper-{$eventful_id}.eventful-carousel-wrapper .eventful__item{ margin-top: 0; } ";
		if ( 'hide' !== $eventful_navigation && ! $view_options['section_title'] && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.top_right, #et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.top_left, #et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.top_center {padding-top: 60px;}";
		}
		if ( 'hide' !== $eventful_navigation && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.bottom_left, #et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.bottom_right, #et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.bottom_center {padding-bottom: 60px;}";
		}
		if ( 'hide_on_mobile' === $eventful_pagination ) {
			$custom_css .= "@media (max-width: 480px) { #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-pagination{ display: none; } }";
		} $custom_css .= "#et-boc .et-l #eventful_wrapper-{$eventful_id} .dots .swiper-pagination-bullet{ background: {$pagination_color}; } #et-boc .et-l #eventful_wrapper-{$eventful_id} .dots .swiper-pagination-bullet-active { background: {$pagination_color_active}; } #et-boc .et-l #eventful_wrapper-{$eventful_id} .number .swiper-pagination-bullet{ color: {$pagination_number_color}; background: {$pagination_number_bg}; } #et-boc .et-l #eventful_wrapper-{$eventful_id} .number .swiper-pagination-bullet-active, #et-boc .et-l #eventful_wrapper-{$eventful_id} .number .swiper-pagination-bullet:hover{ color: {$pagination_number_hover_color}; background: {$pagination_number_hover_bg}; } #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-pagination{text-align:center;} #et-boc .et-l #eventful_wrapper-{$eventful_id} .eventful-pagination .swiper-pagination-bullet{ border-radius: 50%; margin: 0 4px;}";

		$carousel_nav_position = EFUL_Functions::eful_metabox_value( 'eventful_carousel_nav_position', $view_options, 'top_right' );
		if ( 'vertically_center_outer' === $carousel_nav_position ) {
			$custom_css .= "#et-boc .et-l .eventful-wrapper-{$eventful_id} .swiper-container{ position: static; }";
		}
		if ( 'hide' !== $eventful_pagination && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#et-boc .et-l #eventful_wrapper-{$eventful_id} .ta-eventful-carousel {padding-bottom: 60px;}";
		}
	} else {
		$custom_css .= "#eventful_wrapper-{$eventful_id} .swiper-container-fade:not(.swiper-container-rtl)  .swiper-slide .ta-eventful-item:not(:last-child),  #eventful_wrapper-{$eventful_id} .swiper-container-cube:not(.swiper-container-rtl)  .swiper-slide [class~='ta-eventful-item'], #eventful_wrapper-{$eventful_id} .swiper-container-flip:not(.swiper-container-rtl)  .swiper-slide [class~='ta-eventful-item']{
			margin-right:{$margin_between_post}px;
		}
		#eventful_wrapper-{$eventful_id} .swiper-container-fade.swiper-container-rtl  .swiper-slide .ta-eventful-item:not(:last-child),  #eventful_wrapper-{$eventful_id} .swiper-container-cube.swiper-container-rtl  .swiper-slide [class~='ta-eventful-item'], #eventful_wrapper-{$eventful_id} .swiper-container-flip.swiper-container-rtl  .swiper-slide [class~='ta-eventful-item']{
			margin-left:{$margin_between_post}px;
		}
		";
		
		if ( 'hide_on_mobile' === $eventful_navigation ) {
			$custom_css .= "@media (max-width: 480px) { #eventful_wrapper-{$eventful_id} .eventful-button-prev, #eventful_wrapper-{$eventful_id} .eventful-button-next { display: none; } }";
		} $custom_css .= "#eventful_wrapper-{$eventful_id} .eventful-button-prev, #eventful_wrapper-{$eventful_id} .eventful-button-next{ background-image: none; background-size: auto; background-color: {$nav_color_bg}; font-size: {$nav_icon_size}px; height: 33px; width: 33px; margin-top: 8px; border: 1px solid {$nav_color_border}; text-align: center; line-height: 30px; -webkit-transition: 0.3s; border-radius: {$_nav_icon_radius['all']}{$_nav_icon_radius['unit']}; }";
		$custom_css   .= "#eventful_wrapper-{$eventful_id} .eventful-button-prev:hover, #eventful_wrapper-{$eventful_id} .eventful-button-next:hover{ background-color: {$nav_color_bg_hover}; border-color: {$nav_color_border_hover}; } #eventful_wrapper-{$eventful_id} .eventful-button-prev .fa, #eventful_wrapper-{$eventful_id} .eventful-button-next .fa{ color: {$nav_color}; } #eventful_wrapper-{$eventful_id} .eventful-button-prev:hover .fa, #eventful_wrapper-{$eventful_id} .eventful-button-next:hover .fa{ color: {$nav_color_hover}; } #eventful_wrapper-{$eventful_id}.eventful-carousel-wrapper .eventful__item{ margin-top: 0; } ";
		if ( 'hide' !== $eventful_navigation && ! $view_options['section_title'] && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#eventful_wrapper-{$eventful_id} .ta-eventful-carousel.top_right, #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.top_left, #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.top_center {padding-top: 60px;}";
		}
		if ( 'hide' !== $eventful_navigation && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#eventful_wrapper-{$eventful_id} .ta-eventful-carousel.bottom_left, #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.bottom_right, #eventful_wrapper-{$eventful_id} .ta-eventful-carousel.bottom_center {padding-bottom: 60px;}";
		}
		if ( 'hide_on_mobile' === $eventful_pagination ) {
			$custom_css .= "@media (max-width: 480px) { #eventful_wrapper-{$eventful_id} .eventful-pagination{ display: none; } }";
		} $custom_css .= "#eventful_wrapper-{$eventful_id} .dots .swiper-pagination-bullet{ background: {$pagination_color}; } #eventful_wrapper-{$eventful_id} .dots .swiper-pagination-bullet-active { background: {$pagination_color_active}; } #eventful_wrapper-{$eventful_id} .number .swiper-pagination-bullet{ color: {$pagination_number_color}; background: {$pagination_number_bg}; } #eventful_wrapper-{$eventful_id} .number .swiper-pagination-bullet-active, #eventful_wrapper-{$eventful_id} .number .swiper-pagination-bullet:hover{ color: {$pagination_number_hover_color}; background: {$pagination_number_hover_bg}; }";

		$custom_css .= "#eventful_wrapper-{$eventful_id} .eventful-filter-bar ~ .ta-eventful-carousel.top_right, #eventful_wrapper-{$eventful_id} .eventful-filter-bar ~ .ta-eventful-carousel.top_center, #eventful_wrapper-{$eventful_id} .eventful-filter-bar ~ .ta-eventful-carousel.top_left {padding-top: 0px;}";

		$carousel_nav_position = EFUL_Functions::eful_metabox_value( 'eventful_carousel_nav_position', $view_options, 'top_right' );
		if ( 'vertically_center_outer' === $carousel_nav_position ) {
			$custom_css .= ".eventful-wrapper-{$eventful_id} .swiper-container{ position: static; }";
		}
		if ( 'hide' !== $eventful_pagination && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#eventful_wrapper-{$eventful_id} .ta-eventful-carousel {padding-bottom: 60px;}";
		}
	}
