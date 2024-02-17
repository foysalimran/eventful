<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'EFP_Field_backup' ) ) {
  class EFP_Field_backup extends EFP_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $unique = $this->unique;
      $nonce  = wp_create_nonce( 'efp_backup_nonce' );
      $export = add_query_arg( array( 'action' => 'efp-export', 'unique' => $unique, 'nonce' => $nonce ), admin_url( 'admin-ajax.php' ) );

      echo wp_kses_post( $this->field_before() );

      echo '<textarea name="efp_import_data" class="efp-import-data"></textarea>';
      echo '<button type="submit" class="button button-primary efp-confirm efp-import" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Import', 'eventful-pro' ) .'</button>';
      echo '<hr />';
      echo '<textarea readonly="readonly" class="efp-export-data">'. esc_attr( json_encode( get_option( $unique ) ) ) .'</textarea>';
      echo '<a href="'. esc_url( $export ) .'" class="button button-primary efp-export" target="_blank">'. esc_html__( 'Export & Download', 'eventful-pro' ) .'</a>';
      echo '<hr />';
      echo '<button type="submit" name="efp_transient[reset]" value="reset" class="button efp-warning-primary efp-confirm efp-reset" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Reset', 'eventful-pro' ) .'</button>';

      echo wp_kses_post( $this->field_after() );

    }

  }
}
