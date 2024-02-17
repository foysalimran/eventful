<?php
/**
 * The dynamic CSS for Carousel layout.
 *
 * @package Eventful
 * @subpackage Eventful/Public/dynamic-css
 */

	// Navigation options.
	$efp_navigation                = isset( $view_options['efp_navigation'] ) ? $view_options['efp_navigation'] : '';
	$carousel_mode                 = isset( $view_options['efp_carousel_mode'] ) ? $view_options['efp_carousel_mode'] : 'standard';
	$title_text                    = get_the_title( $efp_id );
	$view_options['section_title'] = empty( $title_text ) ? false : $view_options['section_title'];
	$_nav_colors                   = EFP_Functions::efp_metabox_value(
		'efp_nav_colors',
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
	$nav_color                     = EFP_Functions::efp_metabox_value( 'color', $_nav_colors );
	$nav_color_hover               = EFP_Functions::efp_metabox_value( 'hover-color', $_nav_colors );
	$nav_color_bg                  = EFP_Functions::efp_metabox_value( 'bg', $_nav_colors );
	$nav_color_bg_hover            = EFP_Functions::efp_metabox_value( 'hover-bg', $_nav_colors );
	$nav_color_border              = EFP_Functions::efp_metabox_value( 'border-color', $_nav_colors );
	$nav_color_border_hover        = EFP_Functions::efp_metabox_value( 'hover-border-color', $_nav_colors );
	$nav_icon_size                 = EFP_Functions::efp_metabox_value( 'efp_nav_icon_size', $view_options );
	$_nav_icon_radius              = EFP_Functions::efp_metabox_value(
		'navigation_icons_border_radius',
		$view_options,
		array(
			'all'  => '0',
			'unit' => 'px',
		)
	);

	// Pagination options.
	$efp_pagination                = isset( $view_options['efp_pagination'] ) ? $view_options['efp_pagination'] : 'show';
	$_pagination_color_set         = isset( $view_options['efp_pagination_color_set'] ) ? $view_options['efp_pagination_color_set'] : '';
	$_pagination_colors            = isset( $_pagination_color_set['efp_pagination_color'] ) ? $_pagination_color_set['efp_pagination_color'] : array(
		'color'        => '#cccccc',
		'active-color' => '#263ad0',
	);
	$pagination_color              = $_pagination_colors['color'];
	$pagination_color_active       = $_pagination_colors['active-color'];
	$_pagination_number_colors     = isset( $_pagination_color_set['efp_pagination_number_color'] ) ? $_pagination_color_set['efp_pagination_number_color'] : array(
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
		if ( 'hide_on_mobile' === $efp_navigation ) {
			$custom_css .= "@media (max-width: 480px) { #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-prev, #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-next { display: none; } }";
		} $custom_css .= "#et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-prev, #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-next{ background-image: none; background-size: auto; background-color: {$nav_color_bg}; font-size: {$nav_icon_size}px; height: 33px; width: 33px; margin-top: 8px; border: 1px solid {$nav_color_border}; text-align: center; line-height: 30px; -webkit-transition: 0.3s; border-radius: {$_nav_icon_radius['all']}{$_nav_icon_radius['unit']}; }";
		$custom_css   .= "#et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-prev:hover, #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-next:hover{ background-color: {$nav_color_bg_hover}; border-color: {$nav_color_border_hover}; } #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-prev .fa, #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-next .fa{ color: {$nav_color}; } #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-prev:hover .fa, #et-boc .et-l #efp_wrapper-{$efp_id} .efp-button-next:hover .fa{ color: {$nav_color_hover}; } #et-boc .et-l #efp_wrapper-{$efp_id}.efp-carousel-wrapper .eventful__item{ margin-top: 0; } ";
		if ( 'hide' !== $efp_navigation && ! $view_options['section_title'] && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel.top_right, #et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel.top_left, #et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel.top_center {padding-top: 60px;}";
		}
		if ( 'hide' !== $efp_navigation && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel.bottom_left, #et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel.bottom_right, #et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel.bottom_center {padding-bottom: 60px;}";
		}
		if ( 'hide_on_mobile' === $efp_pagination ) {
			$custom_css .= "@media (max-width: 480px) { #et-boc .et-l #efp_wrapper-{$efp_id} .efp-pagination{ display: none; } }";
		} $custom_css .= "#et-boc .et-l #efp_wrapper-{$efp_id} .dots .swiper-pagination-bullet{ background: {$pagination_color}; } #et-boc .et-l #efp_wrapper-{$efp_id} .dots .swiper-pagination-bullet-active { background: {$pagination_color_active}; } #et-boc .et-l #efp_wrapper-{$efp_id} .number .swiper-pagination-bullet{ color: {$pagination_number_color}; background: {$pagination_number_bg}; } #et-boc .et-l #efp_wrapper-{$efp_id} .number .swiper-pagination-bullet-active, #et-boc .et-l #efp_wrapper-{$efp_id} .number .swiper-pagination-bullet:hover{ color: {$pagination_number_hover_color}; background: {$pagination_number_hover_bg}; } #et-boc .et-l #efp_wrapper-{$efp_id} .efp-pagination{text-align:center;} #et-boc .et-l #efp_wrapper-{$efp_id} .efp-pagination .swiper-pagination-bullet{ border-radius: 50%; margin: 0 4px;}";

		$carousel_nav_position = EFP_Functions::efp_metabox_value( 'efp_carousel_nav_position', $view_options, 'top_right' );
		if ( 'vertically_center_outer' === $carousel_nav_position ) {
			$custom_css .= "#et-boc .et-l .efp-wrapper-{$efp_id} .swiper-container{ position: static; }";
		}
		if ( 'hide' !== $efp_pagination && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#et-boc .et-l #efp_wrapper-{$efp_id} .ta-efp-carousel {padding-bottom: 60px;}";
		}
	} else {
		$custom_css .= "#efp_wrapper-{$efp_id} .swiper-container-fade:not(.swiper-container-rtl)  .swiper-slide .ta-eventful-pro-item:not(:last-child),  #efp_wrapper-{$efp_id} .swiper-container-cube:not(.swiper-container-rtl)  .swiper-slide [class~='ta-eventful-pro-item'], #efp_wrapper-{$efp_id} .swiper-container-flip:not(.swiper-container-rtl)  .swiper-slide [class~='ta-eventful-pro-item']{
			margin-right:{$margin_between_post}px;
		}
		#efp_wrapper-{$efp_id} .swiper-container-fade.swiper-container-rtl  .swiper-slide .ta-eventful-pro-item:not(:last-child),  #efp_wrapper-{$efp_id} .swiper-container-cube.swiper-container-rtl  .swiper-slide [class~='ta-eventful-pro-item'], #efp_wrapper-{$efp_id} .swiper-container-flip.swiper-container-rtl  .swiper-slide [class~='ta-eventful-pro-item']{
			margin-left:{$margin_between_post}px;
		}
		";
		
		if ( 'hide_on_mobile' === $efp_navigation ) {
			$custom_css .= "@media (max-width: 480px) { #efp_wrapper-{$efp_id} .efp-button-prev, #efp_wrapper-{$efp_id} .efp-button-next { display: none; } }";
		} $custom_css .= "#efp_wrapper-{$efp_id} .efp-button-prev, #efp_wrapper-{$efp_id} .efp-button-next{ background-image: none; background-size: auto; background-color: {$nav_color_bg}; font-size: {$nav_icon_size}px; height: 33px; width: 33px; margin-top: 8px; border: 1px solid {$nav_color_border}; text-align: center; line-height: 30px; -webkit-transition: 0.3s; border-radius: {$_nav_icon_radius['all']}{$_nav_icon_radius['unit']}; }";
		$custom_css   .= "#efp_wrapper-{$efp_id} .efp-button-prev:hover, #efp_wrapper-{$efp_id} .efp-button-next:hover{ background-color: {$nav_color_bg_hover}; border-color: {$nav_color_border_hover}; } #efp_wrapper-{$efp_id} .efp-button-prev .fa, #efp_wrapper-{$efp_id} .efp-button-next .fa{ color: {$nav_color}; } #efp_wrapper-{$efp_id} .efp-button-prev:hover .fa, #efp_wrapper-{$efp_id} .efp-button-next:hover .fa{ color: {$nav_color_hover}; } #efp_wrapper-{$efp_id}.efp-carousel-wrapper .eventful__item{ margin-top: 0; } ";
		if ( 'hide' !== $efp_navigation && ! $view_options['section_title'] && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#efp_wrapper-{$efp_id} .ta-efp-carousel.top_right, #efp_wrapper-{$efp_id} .ta-efp-carousel.top_left, #efp_wrapper-{$efp_id} .ta-efp-carousel.top_center {padding-top: 60px;}";
		}
		if ( 'hide' !== $efp_navigation && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#efp_wrapper-{$efp_id} .ta-efp-carousel.bottom_left, #efp_wrapper-{$efp_id} .ta-efp-carousel.bottom_right, #efp_wrapper-{$efp_id} .ta-efp-carousel.bottom_center {padding-bottom: 60px;}";
		}
		if ( 'hide_on_mobile' === $efp_pagination ) {
			$custom_css .= "@media (max-width: 480px) { #efp_wrapper-{$efp_id} .efp-pagination{ display: none; } }";
		} $custom_css .= "#efp_wrapper-{$efp_id} .dots .swiper-pagination-bullet{ background: {$pagination_color}; } #efp_wrapper-{$efp_id} .dots .swiper-pagination-bullet-active { background: {$pagination_color_active}; } #efp_wrapper-{$efp_id} .number .swiper-pagination-bullet{ color: {$pagination_number_color}; background: {$pagination_number_bg}; } #efp_wrapper-{$efp_id} .number .swiper-pagination-bullet-active, #efp_wrapper-{$efp_id} .number .swiper-pagination-bullet:hover{ color: {$pagination_number_hover_color}; background: {$pagination_number_hover_bg}; }";

		$custom_css .= "#efp_wrapper-{$efp_id} .efp-filter-bar ~ .ta-efp-carousel.top_right, #efp_wrapper-{$efp_id} .efp-filter-bar ~ .ta-efp-carousel.top_center, #efp_wrapper-{$efp_id} .efp-filter-bar ~ .ta-efp-carousel.top_left {padding-top: 0px;}";

		$carousel_nav_position = EFP_Functions::efp_metabox_value( 'efp_carousel_nav_position', $view_options, 'top_right' );
		if ( 'vertically_center_outer' === $carousel_nav_position ) {
			$custom_css .= ".efp-wrapper-{$efp_id} .swiper-container{ position: static; }";
		}
		if ( 'hide' !== $efp_pagination && 'ticker' !== $carousel_mode ) {
			$custom_css .= "#efp_wrapper-{$efp_id} .ta-efp-carousel {padding-bottom: 60px;}";
		}
	}
