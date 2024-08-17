<?php if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

class EFUL_Metaboxes {
    /**
	 * Layout Metabox function.
	 *
	 * @param string $prefix The meta-key for this metabox.
	 * @return void
	 */
	public static function eful_layout_metabox( $prefix ) {
		EFUL::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__( 'Eventful', 'eventful' ),
				'post_type'    => 'eventful',
				'show_restore' => false,
				'context'      => 'normal',
			)
		);

		EFUL_Layout::section( $prefix );

	}

	/**
	 * Option Metabox function
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function eful_option_metabox( $prefix ) {
		EFUL::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__( 'View Options', 'eventful' ),
				'post_type'    => 'eventful',
				'show_restore' => false,
				'nav'        => 'inline',
				'theme'        => 'light',
			)
		);

		EFUL_FilterPost::section( $prefix );
		EFUL_Display::section( $prefix );
		EFUL_Carousel::section( $prefix );
		EFUL_DetailSettings::section( $prefix );
		EFUL_Typography::section( $prefix );
	}
	/**
	 * Shortcode Metabox function
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function eful_shortcode_metabox( $prefix ) {
		EFUL::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__( 'Eventful', 'eventful' ),
				'post_type'    => 'eventful',
				'context'      => 'side',
				'show_restore' => false,
			)
		);

		EFUL_Shortcode::section( $prefix );

	}
}