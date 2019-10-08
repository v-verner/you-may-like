<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This file will do all the necessary public functions and integrations on the site frontend.
 */

function yml_scripts()
{
   # In this release, only standard WP posts will be used, so other post types need not be considered.
   if (!is_singular("post")) return;

   # CSS
   wp_enqueue_style("yml-main", YML_URL . 'public/css/main.css');
}
add_action('wp_enqueue_scripts', 'yml_scripts', 100);
