// single-route.js

jQuery(document).ready(function($) {

	$('.timetable-banner').click(function() {
		$(this).parent().find('#timetable-content').slideToggle(200);
		$(this).toggleClass('expanded');
		if($(this).hasClass('expanded')) {
			$(this).parent().find('span').text('(Click to minimize)');
		} else {
			$(this).parent().find('span').text('(Click to expand)');
		}
	});



});