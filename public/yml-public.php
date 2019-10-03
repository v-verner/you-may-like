<?php
/**
 * This file will do all the necessary public functions and integrations on the site frontend.
 */

function yml_scripts()
{
   # In this release, only standard WP posts will be used, so other post types need not be considered.
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
      'days_expiration' => get_option('yml-days_expiration')
   ));
   wp_enqueue_script('yml-main');

   # CSS
   wp_enqueue_style( "yml-main", YML_URL . 'public/css/main.css' );
   
}
add_action('wp_enqueue_scripts', 'yml_scripts', 100);