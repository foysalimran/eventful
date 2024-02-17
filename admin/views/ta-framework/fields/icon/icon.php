<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'EFP_Field_icon' ) ) {
	class EFP_Field_icon extends EFP_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'button_title' => esc_html__( 'Add Icon', 'ta-framework' ),
					'remove_title' => esc_html__( 'Remove Icon', 'ta-framework' ),
				)
			);

			echo wp_kses_post( $this->field_before() );

			$nonce  = wp_create_nonce( 'efp_icon_nonce' );
			$hidden = ( empty( $this->value ) ) ? ' hidden' : '';

			echo '<div class="efp-icon-select">';
			echo '<span class="efp-icon-preview' . esc_attr( $hidden ) . '"><i class="' . esc_attr( $this->value ) . '"></i></span>';
			echo '<a href="#" class="button button-primary efp-icon-add" data-nonce="' . esc_attr( $nonce ) . '">' . esc_html( $args['button_title'] ) . '</a>';
			echo '<a href="#" class="button efp-warning-primary efp-icon-remove' . esc_attr( $hidden ) . '">' . esc_html( $args['remove_title'] ) . '</a>';
			echo '<input type="hidden" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '" class="efp-icon-value"' . wp_kses_post( $this->field_attributes() ) . ' />';
			echo '</div>';

			echo wp_kses_post( $this->field_after() );
		}

		public function enqueue() {
			add_action( 'admin_footer', array( 'EFP_Field_icon', 'add_footer_modal_icon' ) );
			add_action( 'customize_controls_print_footer_scripts', array( 'EFP_Field_icon', 'add_footer_modal_icon' ) );
		}

		public static function add_footer_modal_icon() {
			?>
		<div id="efp-modal-icon" class="efp-modal efp-modal-icon hidden">
		<div class="efp-modal-table">
			<div class="efp-modal-table-cell">
			<div class="efp-modal-overlay"></div>
			<div class="efp-modal-inner">
				<div class="efp-modal-title">
				<?php esc_html_e( 'Add Icon', 'ta-framework' ); ?>
				<div class="efp-modal-close efp-icon-close"></div>
				</div>
				<div class="efp-modal-header">
				<input type="text" placeholder="<?php esc_html_e( 'Search...', 'ta-framework' ); ?>" class="efp-icon-search" />
				</div>
				<div class="efp-modal-content">
				<div class="efp-modal-loading"><div class="efp-loading"></div></div>
				<div class="efp-modal-load"></div>
				</div>
			</div>
			</div>
		</div>
		</div>
			<?php
		}
	}
}
