<?php

namespace Shoptet;

class DBXPostType {

  protected $post_type;
  protected $extended_meta_keys = [];
  protected $static_meta_data = [];
  protected $store;

  function __construct( $post_type ) {
    $this->post_type = $post_type;
  }

  public function init() {

    if ( empty($this->extended_meta_keys) ) {
      throw new \Exception( 'Extended meta keys not defined' );
    }

    $this->store = new DBXStore( $this->post_type, $this->extended_meta_keys );

    add_action( 'wp_insert_post', [ $this, 'action_insert_post' ], 10, 3 );
    add_action( 'delete_post', [ $this, 'action_delete_post' ], 10, 3 );

    add_filter( 'add_post_metadata', [ $this, 'filter_update_meta' ], 10, 5 );
    add_filter( 'update_post_metadata', [ $this, 'filter_update_meta' ], 10, 5 );
    add_filter( 'delete_post_metadata', [ $this, 'filter_delete_meta' ], 10, 5 );

    //add_filter( 'get_meta_sql', [ $this, 'filter_meta_sql' ], 10, 6 );
  }

  public function set_extended_meta_keys( array $extended_meta_keys ) {
    $this->extended_meta_keys = $extended_meta_keys;
  }

  public function set_static_meta_data( array $static_meta_data ) {
    $this->static_meta_data = $static_meta_data;
  }

  public function get_extended_meta_keys() {
    return $this->extended_meta_keys;
  }

  public function get_static_meta_data() {
    return $this->static_meta_data;
  }

  public function get_store() {
    return $this->store;
  }

  public function get_normalized_static_meta_data() {
    return array_map( function( $val ) {
      return [ $val ];
    }, $this->static_meta_data );
  }
  
  public function action_insert_post( $post_id, $post, $update ) {
  
    // Check correct post type
    if ( $this->post_type != get_post_type($post_id) ) {
      return;
    }
  
    // Check correct post status
    if ( $post->post_status == 'trash' ) {
      return;
    }
    
    $this->store->maybe_insert_row($post_id);
  }

  public function action_delete_post( $post_id ) {
  
    // Check correct post type
    if ( $this->post_type != get_post_type($post_id) ) {
      return;
    }

    $this->store->delete_row($post_id);
  }
  
  public function filter_update_meta( $check, $post_id, $meta_key, $meta_value, $prev_value ) {

    // Check correct meta key
    if ( ! in_array( $meta_key, $this->extended_meta_keys ) ) {
      return $check;
    }
    
    // Check correct post type
    if ( $this->post_type != get_post_type($post_id) ) {
      return $check;
    }

    // Do not update static meta key
    if ( isset( $this->static_meta_data[$meta_key] ) ) {
      if ( DBX_TEST ) {
        return $check;
      }
      return $this->static_meta_data[$meta_key];
    }
    
    // Make sure a row in table exists
    $this->store->maybe_insert_row($post_id);
  
    $where = [ 'post_id' => $post_id ];

    // Handle a previous value
    if ( ! empty($prev_value) ) {
      $prev_value = maybe_serialize($prev_value);
      $where[$meta_key] = $prev_value;
    }

    $updated = $this->store->update_row(
      [ $meta_key => maybe_serialize( $meta_value ) ],
      $where
    );

    wp_cache_delete( $post_id, 'post_meta' );

    if ( DBX_TEST ) {
      return $check;
    }
    return $updated;
  }

  public function filter_delete_meta( $check, $post_id, $meta_key, $meta_value, $delete_all ) {

    // Check correct meta key
    if ( ! in_array( $meta_key, $this->extended_meta_keys ) ) {
      return $check;
    }
    
    // Check correct post type
    if ( $this->post_type != get_post_type($post_id) ) {
      return $check;
    }
    
    $where = [];
    
    // Handle deleting all meta keys
    if ( ! $delete_all ) {
      $where['post_id'] = $post_id;
    }    

    $updated = $this->store->update_row( [ $meta_key => null ], $where );

    if ( ! $delete_all ) {
      wp_cache_delete( $post_id, 'post_meta' );
    } else {
      // For simplicity delete all cache items instead of affected posts only
      wp_cache_flush(); 
    }

    if ( DBX_TEST ) {
      return $check;
    }
    return $updated;
  }

  function filter_meta_sql( $sql, $queries, $type, $primary_table, $primary_id_column, $context ) {

    // Check correct post type
    $post_type = isset( $context->query['post_type'] ) ? $context->query['post_type'] : false ;
    if ( $this->post_type != $post_type ) {
      return $sql;
    }

    $relation = 'AND';
    $extended_queries = [];
    $original_queries = [];
    $nested_queries = [];

    // Sort queries
    foreach ( $queries as $key => $query ) {
      if ( 'relation' === $key ) {
        $relation = $query;
      } elseif ( isset($query['key']) ) {
        if ( in_array( $query['key'], $this->extended_meta_keys ) ) {
          $extended_queries[] = $query;
        } else {
          $original_queries[] = $query;
        }
      } else {
        $nested_queries[] = $query;
      }
    }

    if ( count($original_queries) > 0 && count($extended_queries) > 0 ) {
      error_log('Original and extended meta keys occurred in the meta query!');
    }
    if ( count($nested_queries) > 0 && count($extended_queries) > 0 ) {
      error_log('Nested and extended meta keys occurred in the meta query!');
    }

    $table_name = $this->store->get_table_name();
    $join = " INNER JOIN $table_name as dbx ON ( $primary_table.$primary_id_column = dbx.post_id )";

    $where = " AND ( ";
    for ( $i = 0; $i < count($extended_queries); $i++ ) {
      $query = $extended_queries[$i];
      if ( isset($query['value']) ) {
        $compare = isset( $query['compare'] ) ? $query['compare'] : '=' ;
        $where .= sprintf( 'dbx.%s %s "%s"', $query['key'], $compare, $query['value'] );
      } else {
        $where .= sprintf( 'dbx.%s IS NOT NULL', $query['key'] );
      }
      if ( $i < count($extended_queries) - 1 ) {
        $where .= ' ' . $relation . ' ';
      }
    }
    $where .= " )";
    
    $sql['join'] = $join;
    $sql['where'] = $where;

    return $sql;
  }

}
