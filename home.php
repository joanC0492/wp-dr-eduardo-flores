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


<section class="blog-posts mt-5 ---">
  <div class="container">
    <div class="row">
      <?php if (have_posts()): ?>
        <?php while (have_posts()): ?>
          <?php the_post(); ?>
          <div class="col-lg-4">
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
          <h2 class="page-questions__title text-blue-1 acumin-variable-concept-bold">Preguntas Frecuentes</h2>
        </div>
        <div class="col-10 mx-auto">
          <?php set_query_var('preguntas', $preguntas); ?>
          <?php get_template_part('template-parts/faq-section'); ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php get_footer(); ?>