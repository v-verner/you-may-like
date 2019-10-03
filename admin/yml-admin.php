<?php

function yml_menu_item() {
	add_menu_page( 'YML Configurações', 'YML Configurações', 'manage_options', 'yml-config', 'yml_menu_options' );
}
add_action( 'admin_menu', 'yml_menu_item' );

function yml_menu_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( "Você não tem permissões suficientes para editar esta página" );
	}
   echo "
   <h1>Hey!</h1>
   <p> This is where you will set some options for the <strong> You May Like </strong> plugin to work. </p>
   <p>To make the listing of user-related posts visible, remember to use shortcode: </p>
   <h4>[you_may_like]</h4>

   <form method='POST' action='options.php'>
   ";

      wp_nonce_field('update-options');

      echo "
      <table class='form-table'>
         <tr valign='top'>
            <th scope='row'>Preference lifetime</th>
            <td>
               <input type='text' name='yml-days_expiration' value='". get_option('yml-days_expiration') ."' />
               <p class='description' id='days_expiration-description'>Please inform after how many days without visiting the site the suggestion cookie should be deleted. </p>
               <p class='description'><strong>Recommended:</strong> 30 days.</p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'>Start recommending posts from how many views?</th>
            <td>
               <input type='text' name='yml-start_indications' value='". get_option('yml-start_indications') ."' />
               <p class='description' id='start_indications-description'>Enter the amount of view cropping for the recommendation.</p>
               <p class='description'><strong>Recommended:</strong> 10 views.</p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'>Use preferences from up to how many tags to recommend content?</th>
            <td>
               <input type='text' name='yml-tags_limit' value='". get_option('yml-tags_limit') ."' />
               <p class='description' id='tags_limit-description'>YML will cross over the tags most read by the customer. In this field you can even tell how many intersections you would like to make.</p>
               <p class='description'><strong>Recommended:</strong> 4 cross over. For large blogs (over 200 posts), decrease the number of crossovers to optimize speed.</p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'>Extra score for current tag</th>
            <td>
               <input type='text' name='yml-extra_points' value='". get_option('yml-extra_points') ."' />
               <p class='description' id='extra_points-description'>To further improve the recommendation, you can set an extra point value for posts with the same tags as the current post.</p>
               <p class='description'><strong>Recommended:</strong> 4 points</p>
            </td>
         </tr>
      </table>

      <input type='hidden' name='action' value='update' />
      <input type='hidden' name='page_options' value='yml-days_expiration' />
      <input type='hidden' name='page_options' value='yml-start_indications' />
      <input type='hidden' name='page_options' value='yml-tags_limit' />
      <input type='hidden' name='page_options' value='yml-extra_points' />

      <p class='submit'>
         <input type='submit' class='button-primary' value='Salvar' />
      </p>
      ";

   echo "</form>";
}