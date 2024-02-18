<?php

if ( ! defined( 'ABSPATH' ) ) {
	die; 
} // Cannot access directly.

if ( ! class_exists( 'EFP_Field_shortcode' ) ) {	
	/**
	 * EFP_Field_shortcode
	 */
	class EFP_Field_shortcode extends EFP_Fields {
		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
        public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}
		/**
		 * Render method.
		 *
		 * @return void
		 */
		public function render() {
			// Get the Post ID.
			$post_id = get_the_ID();
			echo ( ! empty( $post_id ) ) ? '<div class="efp-scode-wrap-side"><p>'. esc_html('To display your show, add the following shortcode into your post, custom post types, page, widget or block editor. If adding the show to your theme files, additionally include the surrounding PHP code.‎', 'eventful') .'</p><span class="efp-shortcode-selectable">[eventful id="' . esc_attr( $post_id ) . '"]</span></div><div class="efp-after-copy-text"><i class="far fa-check-circle"></i> '. esc_html('Shortcode Copied to Clipboard!', 'eventful') .' </div>' : '';
		}

	}
}
