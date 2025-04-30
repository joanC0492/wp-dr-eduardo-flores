<?php
$footer_s = get_footer_settings_data();
$footer_logo = $footer_s['footer_logo'];
$footer_descripcion = $footer_s['footer_descripcion'];
$footer_informacion = $footer_s['footer_informacion'];
$footer_cirugias = $footer_s['footer_cirugias'];
$contacto = $footer_s['contacto'];
?>
</main> <!-- <main> -->
<footer class="bg-blue-1 py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div>
          <?php if (!empty($footer_logo['guid'])): ?>
            <a href="<?= esc_url(home_url('/')) ?>" class="<?= is_front_page() ? 'pointer-events-none' : '' ?>">
              <img src="<?= esc_url($footer_logo['guid']) ?>" alt="<?= esc_attr($footer_logo['post_title']) ?>"
                width="279">
            </a>
          <?php endif; ?>
        </div>
        <div class="footer__description hide-br show-lg-br text-white-1 acumin-variable-concept-thin lh-2 mt-4">
          <?= wpautop($footer_descripcion) ?>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-3">
            <div class="footer__col footer__informacion text-white-1 acumin-variable-concept-thin lh-2 mt-4">
              <?= wpautop($footer_informacion) ?>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer__col footer__cirugias text-white-1 acumin-variable-concept-thin lh-2 mt-4">
              <?= wpautop($footer_cirugias) ?>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="footer__col footer__contacto hide-br text-white-1 acumin-variable-concept-thin lh-2 mt-4">
              <?= wpautop($contacto) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<div id="footer-bottom" class="bg-black-1 py-3">
  <div class="container">
    <p class="text-white-1 fs-5 altone-trial-bold lh-1 text-center">Dr. Eduardo Flores &copy; <?= date('Y'); ?></p>
  </div>
</div>
<?php wp_footer(); ?>
</body>

</html>