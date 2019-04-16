<?php
$the_query = new WP_Query( [
  'post_type' => 'product',
  'posts_per_page' => 10,
  'post_status' => 'publish',
] );
?>
<?php if ( $the_query->have_posts() ) : ?>
  <section class="section section-secondary bg-secondary-light py-5">
    <div class="section-inner container">

      <h2 class="text-center h3 mb-5">
        <?php _e( 'Naše velkoobchody právě nabízí', 'shp-obchodiste' ); ?>
      </h2>

      <div class="owl-carousel owl-carousel-bordered">
        <?php $GLOBALS[ 'is_product_in_carousel' ] = true; ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <?php get_template_part( 'src/template-parts/product/content', 'tease' ); ?>
        <?php endwhile; wp_reset_query(); ?>
        <?php unset( $GLOBALS[ 'is_product_in_carousel' ] ); ?>
      </div>

      <p class="text-center mt-4 mb-0">
        <a
          href="<?php echo get_post_type_archive_link( 'product' ); ?>"
          class="btn btn-primary btn-lg ws-normal"
        >
          <?php _e( 'Zobrazit všechny produkty', 'shp-obchodiste' ); ?>
        </a>
      </p>

    </div>
  </section>
<?php endif; ?>