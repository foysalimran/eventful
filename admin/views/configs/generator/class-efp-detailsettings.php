<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.

/**
 * The Popup settings class.
 */
class EFP_DetailSettings {

	/**
	 * Popup settings section metabox.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFP::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Detail page Settings', 'eventful-pro' ),
				'icon'   => 'fas fa-external-link-square-alt',
				'fields' => array(
					array(
						'id'       => 'efp_page_link_type',
						'class'    => 'efp_page_link_type',
						'type'     => 'radio',
						'title'    => esc_html__( 'Detail Page Link Type', 'eventful-pro' ),
						'subtitle' => esc_html__( 'Choose a link type for the (item) detail page.', 'eventful-pro' ),
						'desc'     => esc_html__( 'More amazing Popup Settings', 'eventful-pro' ),
						'options'  => array(
							'single_page' => esc_html__( 'Single Page', 'eventful-pro' ),
							'none'        => esc_html__( 'None (no link action)', 'eventful-pro' ),
						),
						'default'  => 'single_page',
					),
					array(
						'id'         => 'efp_link_target',
						'type'       => 'radio',
						'title'      => esc_html__( 'Target', 'eventful-pro' ),
						'subtitle'   => esc_html__( 'Set a target for the item link.', 'eventful-pro' ),
						'options'    => array(
							'_self'   => esc_html__( 'Current Tab', 'eventful-pro' ),
							'_blank'  => esc_html__( 'New Tab', 'eventful-pro' ),
							'_parent' => esc_html__( 'Parent', 'eventful-pro' ),
							'_top'    => esc_html__( 'Top', 'eventful-pro' ),
						),
						'default'    => '_self',
						'dependency' => array( 'efp_page_link_type', '==', 'single_page' ),
					),
					array(
						'id'      => 'efp_link_rel',
						'type'    => 'checkbox',
						'title'   => esc_html__( 'Add rel="nofollow" to item links', 'eventful-pro' ),
						'default' => 'false',
					),
				), // End of fields array.
			)
		); // Display settings section end.
	}
}
