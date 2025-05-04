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
    // 
    $preguntas = get_post_meta($id, 'preguntas', false);

    // seccion
    $cirujano_texto = get_post_meta($id, 'seccion_cirujano_general_texto', true);

    $image_cirujano_id = get_post_meta($id, 'seccion_cirujano_general_imagen', true);
    $image_cirujano_data = wp_get_attachment_image_src($image_cirujano_id, 'medium_large');
    $image_cirujano_url = $image_cirujano_data ? $image_cirujano_data[0] : '';
    $image_cirujano_text = get_the_title($image_cirujano_id);

    // seccion testimonios
    $testimonios = get_post_meta($id, 'seccion_testimonios', false);

    // 
    $seccion_agenda = get_post_meta($id, 'seccion_agenda_tu_cita', true);

    // echo '<pre>';
    // print_r($image_cirujano_url);
    // echo '</pre>';
    ?>
    <section id="home-hero" class="home-hero position-relative z-1"
      style="background-image: url(<?= esc_url($image_url) ?>);">
      <div class="container h-100">
        <div class="row h-100 align-items-end">
          <div class="col-12 text-start">
            <div class="home-hero__content pb-10">
              <h2 class="home-hero__title text-blue-1 acumin-variable-concept-black mb-0"><?= $titulo ? $titulo : $title ?>
              </h2>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php
    $images_cintillo = [
      [
        "name" => "Clínica Santa Beatriz",
        "img" => "clinica-santa-beatriz.svg",
        "width" => 239.543,
      ],
      [
        "name" => "Clínica Porvenir",
        "img" => "clinica-porvenir.svg",
        "width" => 184.3243,
      ],
      [
        "name" => "Clínica Novogroup",
        "img" => "clinica-novogroup.svg",
        "width" => 245.1711,
      ],
    ];
    ?>
    <section id="home-cintillo" class="home-cintillo py-2">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="home-cintillo__content d-flex justify-content-center align-items-center">
              <p class="home-cintillo__title text-blue-1 acumin-variable-concept-bold">¿Dónde te operamos?</p>
              <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/arrow-right.svg') ?>" alt="Arrow Right"
                class="home-cintillo__arrow-right d-none d-md-block" width="21">
              <ul class="home-cintillo__list d-flex justify-content-center align-items-center">
                <?php foreach ($images_cintillo as $image): ?>
                  <li class="home-cintillo__item d-flex justify-content-center align-items-center">
                    <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/' . $image['img']) ?>"
                      alt="<?= esc_attr($image['name']) ?>" width="<?= $image['width'] ?>"
                      class="home-cintillo__img img-fluid" />
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php
    $home_content = [
      "title_h2" => "CIRUJANO GENERAL",
      "title_1" => "Dr. Eduardo Flores",
      "especialidades" => [
        "RNE: 43366",
        "CMP: 68420"
      ],
      "logos" => [
        [
          "img" => "icon-seguridad.svg",
          "name" => "Seguridad",
          "width" => 41.8477
        ],
        [
          "img" => "icon-experticia.svg",
          "name" => "Experticia",
          "width" => 41.3444
        ],
        [
          "img" => "icon-transparencia.svg",
          "name" => "Transparencia",
          "width" => 52.4781
        ]
      ]
    ];
    ?>
    <section id="home-content" class="home-content py-4 py-md-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 text-center mb-5 px-4 px-xxl-6 order-2 order-lg-1">
            <img src="<?= esc_url($image_cirujano_url) ?>" alt="<?= esc_attr($image_cirujano_text) ?>"
              class="img-fluid w-100 rounded-5 home-content__img-main" />
          </div>
          <div class="col-lg-6 text-center mb-5 order-1 order-lg-2">
            <div>
              <h2 class="home-content__profesion text-sky-blue-1 acumin-variable-concept-bold">
                <?= $home_content["title_h2"] ?>
              </h2>
              <div class="">
                <h1 class="home-content__title text-blue-1 acumin-variable-concept-bold mb-0 lh-1">
                  <?= $home_content["title_1"] ?>
                </h1>
              </div>
              <div class="">
                <ul class="home-content__list-esp d-flex justify-content-center align-items-center gap-5">
                  <?php foreach ($home_content["especialidades"] as $especialidad): ?>
                    <li class="home-content__list-esp-item text-gray-1 acumin-variable-concept"><?= $especialidad ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="mt-3">
                <ul class="home-content__list-logo d-flex justify-content-center align-items-center gap-6">
                  <?php foreach ($home_content["logos"] as $logo): ?>
                    <li class="home-content__list-logo-item">
                      <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/' . $logo['img']) ?>"
                        alt="<?= esc_attr($logo['name']) ?>" width="<?= esc_attr($logo["width"]) ?>"
                        class="home-content__list-logo-img" />
                      <p class="home-content__list-logo-txt text-blue-1 acumin-variable-concept-bold"><?= $logo['name'] ?></p>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            <?php if (!empty($cirujano_texto)): ?>
              <div class="home-content__text text-gray-1 text-justify mt-3">
                <?= wpautop($cirujano_texto) ?>
              </div>
            <?php endif ?>
            <div class="home-content__button">
              <a class="home-content__cta acumin-variable-concept-bold btn-cta-content"
                href="<?= esc_url(home_url('/dr-manuel-eduardo-flores-vilchez')); ?>">Conoce
                más
                <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/icon-arrow-btn-blue.webp') ?>"
                  alt="Arrow Button" class="icon-arrow-btn-blue" />
                <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/icon-arrow-btn-white.webp') ?>"
                  alt="Arrow Button" class="icon-arrow-btn-white" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ESTAMOS CONTIGO -->
    <section class="surgery-process bg-sky-blue-2 pb-6 pt-0 py-lg-6"
      style="background-image: url(<?= esc_url(get_template_directory_uri() . '/assets/images/backgroun-surgery.webp') ?>)">
      <div class="container-fluid g-0">
        <div
          style="background-image: url(<?= esc_url(get_template_directory_uri() . '/assets/images/left-circle.webp') ?>);"
          class="surgery-process__row row g-0">
          <!-- IZQUIERDA: círculo y texto -->
          <div class="surgery-process__left col-lg-5 d-flex align-items-center justify-content-start position-relative">
            <div class="surgery-process__circle text-center pt-5 pt-md-6 pt-lg-0">
              <div class="surgery-process__icon-corazon mb-3">
                <img src="<?= esc_url(get_template_directory_uri() . "/assets/images/icon-corazon.webp") ?>"
                  alt="Icono de Corazon" width="88.2499" class="surgery-process__icon-corazon-img img-fluid me-9" />
              </div>
              <h2 class="surgery-process__title acumin-variable-concept-bold text-white-1 lh-1 text-start hide-br show-md-br">
                <span class="text-yellow-1 highlight">¡Estamos contigo,</span><br />
                en cada etapa de tu cirugía!
              </h2>
              <p class="surgery-process__subtitle acumin-variable-concept-medium text-white-1 text-start">
                Nos preocupamos porque todo vaya bien, más importante que cualquier otra cosa es la salud de la persona.
              </p>
              <div class="surgery-process__icon-cruz mt-3">
                <img src="<?= esc_url(get_template_directory_uri() . "/assets/images/icon-cruz.webp") ?>" alt="Icono Cruz"
                  width="45.1481" class="surgery-process__icon-cruz-img img-fluid" />
              </div>
            </div>
          </div>

          <!-- DERECHA: cards -->
          <div class="col-lg-7 p-3 p-md-5 surgery-process__right">
            <!-- <div class="row gy-4"> -->
            <div class="surgery-process__card-content d-flex flex-wrap gap-4 justify-content-center justify-content-lg-start">
              <!-- Card 1 -->
              <!-- <div class="col-12"> -->
              <div class="surgery-process__card bg-white-1">
                <h5 class="surgery-process__card-title text-sky-blue-1 acumin-variable-concept-black">Antes de la cirugía:
                </h5>
                <ul class="surgery-process__card-list text-gray-1 acumin-variable-concept-medium">
                  <li class="surgery-process__card-item">Evaluación prequirúrgica para definir si se necesita
                    intervención.</li>
                  <li class="surgery-process__card-item">Estudio preoperatorio completo.</li>
                  <li class="surgery-process__card-item">Explicación clara de todos los riesgos, incluso los mínimos.</li>
                  </u>
              </div>
              <!-- </div> -->
              <!-- Card 2 -->
              <!-- <div class="col-12"> -->
              <div class="surgery-process__card bg-white-1">
                <h5 class="surgery-process__card-title text-sky-blue-1 acumin-variable-concept-black">Durante la cirugía:
                </h5>
                <ul class="surgery-process__card-list text-gray-1 acumin-variable-concept-medium">
                  <li class="surgery-process__card-item">Equipo multidisciplinario especializado.</li>
                  <li class="surgery-process__card-item">Cirugías en clínicas modernas y equipadas.</li>
                  <li class="surgery-process__card-item">Registro detallado de cada procedimiento.</li>
                </ul>
              </div>
              <!-- </div> -->
              <!-- Card 3 -->
              <!-- <div class="col-12"> -->
              <div class="surgery-process__card bg-white-1">
                <h5 class="surgery-process__card-title text-sky-blue-1 acumin-variable-concept-black">Después de la cirugía:
                </h5>
                <ul class="surgery-process__card-list text-gray-1 acumin-variable-concept-medium">
                  <li class="surgery-process__card-item">Informe inmediato y evidencias para la familia.</li>
                  <li class="surgery-process__card-item">Seguimiento continuo hasta la primera cita postoperatoria.</li>
                  <li class="surgery-process__card-item">Controles a 1 y 3 meses.</li>
                </ul>
              </div>
              <!-- </div> -->

            </div>
          </div>
        </div>
      </div>
    </section>

    <!--  NUESTROS PACIENTES NOS RESPALDAN -->
    <?php if (!empty($testimonios)): ?>
      <section id="testimonials" class="testimonials py-4 py-md-6">
        <div class="container">
          <div class="row testimonials__content">
            <!-- Testimonio principal -->
            <div class="col-lg-4">
              <h2 class="testimonials__title hide-br show-md-br text-start text-blue-1 acumin-variable-concept-bold lh-1 mt-4 mt-md-5"><span
                  class="text-sky-blue-1">Nuestros pacientes,</span> <br>nos respaldan</h2>
              <div class="testimonials__card d-flex flex-row gap-3 mt-4">
                <div class="testimonials__img-container">
                  <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/avatar-default.webp') ?>"
                    alt="Testimonio 1" class="testimonials__img rounded-circle" width="64.3683" />
                </div>
                <div class="testimonials__text">
                  <h3 class="testimonials__name acumin-variable-concept-bold text-blue-1 mb-0">Lidia Ramirez</h3>
                  <p class="testimonials__description text-gray-1 acumin-variable-concept-light mb-0">Testimonio de nuestra
                    paciente cirugía de vesícula</p>
                </div>
              </div>
            </div>
            <!-- Videos (iframes de YouTube) -->
            <div class="col-lg-8 mt-4 mt-lg-0">
              <div class="row">
                <?php foreach ($testimonios as $testimonio): ?>
                  <div class="col-lg-4 mb-4 mb-lg-0 testimonials__video">
                    <div class="ratio ratio-16x9">
                      <?= wp_oembed_get($testimonio) ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="row">
                <div class="col-12 text-end mt-lg-4 text-center text-md-start">
                  <div class="me-0 me-md-6">
                    <a href="<?= esc_url(home_url('/testimonios-de-nuestros-pacientes')); ?>"
                      class="testimonials__link acumin-variable-concept-bold btn-cta-content">Ver más
                      <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/icon-arrow-btn-blue.webp') ?>"
                        alt="Arrow Button" class="icon-arrow-btn-blue" />
                      <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/icon-arrow-btn-white.webp') ?>"
                        alt="Arrow Button" class="icon-arrow-btn-white" />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- AGENDA TU CITA -->
    <?php if (!empty($seccion_agenda)): ?>
      <?= do_shortcode('[seccion_agendar_cita mensaje="Hola, me gustaría agendar una cita. ¿Podrían brindarme más información, por favor?"]'); ?>
    <?php endif; ?>

    <!--  -->
    <section id="latest-posts" class="latest-posts py-6">
      <?php
      $latest_posts = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 3,
      ]);
      ?>
      <?php if ($latest_posts->have_posts()): ?>
        <div class="container">
          <div class="hide-br show-lg-br text-center">
            <h2 class="latest-posts__title text-blue-1 acumin-variable-concept-bold lh-1">Conoce más sobre nuestros
              procedimientos
              <br>quirúrgicos <span class="text-sky-blue-1">en nuestro Blog</span>
            </h2>
          </div>
          <!-- <div class="row justify-content-center"> -->
          <div class="latest-posts__container-cards d-grid gap-4 justify-content-center mt-5">
            <?php while ($latest_posts->have_posts()): ?>
              <?php $latest_posts->the_post(); ?>
              <!-- <div class="col-md-4 mb-4"> -->
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
              <?php
            endwhile; ?>
            <?php wp_reset_postdata(); ?>
          </div>
          <!-- Botón a todas las entradas -->
          <div class="text-center mt-4">
            <a href="<?= get_permalink(get_option('page_for_posts')); ?>"
              class="latest-posts__cta acumin-variable-concept-bold btn-cta-content">
              Ir al blog
              <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/icon-arrow-btn-blue.webp') ?>"
                alt="Arrow Button" class="icon-arrow-btn-blue" />
              <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/icon-arrow-btn-white.webp') ?>"
                alt="Arrow Button" class="icon-arrow-btn-white" />
            </a>
          </div>
        </div>
      <?php endif; ?>
      <?php if (!empty($preguntas)): ?>
        <section id="page-questions" class="page-questions mt-5 mt-md-6">
          <div class="container">
            <div class="row">
              <div class="col-12 text-center">
                <h2 class="page-questions__title d-inline-block line-title-md text-blue-1 acumin-variable-concept-bold">
                  Preguntas Frecuentes</h2>
              </div>
              <div class="col-12 col-lg-10 mx-auto">
                <?php set_query_var('preguntas', $preguntas); ?>
                <?php get_template_part('template-parts/faq-section'); ?>
              </div>
            </div>
          </div>
        </section>
      <?php endif; ?>
    </section>

  <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>