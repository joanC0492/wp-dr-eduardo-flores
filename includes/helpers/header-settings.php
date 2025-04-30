<?php
function get_header_settings_data()
{
  if (!function_exists('pods')) {
    return [
      'top_header_texto' => '',
      'logo_header' => [],
      'social_links' => [],
      'header_boton_de_contacto' => '',
    ];
  }

  $settings = pods('configuracion_del_sitio');

  if (empty($settings) || is_wp_error($settings)) {
    return [
      'top_header_texto' => '',
      'logo_header' => [],
      'social_links' => [],
      'header_boton_de_contacto' => '',
    ];
  }

  return [
    'top_header_texto' => $settings->field('top_header_texto'),
    'logo_header' => $settings->field('logo_header'),
    'social_links' => get_social_links_data(), // usando tu helper anterior
    'header_boton_de_contacto' => $settings->field('header_boton_de_contacto'),
  ];
}
