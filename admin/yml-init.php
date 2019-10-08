<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This file handle all the initial setup and includes for the plugin
 */

# function for admin notice transient
function yml_activation()
{
   # Inital Values
   add_option('yml-days_expiration',  180);
   add_option('yml-start_indications', 10);
   add_option('yml-tags_limit', 5);
   add_option('yml-extra_points', 5);

   # Notice transient
   set_transient('yml_activation_notice', true, 5);
}

# admin notice content
function yml_activation_notice_content()
{

   if (!get_transient('yml_activation_notice')) return;

   ob_start(); ?>

   <div class="updated notice is-dismissible">
      <h3><?php _e("You are Awesome!", "you-may-like"); ?></h3>
      <p><?php _e("Thank you for using You May Like! Now you need to configure a few things on the settings page. You can find it in the sidebar menu under wp-admin.", "you-may-like"); ?>
         <p><?php _e("If you have any questions, read <a href='https://vverner.com/plugin-para-recomendacao-de-posts-you-may-like/' target='_blank'> this article<a>.", "you-may-like"); ?></p>
   </div>

<?php

   $content = ob_get_contents();
   ob_end_clean();

   echo $content;

   delete_transient('yml_activation_notice');
}
add_action('admin_notices', 'yml_activation_notice_content');


# Include Admin
include(YML_PATH . "/admin/yml-config.php");
include(YML_PATH . "/admin/yml-cookie.php");
