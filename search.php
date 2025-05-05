<?php get_header(); ?>

<section class="search-results py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="text-center mb-4">Resultados de búsqueda: "<?= get_search_query(); ?>"</h1>
        <!-- <div class="row"> -->
        <div class="search-results__container-cards d-grid gap-4 justify-content-center">
          <?php if (have_posts()): ?>
            <?php while (have_posts()):
              the_post(); ?>
              <!-- <div class="col-lg-6 mb-4"> -->
              <div class="">
                <?php
                $data = [
                  'url' => get_permalink(),
                  'image_url' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : '',
                  'title' => get_the_title(),
                  'excerpt' => get_the_excerpt(),
                ];
                // Lo incluís y pasás las variables
                set_query_var('card_data', $data);
                get_template_part('template-parts/card');
                ?>
              </div>
            <?php endwhile; ?>
            <?php
            the_posts_pagination([
              'mid_size' => 2,
              'prev_text' => __('« Anterior', 'textdomain'),
              'next_text' => __('Siguiente »', 'textdomain'),
              'screen_reader_text' => 'Navegación de entradas para la busqueda',
            ]);
            ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <p>No se encontraron resultados.</p>
            </div>
          <?php endif; ?>
        </div>
        <!-- <div class="mt-4 d-flex justify-content-center">
          <?php the_posts_pagination(); ?>
        </div> -->
      </div>
      <div class="col-lg-4 mt-4 mt-lg-0">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>