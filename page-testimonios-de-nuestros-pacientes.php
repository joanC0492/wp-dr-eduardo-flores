<?php get_header(); ?>

<?php if (have_posts()): ?>
  <?php while (have_posts()): ?>
    <?php the_post(); ?>
    <?php
    $id = get_the_ID();
    $title = get_the_title();
    $content = apply_filters('the_content', get_the_content());
    // $image_url = get_the_post_thumbnail_url($id, 'full');
    // $link = get_permalink();
    $titulo = get_post_meta($id, 'titulo', true);
    $seccion_agenda = get_post_meta($id, 'seccion_agenda_tu_cita', true);
    $carrusel_imagenes = get_post_meta($id, 'carrusel_imagenes', false);

    // $testimonios = get_post_meta($id, 'testimonios', true);
    $testimonios = get_post_meta($id, 'testimonios', false);
    // echo "<pre>";
    // print_r($testimonios);
    // echo "</pre>";

    ?>
    <section id="page-main" class="page-main">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
              <div class="page-main__h1-parent">
                <h1 class="page-main__h1"><?= $titulo ? $titulo : $title ?></h1>
              </div>
            </div>
            <div class="mt-4 text-center">
              <div class="page-main__content">
                <?= $content ?>
              </div>
            </div>
            <?php if (!empty($testimonios)): ?>
              <div class="row my-5">
                <?php foreach ($testimonios as $testimonio): ?>
                  <div class="col-lg-4">
                    <?php
                    // echo wp_oembed_get($testimonio);
                    ?>
                    <?php
                    $embed_url = wp_oembed_get($testimonio);
                    // Extraer la URL del src del iframe
                    preg_match('/src="([^"]+)"/', $embed_url, $matches);
                    $src = $matches[1] ?? '';
                    ?>
                    <div class="video-wrapper" data-src="<?= esc_url($src) ?>">
                      <div class="video-thumbnail" style="position: relative; cursor: pointer;">
                        <img src="https://img.youtube.com/vi/<?= esc_html(getYouTubeId($src)) ?>/hqdefault.jpg"
                          class="img-fluid" />
                        <div class="play-button"
                          style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:3rem;color:white;">
                          ▶</div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <?php if (!empty($seccion_agenda)): ?>
      <?= do_shortcode('[seccion_agendar_cita mensaje="Hola, vi los testimonios de los pacientes del Dr. Eduardo Flores y me gustaría agendar una cita. ¿Podrían brindarme más información, por favor?"]'); ?>
    <?php endif; ?>
  <?php endwhile; ?>
<?php else: ?>
  <p><?php esc_html_e('Lo sentimos, no se encontraron publicaciones.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const wrappers = document.querySelectorAll(".video-wrapper");
    wrappers.forEach(wrapper => {
      wrapper.addEventListener("click", () => {
        const iframe = document.createElement("iframe");
        iframe.setAttribute("src", wrapper.dataset.src + "&autoplay=1");
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");
        iframe.className = "w-100";
        wrapper.innerHTML = "";
        wrapper.appendChild(iframe);
      });
    });
  });
</script>