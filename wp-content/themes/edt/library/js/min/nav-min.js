// main nav

jQuery(document).ready(function($) {
	
	$('.menu-main-nav-container ul li').hover(function() {
		var svgName = $(this).find('svg').attr('rel');
		console.log('svgName: '+ svgName);
	});

});

