<?php
/**
 * The process the custom field output as custom meta.
 *
 * @package Eventful
 * @subpackage Eventful/public/helper
 *
 * @since 2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The Custom Field Output class to process the custom field as custom meta.
 *
 * @since 2.0.0
 */
class EFUL_CustomFieldProcess {

	/**
	 * The key of the custom field.
	 *
	 * @var mixed $key
	 */
	public $key;

	/**
	 * The custom field object.
	 *
	 * @var mixed $object
	 */
	public $object;

	/**
	 * Check if it's a post.
	 *
	 * @var mixed $is_post
	 */
	public $is_post;

	/**
	 * The plugin name used to create the custom field.
	 *
	 * @var mixed $cf_by_plugin
	 */
	public $cf_by_plugin;

	/**
	 * The name/label of the custom field.
	 *
	 * @var mixed $field_name
	 */
	public $field_name = '';

	/**
	 * The value of the custom field.
	 *
	 * @var mixed $field_value
	 */
	public $field_value = '';

	/**
	 * The type of the custom field.
	 *
	 * @var mixed $field_type
	 */
	public $field_type = 'text';

	/**
	 * The constructor of the class.
	 *
	 * @param string  $key Custom field key.
	 * @param mixed   $object The custom field object.
	 * @param boolean $is_post If it's a post.
	 * @param string  $cf_by_plugin The plugin name by which Custom fields were made.
	 */
	public function __construct( $key, $object, $is_post, $cf_by_plugin ) {
		$this->key          = $key;
		$this->object       = $object;
		$this->is_post      = $is_post;
		$this->cf_by_plugin = $cf_by_plugin;
	}


	/**
	 * Switch output as per plugin.
	 *
	 * Process out put according to the plugin used to make the custom field.
	 *
	 * @param array   $_supported_plugin The plugin names supported in this plugin.
	 * @param boolean $condition If the condition fill.
	 * @return void
	 */
	private function select_plugin( $_supported_plugin, $condition = true ) {
		if ( $condition ) {
			switch ( $_supported_plugin ) {
				case '_acf':
					$this->cf_from_acf_plugin();
					break;
				case '_pods':
					$this->cf_from_pods_plugin();
					break;
				case '_toolset':
					$this->cf_from_toolset_plugin();
					break;
			}
		}
	}

	/**
	 * Process custom field output from ACF plugin.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	private function cf_from_acf_plugin() {
		if ( function_exists( 'get_field_object' ) ) {
			$field_object = get_field_object( $this->key, $this->object );
			if ( $field_object ) {
				$this->field_value = EFUL_ACF::show_acf_output( $field_object );
				$this->field_type  = $field_object['type'];
				$this->field_name  = $field_object['label'];
			}
		}
	}

	/**
	 * Process custom field output from Custom post type plugin.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	private function cf_from_default_post() {
		$field_object = get_post_custom_values( $this->key, $this->object->ID );
		foreach ( $field_object as $key => $value ) {
			$this->field_value = $value;
		}
	}

	/**
	 * Process Custom field from Pods plugin.
	 *
	 * @return void
	 */
	private function cf_from_pods_plugin() {
		if ( function_exists( 'pods' ) ) {
			if ( $this->is_post ) {
				$post_type = get_post_type( $this->object->ID );
				$the_pods  = pods( $post_type, $this->object->ID );
				if ( $the_pods ) {
					$pod_output = $the_pods->display( $this->key );
					if ( $pod_output ) {
						$this->field_value = $pod_output;
					}
				}
			} else {
				$the_pods = pods( $this->object->taxonomy, $this->object->slug );
				if ( $the_pods ) {
					$pod_field = $the_pods->field( $this->key );
					if ( $pod_field ) {
						$this->field_value = $pod_field;
					}
				}
			}
		}
	}

	/**
	 * Process custom field output from WP Types plugin.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	private function cf_from_toolset_plugin() {
		if ( shortcode_exists( 'types' ) ) {
			$wpcf_key   = str_replace( 'wpcf-', '', $this->key );
			$shortcode  = apply_filters( 'eful_speventful_toolset_sc', "[types field='$wpcf_key' separator=', ']", $wpcf_key, $this->object );
			$wpcf_value = do_shortcode( $shortcode );
			if ( 0 !== strcmp( $wpcf_value, $shortcode ) ) {
				$this->field_value = $wpcf_value;
			}
		}
	}

} // End of the class.


/**
 * The HTML data of the custom field.
 *
 * @param mixed   $cf_value The value of the.
 * @param string  $key The custom field key.
 * @param boolean $set_oembed Set oEmbed to the url or not.
 * @return statement
 */
function eful_cf_data( $cf_value, $key, $set_oembed ) {

	$output = false;
	if ( $set_oembed && false !== filter_var( $cf_value, FILTER_VALIDATE_URL ) ) {
		$output = wp_oembed_get( $cf_value );
	}

	if ( ! $output && is_string( $cf_value ) ) {
		$path_info = pathinfo( $cf_value );
		$extension = isset( $path_info['extension'] ) ? strtolower( $path_info['extension'] ) : '';
		if ( is_email( $cf_value ) ) {
			$output = sprintf( '<a target="_blank" href="mailto:%1$s">%1$s</a>', antispambot( $cf_value ) );
		} elseif ( preg_match( '/(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)/i', $extension ) ) {
			$output = eful_cf_output_image( $cf_value, $path_info['filename'] );
		} elseif ( 'mp3' === $extension ) {
			$output = eful_cf_output_audio( $cf_value );
		} elseif ( 'mp4' === $extension ) {
			$output = eful_cf_output_video( $cf_value );
		} elseif ( false === ! filter_var( $cf_value, FILTER_VALIDATE_URL ) ) {
			// } else {
			$html   = apply_filters( 'eful_cf_url_output', $cf_value, $key );
			$output = sprintf( '<a target="_blank" href="%s">%s</a>', esc_url( $cf_value ), esc_html( $html ) );
		}
	}

	return $output ? $output : $cf_value;
}

/**
 * If there is more than a plugin for Custom field: Pods, WP Types, ACF.
 *
 * @return statement
 */
function eful_cf_multiple_plugins() {
	$count = 0;

	$count += (int) function_exists( 'pods' );
	$count += (int) shortcode_exists( 'types' );
	$count += (int) function_exists( 'get_field_object' );

	return $count > 0;
}

/**
 * Supported plugins list.
 *
 * @return array
 */
function eful_cf_supported_plugins() {
	return array(
		'_pods'    => esc_html__( 'Pods', 'eventful' ),
		'_toolset' => esc_html__( 'Toolset', 'eventful' ),
		'_acf'     => esc_html__( 'Advanced Custom Fields', 'eventful' ),
	);
}

/**
 * Generate HTML output for the image value of custom field.
 *
 * @param string $value The value of the custom field.
 * @param string $name The name of the image file.
 * @return statement
 */
function eful_cf_output_image( $value, $name ) {
	return sprintf( '<img class="%1$s" src="%2$s" title="%3$s" style="width: 100%;">', 'sp-eventful-cf-image', esc_url( $value ), esc_attr( $name ) );
}

/**
 * Generate HTML output for the audio value of custom field.
 *
 * @param string $value The value of the custom field.
 * @return statement
 */
function eful_cf_output_audio( $value ) {
	return '<audio controls><source src="' . esc_url( $value ) . '" type="audio/mpeg">The Browser does not support the audio format.</audio>';
}

/**
 * Generate HTML output for the video value of custom field.
 *
 * @param string $value The value of the custom field.
 * @return statement
 */
function eful_cf_output_video( $value ) {
	return '<video controls><source src="' . esc_url( $value ) . '" type="video/mp4">The browser does not support HTML5 video.</video>';
}
