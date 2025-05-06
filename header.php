<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Precargar imagenes -->
  <?php
  if (is_front_page()) {
    $hero_image = wp_get_attachment_image_url(get_post_thumbnail_id(), 'full');
    echo '<link rel="preload" as="image" href="' . esc_url($hero_image) . '" />';
  }
  ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php
  $header_settings = get_header_settings_data();
  $top_header_texto = $header_settings['top_header_texto'];
  $logo_header = $header_settings['logo_header'];
  $social_links = $header_settings['social_links'];
  $header_boton_de_contacto = $header_settings['header_boton_de_contacto'];
  $contact_target = trim($header_boton_de_contacto) === '#0' ? '_self' : '_blank';

  $locations = get_nav_menu_locations(); // Obtiene todas las ubicaciones  
  $menu_id = $locations['header_menu'];  // Obtiene el ID del menú asignado a 'header_menu'  
  $menu_items = wp_get_nav_menu_items($menu_id); // Ahora sí, trae los ítems  
  // echo "<pre>";
  // print_r($menu_items);
  // echo "</pre>";
  // Organiza por jerarquía
  $menu_tree = [];
  foreach ($menu_items as $item) {
    $menu_tree[$item->menu_item_parent][] = $item;
  }
  ?>

  <!-- Header principal -->
  <div id="top-header" class="top-header bg-blue-1 fade-in-500">
    <div class="container-xxl h-100">
      <div class="row h-100 align-items-center">
        <div class="col-12">
          <div class="top-header__social d-flex align-items-center gap-4">
            <p class="top-header__social-title text-white-1 montserrat-400"><?= esc_html($top_header_texto) ?></p>
            <?php if (!empty($social_links)): ?>
              <ul class="top-header__social-list d-flex align-items-center gap-2">
                <?php foreach ($social_links as $network): ?>
                  <?php if (!empty($network['url'])): ?>
                    <li class="top-header__social-item d-inline-flex lh-1">
                      <a class="top-header__social-link text-white-1 d-inline-flex px-1"
                        href="<?= esc_url($network['url']) ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/' . $network['icon']) ?>"
                          alt="<?= esc_attr($network['alt']) ?>" width="<?= esc_attr($network['width']) ?>" />
                      </a>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- sticky-top -->
  <header id="header" class="header z-2 position-relative fade-in-500">
    <nav class="navbar navbar-expand-lg py-0 d-none d-lg-flex">
      <div class="container-xxl">
        <!-- class="navbar-brand py-3 py-xxl-4 < is_front_page()  'pointer-events-none---' : '' "> -->
        <?php if (!empty($logo_header['guid'])): ?>
          <a href="<?= esc_url(home_url('/')) ?>" class="navbar-brand py-3 py-xxl-4">
            <img src="<?= esc_url($logo_header['guid']) ?>" alt="<?= $logo_header["post_title"] ?>"
              class="img-fluid header__logo" width="206" height="92" />
          </a>
        <?php else: ?>
          <a class="navbar-brand" href="#">Navbar</a>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pt-4" id="navbarSupportedContent">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'header_menu',
              'container' => false,
              'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0 navbar-jc acumin-variable-concept-bold',
              'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
              'walker' => new Custom_Header_Walker()
            )
          );
          ?>
          <div class="ms-0 mb-3 ms-lg-2 mb-lg-2">
            <a href="<?= esc_url($header_boton_de_contacto) ?>" class="btn-cta-header acumin-variable-concept-bold"
              rel="noopener noreferrer">CONTÁCTANOS</a>
          </div>
        </div>

      </div>
    </nav>

    <?php
    // Función que solo genera HTML desde un árbol ya procesado
    function render_bem_menu($menu_tree, $logo_header)
    {
      function build_menu($parent_id, $menu, $depth = 0)
      {
        if (!isset($menu[$parent_id]))
          return '';

        $output = '<ul class="menu__list' . ($depth > 0 ? ' menu__list--submenu' : '') . '">';
        foreach ($menu[$parent_id] as $item) {
          $has_children = isset($menu[$item->ID]);
          $is_active = in_array('current-menu-item', $item->classes) ? ' menu__item--active' : '';
          $output .= '<li class="menu__item' . ($has_children ? ' menu__item--has-children' : '') . $is_active . '">';
          $output .= '<a href="' . esc_url($item->url) . '" class="menu__link">' . esc_html($item->title) . '</a>';

          if ($has_children) {
            $output .= '<button class="menu__toggle" aria-expanded="false" aria-label="Toggle submenu"></button>';
            $output .= build_menu($item->ID, $menu, $depth + 1);
          }

          $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
      }
      echo '<div id="menu-mobile">';
      echo '  <nav class="menu navbar d-lg-none" aria-label="Main navigation">';
      echo '    <div class="container-fluid">';
      echo '      <a class="navbar-brand py-3" href="' . esc_url(home_url('/')) . '">';
      echo '        <img src="' . esc_url($logo_header['guid']) . '" alt="' . esc_attr($logo_header['post_title']) . '" class="img-fluid" width="156" />';
      echo '      </a>';
      echo '        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContentMobile" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
      echo '        <div class="collapse navbar-collapse" id="navbarSupportedContentMobile">';
      echo build_menu(0, $menu_tree); // Usa $menu_tree que ya tienes armado
      echo '        </div>';
      echo '    </div>';
      echo '  </nav>';
      echo '</div>';
    }
    // Llama a la función pasándole el árbol
    render_bem_menu($menu_tree, $logo_header);
    ?>

  </header>
  <main id="app" class="app">