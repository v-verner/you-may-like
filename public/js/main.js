jQuery(document).ready(function ($) {
   // Function to get the value of the cookie
   function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for (var i = 0; i < ca.length; i++) {
         var c = ca[i];
         while (c.charAt(0) == ' ') {
            c = c.substring(1);
         }
         if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
         }
      }
      return "";
   }

   // Variables passed by the enqueue function
   var days_expiration = yml_params.days_expiration;
   var post_tags =  JSON.parse(yml_params.post_tags);

   // Workers
   if( ! getCookie("yml-post_tags")){
      var yml_tags = {};
   } else {
      var yml_tags = JSON.parse(getCookie("yml-post_tags"));
   }
   var yml_tags_update = {};

   $.each(post_tags, function( index, value ) {
      if( value in yml_tags ){
         yml_tags_update[value] = yml_tags[value] + 1;
      } else {
         yml_tags_update[value] = 1;
      }
   });

   $.each(yml_tags, function( index, value ) {
      if( ! ( index in yml_tags_update ) ){
         yml_tags_update[index] = value;
      }
   });

   var d = new Date();
   d.setTime(d.getTime() + (days_expiration * 24 * 60 * 60 * 1000));
   var expires = "expires="+d.toUTCString();
   document.cookie = "yml-post_tags=" + JSON.stringify(yml_tags_update) + ";" + expires + ";";
});