jQuery(document).ready(function($) {
	var numwidgets = $('#homepage-widgets section.widget').length;
	$('#homepage-widgets').addClass('cols-'+numwidgets);
	var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');
    $('#homepage-widgets section.widget .widget-wrap').equalHeightColumns();	
    
    $('.widget.msd_news_widget .widget-title i').addClass('fa-bullhorn');
    $('.widget.last-child .widget-title i').addClass('fa-star');
});