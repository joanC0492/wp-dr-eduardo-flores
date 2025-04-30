<?php
function social_links_footer_shortcode($atts)
{
  // Atributos por defecto
  $atts = shortcode_atts([
    'facebook_text' => '',
    'instagram_text' => '',
    'tiktok_text' => '',
  ], $atts, 'social_links');

  $social_links = get_social_links_data();

  if (empty($social_links)) {
    return ''; // No hay enlaces disponibles
  }

  // Emparejar textos
  $texts = [
    'Facebook' => sanitize_text_field($atts['facebook_text']),
    'Instagram' => sanitize_text_field($atts['instagram_text']),
    'TikTok' => sanitize_text_field($atts['tiktok_text']),
  ];

  $output = '<ul class="social-links-list">';

  foreach ($social_links as $link) {
    $url = esc_url($link['url']);
    $icon = esc_attr($link['icon']);
    $alt = esc_attr($link['alt']);
    $width = intval($link['width']);
    $text = isset($texts[$alt]) ? $texts[$alt] : '';

    if (!empty($url)) {
      $output .= '<li class="social-link-item">';
      $output .= '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">';
      $output .= '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/images/' . $icon) . '" alt="' . $alt . '" width="' . $width . '">';
      $output .= '<span>' . esc_html($text) . '</span>';
      $output .= '</a>';
      $output .= '</li>';
    }
  }

  $output .= '</ul>';

  return $output;
}
add_shortcode('social_links', 'social_links_footer_shortcode');
