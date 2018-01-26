jQuery(document).ready(function($) {
    $('main .publication-list li').each(function(){
        if($(this).innerHeight()>187){
            var pad = (($(this).innerHeight() - 187)/2)+10;
            $(this).find('.news-logo').css('padding-top',pad + 'px').css('padding-bottom',pad + 'px');
        }
    });
});