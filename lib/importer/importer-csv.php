<?php

namespace Shoptet;

class ImporterCSV {

  const ACF_OPTION_PAGE_NAME = 'product_page_product-import';
  const ACF_CSV_FILE_FIELD = 'product_import_file';

  static function init() {
    add_action( 'acf/init', [ get_called_class(), 'add_field_group' ] );
    add_action( 'acf/init', [ get_called_class(), 'add_options_page' ] );

    add_action( 'acf/save_post', [ get_called_class(), 'form_submit' ], 1 );
    add_filter( 'acf/validate_value/name=' . self::ACF_CSV_FILE_FIELD, [ get_called_class(), 'form_validate' ], 10, 2 );
    
    add_action( 'admin_footer', [ get_called_class(), 'disable_import_button' ] );
    add_filter( 'wp_check_filetype_and_ext', [ get_called_class(), 'fix_large_csv_file_upload' ], 10, 4 );

    // Via: https://github.com/Hube2/acf-filters-and-functions/blob/master/customized-options-page.php
    add_action( self::ACF_OPTION_PAGE_NAME, [ get_called_class(), 'form_description_start' ], 1 );
    add_action( self::ACF_OPTION_PAGE_NAME, [ get_called_class(), 'form_description_end' ], 20 );
  }

  static function form_submit() {
    global $current_user;
    wp_get_current_user(); // Make sure global $current_user is set, if not set it
    $screen = get_current_screen();
  
    if ( ! $screen || self::ACF_OPTION_PAGE_NAME !== $screen->base ) return;
  
    // bail early if no ACF data
    if( empty( $_POST['acf'] ) ) return;
  
    $fields = $_POST['acf'];
    $product_category_id = false;
    $set_pending_status = false;
    foreach( $fields as $key => $value ) {
      $field = acf_get_field( $key );
      switch ( $field['name'] ) {
        case 'related_wholesaler':
        $related_wholesaler_id = $value;
        break;
        case 'product_category':
        $product_category_id = intval( $value );
        break;
        case self::ACF_CSV_FILE_FIELD:
        $file_path = get_attached_file( $value );
        break;
        case 'set_pending_status':
        $set_pending_status = boolval( intval( $value ) );
        break;
      }
    }
  
    if ( ! isset( $file_path ) ) return;
  
    $fp = fopen( $file_path, 'r' );
  
    if ( ! $fp ) return null;
  
    $header = fgetcsv( $fp, 0, ';' );
  
    $data = [];
    while ( $row = fgetcsv( $fp, 0, ';' ) ) {
      foreach ( $row as $key => $value ) {
        $row[$key] = iconv( 'CP1250', 'UTF-8', $value );
      }
      $data[] = array_combine( $header, $row );
    }
  
    fclose( $fp );

    if ( user_can( $current_user, 'subscriber' ) ) {
      $related_wholesaler = get_user_wholesaler( $current_user );
      $related_wholesaler_id = $related_wholesaler->ID;
      $wholesaler_author_id = get_post_field( 'post_author', $related_wholesaler_id );
      $products_left = products_left_to_exceed( 'product', $wholesaler_author_id );
    }
  
    $product_base = new ImporterProduct([
      'wholesaler' => $related_wholesaler_id,
      'category_bulk' => $product_category_id,
      'pending_status' => $set_pending_status,
    ]);
  
    $products_imported = 0;
    foreach ( $data as $product_array ) {
  
      // break importing for subscriber if number of products exceeded
      if (
        user_can( $current_user, 'subscriber' ) &&
        ( $products_left - $products_imported ) <= 0
      ) break;
  
      $product = clone $product_base;
      $product->import_csv_array( $product_array );

      Importer::enqueueProduct($product);
  
      $products_imported++;
    }
  
    $_POST['acf'] = []; // Do not save any data
  
    TermSyncer::enqueueWholesaler( $related_wholesaler_id );
  
    as_run_queue();
  
    // Add query param to url for admin notice
    wp_redirect( add_query_arg( [
      'products_imported' => $products_imported,
    ] ) );
    exit;
  }

  static function form_validate( $valid, $value ) {
    // bail early if value is already invalid
    if( ! $valid ) return $valid;
  
    $file_path = get_attached_file( $value );
    $fp = fopen( $file_path, 'r' );
  
    if ( ! $fp ) {
      $valid =  __( 'Soubor nelze otevřít', 'shp-obchodiste' );
      return $valid;
    }
  
    $header = fgetcsv( $fp, 0, ';' );
    $mandatory = [
      'name',
      'shortDescription',
      'description',
      'image',
    ];
  
    // Check for mandatory fields in header
    $header_mandatory = array_intersect( $mandatory, $header );
    $mandatory_cols_missing = array_diff( $mandatory, $header_mandatory );
    if ( ! empty( $mandatory_cols_missing ) ) {
      $valid = sprintf(
        __( 'Hlavička souboru neobsahuje tyto povinné položky: <strong>%s</strong>', 'shp-obchodiste' ),
        implode( ', ', $mandatory_cols_missing )
      );
      return $valid;
    }
  
    $col_num = count( $header );
    
    $row_number = 1;
    $valid_array = [];
    while ( $row = fgetcsv( $fp, 0, ';' ) ) {
      $row_number++;
  
      // Check the number of fields in a row to be equal to the number of fields in the header
      if ( count( $row ) !== $col_num ) {
        $valid_array[] = sprintf (
          __( '<strong>Chyba na řádku %d</strong>: Jiný počet položek v řádku <strong>(%d)</strong> než počet položek v hlavičce <strong>(%d)</strong>', 'shp-obchodiste' ),
          $row_number,
          count( $row ),
          $col_num
        );
        continue;
      }
  
      // Check the mandatory fields in row
      $row = array_combine( $header, $row );
      foreach ( $mandatory as $m ) {
        if ( empty( $row[ $m ] ) ) {
          $valid_array[] = sprintf (
            __( '<strong>Chyba na řádku %d</strong>: Chybí povinná položka: <strong>%s</strong>', 'shp-obchodiste' ),
            $row_number,
            $m
          );
        }
      }
    }
  
    if ( ! empty( $valid_array ) ) {
      $valid = implode( '<br>', $valid_array );
    }
  
    fclose( $fp );
    
    return $valid;
  }

  static function fix_large_csv_file_upload( $data, $file, $filename, $mimes ) {
    $wp_filetype = wp_check_filetype( $filename, $mimes );
  
    $ext = $wp_filetype['ext'];
    $type = $wp_filetype['type'];
    $proper_filename = $data['proper_filename'];
  
    return compact( 'ext', 'type', 'proper_filename' );
  }

  /**
   * Disable import products csv when no own wholesaler is created
   */
  static function disable_import_button() {
    global $current_user;
    wp_get_current_user(); // Make sure global $current_user is set, if not set it
    $screen = get_current_screen();
    
    if ( ! user_can( $current_user, 'subscriber' ) ) return;
    if ( self::ACF_OPTION_PAGE_NAME !== $screen->base ) return;
    if ( get_user_wholesaler( $current_user ) ) return;
    echo '<script>document.getElementById("publish").disabled = true;</script>';
  }

  static function form_description_start () {
    ob_start();
  }

  static function form_description_end () {
    $content = ob_get_clean();
    $options = get_fields( 'options' );
    
    $product_taxonomy_terms = get_terms(  [ 'taxonomy' => 'producttaxonomy', 'parent' => 0, 'hide_empty' => false ] );
      
    $terms_by_id_html = '<h4>' . __( 'Kategorie produktů a jejich ID:', 'shp-obchodiste' ). '</h4>';
    $terms_by_id_html .= '<p>';
    foreach ( $product_taxonomy_terms as $term ) {
      $terms_by_id_html .= '<span style="margin-right:10px;">';
      $terms_by_id_html .= $term->name . ':&nbsp;';
      $terms_by_id_html .= '<code style="font-size:75%">ID: ' . $term->term_id . '</code>';
      $terms_by_id_html .= '</span>';
    }
    $terms_by_id_html .= '</p>';

    $content = str_replace(
      '<div id="normal-sortables"',
      $options[ 'product_import_description' ] .
      $terms_by_id_html .
      '<div id="normal-sortables"',
      $content
    );

    echo $content;
  }

  static function add_options_page() {
    if( function_exists('acf_add_options_page') ) {
      acf_add_options_sub_page([
        'page_title' 	=> __( 'Import produktů přes CSV', 'shp-obchodiste' ),
        'menu_title' 	=> __( 'Import CSV', 'shp-obchodiste' ),
        'parent_slug' => 'edit.php?post_type=product',
        'menu_slug'   => 'product-import',
        'capability' => 'product_import',
        'update_button'		=> __( 'Importovat', 'shp-obchodiste' ),
        'updated_message'	=> __( 'Produkty úspešně importovány', 'shp-obchodiste' ),
      ]);
    }
  }

  static function add_field_group() {
    if( function_exists('acf_add_local_field_group') ) {
      acf_add_local_field_group(array(
        'key' => 'group_5cd41ee6a3708',
        'title' => 'Hromadný import produktů',
        'fields' => array(
          array(
            'key' => 'field_5cd568b25d2b9',
            'label' => 'Velkoobchod',
            'name' => 'related_wholesaler',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'post_type' => array(
              0 => 'custom',
            ),
            'taxonomy' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
          ),
          array(
            'key' => 'field_5cd41ef65e4d4',
            'label' => 'CSV soubor',
            'name' => 'product_import_file',
            'type' => 'file',
            'instructions' => 'Soubor musí mít kódování Windows-1250 (CP-1250)',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'return_format' => 'array',
            'library' => 'uploadedTo',
            'min_size' => '',
            'max_size' => 2,
            'mime_types' => 'csv',
          ),
          array(
            'key' => 'field_5cd56a30b38fb',
            'label' => 'Kategorie',
            'name' => 'product_category',
            'type' => 'taxonomy',
            'instructions' => 'Vyberte kategorii, do které chcete hromadně zařadit produkty. Toto nastavení bude ignorováno pokud, má produkt vyplněnou položku <code>category</code>',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'taxonomy' => 'producttaxonomy',
            'field_type' => 'select',
            'allow_null' => 1,
            'add_term' => 0,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'id',
            'multiple' => 0,
          ),
          array(
            'key' => 'field_5cdbfcfac2c59',
            'label' => 'Odeslat ke schválení importované produkty',
            'name' => 'set_pending_status',
            'type' => 'true_false',
            'instructions' => 'Ke schválení se odešlou produkty, které mají vyplněny položky: <code>name</code>, <code>description</code>, <code>shortDescription</code>, <code>image</code> a <code>category</code>. Ostatní produkty budou uloženy jako koncept. Položka <code>category</code> nemusí být vyplněna, pokud je vybrána hromadná kategorie.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => 'Odeslat ke schválení',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'product-import',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ));
    }
  }

}

ImporterCSV::init();