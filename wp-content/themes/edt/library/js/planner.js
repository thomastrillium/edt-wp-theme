jQuery(document).ready(function($) {

	$('#expand-planner-button').on('click touchend', openPlanner);
	$('#start-location').on('click touchstart', openPlanner);
	
	

	
});

function openPlanner() {
	 $('#expand-planner-button').parent().addClass('expanded');
	$('#home-map-inner').addClass('moved-down');
	$('.expanded #expand-planner-button').on('click touchend', closePlanner);
};
function closePlanner() {
	 $('#expand-planner-button').parent().removeClass('expanded');
	$('#home-map-inner').removeClass('moved-down');
	$('#expand-planner-button').on('click touchend', openPlanner);
};
	