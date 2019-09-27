<?php

function yml_related_posts( $atts )
{
   if(is_admin()) return;

   $opt = shortcode_atts( array(
      'limite' => 5,
      'match'  => "sim"
	), $atts );
   
   $tags = (array) json_decode( stripslashes( $_COOKIE["yml-post_tags"] ) );

   arsort($tags, SORT_NUMERIC);

   $min_visualizacoes = get_option('yml-comecar_indicacoes');
   $limite = get_option('yml-limite_tags');
   $bonus_score = get_option('yml-pontos_extra');
   $counter = 0;

   $tags_ids = [];
   foreach($tags as $id => $value){

      if($value < $min_visualizacoes) continue;

      array_push($tags_ids, $id);
      
      if ( $counter > $limite ) break;
      
      $counter++;
   }

   $recomendacoes = get_posts([
      "tag__in"      => $tags_ids,
      "numberposts"  => -1
   ]);

   $current_post_tags = get_the_tags();

   $rank = [];

   foreach($recomendacoes as $recomendacao){

      $score = $limite + 1;

      $rank[(string) $recomendacao->ID] = 0;

      foreach( $tags_ids as $tag_id ){

         if( has_tag( $tag_id , $recomendacao ) ) {
            $rank[(string) $recomendacao->ID] += $score; 
         }
         $score--;

      }

      foreach($current_post_tags as $current_tag ){
         if( has_tag( $current_tag->term_id , $recomendacao ) ) {
            $rank[(string) $recomendacao->ID] += $bonus_score; 
         }        
      }
   }

   arsort($rank, SORT_NUMERIC);
   $rank = array_slice($rank, 0, $opt['limite'], true);


   $html = "<ul class='yml-list'>";
   $total = 0;

   if($opt['match'] == "sim"){
      foreach($rank as $post_ID => $points){
         $total += $points;
      }
   }

   foreach($rank as $post_ID => $points){
      if($opt['match'] == "sim"){
         $match_calc = number_format(( $points / $total ) * 100, 0, ",",".");
         $match = "($match_calc% relevante!)";
      } else {
         $match = "";
      }
      $html .= "<li class='yml-item'><a class='yml-link' href='".get_the_permalink( $post_ID )."'>". get_the_title( $post_ID ) . "</a> ".$match."</li>";
   }

   $html .= "</ul>";

   return $html;

}
add_shortcode( "you_may_like", "yml_related_posts" );