<?php
/* Garantiza que el archivo solo pueda ser utilizado dentro del entorno de WordPress */
if (!defined('ABSPATH'))
  die();

/***************************EDITOR_CLASICO***************************/
// add_filter('use_block_editor_for_post', '__return_false', 10);

/***************************INCLUDES***************************/
require_once get_template_directory() . '/includes/index.php';
/***************************SHORTCODES***************************/
require_once get_template_directory() . '/shortcodes/index.php';

function theme_assets()
{
  /***************************CSS***************************/
  /* Bootstrap css */
  wp_enqueue_style(
    'bootstrap-5.3.5-style',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css',
    array(), // Sin dependencias
    '5.3.5' // Versión para caché
  );

  /* Swiper css */
  wp_enqueue_style(
    'swiper-11.2.6-style',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
    array(), // Sin dependencias
    '11.2.6' // Versión para caché
  );

  /* Font Awesome css */
  // wp_enqueue_style(
  //   'fontawesome-6.5.1-style',
  //   'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
  //   array(), // Sin dependencias
  //   '6.5.1' // Versión para caché
  // );

  /* Montserrat font */
  wp_enqueue_style(
    'google-font-montserrat-style',
    'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
    array(),
    null
  );


  /* My css */
  wp_enqueue_style(
    'jc-main-style',
    get_template_directory_uri() . '/assets/css/main.css',
    array('bootstrap-5.3.5-style'), // Depende de Bootstrap
    filemtime(get_template_directory() . '/assets/css/main.css') // Evita caché
  );
  /*************************** JS ***************************/
  wp_enqueue_script(
    'bootstrap-5.3.5-bundle',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js',
    array(), // Sin dependencias (jQuery no es necesario en Bootstrap 5)
    '5.3.5', // Versión
    true // Cargar en el footer (antes de cerrar </body>)
  );
  /* Swiper js */
  wp_enqueue_script(
    'swiper-11.2.6-script',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
    array("bootstrap-5.3.5-bundle"),
    '11.2.6',
    true // Cargar en el footer (antes de cerrar </body>)
  );

  /* My js */
  wp_enqueue_script(
    'jc-main-script',
    get_template_directory_uri() . '/assets/js/main.js',
    array('swiper-11.2.6-script'), // Depende de Bootstrap
    filemtime(get_template_directory() . '/assets/js/main.js'),
    true // En el footer
  );
}
add_action('wp_enqueue_scripts', 'theme_assets', 5);

// Agrega etiquetas <link rel="preconnect"> en el <head>
// function add_preconnect_links()
// {
//   echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
//   echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
// }
// add_action('wp_head', 'add_preconnect_links');


// // JS
// wp_enqueue_script(
//   'script',
//   get_stylesheet_directory_uri() . '/assets/js/script.js',
//   array('jquery'),
//   '1.0.0',
//   true
// );
// // Font Awesome
// wp_enqueue_style(
//   'font-awesome',
//   'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
//   array(),
//   '6.0.0-beta3',
//   'all'
// );
// // Google Fonts
// wp_enqueue_style(
//   'google-fonts',
//   'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap',
//   array(),
//   null,
//   'all'
// );


function init_template()
{
  // Agrega el titulo desde el admin wordpress
  add_theme_support('title-tag');
  // Agrega la opcion de imagen destacada
  add_theme_support('post-thumbnails');

  // Habilita la opcion 'Menús'
  // Apariencia > Menús
  register_nav_menus(
    array(
      'header_menu' => 'Menú Header',
    )
  );
}
add_action('after_setup_theme', 'init_template');


/**
 * Plugin Name: is_page_X capability
 * Description: Grant the current user access to fields or groups based on the ID or slug of the current page being edited. Capability <code>is_page_contact-us</code> will be granted on page with slug <code>contact-us</code>. <code>is_page_123</code> will be granted on page with ID <code>123</code>.
 */

/**
 * For a capability starting with "is_page_", grant the capability to the current user
 * if the slug or ID of the currently viewed page is the same as whatever comes after the "is_page_" prefix.
 * 
 * For example:
 *     "is_page_contact-us" will be granted on page with slug "contact-us".
 *     "is_page_123" will be granted on page with ID 123.
 * 
 * @see https://developer.wordpress.org/reference/hooks/map_meta_cap/
 */
add_filter(
  'map_meta_cap',
  function ($caps, $cap, $user_id, $args) {
    $prefix = 'is_page_';
    $prefix_length = strlen($prefix);

    if (
      $prefix === substr($cap, 0, $prefix_length)
      && array_key_exists('post', $_GET) // Only applies once a new page has been saved and refreshed.
    ) {
      $post_object = get_post(intval($_GET['post']));

      if ('page' === $post_object->post_type) {
        $slug_or_id = substr($cap, $prefix_length);

        if (is_numeric($slug_or_id)) {
          // The capability is providing an ID in the form is_page_123.
          if ($post_object->ID !== intval($slug_or_id)) {
            // If is_page_123 does not match the current page ID being 123, don't allow.
            $caps = ['do_not_allow'];
          } else {
            // If the ID does match, require the user have the capability to edit pages.
            $caps = ['edit_pages'];
          }
        } else {
          // The capability is providing a slug in the form is_page_contact-us.
          if ($post_object->post_name !== $slug_or_id) {
            // If is_page_contact-us does not match the current page slug being contact-us, don't allow.
            $caps = ['do_not_allow'];
          } else {
            // If the slug does match, require the user have the capability to edit pages.
            $caps = ['edit_pages'];
          }
        }
      }
    }

    return $caps;
  },
  10,
  4
);


// Asegúrate de que PODS procese los shortcodes dentro de campos personalizados WYSIWYG
function process_pods_shortcode_in_wysiwyg($content)
{
  return do_shortcode($content);
}
add_filter('pods_field_output', 'process_pods_shortcode_in_wysiwyg');



// function mi_estilo_personalizado_para_pods_admin()
// {
//   $screen = get_current_screen();
//   if (isset($screen->post_type) && $screen->post_type === 'cirugia') {
//     echo '<style>
//           .pods-field-option .pods-dfv-container {
//               max-width: 100% !important;
//               width: 100% !important;
//           }
//           .pods-dfv-container-wysiwyg .mce-container iframe {
//               height: 240px !important;
//           }
//       </style>';
//   }
// }
// add_action('admin_head', 'mi_estilo_personalizado_para_pods_admin');


// Permitir subir archivos SVG
function allow_svg_upload($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');
// Validar tipo de archivo SVG correctamente (WordPress 5.1+)
function fix_svg_mime_type($data, $file, $filename, $mimes)
{
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if ($ext === 'svg') {
    $data['ext'] = 'svg';
    $data['type'] = 'image/svg+xml';
  }
  return $data;
}
add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 4);


// Para que la busqueda solo devuelva entradas (posts) y no páginas o cualquier otro tipo de contenido
function limitar_busqueda_a_entradas($query)
{
  if ($query->is_search() && $query->is_main_query() && !is_admin()) {
    $query->set('post_type', 'post');
  }
}
add_action('pre_get_posts', 'limitar_busqueda_a_entradas');


// Para la carga de videos en Pagina de Testimonios
function getYouTubeId($url)
{
  preg_match('/\/embed\/([^?]+)/', $url, $matches);
  return $matches[1] ?? '';
}

// Permite mostrar 3 Elementos en el home.php
function custom_posts_per_page_home($query)
{
  if ($query->is_home() && $query->is_main_query()) {
    $query->set('posts_per_page', 3);
  }
}
add_action('pre_get_posts', 'custom_posts_per_page_home');

// Permite mostrar 6 Elementos en el category y el search
function custom_posts_per_page_category($query)
{
  if (($query->is_category() || $query->is_search()) && $query->is_main_query()) {
    $query->set('posts_per_page', 6);
  }
}
add_action('pre_get_posts', 'custom_posts_per_page_category');

// 
// 
// 
// Ninja Forms - Generar número de registro único
function create_custom_table()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'custom_ninja_forms_ids';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        form_id INT NOT NULL,
        entry_number VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($sql);
}
add_action('init', 'create_custom_table');

// Generar número de registro único
function custom_ninja_forms_generate_id($form_data)
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'custom_ninja_forms_ids';

  // Obtener form_id desde la clave correcta
  $form_id = isset($form_data['id']) ? intval($form_data['id']) : null;

  if (!$form_id) {
    error_log("Error: 'form_id' no está definido en el formulario.");
    return $form_data; // Salir sin modificar nada
  }

  $current_year = date('Y');

  // Obtener el último número registrado para este año y formulario
  $last_entry = $wpdb->get_var(
    $wpdb->prepare(
      "SELECT entry_number FROM $table_name WHERE form_id = %d AND entry_number LIKE %s ORDER BY id DESC LIMIT 1",
      $form_id,
      "%-$current_year"
    )
  );

  // Inicializar número
  $next_number = '000000001';

  if ($last_entry) {
    if (preg_match('/Nº (\d+)-(\d{4})/', $last_entry, $matches)) {
      $next_number = str_pad((int) $matches[1] + 1, 9, '0', STR_PAD_LEFT);
    }
  }

  $new_id = "Nº $next_number-$current_year";

  // Insertar en la base de datos
  $result = $wpdb->insert(
    $table_name,
    [
      'form_id' => $form_id,
      'entry_number' => $new_id,
      'created_at' => current_time('mysql')
    ]
  );
  if ($result === false) {
    error_log("Error en la inserción: " . $wpdb->last_error);
  }
  // Asignar el valor al campo oculto
  foreach ($form_data['fields'] as &$field) {
    if ($field['key'] === 'numero_registro') {
      $field['value'] = $new_id;
      break;
    }
  }

  return $form_data;
}
add_filter('ninja_forms_submit_data', 'custom_ninja_forms_generate_id');