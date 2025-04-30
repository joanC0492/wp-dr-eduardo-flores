<?php get_header(); ?>

<?php
// Obtener ID de la página asignada como Página de entradas
// $blog_page_id = get_option('page_for_posts');
$id = get_option('page_for_posts');

// Obtener el post de esa página
$blog_page = get_post($id);

$title = get_the_title($id);

$preguntas = get_post_meta($id, 'preguntas', false);
$titulo = get_post_meta($id, 'titulo', true);
?>

<section id="page-main" class="page-main">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="text-center">
          <h1><?= $titulo ? $titulo : $title ?></h1>
        </div>
        <div class="text-center">
          <?= apply_filters('the_content', $blog_page->post_content); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Busqueda -->
<div id="blog-search" class="blog-search mt-4 mb-5">
  <form role="search" method="get" action="<?= esc_url(home_url('/')); ?>" class="d-flex justify-content-center">
    <div class="input-group input-group-lg w-75">
      <span class="input-group-text bg-white border-primary"><i class="bi bi-search text-primary"></i></span>
      <input type="search" class="form-control border-primary rounded-end" placeholder="Buscar..."
        value="<?= get_search_query(); ?>" name="s" />
    </div>
  </form>
</div>


<section class="blog-posts mt-5">
  <div class="container">
    <div class="row">
      <?php if (have_posts()): ?>
        <?php while (have_posts()): ?>
          <?php the_post(); ?>
          <div class="col-lg-4">
            <a href="<?php the_permalink(); ?>" class="blog-posts__card card p-4 text-decoration-none">
              <article class="blog-posts__card-body">
                <div class="blog-posts__card-figure">
                  <?php if (has_post_thumbnail()): ?>
                    <?php $image_url_post = get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>
                    <img src="<?= esc_url($image_url_post); ?>" alt="<?= esc_attr(get_the_title()) ?>"
                      class="blog-posts__card-img img-fluid w-100" />
                  <?php else: ?>
                    <img src="<?= get_template_directory_uri(); ?>/assets/images/no-thumbnail.webp" alt="Imagen por defecto"
                      class="blog-posts__card img-fluid" />
                  <?php endif; ?>
                </div>
                <div class="blog-posts__card-content">
                  <h2 class="blog-posts__card-title"><?php the_title(); ?></h2>
                </div>
                <div class="blog-posts__card-description"><?php the_excerpt(); ?></div>
              </article>
            </a>
          </div>
        <?php endwhile; ?>
        <?php the_posts_pagination([
          'mid_size' => 2,
          'prev_text' => __('« Anterior', 'textdomain'),
          'next_text' => __('Siguiente »', 'textdomain'),
        ]); ?>
      <?php else: ?>
        <div class="col-12">
          <p>No hay entradas disponibles.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if (!empty($preguntas)): ?>
  <section id="page-questions" class="page-questions mt-5 mb-6">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="page-questions__title">Preguntas Frecuentes</h2>
        </div>
        <div class="col-10 mx-auto">
          <div class="page-questions__accordion accordion mt-4" id="accordionExample">
            <?php foreach ($preguntas as $index => $pregunta_id): ?>
              <?php
              $pregunta_post = get_post($pregunta_id);
              if (!$pregunta_post)
                continue;
              $titulo_pregunta = esc_html($pregunta_post->post_title);
              $contenido_pregunta = apply_filters('the_content', $pregunta_post->post_content);
              $collapse_id = 'collapse' . $index;
              ?>
              <div class="page-questions__accordion-item accordion-item">
                <h2 class="page-questions__accordion-header accordion-header" id="heading<?= $index; ?>">
                  <button class="page-questions__accordion-button accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#<?= $collapse_id ?>" aria-expanded="false"
                    aria-controls="<?= $collapse_id ?>">
                    <?= $titulo_pregunta ?>
                  </button>
                </h2>
                <div id="<?= $collapse_id ?>" class="page-questions__accordion-collape accordion-collapse collapse"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body"><?= $contenido_pregunta; ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php get_footer(); ?>