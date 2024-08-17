<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.
/**
 *
 * Field: code_editor
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if (!class_exists('EFUL_Field_code_editor')) {
	class EFUL_Field_code_editor extends EFUL_Fields
	{

		public $version = '1.0.0';
		public $cdn_url = EFUL_URL . 'admin/views/ta-framework/assets';

		public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
		{
			parent::__construct($field, $value, $unique, $where, $parent);
		}

		public function render()
		{

			$default_settings = array(
				'tabSize'     => 2,
				'lineNumbers' => true,
				'theme'       => 'default',
				'mode'        => 'htmlmixed',
				'cdnURL'        => $this->cdn_url,
			);

			$settings = (!empty($this->field['settings'])) ? $this->field['settings'] : array();
			$settings = wp_parse_args($settings, $default_settings);

			echo wp_kses_post($this->field_before());
			echo '<textarea name="' . esc_attr($this->field_name()) . '"' . wp_kses_post($this->field_attributes()) . ' data-editor="' . esc_attr(wp_json_encode($settings)) . '">' . wp_kses_post($this->value) . '</textarea>';
			echo wp_kses_post($this->field_after());
		}

		public function enqueue()
		{

			$page = (!empty($_GET['page'])) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';

			// Do not loads CodeMirror in revslider page.
			if (in_array($page, array('revslider'))) {
				return;
			}
			if(!wp_enqueue_script('eful-codemirror')) {
				wp_enqueue_script('eful-codemirror', EFUL_URL . 'admin/views/ta-framework/assets/js/codemirror.min.js', array('eventful'), $this->version, true);
				wp_enqueue_script('eful-codemirror-loadmode', EFUL_URL . 'admin/views/ta-framework/assets/js/loadmode.min.js', array('wp-codemirror'), $this->version, true);
			}

			// Enqueue Codemirror style if it's not already enqueued
			if (!wp_style_is('eful-codemirror')) {
				wp_enqueue_style('eful-codemirror', EFUL_URL . 'admin/views/ta-framework/assets/css/codemirror.min.css', array(), $this->version);
			}
		}
	}
}
