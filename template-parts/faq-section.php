<?php
$preguntas = get_query_var('preguntas');
?><div class="page-questions__accordion accordion mt-4" id="accordionExample">
  <?php foreach ($preguntas as $index => $pregunta_id):
    $pregunta_post = get_post($pregunta_id);
    if (!$pregunta_post)
      continue;

    $titulo_pregunta = esc_html($pregunta_post->post_title);
    $contenido_pregunta = apply_filters('the_content', $pregunta_post->post_content);
    $collapse_id = 'collapse' . $index;
    ?>
    <div class="page-questions__accordion-item accordion-item mt-3 rounded-2">
      <h2 class="page-questions__accordion-header accordion-header" id="heading<?= $index; ?>">
        <button
          class="bg-gray-2 text-gray-1 acumin-variable-concept-medium page-questions__accordion-button accordion-button collapsed"
          type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapse_id ?>" aria-expanded="false"
          aria-controls="<?= $collapse_id ?>">
          <?= $titulo_pregunta ?>
        </button>
      </h2>
      <div id="<?= $collapse_id ?>" class="page-questions__accordion-collape accordion-collapse collapse"
        data-bs-parent="#accordionExample">
        <div class="accordion-body text-gray-1 acumin-variable-concept"><?= $contenido_pregunta; ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>