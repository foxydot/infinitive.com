jQuery(document).ready(function($) {	
    $('p:empty').remove();
    $('body *:first-child').addClass('first-child');
    $('body *:last-child').addClass('last-child');
    $('body *:nth-child(even)').addClass('even');
    $('body *:nth-child(odd)').addClass('odd');
    $('body').css('opacity','1');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	$.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      });
	
	$('.section.expandable .expand').click(function(){
	    var target = $(this).parents('.section-body').find('.content');
	    console.log(target);
	    if(target.hasClass('open')){
            target.removeClass('open');
            $(this).html('MORE <i class="fa fa-angle-down"></i>');
	    } else {
	        target.addClass('open');
	        $(this).html('LESS <i class="fa fa-angle-up"></i>');
	    }
	});
    if ( $( '.genesis-teaser' ).length ) {
       $('.genesis-teaser').equalHeightColumns();
       }
    if ( $( '.equalize' ).length ) {
       $('.equalize').equalHeightColumns();
       }
       
       
    var preheaderheight = $(".pre-header").outerHeight();
    var headerheight = $(".site-header").outerHeight();
    if($( window ).width() > 480){
        $(".pre-header").sticky();
        $(".site-header").sticky({topSpacing:preheaderheight});
    } else {
        $(".site-header").sticky();
    }
    

    $(window).scroll(function() {
       if($(window).scrollTop() == 0) {
           $(".sticky-wrapper").css('height','auto');
       }
    });

    //internal soft scroll
    $('a[href^="#"]').click(function(){
        var target = $(this.hash);
        var headerheight = $(".site-header").outerHeight();
        $('html,body').animate({
            scrollTop: target.offset().top - (headerheight + 20)
        }, 1000);
        return false;
    });

    if ( $( '.section-content .box.eq' ).length ) {
        $('.section-content .box.eq').equalHeightColumns();
    }
});