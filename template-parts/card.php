<?php
$data = get_query_var('card_data', []);
$url = $data['url'] ?? '#';
// $image_url = $data['image_url'] ?? '';
$image_url = $data['image_url'] ? $data['image_url'] : get_template_directory_uri() . '/assets/images/no-thumbnail.webp';
$title = $data['title'] ?? '';
$excerpt = $data['excerpt'] ?? '';
?>
<a href="<?= esc_url($url); ?>" class="text-decoration-none card-blog">
  <article class="card-blog__article rounded-5 card overflow-hidden">
    <?php if ($image_url): ?>
      <img src="<?= esc_url($image_url); ?>" class="card-img-top card-blog__img" alt="<?= esc_attr($title); ?>">
    <?php endif; ?>
    <div class="p-0">
      <div class="card-blog__heading bg-blue-1 text-center px-3 d-flex align-items-center justify-content-center">
        <h6 class="card-blog__title card-title text-white-1 acumin-variable-concept-bold mb-0 lh-1">
          <?= esc_html($title); ?>
        </h6>
      </div>
    </div>
  </article>
  <div class="card-blog__content p-4 text-gray-3 bg-gray-4 rounded-4 mt-3">
    <?= esc_html(mb_strimwidth($excerpt, 0, 104, '...')); ?>
  </div>
</a>