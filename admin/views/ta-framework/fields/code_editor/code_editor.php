<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: code_editor
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'EFUL_Field_code_editor' ) ) {
	class EFUL_Field_code_editor extends EFUL_Fields {

		public $version = '1.0.0';

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$default_settings = array(
				'tabSize'     => 2,
				'lineNumbers' => true,
				'theme'       => 'default',
				'mode'        => 'htmlmixed',
			);

			$settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
			$settings = wp_parse_args( $settings, $default_settings );

			echo wp_kses_post( $this->field_before() );
			echo '<textarea name="' . esc_attr( $this->field_name() ) . '"' . wp_kses_post( $this->field_attributes() ) . ' data-editor="' . esc_attr( wp_json_encode( $settings ) ) . '">' . wp_kses_post($this->value) . '</textarea>';
			echo wp_kses_post( $this->field_after() );
		}

		public function enqueue() {

			$page = ( ! empty( $_GET['page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

			// Do not loads CodeMirror in revslider page.
			if ( in_array( $page, array( 'revslider' ) ) ) {
				return; }

			if ( ! wp_script_is( 'eventful-codemirror' ) ) {
				wp_enqueue_script('wp-codemirror-js', 'path_to_wp_codemirror_js_file', array('jquery'), null, true);
				wp_enqueue_script( 'loadmode', EFUL_URL . 'admin/views/ta-framework/assets/js/loadmode.min.js', array( 'eventful-codemirror' ), $this->version, true );
			}

			if ( ! wp_style_is( 'eventful-codemirror' ) ) {
				wp_enqueue_style('wp-codemirror', 'path_to_wp_codemirror_css_file');
			}
		}
	}
}
