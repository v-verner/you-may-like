<?php
/**
 * Este arquivo fará todas as funções públicas e integrações necessárias no frontend do site
 */

function yml_scripts()
{
   # Nesta versão, apenas posts padrão do WP serão usados, então em outras páginas não há necessidade de aparecer
   if( ! is_singular("post") ) return;

   $tags = get_the_tags();

   if ( !$tags ) return;

   $tags_arr = [];

   foreach($tags as $tag){
      array_push($tags_arr, $tag->term_id);
   }

   # JS
   wp_register_script('yml-main', YML_URL . 'public/js/main.js', array('jquery'), false, true);
   wp_localize_script('yml-main', 'yml_params', array(
      'post_tags' => json_encode($tags_arr),
      'dias_expiracao' => get_option('yml-dias_expiracao')
   ));
   wp_enqueue_script('yml-main');

   # CSS
   wp_enqueue_style( "yml-main", YML_URL . 'public/css/main.css' );
   
}
add_action('wp_enqueue_scripts', 'yml_scripts', 100);