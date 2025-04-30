<?php
// En tu functions.php o en un plugin personalizado
function seccion_agendar_cita_shortcode($atts)
{
  // Configuración de atributos del shortcode
  $atts = shortcode_atts(array(
    'titulo' => get_the_title(), // Título dinámico por defecto
    'doctor' => 'Eduardo Flores', // Doctor por defecto
    'telefono' => '900556665', // Número de WhatsApp
    'mensaje' => '' // Mensaje personalizado opcional
  ), $atts);

  // Obtener URL base de la página actual
  $url_actual = get_permalink();

  // Construir el mensaje para WhatsApp
  if (empty($atts['mensaje'])) {
    $mensaje_whatsapp = $url_actual . " \nHola, estoy interesado en \"" . esc_attr($atts['titulo']) .
      "\" con el Dr. " . esc_attr($atts['doctor']) .
      ". ¿Podrían ayudarme con más información?";
  } else {
    $mensaje_whatsapp = $url_actual . " \n" . $atts['mensaje'];
  }

  // URL de WhatsApp con el mensaje
  $url_whatsapp = 'https://wa.me/51' . esc_attr($atts['telefono']) . '?text=' . urlencode($mensaje_whatsapp);

  // Maquetación HTML completa
  $output = '
<section class="section-agendar-cita bg-sky-blue-2 py-6" id="section-agendar-cita">
  <div class="container">
    <div class="row myriad-pro-bold">
      <div class="col-lg-6">        
        <h4 class="section-agendar-cita__title text-sky-blue-3">Agenda tu cita hoy con el Dr. ' . esc_html($atts['doctor']) . ', <span>y deja en manos expertas tu bienestar.</span></h4>
      </div>
      <div class="col-lg-6 text-center align-self-center">
        <a class="section-agendar-cita__btn" href="' . esc_url($url_whatsapp) . '" target="_blank" rel="noopener noreferrer">
          AGENDAR CITA
        </a>
      </div>
    </div>
  </div>
</section>';
  return $output;
}
add_shortcode('seccion_agendar_cita', 'seccion_agendar_cita_shortcode');