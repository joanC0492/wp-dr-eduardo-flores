<?php
// Top Header Social Links
function get_social_links_data()
{
  if (!function_exists('pods')) {
    return []; // Pods no está disponible
  }

  $settings = pods('configuracion_del_sitio');

  if (empty($settings) || is_wp_error($settings)) {    
    return []; // No existe el pod o hubo error
  }
  return [
    [
      'url' => $settings->field('top_header_facebook'),
      'icon' => 'icon-facebook.png',
      'alt' => 'Facebook',
      'width' => 9
    ],
    [
      'url' => $settings->field('top_header_instagram'),
      'icon' => 'icon-instagram.png',
      'alt' => 'Instagram',
      'width' => 20
    ],
    [
      'url' => $settings->field('top_header_tiktok'),
      'icon' => 'icon-tiktok.png',
      'alt' => 'TikTok',
      'width' => 16
    ]
  ];
}