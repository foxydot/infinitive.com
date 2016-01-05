jQuery(document).ready(function($) {	
	$('ul li:first-child').addClass('first');
	$('ul li:last-child').addClass('last');
	$('ul li:even').addClass('even');
	$('ul li:odd').addClass('odd');
	//Print Page
	$('.functions .print').click(function(){
		window.print();
	});
	//email page
		var sSubject = 'Infinitive';
		var sBody = escape('Hi,\nI recommend the following Infinitive information:\n\n '+location.href);
		var sItemURL = "mailto:?subject="+sSubject+"&body="+sBody;
		$('.functions .email').attr('href',sItemURL); 
		$('.functions .email').click(function(){
			window.location = $(this).attr('href');
		});
	//tracking for SEO WhitePaper
		$('.analytics #gform_1 #gform_submit_button_1').click(function(){
			_gaq.push(['_trackEvent', 'Form', 'Submit', 'Building the Foundation for Smart SEO']);
		});
});