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
      'numero_whatsapp' => '',
      'mensaje_whatsapp' => '',
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
      'numero_whatsapp' => '',
      'mensaje_whatsapp' => '',
    ];
  }

  return [
    'footer_logo' => $settings->field('footer_logo'),
    'footer_descripcion' => $settings->field('footer_descripcion'),
    'footer_informacion' => $settings->field('footer_informacion'),
    'footer_cirugias' => $settings->field('footer_cirugias'),
    'contacto' => $settings->field('contacto'),
    'numero_whatsapp' => $settings->field('boton_whatsapp_cta'),
    'mensaje_whatsapp' => $settings->field('boton_whatsapp_texto'),
  ];
}
