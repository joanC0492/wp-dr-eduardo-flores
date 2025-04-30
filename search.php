<?php get_header(); ?>

<section class="search-results py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="text-center mb-4">Resultados de búsqueda: "<?= get_search_query(); ?>"</h1>
        <div class="row">
          <?php if (have_posts()): ?>
            <?php while (have_posts()):
              the_post(); ?>
              <div class="col-lg-6 mb-4">
                <a href="<?php the_permalink(); ?>" class="card h-100 text-decoration-none">
                  <?php if (has_post_thumbnail()): ?>
                    <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" class="card-img-top"
                      alt="<?= esc_attr(get_the_title()); ?>">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title fw-bold text-dark"><?= get_the_title(); ?></h5>
                    <p class="card-text"><?= get_the_excerpt(); ?></p>
                  </div>
                </a>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <p>No se encontraron resultados.</p>
            </div>
          <?php endif; ?>
        </div>
        <div class="mt-4 d-flex justify-content-center">
          <?php the_posts_pagination(); ?>
        </div>
      </div>
      <div class="col-lg-4">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>