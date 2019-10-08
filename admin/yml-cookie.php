<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * In this file, we are creating and managing the yml cookie
 */

function yml_update_cookie()
{
   # In this release, only standard WP posts will be used, so other post types need not be considered.
   if (!is_singular("post")) return;

   $tags = get_the_tags();
   if (!$tags) return;

   $days_expiration  = get_option("yml-days_expiration");
   $yml_cookie       = "yml-" . YML_SUFFIX;

   if (!$_COOKIE[$yml_cookie]) {
      $yml_tags = array();
   } else {
      $yml_tags = (array) json_decode(stripslashes($_COOKIE[$yml_cookie]));
   }


   foreach ($tags as $value) {

      if (isset($yml_tags["{$value->term_id}"])) {
         $yml_tags["{$value->term_id}"] += 1;
      } else {
         $yml_tags["{$value->term_id}"] = 1;
      }
   }

   $yml_tags = json_encode($yml_tags);
   setcookie($yml_cookie, $yml_tags, strtotime("+{$days_expiration} days"), COOKIEPATH, COOKIE_DOMAIN);
}

add_action('wp', 'yml_update_cookie');
