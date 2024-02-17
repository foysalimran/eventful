<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: submessage
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'EFP_Field_submessage' ) ) {
	class EFP_Field_submessage extends EFP_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$style = ( ! empty( $this->field['style'] ) ) ? $this->field['style'] : 'normal';

			echo '<div class="taf-submessage taf-submessage-' . esc_attr( $style ) . '">' . wp_kses_post($this->field['content']) . '</div>';
		}
	}
}
