<?php get_header(); ?>
<div class="container py-5">
  <div class="row">
    <div class="col-lg-8">
      <h1 class="mb-4">Categoría: <?= single_cat_title('', false); ?></h1>
      <!-- <div class="row"> -->
      <div class="search-results__container-cards d-grid gap-4 justify-content-center">
        <?php if (have_posts()):
          while (have_posts()):
            the_post(); ?>
            <!-- <div class="col-md-6 mb-4"> -->
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
            'screen_reader_text' => 'Navegación de entradas por categoría',
          ]);
          ?>
        <?php else: ?>
          <p>No hay publicaciones en esta categoría.</p>
        <?php endif; ?>
      </div>

    </div>
    <div class="col-lg-4 mt-4 mt-lg-0">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>