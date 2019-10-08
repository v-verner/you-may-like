<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * In this file are the settings for YML page on wp-admin
 */

function yml_menu_item()
{
   add_menu_page(__("YML Settings", "you-may-like"), __("YML Settings", "you-may-like"), 'manage_options', 'yml-settings', 'yml_menu_options');

   add_action( 'admin_init', 'yml_register_options' );
}
add_action('admin_menu', 'yml_menu_item');

function yml_register_options()
{
   register_setting( 'yml-settings', 'yml-days_expiration' );
   register_setting( 'yml-settings', 'yml-start_indications' );
   register_setting( 'yml-settings', 'yml-tags_limit' );
   register_setting( 'yml-settings', 'yml-extra_points' );
}

function yml_menu_options()
{
   if (!current_user_can('manage_options')) {
      wp_die(__("You do not have sufficient permissions to edit this page.", "you-may-like"));
   }

   $days_expirataion = get_option('yml-days_expiration');
   $start_indications = get_option('yml-start_indications');
   $tags_limit = get_option('yml-tags_limit');
   $extra_points = get_option('yml-extra_points');

   ob_start(); ?>
   <div class="wrap">
   
   <h1><?php _e("Hey!", "you-may-like"); ?></h1>
   <p><?php _e("On this page you will make the necessary settings for the You May Like plugin to work according to your needs.", "you-may-like"); ?></p>
   <p><?php _e("Remember that for the recommended post listing to appear, you need to use the shortcode below in your sidebar and / or post content. ", "you-may-like"); ?></p>
   <h4>[you_may_like]</h4>

   <form method='POST' action='options.php'>
      <?php settings_fields( 'yml-settings' ); ?>
      <table class='form-table'>
         <tr valign='top'>
            <th scope='row'><?php _e("Cookie validity", "you-may-like"); ?></th>
            <td>
               <input type='text' name='yml-days_expiration' value='<?php echo $days_expirataion; ?>' />
               <p class='description' id='days_expiration-description'><?php _e("After how many days without visiting your site, should the recommendation cookie be deleted from the visitor's computer?", "you-may-like"); ?></p>
               <p class='description'><strong><?php _e("Recommended:", "you-may-like"); ?></strong> <?php _e("180 days", "you-may-like"); ?></p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'><?php _e("Minimal user interest in subject", "you-may-like"); ?></th>
            <td>
               <input type='text' name='yml-start_indications' value='<?php echo $start_indications; ?>' />
               <p class='description' id='start_indications-description'><?php _e("After how many user readings on the same subject, consider the subject for making post recommendations?", "you-may-like") ?></p>
               <p class='description'><strong><?php _e("Recommended:", "you-may-like"); ?></strong> <?php _e("10 views", "you-may-like") ?></p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'><?php _e("How many subjects to use to recommend content to visitors?", "you-may-like"); ?></th>
            <td>
               <input type='text' name='yml-tags_limit' value='<?php echo $tags_limit; ?>' />
               <p class='description' id='tags_limit-description'><?php _e("In order to recommend the correct content to the reader, will YML consider how many subjects of his 'preference ranking'? (Starting from the preferred subject to what is in the position indicated in this field)", "you-may-like"); ?></p>
               <p class='description'><strong><?php _e("Recommended:", "you-may-like"); ?></strong> <?php _e("Up to 5 position. For large blogs (over 300 posts), reduce this number to optimize query speed.", "you-may-like"); ?></p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'><?php _e("Extra score for current tag", "you-may-like"); ?></th>
            <td>
               <input type='text' name='yml-extra_points' value='<?php echo $extra_points; ?>' />
               <p class='description' id='extra_points-description'><?php _e("To further improve the recommendation, you can set an extra point value for posts with the same tags as the current post.", "you-may-like"); ?></p>
               <p class='description'><strong><?php _e("Recommended:", "you-may-like"); ?></strong> <?php _e("5 points", "you-may-like"); ?></p>
            </td>
         </tr>
      </table>

      <p class='submit'>
         <input type='submit' class='button-primary' value='<?php _e("Save", "you-may-like"); ?>' />
      </p>

   </form>

   </div>
<?php

   $content = ob_get_contents();
   ob_end_clean();

   echo $content;
}
