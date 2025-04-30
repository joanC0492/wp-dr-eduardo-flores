<?php get_header(); ?>
<?php if (have_posts()): ?>
  <?php while (have_posts()): ?>
    <?php the_post(); ?>
    <?php
    $id = get_the_ID();
    $title = get_the_title();
    $content = apply_filters('the_content', get_the_content());
    $image_url = get_the_post_thumbnail_url($id, 'full');
    $link = get_permalink();
    ?>
    <section id="hero" class="home-hero position-relative z-1" style="background-image: url(<?= esc_url($image_url) ?>);">
      <div class="container h-100">
        <div class="row h-100 align-items-end">
          <div class="col-12 text-start">
            <div class="home-hero__content pb-9">
              <p class="home-hero__title">Confía tu salud en manos expertas</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>