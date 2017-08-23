jQuery(document).ready(function($) {    
   $('textarea').blur(function(){
       var content = $(this).val();
       var regexp = /href="([(?!https?:\/\/)|(\#)].*)"/i;
       var matches_array = content.match(regexp);
       if(matches_array.length > 0){
          // alert('You have links that start without http(s):// or #. Did you mean to do this?');
       }
   });
});