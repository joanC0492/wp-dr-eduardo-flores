<?php
function get_footer_settings_data()
{
  if (!function_exists('pods')) {
    return [
      'footer_logo' => [],
      'footer_descripcion' => '',
      'footer_informacion' => '',
      'footer_cirugias' => '',
      'contacto' => '',
    ];
  }

  $settings = pods('configuracion_del_sitio');

  if (empty($settings) || is_wp_error($settings)) {
    return [
      'footer_logo' => [],
      'footer_descripcion' => '',
      'footer_informacion' => '',
      'footer_cirugias' => '',
      'contacto' => '',
    ];
  }

  return [
    'footer_logo' => $settings->field('footer_logo'),
    'footer_descripcion' => $settings->field('footer_descripcion'),
    'footer_informacion' => $settings->field('footer_informacion'),
    'footer_cirugias' => $settings->field('footer_cirugias'),
    'contacto' => $settings->field('contacto'),
  ];
}
