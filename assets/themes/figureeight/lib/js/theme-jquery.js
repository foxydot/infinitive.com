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

	$('.nav-footer ul.menu>li').after(function(){
		if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!='none'){
			return '<li class="separator">|</li>';
		}
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
});