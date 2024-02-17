<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: color_group
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'EFP_Field_color_group' ) ) {
  class EFP_Field_color_group extends EFP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $options = ( ! empty( $this->field['options'] ) ) ? $this->field['options'] : array();

      echo wp_kses_post( $this->field_before() );

      if ( ! empty( $options ) ) {
        foreach ( $options as $key => $option ) {

          $color_value  = ( ! empty( $this->value[$key] ) ) ? $this->value[$key] : '';
          $default_attr = ( ! empty( $this->field['default'][$key] ) ) ? ' data-default-color="'. esc_attr( $this->field['default'][$key] ) .'"' : '';

          echo '<div class="efp--left efp-field-color">';
          echo '<div class="efp--title">'. $option .'</div>';
          echo '<input type="text" name="'. esc_attr( $this->field_name( '['. $key .']' ) ) .'" value="'. esc_attr( $color_value ) .'" class="efp-color"'. $default_attr . $this->field_attributes() .'/>';
          echo '</div>';

        }
      }

      echo wp_kses_post( $this->field_after() );

    }

  }
}
