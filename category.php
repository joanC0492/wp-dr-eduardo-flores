<?php get_header(); ?>
<div class="container mt-5">
  <div class="row">
    <div class="col-lg-8">
      <h1 class="mb-4">Categoría: <?= single_cat_title('', false); ?></h1>

      <div class="row">
        <?php if (have_posts()):
          while (have_posts()):
            the_post(); ?>
            <div class="col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                <?php if (has_post_thumbnail()): ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                  </a>
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title fw-bold">
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                      <?php the_title(); ?>
                    </a>
                  </h5>
                  <p class="card-text"><?php the_excerpt(); ?></p>
                </div>
                <div class="card-footer bg-white border-0">
                  <small class="text-muted">Publicado el <?php the_time('d M Y'); ?></small>
                </div>
              </div>
            </div>
          <?php endwhile; else: ?>
          <p>No hay publicaciones en esta categoría.</p>
        <?php endif; ?>
      </div>

    </div>
    <div class="col-lg-4">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>