jQuery(document).ready(function() {
	jQuery('.pluginbuddy_tip').tooltip({ 
		track: true, 
		delay: 0, 
		showURL: false, 
		showBody: " - ", 
		fade: 250 
	});
});

jQuery(document).on('click', '.thumbnail', function(event) {
	jQuery('.attachment-details label').each(function(){
		if ( 'description' == jQuery(this).attr('data-setting') )
			jQuery(this).children('span').text('Image Link');
	});
});