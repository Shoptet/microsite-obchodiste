<div class="filters mb-4 mb-md-0">
  <button
    class="btn btn-primary d-md-none"
    type="button"
    data-toggle="collapse"
    href="#filtersCollapse"
    role="button"
    aria-expanded="false"
    aria-controls="filtersCollapse"
  >
    <?php _e( 'Zobrazit filtry', 'shp-obchodiste' ); ?>
  </button>

  <div class="collapse d-md-block" id="filtersCollapse">
    <div class="mt-3 mt-md-0">

      <p class="h5 h-heavy mb-2">
        <?php _e( 'Kategorie', 'shp-obchodiste' ); ?>
      </p>

      <?php
      if ( is_tax() ) {
        $checked_categories[] = $wp_query->get_queried_object()->term_id;
      } else {
        $checked_categories = ( isset( $_GET[ 'category' ]) && is_array($_GET[ 'category' ] ) ) ? $_GET[ 'category' ] : [];
      }
      ?>

      <?php foreach ( get_terms_with_special_offer() as $term ): ?>
        <div class="custom-control custom-checkbox">
          <input
            class="custom-control-input"
            type="checkbox"
            value="<?php echo $term->term_id; ?>"
            id="filterCategory<?php echo $term->term_id; ?>"
            name="category[]"
            data-slug="<?php echo $term->slug; ?>"
            <?php if ( in_array ( $term->term_id, $checked_categories ) ) echo "checked"; ?>
          >
          <label
            class="custom-control-label"
            for="filterCategory<?php echo $term->term_id; ?>"
          >
            <?php echo $term->name; ?>
          </label>
        </div>
      <?php endforeach; ?>

      <div class="filters-divider"></div>

      <p class="h5 h-heavy mt-0 mb-2">
        <?php _e( 'Lokalita', 'shp-obchodiste' ); ?>
      </p>

      <?php
      $checked_regions = ( isset($_GET[ 'region' ]) && is_array($_GET[ 'region' ]) ) ? $_GET[ 'region' ] : [];
      ?>

      <?php foreach ( get_used_regions_by_country() as $country_code => $country ): ?>
        <p class="font-weight-bold my-2"><?php echo $country[ 'name' ]; ?></p>
        <?php foreach ( $country[ 'used_regions' ] as $region ): ?>
          <div class="custom-control custom-checkbox">
            <input
              class="custom-control-input"
              type="checkbox"
              value="<?php echo $region[ 'id' ]; ?>"
              id="filterRegion<?php echo $region[ 'id' ]; ?>"
              name="region[]"
              <?php if ( in_array ( $region[ 'id' ], $checked_regions ) ) echo "checked"; ?>
            >
            <label
              class="custom-control-label"
              for="filterRegion<?php echo $region[ 'id' ]; ?>"
            >
              <?php echo $region[ 'name' ]; ?>
            </label>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>

      <div class="filters-divider"></div>

      <a
        class="small"
        role="button"
        href="<?php echo get_post_type_archive_link( 'special_offer' ); ?>"
      >
        <i class="fas fa-times text-muted mr-1"></i>
        <?php _e( 'Zrušit filtry', 'shp-obchodiste' ); ?>
      </a>

      <button type="submit" class="btn btn-primary btn-block mt-2" id="filterSubmit">
        <?php _e( 'Filtrovat', 'shp-obchodiste' ); ?>
      </button>

    </div>
  </div>
</div>
