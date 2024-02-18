<?php
/**
 * The Enqueue and Dequeue CSS and JS files setting configurations.
 *
 * @package Eventful
 * @subpackage Eventful/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access pages directly.

/**
 * The Layout building class.
 */
class EFP_ScriptsAndStyles {

	/**
	 * Advanced setting section.
	 *
	 * @param string $prefix The settings.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFP::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Scripts & Styles', 'eventful' ),
				'icon'   => 'far fa-file-code',
				'fields' => array(
					array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Enqueue or Dequeue JS', 'eventful' ),
					),
					array(
						'id'         => 'eventful_swiper_js',
						'type'       => 'switcher',
						'title'      => esc_html__( 'Swiper JS', 'eventful' ),
						'text_on'    => esc_html__( 'Enqueued', 'eventful' ),
						'text_off'   => esc_html__( 'Dequeued', 'eventful' ),
						'text_width' => 95,
						'default'    => true,
					),
					array(
						'id'         => 'eventful_bx_js',
						'type'       => 'switcher',
						'title'      => esc_html__( 'bxSlider JS', 'eventful' ),
						'text_on'    => esc_html__( 'Enqueued', 'eventful' ),
						'text_off'   => esc_html__( 'Dequeued', 'eventful' ),
						'text_width' => 95,
						'default'    => true,
					),
					array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Enqueue or Dequeue CSS', 'eventful' ),
					),
					array(
						'id'         => 'eventful_swiper_css',
						'type'       => 'switcher',
						'title'      => esc_html__( 'Swiper CSS', 'eventful' ),
						'text_on'    => esc_html__( 'Enqueued', 'eventful' ),
						'text_off'   => esc_html__( 'Dequeued', 'eventful' ),
						'text_width' => 95,
						'default'    => true,
					),
					array(
						'id'         => 'eventful_fontawesome_css',
						'type'       => 'switcher',
						'title'      => esc_html__( 'Font Awesome CSS', 'eventful' ),
						'text_on'    => esc_html__( 'Enqueued', 'eventful' ),
						'text_off'   => esc_html__( 'Dequeued', 'eventful' ),
						'text_width' => 95,
						'default'    => true,
					),
				),
			)
		);
	}
}
