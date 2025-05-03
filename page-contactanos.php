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

    $titulo = get_post_meta($id, 'titulo', true);
    $seccion_agenda = get_post_meta($id, 'seccion_agenda_tu_cita', true);
    $carrusel_imagenes = get_post_meta($id, 'carrusel_imagenes', false);

    $is_slider = !empty($carrusel_imagenes) && is_array($carrusel_imagenes) && count($carrusel_imagenes) > 1;
    ?>
    <section id="page-main" class="page-main">
      <div class="container">
        <div class="row">
          <div class="col-12 col-xxl-10 mx-auto">
            <div class="page-main__h1-parent text-center">
              <h1 class="page-main__h1"><?= $titulo ? $titulo : $title ?></h1>
            </div>
            <div class="page-main__content text-center">
              <?= $content ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; ?>
<?php else: ?>
  <p><?php esc_html_e('Lo sentimos, no se encontraron publicaciones.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>