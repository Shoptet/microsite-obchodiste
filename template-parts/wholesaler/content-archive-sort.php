<div class="d-lg-flex w-100 align-items-center justify-content-between mt-3 mb-4">
  <div class="form-inline">
    <div class="form-group mb-0">
      <label for="orderSelect">
        <?php _e( 'Seřadit podle:', 'shp-obchodiste' ); ?>
      </label>
      <select class="form-control custom-select ml-sm-2 mr-sm-4" id="orderSelect" name="orderby">
        <?php
        $order_choices = [
        	'date_desc' => __( 'Nejnověji přidáno', 'shp-obchodiste' ),
          'favorite_desc' => __( 'Nejoblíbenější', 'shp-obchodiste' ),
          'title_asc' => __( 'Dle jména A-Z', 'shp-obchodiste' ),
          'title_desc' => __( 'Dle jména Z-A', 'shp-obchodiste' ),
        ];
        $selected_orderby = isset( $_GET[ 'orderby' ] ) ? $_GET[ 'orderby' ] : null;
        ?>
        <?php foreach ( $order_choices as $value => $choice ): ?>
          <option
            value="<?php echo $value ?>"
            <?php if ( $selected_orderby == $value ) echo "selected"; ?>
          >
            <?php echo $choice ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="text-muted mt-3 mt-lg-0">
    <?php
    printf(
      __( 'Celkem %d z %d velkoobchodů', 'shp-obchodiste' ),
      $wp_query->post_count,
      $wp_query->found_posts
    );
    ?>
  </div>
</div>
