<?php
/**
 * The dynamic CSS for Carousel layout.
 *
 * @package Eventful
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$efp_settings                  = get_option( 'ta_eventful_settings' );
$efp_responsive_screen_setting = isset( $efp_settings['efp_responsive_screen_setting'] ) ? $efp_settings['efp_responsive_screen_setting'] : '';
$desktop_screen_size           = isset( $efp_responsive_screen_setting ['desktop'] ) ? $efp_responsive_screen_setting ['desktop'] : '1200';
$tablet_screen_size            = isset( $efp_responsive_screen_setting ['tablet'] ) ? $efp_responsive_screen_setting ['tablet'] : '992';
$mobile_land_screen_size       = isset( $efp_responsive_screen_setting ['mobile_landscape'] ) ? $efp_responsive_screen_setting ['mobile_landscape'] : '768';
$mobile_screen_size            = isset( $efp_responsive_screen_setting ['mobile'] ) ? $efp_responsive_screen_setting ['mobile'] : '576';
$classes                       = get_body_class();
if ( in_array( 'et_divi_builder', $classes, true ) ) {
	$custom_css .= '#et-boc .et-l .efp-filter-bar .efp-bar {
  margin-bottom: 30px;
}
#et-boc .et-l .efp-filter-bar label {
  display: inline-block;
  font-size: 16px;
  font-weight: 400;
  margin-right: 6px;
  text-transform: capitalize;
  margin-bottom: 10px;
}
#et-boc .et-l .efp-order.efp-bar.fl-btn input ~ div, #et-boc .et-l .efp-order-by.efp-bar.fl-btn input ~ div, #et-boc .et-l .efp-author-filter.efp-bar.fl_button input ~ div, #et-boc .et-l .efp-filter-bar .efp-filter-by.efp-bar.fl_button input ~ div {
  padding: 4px 10px;
  cursor: pointer;
  border-radius: 3px;
  font-size: 13px;
  font-weight: 700;
  border: 2px solid #bbb;
  text-transform: uppercase;
  text-align: center;
}
#et-boc .et-l .ta-efp-post .ta-efp-post-content .ta-efp-readmore {
  margin-top: 15px;
}
#et-boc .et-l .ta-efp-post .ta-efp-post-content .ta-efp-readmore a {
  display: inline-block;
  border: 1px solid;
  padding: 7px 12px;
  box-shadow: 0 0 0;
}
#et-boc .et-l .efp-hide {
  display: none;
}
#et-boc .et-l .ta-efp-post.left-thumb .eventful__item__content {
  margin-left: 20px;
}
#et-boc .et-l .zigzag-container .ta-col-xs-1 .eventful__item__content {
  margin-left: 20px;
  margin-right: 0;
}
#et-boc .et-l .ta-collapse .efp-collapse-header {
  padding: 15px;
  display: block;
  border-bottom: none;
  word-wrap: break-word;
  margin: 0;
  font-size: 20px;
  cursor: pointer;
}
#et-boc .et-l [class*="ta-efp-block-"] .ta-efp-post-thumb-area img {
  height: 100%;
  width: 100%;
}
#et-boc .et-l .ta-container {
  width: 100%;
  margin-right: auto;
  margin-left: auto;
  position: relative;
}
#et-boc .et-l .ta-efp-post.right-thumb .eventful__item__content {
  text-align: right;
  margin-right: 20px;
}
#et-boc .et-l .efp-post-pagination.efp-on-mobile {
display: none;
}
#et-boc .et-l .efp-post-pagination a, #et-boc .et-l .efp-post-pagination .page-numbers {
  background: #fff;
  color: #5e5e5e;
  border: 2px solid #bbb;
  width: 34px;
  height: 34px;
  line-height: 34px;
  font-size: 14px;
  text-align: center;
  display: inline-block;
  margin-right: 4px;
  text-decoration: none;
  font-weight: 700;
  border-radius: 3px;
  -webkit-transition: all 0.33s;
  transition: all 0.33s;
  -webkit-box-sizing: content-box;
  box-sizing: content-box;
  cursor: pointer;
}
#et-boc .et-l .ta-efp-carousel div{
	-webkit-transition:600ms;
	transition:600ms;
}
#et-boc .et-l .ta-efp-timeline-section .efp-timeline-item .ta-efp-post {
  margin-bottom: 40px;
}';
}
$custom_css .= "
@media (min-width: {$desktop_screen_size}px) {
  .ta-row .ta-col-xl-1 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .ta-row .ta-col-xl-2 {
    flex: 0 0 50%;
    max-width: 50%;
  }
  .ta-row .ta-col-xl-3 {
    flex: 0 0 33.22222222%;
    max-width: 33.22222222%;
  }
  .ta-row .ta-col-xl-4 {
    flex: 0 0 25%;
    max-width: 25%;
  }
  .ta-row .ta-col-xl-5 {
    flex: 0 0 20%;
    max-width: 20%;
  }
  .ta-row .ta-col-xl-6 {
    flex: 0 0 16.66666666666667%;
    max-width: 16.66666666666667%;
  }
  .ta-row .ta-col-xl-7 {
    flex: 0 0 14.28571428%;
    max-width: 14.28571428%;
  }
  .ta-row .ta-col-xl-8 {
    flex: 0 0 12.5%;
    max-width: 12.5%;
  }
}

@media (max-width: {$desktop_screen_size}px) {
  .ta-row .ta-col-lg-1 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .ta-row .ta-col-lg-2 {
    flex: 0 0 50%;
    max-width: 50%;
  }
  .ta-row .ta-col-lg-3 {
    flex: 0 0 33.22222222%;
    max-width: 33.22222222%;
  }
  .ta-row .ta-col-lg-4 {
    flex: 0 0 25%;
    max-width: 25%;
  }
  .ta-row .ta-col-lg-5 {
    flex: 0 0 20%;
    max-width: 20%;
  }
  .ta-row .ta-col-lg-6 {
    flex: 0 0 16.66666666666667%;
    max-width: 16.66666666666667%;
  }
  .ta-row .ta-col-lg-7 {
    flex: 0 0 14.28571428%;
    max-width: 14.28571428%;
  }
  .ta-row .ta-col-lg-8 {
    flex: 0 0 12.5%;
    max-width: 12.5%;
  }
}

@media (max-width: {$tablet_screen_size}px) {
  .ta-row .ta-col-md-1 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .ta-row .ta-col-md-2 {
    flex: 0 0 50%;
    max-width: 50%;
  }
  .ta-row .ta-col-md-2-5 {
    flex: 0 0 75%;
    max-width: 75%;
  }
  .ta-row .ta-col-md-3 {
    flex: 0 0 33.333%;
    max-width: 33.333%;
  }
  .ta-row .ta-col-md-4 {
    flex: 0 0 25%;
    max-width: 25%;
  }
  .ta-row .ta-col-md-5 {
    flex: 0 0 20%;
    max-width: 20%;
  }
  .ta-row .ta-col-md-6 {
    flex: 0 0 16.66666666666667%;
    max-width: 16.66666666666667%;
  }
  .ta-row .ta-col-md-7 {
    flex: 0 0 14.28571428%;
    max-width: 14.28571428%;
  }
  .ta-row .ta-col-md-8 {
    flex: 0 0 12.5%;
    max-width: 12.5%;
  }
}

@media (max-width: {$mobile_land_screen_size}px) {
  .ta-row .ta-col-sm-1 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .ta-row .ta-col-sm-2 {
    flex: 0 0 50%;
    max-width: 50%;
  }
  .ta-row .ta-col-sm-2-5 {
    flex: 0 0 75%;
    max-width: 75%;
  }
  .ta-row .ta-col-sm-3 {
    flex: 0 0 33.333%;
    max-width: 33.333%;
  }
  .ta-row .ta-col-sm-4 {
    flex: 0 0 25%;
    max-width: 25%;
  }
  .ta-row .ta-col-sm-5 {
    flex: 0 0 20%;
    max-width: 20%;
  }
  .ta-row .ta-col-sm-6 {
    flex: 0 0 16.66666666666667%;
    max-width: 16.66666666666667%;
  }
  .ta-row .ta-col-sm-7 {
    flex: 0 0 14.28571428%;
    max-width: 14.28571428%;
  }
  .ta-row .ta-col-sm-8 {
    flex: 0 0 12.5%;
    max-width: 12.5%;
  }
}
.efp-post-pagination.efp-on-mobile {
  display: none;
}
@media (max-width: {$mobile_screen_size}px) {
  .ta-row .ta-col-xs-1 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .ta-row .ta-col-xs-2 {
    flex: 0 0 50%;
    max-width: 50%;
  }
  .ta-row .ta-col-xs-3 {
    flex: 0 0 33.22222222%;
    max-width: 33.22222222%;
  }
  .ta-row .ta-col-xs-4 {
    flex: 0 0 25%;
    max-width: 25%;
  }
  .ta-row .ta-col-xs-5 {
    flex: 0 0 20%;
    max-width: 20%;
  }
  .ta-row .ta-col-xs-6 {
    flex: 0 0 16.66666666666667%;
    max-width: 16.66666666666667%;
  }
  .ta-row .ta-col-xs-7 {
    flex: 0 0 14.28571428%;
    max-width: 14.28571428%;
  }
  .ta-row .ta-col-xs-8 {
    flex: 0 0 12.5%;
    max-width: 12.5%;
  }
  .efp-post-pagination.efp-on-mobile:not(.efp-hide) {
    display: block;
  }
  .efp-post-pagination:not(.efp-on-mobile) {
    display: none;
  }
}
";
