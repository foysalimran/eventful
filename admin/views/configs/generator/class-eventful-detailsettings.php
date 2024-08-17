<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The Popup settings class.
 */
class EFUL_DetailSettings {

	/**
	 * Popup settings section metabox.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFUL::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Detail page Settings', 'eventful' ),
				'icon'   => 'fas fa-external-link-square-alt',
				'fields' => array(
					array(
						'id'       => 'eful_page_link_type',
						'class'    => 'eful_page_link_type',
						'type'     => 'radio',
						'title'    => esc_html__( 'Detail Page Link Type', 'eventful' ),
						'subtitle' => esc_html__( 'Choose a link type for the (item) detail page.', 'eventful' ),
						'options'  => array(
							'single_page' => esc_html__( 'Single Page', 'eventful' ),
							'none'        => esc_html__( 'None (no link action)', 'eventful' ),
						),
						'default'  => 'single_page',
					),
					array(
						'id'         => 'eful_link_target',
						'type'       => 'radio',
						'title'      => esc_html__( 'Target', 'eventful' ),
						'subtitle'   => esc_html__( 'Set a target for the item link.', 'eventful' ),
						'options'    => array(
							'_self'   => esc_html__( 'Current Tab', 'eventful' ),
							'_blank'  => esc_html__( 'New Tab', 'eventful' ),
							'_parent' => esc_html__( 'Parent', 'eventful' ),
							'_top'    => esc_html__( 'Top', 'eventful' ),
						),
						'default'    => '_self',
						'dependency' => array( 'eful_page_link_type', '==', 'single_page' ),
					),
					array(
						'id'      => 'eful_link_rel',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Add rel="nofollow" to item links', 'eventful' ),
						'default' => 'false',
					),
				), // End of fields array.
			)
		); // Display settings section end.
	}
}
