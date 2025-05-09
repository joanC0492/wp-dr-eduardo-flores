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
    $video = get_post_meta($id, 'video', true);
    $seccion_agenda = get_post_meta($id, 'seccion_agenda_tu_cita', true);
    $carrusel_imagenes = get_post_meta($id, 'carrusel_imagenes', false);

    $is_slider = !empty($carrusel_imagenes) && is_array($carrusel_imagenes) && count($carrusel_imagenes) > 1;
    $preguntas = get_post_meta($id, 'preguntas', false);
    ?>
    <section id="page-main" class="page-main pb-5">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-5 order-2 order-lg-1 mt-3 mt-md-0">
            <?php if ($is_slider): ?>
              <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                <div class="swiper-wrapper">
                  <?php foreach ($carrusel_imagenes as $image_id): ?>
                    <?php $image_url = wp_get_attachment_url($image_id); ?>
                    <?php $alt_text = get_the_title($image_id); ?>
                    <?php if ($image_url): ?>
                      <div class="swiper-slide">
                        <img src="<?= esc_url($image_url) ?>" alt="<?= esc_attr($alt_text) ?>" />
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div> <!-- .swiper-wrapper -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
              </div>
              <div thumbsSlider="" class="swiper mySwiper">
                <div class="swiper-wrapper">
                  <?php foreach ($carrusel_imagenes as $image_id): ?>
                    <?php $thumb_data = wp_get_attachment_image_src($image_id, 'thumbnail'); ?>
                    <?php $thumb_url = $thumb_data ? $thumb_data[0] : ''; ?>
                    <?php $alt_text = get_the_title($image_id); ?>
                    <?php if ($thumb_url): ?>
                      <div class="swiper-slide">
                        <img src="<?= esc_url($thumb_url); ?>" alt="<?= esc_attr($alt_text); ?>" />
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php else: ?>
              <div class="single-image">
                <?php $image_url = wp_get_attachment_url($carrusel_imagenes[0]); ?>
                <?php if ($image_url): ?>
                  <img src="<?= esc_url($image_url); ?>" alt="" class="img-fluid" />
                <?php else: ?>
                  <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/default-image-test.webp') ?>"
                    alt="Test Image" class="img-fluid" />
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-12 col-lg-7 order-1 order-lg-2">
            <div class="page-main__h1-parent">
              <h1 class="page-main__h1 acumin-variable-concept-bold text-blue-1"><?= $titulo ? $titulo : $title ?></h1>
            </div>
            <div class="page-main__content">
              <?= $content ?>
            </div>
            <!-- SINGLE-BEGIN -->
            <?php if (!empty($video)): ?>
              <div class="page-main__video">
                <div class="d-flex gap-1 align-items-center justify-content-end me-0 me-md-4 flex-column flex-md-row">
                  <p class="page-main__video-title">Reproduce el video</p>
                  <div class="page-main__content-iframe">
                    <?= wp_oembed_get($video) ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <!-- SINGLE-END -->
          </div>
        </div>
      </div>
    </section>

    <?php if (!empty($preguntas)): ?>
      <section id="page-questions" class="page-questions pb-4 pb-md-5">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-10 mx-auto">
              <?php set_query_var('preguntas', $preguntas); ?>
              <?php get_template_part('template-parts/faq-section'); ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <?php if (!empty($seccion_agenda)): ?>
      <?= do_shortcode('[seccion_agendar_cita]'); ?>
    <?php endif; ?>
  <?php endwhile; ?>
<?php else: ?>
  <p><?php esc_html_e('Lo sentimos, no se encontraron publicaciones.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>

<style>
  .swiper {
    width: 100%;
    height: 100%;
  }

  .swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .swiper {
    width: 100%;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
  }

  .swiper-slide {
    background-size: cover;
    background-position: center;
  }

  .mySwiper2 {
    height: 80%;
    width: 100%;
  }

  .mySwiper {
    height: 20%;
    box-sizing: border-box;
    padding: 10px 0;
  }

  .mySwiper .swiper-slide {
    width: 25%;
    height: 100%;
    opacity: 0.4;
  }

  .mySwiper .swiper-slide-thumb-active {
    opacity: 1;
  }

  .swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>
<!-- Initialize Swiper -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper(".mySwiper", {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    const swiper2 = new Swiper(".mySwiper2", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      thumbs: {
        swiper: swiper,
      },
    });
  });
</script>