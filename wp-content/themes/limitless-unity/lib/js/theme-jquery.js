jQuery(document).ready(function($) {	
    $('ul li:first-child').addClass('first-child');
    $('ul li:last-child').addClass('last-child');
    $('ul li:nth-child(even)').addClass('even');
    $('ul li:nth-child(odd)').addClass('odd');
	$('table tr:first-child').addClass('first-child');
	$('table tr:last-child').addClass('last-child');
	$('table tr:nth-child(even)').addClass('even');
	$('table tr:nth-child(odd)').addClass('odd');
	$('tr td:first-child').addClass('first-child');
	$('tr td:last-child').addClass('last-child');
	$('tr td:nth-child(even)').addClass('even');
	$('tr td:nth-child(odd)').addClass('odd');
    $('div:first-child').addClass('first-child');
    $('div:last-child').addClass('last-child');
    $('div:nth-child(even)').addClass('even');
    $('div:nth-child(odd)').addClass('odd');
    $('section:first-child').addClass('first-child');
    $('section:last-child').addClass('last-child');
    $('section:nth-child(even)').addClass('even');
    $('section:nth-child(odd)').addClass('odd');


	$('#footer-widgets div.widget:first-child').addClass('first-child');
	$('#footer-widgets div.widget:last-child').addClass('last-child');
	$('#footer-widgets div.widget:nth-child(even)').addClass('even');
	$('#footer-widgets div.widget:nth-child(odd)').addClass('odd');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	
	$('#blog-header').click(function(){
	    window.location.href = '/hot-topics/blog/';
	});
	
	//special for lifestyle
	$('.ftr-menu ul.menu>li').after(function(){
		if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!='none'){
			return '<li class="separator">|</li>';
		}
	});
	
	//bootstrap
    $('.site-inner').addClass('container');
    //$('.wrap').addClass('row');
    $('.content-sidebar .content-sidebar-wrap').addClass('row');
    $('.content-sidebar .content').addClass('col-md-8 col-sm-12');
    $('.content-sidebar .sidebar').addClass('col-md-4');
    
    //icons
    $('.menu li[class*="icon-"]>a').prepend('<i></i>');
    $('.widget .widget-title').append('<i class="fa fa-lg"></i>');
    $('.widget.featured-content .widget-title i').addClass('fa-rss');
    $('#case-study.widget .widget-title i').addClass('fa-file-text');
    $('.widget.widget_pluginbuddyvideoshowcase .widget-title i').addClass('fa-youtube-play');
    
    //nav
    $('.nav-secondary .menu-item .sub-menu').wrap('<div class="subnav-wrapper"></div>');
	
});

jQuery(document).ready(function(){

/*RESPONSIVE NAVIGATION, COMBINES MENUS EXCEPT FOR FOOTER MENU*/

    jQuery('.menu-primary, .menu-secondary').wrap('<div id="nav-response" class="nav-responsive">');
    jQuery('header.site-header').after('<div id="mobile-nav"><a href="#" id="pull"><strong>MENU</strong></a></div>');  
    
    //combinate
    sf_duplicate_menu( jQuery('.nav-responsive>ul'), jQuery('#mobile-nav #pull'), 'mobile_menu', 'sf_mobile_menu' );
                
    function sf_duplicate_menu( menu, append_to, menu_id, menu_class ){
        var jQuerycloned_nav;
        
        menu.clone().attr('id',menu_id).removeClass().attr('class',menu_class).appendTo( append_to );
        jQuerycloned_nav = append_to.find('> ul');
        jQuerycloned_nav.find('.menu_slide').remove();
        jQuerycloned_nav.find('li:first').addClass('sf_first_mobile_item');
        
        append_to.addClass('closed');
        jQuerycloned_nav.slideUp( 500 );
        
        append_to.click( function(){
            if ( jQuery(this).hasClass('closed') ){
                jQuery(this).removeClass( 'closed' ).addClass( 'opened' );
                jQuerycloned_nav.slideDown( 500 );
            } else {
                jQuery(this).removeClass( 'opened' ).addClass( 'closed' );
                jQuerycloned_nav.slideUp( 500 );
            }
            return false;
        } );
        
        append_to.find('a').click(function(){
            if ( jQuery(this).hasClass('opened') ){
                jQuery(this).removeClass( 'opened' ).addClass( 'closed' );
                jQuery(this).next('.sub-menu').slideUp( 500 );
            } else {
                if(jQuery(this).attr('href')!='#'){
                    window.location.replace(jQuery(this).attr('href'));
                } else {
                    jQuery(this).removeClass( 'closed' ).addClass( 'opened' );
                    jQuery(this).next('.sub-menu').slideDown( 500 );
                }
            }
            return false;
        } );
        
        append_to.find('a').click( function(event){
            event.stopPropagation();
        } );
    }
});