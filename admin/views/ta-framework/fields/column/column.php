<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: column
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'EFUL_Field_column' ) ) {

	/**
	 * The column field class.
	 */
	class EFUL_Field_column extends EFUL_Fields {

		/**
		 * Column field constructor.
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
		 * Render column function.
		 *
		 * @return void
		 */
		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'lg_desktop_icon'              => '<i class="fas fa-tv"></i>',
					'desktop_icon'                 => '<i class="fas fa-desktop"></i>',
					'tablet_icon'                  => '<i class="fas fa-tablet-alt"></i>',
					'mobile_landscape_icon'        => '<i class="fas fa-mobile-alt"></i>',
					'mobile_icon'                  => '<i class="fas fa-mobile-alt"></i>',
					'all_icon'                     => '<i class="fas fa-arrows-alt-h"></i>',
					'lg_desktop_placeholder'       => esc_html__( 'Large Desktop', 'eventful' ),
					'desktop_placeholder'          => esc_html__( 'Desktop', 'eventful' ),
					'tablet_placeholder'           => esc_html__( 'Tablet', 'eventful' ),
					'mobile_landscape_placeholder' => esc_html__( 'Mobile Landscape', 'eventful' ),
					'mobile_placeholder'           => esc_html__( 'Mobile', 'eventful' ),
					'all_placeholder'              => esc_html__( 'all', 'eventful' ),
					'lg_desktop'                   => true,
					'desktop'                      => true,
					'tablet'                       => true,
					'mobile_landscape'             => true,
					'mobile'                       => true,
					'min'                          => '0',
					'unit'                         => false,
					'all'                          => false,
					'units'                        => array( 'px', '%', 'em' ),
				)
			);

			$default_values = array(
				'lg_desktop'       => '0',
				'desktop'          => '4',
				'tablet'           => '3',
				'mobile_landscape' => '2',
				'mobile'           => '1',
				'min'              => '',
				'all'              => '',
				'unit'             => 'px',
			);

			// $value = wp_parse_args( $this->value, $default_values );
			$value   = wp_parse_args( $this->value, $default_values );
			$unit    = ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? $args['units'][0] : '';
			$is_unit = ( ! empty( $unit ) ) ? ' eventful--is-unit' : '';

			echo wp_kses_post( $this->field_before() );

			echo '<div class="eventful--inputs">';

			$min = ( isset( $args['min'] ) ) ? ' min="' . $args['min'] . '"' : '';
			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . $args['all_placeholder'] . '"' : '';

				echo '<div class="eventful--input">';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="eventful--label eventful--icon">' . wp_kses_post($args['all_icon']) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr($this->field_name( '[all]' )) . '" value="' . esc_attr($value['all']) . '"' . wp_kses_post($placeholder . $min) . ' class="eventful-number" />';
				echo ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? '<span class="eventful--label eventful--unit">' . esc_html($args['units'][0]) . '</span>' : '';
				echo '</div>';

			} else {

				$properties = array();

				foreach ( array( 'lg_desktop', 'desktop', 'tablet', 'mobile_landscape', 'mobile' ) as $prop ) {
					if ( ! empty( $args[ $prop ] ) ) {
						$properties[] = $prop;
					}
				}

				$properties = ( $properties === array( 'tablet', 'mobile' ) ) ? array_reverse( $properties ) : $properties;

				foreach ( $properties as $property ) {

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? ' placeholder="' . $args[ $property . '_placeholder' ] . '"' : '';

					echo '<div class="eventful--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="eventful--label eventful--icon">' . wp_kses_post($args[ $property . '_icon' ]) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr($this->field_name( '[' . $property . ']' )) . '" value="' . esc_attr($value[ $property ]) . '"' . wp_kses_post($placeholder . $min) . ' class="eventful-number" />';
					echo ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? '<span class="eventful--label eventful--unit">' . wp_kses_post($args['units'][0]) . '</span>' : '';
					echo '</div>';

				}
			}

			if ( ! empty( $args['unit'] ) && count( $args['units'] ) > 1 ) {
				echo '<div class="eventful--input">';

				echo '<select name="' . esc_attr($this->field_name( '[unit]' )) . '">';
				foreach ( $args['units'] as $unit ) {
					$selected = ( $value['unit'] === $unit ) ? ' selected' : '';
					echo '<option value="' . esc_attr($unit) . '"' . esc_attr($selected) . '>' . esc_html($unit) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}

			echo '</div>';

			echo wp_kses_post( $this->field_after() );

		}

		/**
		 * The output function.
		 *
		 * @return void
		 */
		public function output() {

			$output    = '';
			$element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];
			$important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
			$unit      = ( ! empty( $this->value['unit'] ) ) ? $this->value['unit'] : 'px';

			$mode = ( ! empty( $this->field['output_mode'] ) ) ? $this->field['output_mode'] : 'padding';
			$mode = ( $mode === 'relative' || $mode === 'absolute' || $mode === 'none' ) ? '' : $mode;
			$mode = ( ! empty( $mode ) ) ? $mode . '-' : '';

			if ( ! empty( $this->field['all'] ) && isset( $this->value['all'] ) && $this->value['all'] !== '' ) {

				$output  = $element . '{';
				$output .= $mode . 'lg_desktop:' . $this->value['all'] . $unit . $important . ';';
				$output .= $mode . 'desktop:' . $this->value['all'] . $unit . $important . ';';
				$output .= $mode . 'tablet:' . $this->value['all'] . $unit . $important . ';';
				$output .= $mode . 'mobile_landscape:' . $this->value['all'] . $unit . $important . ';';
				$output .= $mode . 'mobile:' . $this->value['all'] . $unit . $important . ';';
				$output .= '}';

			} else {

				$lg_desktop = ( isset( $this->value['lg_desktop'] ) && $this->value['lg_desktop'] !== '' ) ? $mode . 'lg_desktop:' . $this->value['lg_desktop'] . $unit . $important . ';' : '';
				$desktop    = ( isset( $this->value['desktop'] ) && $this->value['desktop'] !== '' ) ? $mode . 'desktop:' . $this->value['desktop'] . $unit . $important . ';' : '';
				$tablet           = ( isset( $this->value['tablet'] ) && $this->value['tablet'] !== '' ) ? $mode . 'tablet:' . $this->value['tablet'] . $unit . $important . ';' : '';
				$mobile_landscape = ( isset( $this->value['mobile_landscape'] ) && $this->value['mobile_landscape'] !== '' ) ? $mode . 'mobile_landscape:' . $this->value['mobile_landscape'] . $unit . $important . ';' : '';
				$mobile           = ( isset( $this->value['mobile'] ) && $this->value['mobile'] !== '' ) ? $mode . 'mobile:' . $this->value['mobile'] . $unit . $important . ';' : '';

				if ( $lg_desktop !== '' || $desktop !== '' || $tablet !== '' || $mobile_landscape !== '' || $mobile !== '' ) {
					$output = $element . '{' . $lg_desktop . $desktop . $tablet . $mobile_landscape . $mobile . '}';
				}
			}

			$this->parent->output_css .= $output;

			return $output;

		}

	}
}
