<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: submessage
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'EFUL_Field_submessage' ) ) {
	class EFUL_Field_submessage extends EFUL_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$style = ( ! empty( $this->field['style'] ) ) ? $this->field['style'] : 'normal';

			echo '<div class="eventful-submessage eventful-submessage-' . esc_attr( $style ) . '">' . wp_kses_post($this->field['content']) . '</div>';
		}
	}
}
