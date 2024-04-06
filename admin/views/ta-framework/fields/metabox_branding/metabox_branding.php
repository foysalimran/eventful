<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: metabox_branding
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'EFUL_Field_metabox_branding' ) ) {
  class EFUL_Field_metabox_branding extends EFUL_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			echo ( ! empty( $this->field['content'] ) ) ? esc_html($this->field['content']) : '';
			echo ( ! empty( $this->field['image'] ) ) ? '<img src="' . esc_url($this->field['image']) . '">' : '';

			echo ( ! empty( $this->field['after'] ) && ! empty( $this->field['link'] ) ) ? '<span class="spacer"></span><span class="support"><a target="_blank" href="' . esc_url($this->field['link']) . '">' . wp_kses_post($this->field['after']) . '</a></span>' : '';
		}

  }
}
