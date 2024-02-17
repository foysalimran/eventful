<?php

/**
 *  Dynamic CSS
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

if (!defined('ABSPATH')) {
	exit;
}

$view_options = get_post_meta($efp_id, 'ta_efp_view_options', true);
$layouts      = get_post_meta($efp_id, 'ta_efp_layouts', true);
$layout = isset($layouts['efp_layout_preset']) ? $layouts['efp_layout_preset'] : '';
$popup_content_color       = isset( $view_options['popup_content_color'] ) ? $view_options['popup_content_color'] : '';
$popup_custom_fields_color = isset( $popup_content_color['custom-fields'] ) ? $popup_content_color['custom-fields'] : '#888';

$show_section_title        = isset($view_options['section_title']) ? $view_options['section_title'] : false;
if ($show_section_title) {
	$section_title_margin_top    = isset($view_options['section_title_margin']['top']) && $view_options['section_title_margin']['top'] > 0 ? $view_options['section_title_margin']['top'] . 'px' : 0;
	$section_title_margin_right  = isset($view_options['section_title_margin']['right']) && $view_options['section_title_margin']['right'] > 0 ? $view_options['section_title_margin']['right'] . 'px' : 0;
	$section_title_margin_bottom = isset($view_options['section_title_margin']['bottom']) && $view_options['section_title_margin']['bottom'] > 0 ? $view_options['section_title_margin']['bottom'] . 'px' : 0;
	$section_title_margin_left   = isset($view_options['section_title_margin']['left']) && $view_options['section_title_margin']['left'] > 0 ? $view_options['section_title_margin']['left'] . 'px' : 0;
	$_section_title_typography   = isset($view_options['section_title_typography']) && array_key_exists('font-size', $view_options['section_title_typography']) ? $view_options['section_title_typography'] : array(
		'color'              => '#444',
		'font-family'        => '',
		'font-weight'        => '',
		'subset'             => '',
		'font-size'          => '24',
		'tablet-font-size'   => '15',
		'mobile-font-size'   => '18',
		'line-height'        => '28',
		'tablet-line-height' => '24',
		'mobile-line-height' => '15',
		'letter-spacing'     => '0',
		'text-align'         => 'left',
		'text-transform'     => 'none',
		'type'               => '',
		'unit'               => 'px',
	);
	$section_title_font_weight   = !empty($_section_title_typography['font-weight']) ? $_section_title_typography['font-weight'] : '400';
	$section_title_font_style    = !empty($_section_title_typography['font-style']) ? $_section_title_typography['font-style'] : 'normal';
	$custom_css                 .= "#efp_wrapper-{$efp_id} .efp-section-title{";
	if (!empty($_section_title_typography['font-family'])) {
		$custom_css .= "font-family: {$_section_title_typography['font-family']};font-weight: {$section_title_font_weight};font-style: {$section_title_font_style};";
	}
	$custom_css .= "text-align: {$_section_title_typography['text-align']};text-transform: {$_section_title_typography['text-transform']};font-size: {$_section_title_typography['font-size']}px;line-height: {$_section_title_typography['line-height']}px;letter-spacing: {$_section_title_typography['letter-spacing']}px;color: {$_section_title_typography['color']};margin: {$section_title_margin_top} {$section_title_margin_right} {$section_title_margin_bottom} {$section_title_margin_left}}";
}

$margin_between_post      = isset( $view_options['margin_between_post']['all'] ) ? (int) $view_options['margin_between_post']['all'] : 20;
$margin_between_post_half = $margin_between_post / 2;
$custom_css              .= "#efp_wrapper-{$efp_id} .ta-row{ margin-right: -{$margin_between_post_half}px;margin-left: -{$margin_between_post_half}px;}#efp_wrapper-{$efp_id} .ta-row [class*='ta-col-']{padding-right: {$margin_between_post_half}px;padding-left: {$margin_between_post_half}px;padding-bottom: {$margin_between_post}px;}";
if ( 'large_with_small' === $layouts['efp_layout_preset'] ) {
	$custom_css .= "#efp_wrapper-{$efp_id} .ta-efp-block-8, #efp_wrapper-{$efp_id} .ta-efp-block-4, #efp_wrapper-{$efp_id} .ta-efp-block-6, #efp_wrapper-{$efp_id} .ta-efp-block-3{padding-right: {$margin_between_post_half}px;padding-left: {$margin_between_post_half}px;}#efp_wrapper-{$efp_id} .ta-efp-block-4 .ta-efp-block-half,#efp_wrapper-{$efp_id} .ta-efp-block-8,#efp_wrapper-{$efp_id} .ta-efp-block-3 .ta-efp-block-half,#efp_wrapper-{$efp_id} .ta-efp-block-6{padding-bottom: {$margin_between_post}px;}";
}
/**
 * Style for each slide/post.
 */
// Post Title.
$post_sorter     = isset($view_options['post_content_sorter']) ? $view_options['post_content_sorter'] : '';
$efp_event_fildes  = isset($post_sorter['efp_event_fildes']) ? $post_sorter['efp_event_fildes'] : '';
$efp_post_title  = isset($post_sorter['efp_post_title']) ? $post_sorter['efp_post_title'] : '';

$show_post_title = isset($efp_post_title['show_post_title']) ? $efp_post_title['show_post_title'] : '';
// PCP Post Content.
$efp_post_content  = isset($post_sorter['efp_post_content']) ? $post_sorter['efp_post_content'] : '';
$show_post_content = isset($efp_post_content['show_post_content']) ? $efp_post_content['show_post_content'] : '';

// Post Title.
if ($show_post_title) {
	$post_title_margin = isset($efp_post_title['post_title_margin']) ? $efp_post_title['post_title_margin'] : array(
		'top'    => '0',
		'right'  => '0',
		'bottom' => '9',
		'left'   => '0',
	);

	$_post_title_typography = isset($view_options['post_title_typography']) && array_key_exists('font-size', $view_options['post_title_typography']) ? $view_options['post_title_typography'] : array(
		'color'              => '#111',
		'hover_color'        => '#263ad0',
		'font-family'        => '',
		'font-weight'        => '',
		'subset'             => '',
		'font-size'          => '15',
		'tablet-font-size'   => '18',
		'mobile-font-size'   => '16',
		'line-height'        => '24',
		'tablet-line-height' => '22',
		'mobile-line-height' => '15',
		'letter-spacing'     => '0',
		'text-align'         => 'left',
		'text-transform'     => 'none',
		'type'               => '',
		'unit'               => 'px',
	);
	$post_title_font_weight = !empty($_post_title_typography['font-weight']) ? $_post_title_typography['font-weight'] : '400';
	$post_title_font_style  = !empty($_post_title_typography['font-style']) ? $_post_title_typography['font-style'] : 'normal';
	$custom_css            .= "#efp_wrapper-{$efp_id} .eventful__item--title a{";
	if (!empty($_post_title_typography['font-family'])) {
		$custom_css .= "font-family: {$_post_title_typography['font-family']};font-weight: {$post_title_font_weight};font-style: {$post_title_font_style};";
	}
	if ('zigzag_layout' !== $layouts['efp_layout_preset']) {
		$custom_css .= "text-align: {$_post_title_typography['text-align']};";
	}
	$custom_css .= "text-transform: {$_post_title_typography['text-transform']};font-size: {$_post_title_typography['font-size']}px;line-height: {$_post_title_typography['line-height']}px;letter-spacing: {$_post_title_typography['letter-spacing']}px;color: {$_post_title_typography['color']};display: inherit;}#efp_wrapper-{$efp_id} .eventful__item--title {margin: {$post_title_margin['top']}px {$post_title_margin['right']}px {$post_title_margin['bottom']}px {$post_title_margin['left']}px;}#efp_wrapper-{$efp_id} .efp-collapse-header a{display: inline-block;}";
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--title a:hover,#efp_wrapper-{$efp_id} .efp-collapse-header:hover a{color: {$_post_title_typography['hover_color']};}";
}

// Post Content.
if ($show_post_content) {
	$post_content_margin      = isset($efp_post_content['post_content_margin']) ? $efp_post_content['post_content_margin'] : array(
		'top'    => '0',
		'right'  => '0',
		'bottom' => '15',
		'left'   => '0',
	);
	$_post_content_typography = isset($view_options['post_content_typography']) && array_key_exists('font-size', $view_options['post_content_typography']) ? $view_options['post_content_typography'] : array(
		'color'              => '#444',
		'font-family'        => '',
		'font-weight'        => '',
		'subset'             => '',
		'font-size'          => '16',
		'tablet-font-size'   => '14',
		'mobile-font-size'   => '12',
		'line-height'        => '20',
		'tablet-line-height' => '18',
		'mobile-line-height' => '18',
		'letter-spacing'     => '0',
		'text-align'         => 'left',
		'text-transform'     => 'none',
		'type'               => '',
		'unit'               => 'px',
	);
	$post_content_font_weight = !empty($_post_content_typography['font-weight']) ? $_post_content_typography['font-weight'] : '400';
	$post_content_font_style  = !empty($_post_content_typography['font-style']) ? $_post_content_typography['font-style'] : 'normal';
	$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item__content{";
	if (!empty($_post_content_typography['font-family'])) {
		$custom_css .= "font-family: {$_post_content_typography['font-family']};font-weight: {$post_content_font_weight};font-style: {$post_content_font_style};";
	}
	if ('zigzag_layout' !== $layouts['efp_layout_preset']) {
		$custom_css .= "text-align: {$_post_content_typography['text-align']};";
	}
	$custom_css .= "text-transform: {$_post_content_typography['text-transform']};font-size: {$_post_content_typography['font-size']}px;line-height: {$_post_content_typography['line-height']}px;letter-spacing: {$_post_content_typography['letter-spacing']}px;margin: {$post_content_margin['top']}px {$post_content_margin['right']}px {$post_content_margin['bottom']}px {$post_content_margin['left']}px;color: {$_post_content_typography['color']}; }";
}

if ('carousel_layout' === $layout) {
	include EFP_PATH . '/public/dynamic-css/carousel-css.php';
}

// Post inner padding.
$post_content_orientation   = $view_options['post_content_orientation'];
$post_details_class         = 'overlay-box' === $post_content_orientation ? '.ta-efp-post-details' : '';
$post_details_content_class = 'overlay-box' === $post_content_orientation ? '.ta-efp-post-details-content' : '';
if ('overlay' !== $post_content_orientation) {
	$_post_inner_padding       = EFP_Functions::efp_metabox_value('post_inner_padding_property', $view_options);
	$post_inner_padding_unit   = $_post_inner_padding['unit'];
	$post_inner_padding_top    = $_post_inner_padding['top'] > 0 ? $_post_inner_padding['top'] . $post_inner_padding_unit : '0';
	$post_inner_padding_right  = $_post_inner_padding['right'] > 0 ? $_post_inner_padding['right'] . $post_inner_padding_unit : '0';
	$post_inner_padding_bottom = $_post_inner_padding['bottom'] > 0 ? $_post_inner_padding['bottom'] . $post_inner_padding_unit : '0';
	$post_inner_padding_left   = $_post_inner_padding['left'] > 0 ? $_post_inner_padding['left'] . $post_inner_padding_unit : '0';
	$custom_css               .= "#efp_wrapper-{$efp_id} .eventful__item {padding: {$post_inner_padding_top} {$post_inner_padding_right} {$post_inner_padding_bottom} {$post_inner_padding_left};}";
}

// Post border.
$_post_border      = $view_options['post_border'];
$post_border_width = (int) $_post_border['all'];
$post_border_style = $_post_border['style'];
$post_border_color = $_post_border['color'];
if ('none' !== $post_border_style) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item {border: {$post_border_width}px {$post_border_style} {$post_border_color};}";
}

// Post box shadow.
$show_post_box_shadow = EFP_Functions::efp_metabox_value( 'show_post_box_shadow', $view_options, false );
if ( $show_post_box_shadow ) {
	$post_box_shadow_property = EFP_Functions::efp_metabox_value(
		'post_box_shadow_property',
		$view_options,
		array(
			'horizontal' => '0',
			'vertical'   => '0',
			'blur'       => '8',
			'spread'     => '0',
			'color'      => 'rgb(187, 187, 187)',
		)
	);
	$box_shadow_h             = EFP_Functions::efp_metabox_value( 'horizontal', $post_box_shadow_property );
	$box_shadow_v             = EFP_Functions::efp_metabox_value( 'vertical', $post_box_shadow_property );
	$box_shadow_blur          = EFP_Functions::efp_metabox_value( 'blur', $post_box_shadow_property );
	$box_shadow_spread        = EFP_Functions::efp_metabox_value( 'spread', $post_box_shadow_property );
	$box_shadow_color         = EFP_Functions::efp_metabox_value( 'color', $post_box_shadow_property );
	$box_shadow_style         = 'outset' === $post_box_shadow_property['style'] ? '' : $post_box_shadow_property['style'];
	$box_shadow_margin_top    = 'inset' === $box_shadow_style ? '0' : ( $box_shadow_spread - $box_shadow_v + 0.5 * $box_shadow_blur );
	$box_shadow_margin_right  = 'inset' === $box_shadow_style ? '0' : ( $box_shadow_spread + $box_shadow_h + 0.5 * $box_shadow_blur );
	$box_shadow_margin_bottom = 'inset' === $box_shadow_style ? '0' : ( $box_shadow_spread + $box_shadow_v + 0.5 * $box_shadow_blur );
	$box_shadow_margin_left   = 'inset' === $box_shadow_style ? '0' : ( $box_shadow_spread - $box_shadow_h + 0.5 * $box_shadow_blur );
	$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item {$post_details_class} {$post_details_content_class}{box-shadow: {$box_shadow_h}px {$box_shadow_v}px {$box_shadow_blur}px {$box_shadow_spread}px {$box_shadow_color} {$box_shadow_style};margin: {$box_shadow_margin_top}px {$box_shadow_margin_right}px {$box_shadow_margin_bottom}px {$box_shadow_margin_left}px;}";
}

// Post background color.
$post_background_property = EFP_Functions::efp_metabox_value('post_background_property', $view_options);
$post_background_overlay = EFP_Functions::efp_metabox_value('post_background_overlay', $view_options);
$post_background_blur = EFP_Functions::efp_metabox_value('post_background_blur', $view_options);

$_post_border_radius         = EFP_Functions::efp_metabox_value(
	'post_border_radius_property',
	$view_options,
	array(
		'all' => '0',
	)
);
$post_border_radius_unit     = EFP_Functions::efp_metabox_value('unit', $_post_border_radius);
$post_border_radius_length   = EFP_Functions::efp_metabox_value('all', $_post_border_radius);
$post_border_radius_property = $post_border_radius_length > 0 ? $post_border_radius_length . $post_border_radius_unit : '0';
$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item {border-radius: {$post_border_radius_property};}";
if (!in_array($post_content_orientation, array('overlay', 'overlay-box'), true)) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item {background-color: {$post_background_property};}";
}

if (in_array($post_content_orientation, array('overlay'), true)) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item.ta-overlay::after {background-color: {$post_background_overlay}; opacity: 0.$post_background_blur;}";
}

/**
 * Post Thumbnail CSS.
 */
$post_thumb_css           = $post_sorter['efp_post_thumb'];
$post_thumb_margin        = isset($post_thumb_css['post_thumb_margin']) ? $post_thumb_css['post_thumb_margin'] : array(
	'top'    => '40',
	'right'  => '0',
	'bottom' => '11',
	'left'   => '0',
);
$post_thumb_border_radius = isset($post_thumb_css['post_thumb_border_radius']) ? $post_thumb_css['post_thumb_border_radius'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '0',
	'left'   => '0',
	'unit'   => 'px',
);
$post_thumb_border_radius_top = $post_thumb_border_radius['top'].$post_thumb_border_radius['unit'];
$post_thumb_border_radius_left = $post_thumb_border_radius['left'].$post_thumb_border_radius['unit'];
$post_thumb_border_radius_bottom = $post_thumb_border_radius['bottom'].$post_thumb_border_radius['unit'];
$post_thumb_border_radius_right = $post_thumb_border_radius['right'].$post_thumb_border_radius['unit'];
// Post thumb border radius.
$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item .eventful__item--thumbnail img{border-radius: {$post_thumb_border_radius_top} {$post_thumb_border_radius_right} {$post_thumb_border_radius_bottom} {$post_thumb_border_radius_left};} #efp_wrapper-{$efp_id} .eventful__item .eventful__item--thumbnail{margin: {$post_thumb_margin['top']}px {$post_thumb_margin['right']}px {$post_thumb_margin['bottom']}px {$post_thumb_margin['left']}px;}#efp_wrapper-{$efp_id} .ta-overlay.eventful__item .eventful__item--thumbnail,#efp_wrapper-{$efp_id} .left-thumb.eventful__item .eventful__item--thumbnail,#efp_wrapper-{$efp_id} .right-thumb.eventful__item .eventful__item--thumbnail,#efp_wrapper-{$efp_id} .ta-efp-content-box.eventful__item .eventful__item--thumbnail{margin: 0;}";

// Border for Post thumb.
$post_thumb_border = isset($post_thumb_css['efp_thumb_border']) ? $post_thumb_css['efp_thumb_border'] : array(
	'all'   => '0',
	'style' => 'solid',
	'color' => '#dddddd',
);
if (0 !== $post_thumb_border['all'] && 'none' !== $post_thumb_border['style']) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--thumbnail{border: {$post_thumb_border['all']}px {$post_thumb_border['style']} {$post_thumb_border['color']};}";
}

// Grayscale effect.
$post_thumb_gray_scale = isset($post_thumb_css['post_thumb_gray_scale']) ? $post_thumb_css['post_thumb_gray_scale'] : 'none';

if ('gray_and_normal' === $post_thumb_gray_scale) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--thumbnail img{-webkit-filter: grayscale(100%);filter: grayscale(100%);}#efp_wrapper-{$efp_id} .eventful__item:hover .eventful__item--thumbnail img{-webkit-filter: grayscale(0);filter: grayscale(0);}";
} elseif ('gray_on_hover' === $post_thumb_gray_scale) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--thumbnail img{-webkit-filter: grayscale(0);filter: grayscale(0);}#efp_wrapper-{$efp_id} .eventful__item:hover .eventful__item--thumbnail img{-webkit-filter: grayscale(100%);filter: grayscale(100%);}";
} elseif ('always_gray' === $post_thumb_gray_scale) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--thumbnail img,#efp_wrapper-{$efp_id} .eventful__item:hover .eventful__item--thumbnail img{-webkit-filter: grayscale(100%);filter: grayscale(100%);}";
}
// Zoom effect.
$post_thumb_zoom = isset($post_thumb_css['post_thumb_zoom']) ? $post_thumb_css['post_thumb_zoom'] : 'none';
if ('zoom_in' === $post_thumb_zoom) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--thumbnail:hover img{transform: scale(1.08);}";
} elseif ('zoom_out' === $post_thumb_zoom) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--thumbnail img{transform: scale(1.08);}
		#efp_wrapper-{$efp_id} .eventful__item--thumbnail:hover img{transform: scale(1.0);}";
}

// Post Meta.
$_post_meta_typography    = isset($view_options['post_meta_typography']) && array_key_exists('font-size', $view_options['post_meta_typography']) ? $view_options['post_meta_typography'] : array(
	'color'              => '#888',
	'hover_color'        => '#263ad0',
	'font-family'        => '',
	'font-weight'        => '',
	'subset'             => '',
	'font-size'          => '14',
	'tablet-font-size'   => '14',
	'mobile-font-size'   => '12',
	'line-height'        => '16',
	'tablet-line-height' => '16',
	'mobile-line-height' => '16',
	'letter-spacing'     => '0',
	'text-align'         => 'left',
	'text-transform'     => 'none',
	'type'               => '',
	'unit'               => 'px',
);
$post_meta_font_weight    = !empty($_post_meta_typography['font-weight']) ? $_post_meta_typography['font-weight'] : '400';
$post_meta_font_style     = !empty($_post_meta_typography['font-style']) ? $_post_meta_typography['font-style'] : 'normal';
$efp_post_meta     = !empty($post_sorter['efp_post_meta']) ? $post_sorter['efp_post_meta'] : '';
$post_meta_margin         = isset($efp_post_meta['post_meta_margin']) ? $efp_post_meta['post_meta_margin'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '9',
	'left'   => '0',
);
$post_meta_between_margin = isset($efp_post_meta['post_meta_between_margin']) ? $efp_post_meta['post_meta_between_margin'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '0',
	'left'   => '0',
);
$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item .efp-category a,#efp_wrapper-{$efp_id}  .eventful__item .eventful__item--meta ul li{
	margin: {$post_meta_between_margin['top']}px {$post_meta_between_margin['right']}px {$post_meta_between_margin['bottom']}px {$post_meta_between_margin['left']}px;
}";
$meta_separator_color = isset($efp_post_meta['meta_separator_color']) ? $efp_post_meta['meta_separator_color'] : "";
$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item .meta_separator{
	color: {$meta_separator_color};
}";
$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--meta li,#efp_wrapper-{$efp_id} td.eventful__item--meta,#efp_wrapper-{$efp_id} .eventful__item--meta ul,#efp_wrapper-{$efp_id} .eventful__item--meta li a{";
if (!empty($_post_meta_typography['font-family'])) {
	$custom_css .= "font-family: {$_post_meta_typography['font-family']};font-weight: {$post_meta_font_weight};font-style: {$post_meta_font_style};";
}

$custom_css .= "text-transform: {$_post_meta_typography['text-transform']};font-size: {$_post_meta_typography['font-size']}px;line-height: {$_post_meta_typography['line-height']}px;letter-spacing: {$_post_meta_typography['letter-spacing']}px;color: {$_post_meta_typography['color']};}#efp_wrapper-{$efp_id} .eventful__item--meta{margin: {$post_meta_margin['top']}px {$post_meta_margin['right']}px {$post_meta_margin['bottom']}px {$post_meta_margin['left']}px;";
if ('zigzag_layout' !== $layouts['efp_layout_preset']) {
	$custom_css .= "text-align: {$_post_meta_typography['text-align']};";
}
$custom_css .= '}';

$event_meta_alignment 	= isset( $efp_post_meta['post_meta_alignment'] ) ? $efp_post_meta['post_meta_alignment'] : '';
$custom_css         	.= "#efp_wrapper-{$efp_id} .eventful__item--meta ul, #efp_wrapper-{$efp_id} .eventful__item--meta ul li{justify-content:{$event_meta_alignment}}";

$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--meta li a:hover{color: {$_post_meta_typography['hover_color']};}";

// Post Pill Meta Color. ( button style meta ).
$post_meta_group = isset($efp_post_meta['efp_post_meta_group']) ? $efp_post_meta['efp_post_meta_group'] : '';
$title_above     = 1;
$over_thumb      = 1;
$show_post_meta  = isset($efp_post_meta['show_post_meta']) ? $efp_post_meta['show_post_meta'] : true;

if (is_array($post_meta_group) && $show_post_meta) {
	foreach ($post_meta_group as $key => $post_meta) {
		$selected_meta      = $post_meta['select_post_meta'];
		$meta_position      = isset($post_meta['efp_meta_position']) ? $post_meta['efp_meta_position'] : '';
		$meta_pill_color    = isset($post_meta['efp_meta_pill_color']) ? $post_meta['efp_meta_pill_color'] : array(
			'text' => '#fff',
			'bg'   => '#0015b5',
		);
		$efp_taxonomy       = isset($post_meta['post_meta_taxonomy']) ? $post_meta['post_meta_taxonomy'] : '';
		$efp_taxonomy_class = !empty($efp_taxonomy) ? ".{$efp_taxonomy}" : '';
		$text_color         = $meta_pill_color['text'];
		$bg                 = $meta_pill_color['bg'];
		if ('taxonomy' === $selected_meta) {
			if ('over_thumb' === $meta_position) {
				$meta_over_thumb_position = isset($post_meta['efp_meta_over_thump_position']) ? $post_meta['efp_meta_over_thump_position'] : 'top_left';
				$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item-thumb-area {$efp_taxonomy_class}.efp-category.{$meta_over_thumb_position} a {color: {$text_color}; background: {$bg};";
				if (!empty($_post_meta_typography['font-family'])) {
					$custom_css .= "font-family: {$_post_meta_typography['font-family']};font-weight: {$post_meta_font_weight};font-style: {$post_meta_font_style};";
				}
				$custom_css .= "text-transform: {$_post_meta_typography['text-transform']};font-size: {$_post_meta_typography['font-size']}px;line-height: {$_post_meta_typography['line-height']}px;letter-spacing: {$_post_meta_typography['letter-spacing']}px;
			}";
				++$over_thumb;
			}
			if ('above_title' === $meta_position) {
				$custom_css .= "#efp_wrapper-{$efp_id} {$efp_taxonomy_class}.efp-category.above_title{
					text-align: {$_post_meta_typography['text-align']};
				}#efp_wrapper-{$efp_id} {$efp_taxonomy_class}.efp-category.above_title a{ color: {$text_color}; background: {$bg};";
				if (!empty($_post_meta_typography['font-family'])) {
					$custom_css .= "font-family: {$_post_meta_typography['font-family']};font-weight: {$post_meta_font_weight};font-style: {$post_meta_font_style};";
				}
				$custom_css .= "text-transform: {$_post_meta_typography['text-transform']};font-size: {$_post_meta_typography['font-size']}px;line-height: {$_post_meta_typography['line-height']}px;letter-spacing: {$_post_meta_typography['letter-spacing']}px;
			}";
				++$title_above;
			}
		}
	}
}
if (!empty($_post_meta_typography['font-family'])) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item-thumb-area .efp-category a{font-family: {$_post_meta_typography['font-family']};}";
}

// Event Meta.
$_event_fildes_typography    = isset($view_options['event_fildes_typography']) && array_key_exists('font-size', $view_options['event_fildes_typography']) ? $view_options['event_fildes_typography'] : array(
	'color'              => '#888',
	'hover_color'        => '#263ad0',
	'font-family'        => '',
	'font-weight'        => '',
	'subset'             => '',
	'font-size'          => '14',
	'tablet-font-size'   => '14',
	'mobile-font-size'   => '12',
	'line-height'        => '16',
	'tablet-line-height' => '16',
	'mobile-line-height' => '16',
	'letter-spacing'     => '0',
	'text-align'         => 'left',
	'text-transform'     => 'none',
	'type'               => '',
	'unit'               => 'px',
);
$event_fildes_font_weight    = !empty($_event_fildes_typography['font-weight']) ? $_event_fildes_typography['font-weight'] : '400';
$event_fildes_font_style     = !empty($_event_fildes_typography['font-style']) ? $_event_fildes_typography['font-style'] : 'normal';
$event_fildes_margin         = isset($efp_event_fildes['event_fildes_margin']) ? $efp_event_fildes['event_fildes_margin'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '15',
	'left'   => '0',
);
$event_fildes_between_margin = isset($efp_event_fildes['event_fildes_between_margin']) ? $efp_event_fildes['event_fildes_between_margin'] : array(
	'top'    => '0',
	'right'  => '',
	'bottom' => '',
	'left'   => '0',
);
$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item .efp-category a,#efp_wrapper-{$efp_id}  .eventful__item .eventful__item--meta ul li{
	margin: {$event_fildes_between_margin['top']}px {$event_fildes_between_margin['right']}px {$event_fildes_between_margin['bottom']}px {$event_fildes_between_margin['left']}px;
}";
$event_separator_color = isset($efp_event_fildes['event_meta_separator_color']) ? $efp_event_fildes['event_meta_separator_color'] : "";
$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item .event_separator{
	color: {$event_separator_color};
}";

$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--meta li,#efp_wrapper-{$efp_id} td.eventful__item--meta,#efp_wrapper-{$efp_id} .eventful__item--meta ul,#efp_wrapper-{$efp_id} .eventful__item--meta li a{";
if (!empty($_event_fildes_typography['font-family'])) {
	$custom_css .= "font-family: {$_event_fildes_typography['font-family']};font-weight: {$event_fildes_font_weight};font-style: {$event_fildes_font_style};";
}

$custom_css .= "text-transform: {$_event_fildes_typography['text-transform']};font-size: {$_event_fildes_typography['font-size']}px;line-height: {$_event_fildes_typography['line-height']}px;letter-spacing: {$_event_fildes_typography['letter-spacing']}px;color: {$_event_fildes_typography['color']};}#efp_wrapper-{$efp_id} .eventful__item--meta.event_meta{margin: {$event_fildes_margin['top']}px {$event_fildes_margin['right']}px {$event_fildes_margin['bottom']}px {$event_fildes_margin['left']}px;";
if ('zigzag_layout' !== $layouts['efp_layout_preset']) {
	$custom_css .= "text-align: {$_event_fildes_typography['text-align']};";
}
$custom_css .= '}';

$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--meta li a:hover{color: {$_event_fildes_typography['hover_color']};}";

// Post Pill Meta Color. ( button style meta ).
$event_fildes_group = isset($efp_event_fildes['efp_event_fildes_group']) ? $efp_event_fildes['efp_event_fildes_group'] : '';
$title_above     = 1;
$over_thumb      = 1;
$show_event_fildes  = isset($efp_event_fildes['show_event_fildes']) ? $efp_event_fildes['show_event_fildes'] : true;

if (is_array($event_fildes_group) && $show_event_fildes) {
	foreach ($event_fildes_group as $key => $event_fildes) {
		$selected_meta      = $event_fildes['select_event_fildes'];
		$meta_position      = isset($event_fildes['efp_meta_position']) ? $event_fildes['efp_meta_position'] : '';
		$meta_pill_color    = isset($event_fildes['efp_meta_pill_color']) ? $event_fildes['efp_meta_pill_color'] : array(
			'text' => '#fff',
			'bg'   => '#0015b5',
		);
		$efp_taxonomy       = isset($event_fildes['event_fildes_taxonomy']) ? $event_fildes['event_fildes_taxonomy'] : '';
		$efp_taxonomy_class = !empty($efp_taxonomy) ? ".{$efp_taxonomy}" : '';
		$text_color         = $meta_pill_color['text'];
		$bg                 = $meta_pill_color['bg'];
		if ('taxonomy' === $selected_meta) {
			if ('over_thumb' === $meta_position) {
				$meta_over_thumb_position = isset($event_fildes['efp_meta_over_thump_position']) ? $event_fildes['efp_meta_over_thump_position'] : 'top_left';
				$custom_css              .= "#efp_wrapper-{$efp_id} .eventful__item-thumb-area {$efp_taxonomy_class}.efp-category.{$meta_over_thumb_position} a {color: {$text_color}; background: {$bg};";
				if (!empty($_event_fildes_typography['font-family'])) {
					$custom_css .= "font-family: {$_event_fildes_typography['font-family']};font-weight: {$event_fildes_font_weight};font-style: {$event_fildes_font_style};";
				}
				$custom_css .= "text-transform: {$_event_fildes_typography['text-transform']};font-size: {$_event_fildes_typography['font-size']}px;line-height: {$_event_fildes_typography['line-height']}px;letter-spacing: {$_event_fildes_typography['letter-spacing']}px;
			}";
				++$over_thumb;
			}
			if ('above_title' === $meta_position) {
				$custom_css .= "#efp_wrapper-{$efp_id} {$efp_taxonomy_class}.efp-category.above_title{
					text-align: {$_event_fildes_typography['text-align']};
				}#efp_wrapper-{$efp_id} {$efp_taxonomy_class}.efp-category.above_title a{ color: {$text_color}; background: {$bg};";
				if (!empty($_event_fildes_typography['font-family'])) {
					$custom_css .= "font-family: {$_event_fildes_typography['font-family']};font-weight: {$event_fildes_font_weight};font-style: {$event_fildes_font_style};";
				}
				$custom_css .= "text-transform: {$_event_fildes_typography['text-transform']};font-size: {$_event_fildes_typography['font-size']}px;line-height: {$_event_fildes_typography['line-height']}px;letter-spacing: {$_event_fildes_typography['letter-spacing']}px;
			}";
				++$title_above;
			}
		}
	}
}
if (!empty($_event_fildes_typography['font-family'])) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item-thumb-area .efp-category a{font-family: {$_event_fildes_typography['font-family']};}";
}

// Post ReadMore Settings.
$post_content_settings = isset($post_sorter['efp_post_content_readmore']) ? $post_sorter['efp_post_content_readmore'] : '';

$readmore_margin      = isset($post_content_settings['readmore_margin']) ? $post_content_settings['readmore_margin'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '15',
	'left'   => '0',
);
$readmore_padding      = isset($post_content_settings['readmore_padding']) ? $post_content_settings['readmore_padding'] : array(
	'top'    => '6',
	'right'  => '20',
	'bottom' => '6',
	'left'   => '20',
);
$show_read_more        = isset($post_content_settings['show_read_more']) ? $post_content_settings['show_read_more'] : true;
if ($show_read_more) {
	$_read_more_typography = isset($view_options['read_more_typography']) && array_key_exists('font-size', $view_options['read_more_typography']) ? $view_options['read_more_typography'] : array(
		'font-family'        => '',
		'font-weight'        => '600',
		'subset'             => '',
		'font-size'          => '12',
		'tablet-font-size'   => '12',
		'mobile-font-size'   => '10',
		'line-height'        => '18',
		'tablet-line-height' => '18',
		'mobile-line-height' => '16',
		'letter-spacing'     => '0',
		'text-align'         => 'left',
		'text-transform'     => 'uppercase',
		'type'               => '',
		'unit'               => 'px',
	);

	$read_more_font_weight = !empty($_read_more_typography['font-weight']) ? $_read_more_typography['font-weight'] : '400';
	$read_more_font_style  = !empty($_read_more_typography['font-style']) ? $_read_more_typography['font-style'] : 'normal';
	$read_more_type        = isset($post_content_settings['read_more_type']) ? $post_content_settings['read_more_type'] : 'button';
	$custom_css           .= "#efp_wrapper-{$efp_id} .eventful__item__btn{";
	if (!empty($_read_more_typography['font-family'])) {
		$custom_css .= "font-family: {$_read_more_typography['font-family']}; font-weight: {$read_more_font_weight}; font-style: {$read_more_font_style};";
	}
	$custom_css .= "text-transform: {$_read_more_typography['text-transform']}; font-size: {$_read_more_typography['font-size']}px; line-height: {$_read_more_typography['line-height']}px; letter-spacing: {$_read_more_typography['letter-spacing']}px; }";
	if ( 'zigzag_layout' !== $layouts['efp_layout_preset'] ) {
		$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item__content__readmore{ text-align: {$_read_more_typography['text-align']}; }";
	}
	if ('button' === $read_more_type) {
		$_button_color  = isset($post_content_settings['readmore_color_button']) ? $post_content_settings['readmore_color_button'] : array(
			'standard'     => '#111',
			'hover'        => '#fff',
			'bg'           => 'transparent',
			'hover_bg'     => '#263ad0',
			'border'       => '#888',
			'hover_border' => '#263ad0',
		);
		$_border_radius = isset($post_content_settings['readmore_button_radius']) ? $post_content_settings['readmore_button_radius'] : array(
			'all'  => '0',
			'unit' => 'px',
		);
		$custom_css    .= "#efp_wrapper-{$efp_id} .eventful__item__btn{ background: {$_button_color['bg']}; color: {$_button_color['standard']}; border-color: {$_button_color['border']}; border-radius: {$_border_radius['all']}{$_border_radius['unit']}; margin: {$readmore_margin['top']}px {$readmore_margin['right']}px {$readmore_margin['bottom']}px {$readmore_margin['left']}px; padding: {$readmore_padding['top']}px {$readmore_padding['right']}px {$readmore_padding['bottom']}px {$readmore_padding['left']}px; } #efp_wrapper-{$efp_id} .eventful__item__btn:hover { background: {$_button_color['hover_bg']}; color: {$_button_color['hover']}; border-color: {$_button_color['hover_border']};  }";
	} else {
		$readmore_text_color = $post_content_settings['readmore_color_text'];
		$custom_css         .= "#efp_wrapper-{$efp_id} .eventful__item__btn{ color: {$readmore_text_color['standard']}; } #efp_wrapper-{$efp_id} .eventful__item__btn:hover{ color: {$readmore_text_color['hover']};margin: {$readmore_margin['top']}px {$readmore_margin['right']}px {$readmore_margin['bottom']}px {$readmore_margin['left']}px;color: {$_post_content_typography['color']};padding: {$readmore_padding['top']}px {$readmore_padding['right']}px {$readmore_padding['bottom']}px {$readmore_padding['left']}px; } ";
	}
}
// Post Thumb Archive Settings.
$efp_post_thumb = isset($post_sorter['efp_post_thumb']) ? $post_sorter['efp_post_thumb'] : '';
$post_thumb_show = isset($efp_post_thumb['post_thumb_show']) ? $efp_post_thumb['post_thumb_show'] : '';
$post_thumb_meta = isset($efp_post_thumb['post_thumb_meta']) ? $efp_post_thumb['post_thumb_meta'] : '';

if ($post_thumb_show && $post_thumb_meta != 'none') {
	$_thumb_archive_typography = isset($view_options['thumb_archive_typography']) && array_key_exists('font-size', $view_options['thumb_archive_typography']) ? $view_options['thumb_archive_typography'] : array(
		'font-family'        => '',
		'font-weight'        => '600',
		'subset'             => '',
		'font-size'          => '12',
		'tablet-font-size'   => '12',
		'mobile-font-size'   => '10',
		'line-height'        => '18',
		'tablet-line-height' => '18',
		'mobile-line-height' => '16',
		'letter-spacing'     => '0',
		'text-align'         => 'left',
		'text-transform'     => 'uppercase',
		'type'               => '',
		'unit'               => 'px',
	);

	$post_thumb_font_weight = !empty($_thumb_archive_typography['font-weight']) ? $_thumb_archive_typography['font-weight'] : '400';
	$post_thumb_font_style  = !empty($_thumb_archive_typography['font-style']) ? $_thumb_archive_typography['font-style'] : 'normal';
	$post_thumb_type        = isset($post_content_settings['post_thumb_type']) ? $post_content_settings['post_thumb_type'] : 'button';
	$custom_css           .= "#efp_wrapper-{$efp_id} .eventful__item--archive li{";
	if (!empty($_thumb_archive_typography['font-family'])) {
		$custom_css .= "font-family: {$_thumb_archive_typography['font-family']}; font-weight: {$post_thumb_font_weight}; font-style: {$post_thumb_font_style};";
	}
	$custom_css .= "text-transform: {$_thumb_archive_typography['text-transform']}; font-size: {$_thumb_archive_typography['font-size']}px; line-height: {$_thumb_archive_typography['line-height']}px; letter-spacing: {$_thumb_archive_typography['letter-spacing']}px; }";
 	if ('button' === $post_thumb_type) {
		$_post_thumb_button  = isset($efp_post_thumb['post_thumb_meta_button']) ? $efp_post_thumb['post_thumb_meta_button'] : array(
			'standard'     => '#111',
			'hover'        => '#fff',
			'bg'           => 'transparent',
			'hover_bg'     => '#263ad0',
			'border'       => '#888',
			'hover_border' => '#263ad0',
		);
		$_border_radius = isset($post_content_settings['readmore_button_radius']) ? $post_content_settings['readmore_button_radius'] : array(
			'all'  => '0',
			'unit' => 'px',
		);
		$custom_css    .= "#efp_wrapper-{$efp_id} .eventful__item--archive li{ background: {$_post_thumb_button['bg']}; color: {$_post_thumb_button['standard']}; border-color: {$_post_thumb_button['border']}; border-radius: {$_border_radius['all']}{$_border_radius['unit']}; } #efp_wrapper-{$efp_id} .eventful__item--archive li:hover { background: {$_post_thumb_button['hover_bg']}; color: {$_post_thumb_button['hover']}; border-color: {$_post_thumb_button['hover_border']}; }";
	} else {
		$readmore_text_color = $post_content_settings['readmore_color_text'];
		$custom_css         .= "#efp_wrapper-{$efp_id} .eventful__item--archive li{ color: {$readmore_text_color['standard']}; } #efp_wrapper-{$efp_id} .eventful__item--archive li:hover{ color: {$readmore_text_color['hover']}; } ";
	}
}

// Pagination CSS and Live filter CSS.
$show_pagination = isset($view_options['show_post_pagination']) ? $view_options['show_post_pagination'] : false;
if ($show_pagination) {
	$pagination_btn_color   = isset($view_options['efp_pagination_btn_color']) ? $view_options['efp_pagination_btn_color'] : array(
		'text_color'        => '#5e5e5e',
		'text_acolor'       => '#ffffff',
		'border_color'      => '#bbbbbb',
		'border_acolor'     => '#263ad0',
		'background'        => '#ffffff',
		'active_background' => '#263ad0',
	);
	$efp_loadmore_btn_color = isset($view_options['efp_loadmore_btn_color']) ? $view_options['efp_loadmore_btn_color'] : array(
		'text_color'        => '#ffffff',
		'text_hcolor'       => '#5e5e5e',
		'background'        => '#263ad0',
		'active_background' => '#ffffff',
	);
	$pagination_alignment   = isset($view_options['pagination_alignment']) ? $view_options['pagination_alignment'] : 'left';
	$custom_css            .= "#efp_wrapper-{$efp_id} .efp-post-pagination .page-numbers.current, #efp_wrapper-{$efp_id} .efp-post-pagination a.active , #efp_wrapper-{$efp_id} .efp-post-pagination a:hover{ color: {$pagination_btn_color['text_acolor']}; background: {$pagination_btn_color['active_background']}; border-color: {$pagination_btn_color['border_acolor']}; }#efp_wrapper-{$efp_id} .efp-post-pagination,#efp_wrapper-{$efp_id} .efp-load-more,#efp_wrapper-{$efp_id} .efp-infinite-scroll-loader{ text-align: {$pagination_alignment};justify-content: {$pagination_alignment}; }#efp_wrapper-{$efp_id} .efp-post-pagination .page-numbers, .efp-post-pagination a{ background: {$pagination_btn_color['background']}; color:{$pagination_btn_color['text_color']}; border-color: {$pagination_btn_color['border_color']}; }#efp_wrapper-{$efp_id} .efp-load-more button{ background: {$efp_loadmore_btn_color['background']}; color: {$efp_loadmore_btn_color['text_color']}; border:1px solid transparent; }#efp_wrapper-{$efp_id} .efp-load-more button:hover{ background: {$efp_loadmore_btn_color['active_background']}; color: {$efp_loadmore_btn_color['text_hcolor']}; border:1px solid; cursor: pointer; }";
}

// $index          = 0;
$filter_by      = isset($view_options['efp_advanced_filter']) ? $view_options['efp_advanced_filter'] : array();
$taxonomy_types = isset($view_options['efp_filter_by_taxonomy']['efp_taxonomy_and_terms']) && !empty($view_options['efp_filter_by_taxonomy']['efp_taxonomy_and_terms']) ? $view_options['efp_filter_by_taxonomy']['efp_taxonomy_and_terms'] : '';
if (is_array($taxonomy_types) && !empty($taxonomy_types) && is_array($filter_by) && in_array('taxonomy', $filter_by)) {
	foreach ($taxonomy_types as $tax_type) {
		$filter_options            = isset($tax_type['ajax_filter_options']) ? $tax_type['ajax_filter_options'] : '';
		$add_filter                = isset($tax_type['add_filter_post']) ? $tax_type['add_filter_post'] : '';
		$efp_select_taxonomy       = isset($tax_type['efp_select_taxonomy']) ? $tax_type['efp_select_taxonomy'] : '';
		$efp_filter_btn_color      = isset($filter_options['efp_filter_btn_color']) ? $filter_options['efp_filter_btn_color'] : array(
			'text_color'        => '#5e5e5e',
			'text_acolor'       => '#ffffff',
			'border_color'      => '#bbbbbb',
			'border_acolor'     => '#263ad0',
			'background'        => '#ffffff',
			'active_background' => '#263ad0',
		);
		$efp_margin_between_button = isset($filter_options['efp_margin_between_button']) ? $filter_options['efp_margin_between_button'] : array(
			'top'    => '0',
			'right'  => '8',
			'bottom' => '8',
			'left'   => '0',
			'unit'   => 'px',
		);
		$ajax_filter_style         = isset($filter_options['ajax_filter_style']) ? $filter_options['ajax_filter_style'] : '';

		if ('fl_btn' === $ajax_filter_style && $add_filter) {
			if (!empty($efp_filter_btn_color)) {
				$custom_css .= "
			#efp_wrapper-{$efp_id} .efp-filter-bar .efp-filter-by.efp-bar.fl_button.filter-{$efp_select_taxonomy} label{
				margin: {$efp_margin_between_button['top']}px {$efp_margin_between_button['right']}px  {$efp_margin_between_button['bottom']}px {$efp_margin_between_button['left']}px;
			}
			#efp_wrapper-{$efp_id} .efp-filter-bar .efp-filter-by.efp-bar.fl_button.filter-{$efp_select_taxonomy} input~div{
				background: {$efp_filter_btn_color['background']};
				color: {$efp_filter_btn_color['text_color']};
				border-color: {$efp_filter_btn_color['border_color']};
			}
			#efp_wrapper-{$efp_id} .efp-filter-bar .efp-filter-by.efp-bar.fl_button.filter-{$efp_select_taxonomy} input:checked~div,
			.efp-order-by.efp-bar.fl-btn input:checked~div{
				color: {$efp_filter_btn_color['text_acolor']};
				background: {$efp_filter_btn_color['active_background']};
				border-color: {$efp_filter_btn_color['border_acolor']};
			}
			#efp_wrapper-{$efp_id} .efp-filter-bar .efp-filter-by.efp-bar.fl_button.filter-{$efp_select_taxonomy} input:hover~div,
			.efp-order-by.efp-bar.fl-btn input:hover~div{
				color: {$efp_filter_btn_color['text_acolor']};
				background: {$efp_filter_btn_color['active_background']};
				border-color: {$efp_filter_btn_color['border_acolor']};
			}";
			}
		}
	}
}

// Color for Sort by ajax live filter's orderby button.
$add_orderby_filter_post = isset($view_options['efp_filter_by_order']['add_orderby_filter_post']) ? $view_options['efp_filter_by_order']['add_orderby_filter_post'] : false;
$orderby_options         = isset($view_options['efp_filter_by_order']['orderby_ajax_filter_options']) && !empty($view_options['efp_filter_by_order']['orderby_ajax_filter_options']) ? $view_options['efp_filter_by_order']['orderby_ajax_filter_options'] : '';

$orderby_btn_color = isset($orderby_options['efp_orderby_filter_btn_color']) ? $orderby_options['efp_orderby_filter_btn_color'] : array(
	'text_color'        => '#5e5e5e',
	'text_acolor'       => '#ffffff',
	'border_color'      => '#bbbbbb',
	'border_acolor'     => '#263ad0',
	'background'        => '#ffffff',
	'active_background' => '#263ad0',
);

if (!empty($orderby_btn_color) && $add_orderby_filter_post && is_array($filter_by) && in_array('sortby', $filter_by)) {
	$order_margin_between_button = isset($orderby_options['order_margin_between_button']) ? $orderby_options['order_margin_between_button'] : array(
		'top'    => '0',
		'right'  => '8',
		'bottom' => '8',
		'left'   => '0',
		'unit'   => 'px',
	);
	$custom_css                 .= "#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order-by.efp-bar.fl-btn input~div  { background: {$orderby_btn_color['background']};color:{$orderby_btn_color['text_color']}; border-color: {$orderby_btn_color['border_color']}; }#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order-by.efp-bar.fl-btn input:checked~div{ color: {$orderby_btn_color['text_acolor']}; background: {$orderby_btn_color['active_background']}; border-color: {$orderby_btn_color['border_acolor']}; }#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order-by.efp-bar.fl-btn input:hover~div{ color: {$orderby_btn_color['text_acolor']}; background: {$orderby_btn_color['active_background']}; border-color: {$orderby_btn_color['border_acolor']}; }#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order-by.efp-bar.fl-btn .fl_radio{	margin: {$order_margin_between_button['top']}px {$order_margin_between_button['right']}px {$order_margin_between_button['bottom']}px {$order_margin_between_button['left']}px; }";
}

$add_author_filter_post = isset($view_options['efp_filter_by_author']['add_author_filter_post']) && !empty($view_options['efp_filter_by_author']['add_author_filter_post']) ? $view_options['efp_filter_by_author']['add_author_filter_post'] : '';
$ajax_filter_style      = isset($view_options['efp_filter_by_author']['ajax_filter_options']['ajax_filter_style']) ? $view_options['efp_filter_by_author']['ajax_filter_options']['ajax_filter_style'] : false;
if ($ajax_filter_style && $add_author_filter_post && is_array($filter_by) && in_array('author', $filter_by)) {
	$author_ajax_filter_options   = isset($view_options['efp_filter_by_author']['ajax_filter_options']) && !empty($view_options['efp_filter_by_author']['ajax_filter_options']) ? $view_options['efp_filter_by_author']['ajax_filter_options'] : array();
	$efp_author_btn_color         = isset($author_ajax_filter_options['efp_author_btn_color']) ? $author_ajax_filter_options['efp_author_btn_color'] : array(
		'text_color'        => '#5e5e5e',
		'text_acolor'       => '#ffffff',
		'border_color'      => '#bbbbbb',
		'border_acolor'     => '#263ad0',
		'background'        => '#ffffff',
		'active_background' => '#263ad0',
	);
	$author_margin_between_button = isset($author_ajax_filter_options['author_margin_between_button']) ? $author_ajax_filter_options['author_margin_between_button'] : array(
		'top'    => '0',
		'right'  => '8',
		'bottom' => '8',
		'left'   => '0',
		'unit'   => 'px',
	);
	$custom_css                  .= "#efp_wrapper-{$efp_id} .efp-author-filter.efp-bar.fl_button input~div { background: {$efp_author_btn_color['background']}; color:{$efp_author_btn_color['text_color']}; border-color: {$efp_author_btn_color['border_color']}; } #efp_wrapper-{$efp_id} .efp-author-filter.efp-bar.fl_button input:checked~div{ color: {$efp_author_btn_color['text_acolor']}; background: {$efp_author_btn_color['active_background']}; border-color: {$efp_author_btn_color['border_acolor']}; } #efp_wrapper-{$efp_id} .efp-author-filter.efp-bar.fl_button input:hover~div{ color: {$efp_author_btn_color['text_acolor']}; background: {$efp_author_btn_color['active_background']}; border-color: {$efp_author_btn_color['border_acolor']};#efp_wrapper-{$efp_id} .efp-author-filter.efp-bar.fl_button label { margin: {$author_margin_between_button['top']}px {$author_margin_between_button['right']}px {$author_margin_between_button['bottom']}px {$author_margin_between_button['left']}px; } }";
}
// Color for Sort by ajax live filter's order button(ASC/DESC).
$efp_order_options   = isset($view_options['efp_filter_by_order']['order_filter_options']) && !empty($view_options['efp_filter_by_order']['order_filter_options']) ? $view_options['efp_filter_by_order']['order_filter_options'] : '';
$efp_order_btn_color = isset($efp_order_options['efp_order_filter_button_color']) ? $efp_order_options['efp_order_filter_button_color'] : array(
	'text_color'        => '#5e5e5e',
	'text_acolor'       => '#ffffff',
	'border_color'      => '#bbbbbb',
	'border_acolor'     => '#263ad0',
	'background'        => '#ffffff',
	'active_background' => '#263ad0',
);
if (!empty($efp_order_btn_color)) {
	$custom_css .= "
		#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order.efp-bar.fl-btn input~div { background: {$efp_order_btn_color['background']};
		color:{$efp_order_btn_color['text_color']}; border-color: {$efp_order_btn_color['border_color']}; }
		#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order.efp-bar.fl-btn input:checked~div{ color: {$efp_order_btn_color['text_acolor']}; background: {$efp_order_btn_color['active_background']}; border-color: {$efp_order_btn_color['border_acolor']}; }
		#efp_wrapper-{$efp_id} .efp_ex_filter_bar .efp-order.efp-bar.fl-btn input:hover~div{ color: {$efp_order_btn_color['text_acolor']}; background: {$efp_order_btn_color['active_background']}; border-color: {$efp_order_btn_color['border_acolor']}; }";
}

// Filter Settings.
$filer_btn_bg            = isset($view_options['efp_filer_btn_bg']) ? $view_options['efp_filer_btn_bg'] : array(
	'text_color'        => '#444444',
	'text_acolor'       => '#ffffff',
	'border_color'      => '#bbbbbb',
	'border_acolor'     => '#263ad0',
	'background'        => 'transparent',
	'active-background' => '#263ad0',
);
$margin_between_button   = isset($view_options['efp_margin_between_button']) ? $view_options['efp_margin_between_button'] : array(
	'top'    => '0',
	'right'  => '8',
	'bottom' => '8',
	'left'   => '0',
	'unit'   => 'px',
);
$margin_between_taxonomy = isset($view_options['efp_margin_between_taxonomy']) ? $view_options['efp_margin_between_taxonomy'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '30',
	'left'   => '0',
	'unit'   => 'px',
);

// Responsive.
$custom_css .= ' @media (max-width: 768px) {';
if ($show_section_title) {
	$custom_css .= "#efp_wrapper-{$efp_id} .efp-section-title{ font-size: {$_section_title_typography['tablet-font-size']}px; line-height: {$_section_title_typography['tablet-line-height']}px; }";
}
if ($show_post_title) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--title a{ font-size: {$_post_title_typography['tablet-font-size']}px; line-height: {$_post_title_typography['tablet-line-height']}px; }";
}
if ($show_post_content) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item__content, #efp_wrapper-{$efp_id} .eventful__item__content p{ font-size: {$_post_content_typography['tablet-font-size']}px; line-height: {$_post_content_typography['tablet-line-height']}px; }";
}
// Post ReadMore Settings.

$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--meta li, #efp_wrapper-{$efp_id} .eventful__item--meta li a { font-size: {$_post_meta_typography['tablet-font-size']}px; line-height: {$_post_meta_typography['tablet-line-height']}px; } } @media (max-width: 420px) {";

if ($show_section_title) {
	$custom_css .= "#efp_wrapper-{$efp_id} .efp-section-title{ font-size: {$_section_title_typography['mobile-font-size']}px; line-height: {$_section_title_typography['mobile-line-height']}px; }";
}
if ($show_post_title) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--title a{ font-size: {$_post_title_typography['mobile-font-size']}px; line-height: {$_post_title_typography['mobile-line-height']}px; }";
}
if ($show_post_content) {
	$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item__content, #efp_wrapper-{$efp_id} .eventful__item__content p{ font-size: {$_post_content_typography['mobile-font-size']}px; line-height: {$_post_content_typography['mobile-line-height']}px; }";
}
$custom_css .= "#efp_wrapper-{$efp_id} .eventful__item--meta li, #efp_wrapper-{$efp_id} .eventful__item--meta li a{ font-size: {$_post_meta_typography['mobile-font-size']}px; line-height: {$_post_meta_typography['mobile-line-height']}px; } }";
