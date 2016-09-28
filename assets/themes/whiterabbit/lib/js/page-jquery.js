jQuery(document).ready(function($) {    
    //do some nifty stuff for the menu
    $('.widget_advanced_menu .menu>li.current-menu-item,.widget_advanced_menu .menu>li.current-menu-ancestor').addClass('open');
    $('.widget_advanced_menu .menu>li').prepend(function(){
        if($(this).hasClass('menu-item-has-children')){
            if($(this).hasClass('open')){
                return '<i class="fa fa-minus"></i>';
            } else {
                return '<i class="fa fa-plus"></i>';
            }
        } else {
            return '';
        }
    });
    $('.widget_advanced_menu .menu>li>i').click(function(){
        var old = $('.widget_advanced_menu .menu>li.open');
        var cur = $(this).parent();
        old.removeClass('open').find('i').removeClass('fa-minus').addClass(function(){
            if($(this).parent().hasClass('menu-item-has-children')){
                return 'fa-plus';
            }
        });
        cur.addClass('open').find('i').removeClass('fa-plus').addClass(function(){
            if($(this).parent().hasClass('menu-item-has-children')){
                return 'fa-minus';
            }
        });
    });
});