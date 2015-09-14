<?php
/*
Template Name: Showcase Page
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action('genesis_before_entry','msd_post_image');
add_action('genesis_after_header','msd_showcase_post_image');
add_shortcode('box','msdlab_box_shortcode_output');
add_filter('the_content','strip_empty_tags', 9999);
add_action('genesis_before_footer','msdlab_showcase_footer',5);
add_action('wp_footer','msdlab_showcase_jquery');

function msd_showcase_post_image(){
    global $post;
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $background = $featured_image[0];
    $ret = '<div class="banner" style="background-image:url('.$background.')"></div>';
    print $ret;
}

function msdlab_box_shortcode_output($args, $content){
    $content = do_shortcode($content);
    $content = trim_whitespace($content);
    return '<div class="box">'.$content.'</div>';
}

function msdlab_showcase_footer(){
    print '<div class="showcase-footer"><div class="wrap">';
    gravity_form( 2, true,true,false,null,true,1000,true );
    print '</div></div>';
}

function msdlab_showcase_jquery(){
   ?>
<script type="text/javascript">
var $=jQuery;
    equalheight = function(container){
    console.log(container);
    var currentTallest = 0,
         currentRowStart = 0,
         rowDivs = new Array(),
         $el,
         topPosition = 0;
     $(container).each(function() {
    
       $el = $(this);
       $($el).height('auto')
       topPostion = $el.position().top;
    
       if (currentRowStart != topPostion) {
         for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
           rowDivs[currentDiv].height(currentTallest);
         }
         rowDivs.length = 0; // empty the array
         currentRowStart = topPostion;
         currentTallest = $el.height();
         rowDivs.push($el);
       } else {
         rowDivs.push($el);
         currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
      }
       for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
         rowDivs[currentDiv].height(currentTallest);
       }
     });
    }

jQuery(window).load(function() {
  equalheight('.col-md-4');
  jQuery('.box').css('height',function(){
     return (jQuery(this).parent('.col-md-4').height() - 30) + "px"; 
  });
});


jQuery(window).resize(function(){
  equalheight('.col-md-4');
  jQuery('.box').css('height',function(){
     return (jQuery(this).parent('.col-md-4').height() - 30) + "px"; 
  });
});

        </script>
    <?php
}

genesis();
