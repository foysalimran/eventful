<?php if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

class EFP_Metaboxes {
    /**
	 * Layout Metabox function.
	 *
	 * @param string $prefix The meta-key for this metabox.
	 * @return void
	 */
	public static function layout_metabox( $prefix ) {
		EFP::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__( 'Eventful', 'eventful-pro' ),
				'post_type'    => 'eventful',
				'show_restore' => false,
				'context'      => 'normal',
			)
		);

		EFP_Layout::section( $prefix );

	}

	/**
	 * Option Metabox function
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function option_metabox( $prefix ) {
		EFP::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__( 'View Options', 'eventful-pro' ),
				'post_type'    => 'eventful',
				'show_restore' => false,
				'nav'        => 'inline',
				'theme'        => 'light',
			)
		);

		EFP_FilterPost::section( $prefix );
		EFP_Display::section( $prefix );
		EFP_Carousel::section( $prefix );
		EFP_DetailSettings::section( $prefix );
		EFP_Typography::section( $prefix );
	}
	/**
	 * Shortcode Metabox function
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function shortcode_metabox( $prefix ) {
		EFP::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__( 'Eventful', 'eventful-pro' ),
				'post_type'    => 'eventful',
				'context'      => 'side',
				'show_restore' => false,
			)
		);

		EFP_Shortcode::section( $prefix );

	}
}