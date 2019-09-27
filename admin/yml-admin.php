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
   <h1>Opa!</h1>
   <p>Aqui é onde você irá definir algumas opções para o funcionamento do plugin <strong>You May Like</strong>.</p>
   <p>Para que a listagem de posts relacionados ao usuário fique visível, lembre-se de usar o shortcode: </p>
   <h4>[you_may_like]</h4>

   <form method='POST' action='options.php'>
   ";

      wp_nonce_field('update-options');

      echo "
      <table class='form-table'>
         <tr valign='top'>
            <th scope='row'>Vida útil das preferências</th>
            <td>
               <input type='text' name='yml-dias_expiracao' value='". get_option('yml-dias_expiracao') ."' />
               <p class='description' id='dias_expiracao-description'>Informe após quantos dias sem visita no site o cookie de sugestões deve ser apagado. </p>
               <p class='description'><strong>Recomendado:</strong> 30 dias.</p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'>Começar indicações a partir de quantas visualizações?</th>
            <td>
               <input type='text' name='yml-comecar_indicacoes' value='". get_option('yml-comecar_indicacoes') ."' />
               <p class='description' id='comecar_indicacoes-description'>Informe a quantidade de corte de visualizações para a recomendação.</p>
               <p class='description'><strong>Recomendado:</strong> 10 visualizações.</p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'>Usar as preferencias de até quantas tags para recomendar o conteúdo?</th>
            <td>
               <input type='text' name='yml-limite_tags' value='". get_option('yml-limite_tags') ."' />
               <p class='description' id='limite_tags-description'>O YML fará o cruzamento das tags mais lidas pelo cliente. Neste campo você informa até quantos cruzamentos você gostaria de fazer.</p>
               <p class='description'><strong>Recomendado:</strong> 4 cruzamentos. Para blogs grandes (mais de 200 posts), diminua a quantidade de cruzamentos para otimizar a velocidade.</p>
            </td>
         </tr>
         <tr valign='top'>
            <th scope='row'>Pontuação extra para tag atual</th>
            <td>
               <input type='text' name='yml-pontos_extra' value='". get_option('yml-pontos_extra') ."' />
               <p class='description' id='limite_tags-description'>Para melhorar ainda mais a recomendação,  você pode estipular um valor de pontuação extra para posts com as mesmas tags do post atual.</p>
               <p class='description'><strong>Recomendado:</strong> 10 pontos</p>
            </td>
         </tr>
      </table>

      <input type='hidden' name='action' value='update' />
      <input type='hidden' name='page_options' value='yml-dias_expiracao' />
      <input type='hidden' name='page_options' value='yml-comecar_indicacoes' />
      <input type='hidden' name='page_options' value='yml-limite_tags' />
      <input type='hidden' name='page_options' value='yml-pontos_extra' />

      <p class='submit'>
         <input type='submit' class='button-primary' value='Salvar' />
      </p>
      ";

   echo "</form>";
}