<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This file creates all shortcodes for user
 */

function yml_related_posts($atts)
{
   if (is_admin()) return;

   $opt = shortcode_atts(array(
      'limit' => 5,
      'match'  => "true"
   ), $atts);

   $tags = (array) json_decode(stripslashes($_COOKIE["yml-" . YML_SUFFIX]));

   arsort($tags, SORT_NUMERIC);

   $min_views = get_option('yml-start_indications');
   $limit = get_option('yml-tags_limit');
   $bonus_score = get_option('yml-extra_points');

   $tags_ids = [];
   foreach ($tags as $id => $value) {

      if ($value < $min_views) continue;

      array_push($tags_ids, $id);

      if (count($tags_ids) == $limit) break;
   }

   $recommendations = get_posts([
      "tag__in"      => $tags_ids,
      "numberposts"  => -1
   ]);

   $current_post_tags = get_the_tags();

   $rank = [];

   foreach ($recommendations as $recommendation) {

      $score = $limit + 1;

      $rank[(string) $recommendation->ID] = 0;

      foreach ($tags_ids as $tag_id) {

         if (has_tag($tag_id, $recommendation)) {
            $rank[(string) $recommendation->ID] += $score;
         }
         $score--;
      }

      if (!$current_post_tags) continue;

      foreach ($current_post_tags as $current_tag) {
         if (has_tag($current_tag->term_id, $recommendation)) {
            $rank[(string) $recommendation->ID] += $bonus_score;
         }
      }
   }

   arsort($rank, SORT_NUMERIC);
   $rank = array_slice($rank, 0, $opt['limit'], true);


   $html = "<ul class='yml-list'>";
   $total = 0;

   if ($opt['match'] == "true") {
      foreach ($rank as $post_ID => $points) {
         $total += $points;
      }
   }

   foreach ($rank as $post_ID => $points) {

      if ($opt['match'] == "true") {
         $match_calc = number_format(($points / $total) * 100, 0, ",", ".");
         $match = "(" . $match_calc . __("% match!", "you-may-like") . ")";
      } else {
         $match = "";
      }
      $html .= "<li class='yml-item'><a class='yml-link' href='" . get_the_permalink($post_ID) . "'>" . get_the_title($post_ID) . "</a> " . $match . "</li>";
   }

   $html .= "</ul>";

   return $html;
}
add_shortcode("you_may_like", "yml_related_posts");
