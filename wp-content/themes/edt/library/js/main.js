
var $hoverRoute;
var $hoverRouteObjs;
var $hoverStroke;
jQuery(document).ready(function($) {

//	$('polygon, line, polyline').css('stroke-width','70px');
	$('polygon, line, polyline').on('click', function() {
		//$(this).css('stroke-width','100px');
		//$(this).attr('filter',"url(#f3)");
	//	$(this).parentNode.appendChild(el);
	});
	
	$('polygon, line, polyline').on('mouseenter', function() {
		//$(this).css('stroke-width','40px');
	});
	
	$('#hovers_1_').find('polygon, path').on('mouseenter click', function() {
		var routeName = $(this).attr('id').split('_')[0];
		//console.log(routeName);
		var $routeGroups = $('#paths-expanded > g');
		$.each($routeGroups, function(i, val) {
			//console.log($(val).attr('id'));
			if($(val).attr('id').indexOf(routeName) !== -1)
			{
				var $potentialObjs = $(val).find('polygon, line, polyline, path');
				$potentialObjs.attr('filter','url(#f1)');
				$hoverRouteObjs = $potentialObjs;
				/*$.each($potentialObjs,function(k, v) {
					console.log($(v).attr('fill'));
					if( $(v).attr('fill') === '#FFFFFF') {
						 $(v).css('stroke-width','10px');
						 $(v).css('stroke','white');
						 $hoverStroke = $(v);
					}
				});*/
				$hoverRoute = $(val);
				$hoverRoute.toggleClass('route-hover');
			}
		});
	}).on('mouseout mouseleave', function() {
		if($hoverRouteObjs) {
			$hoverRouteObjs.attr('filter','url()');
			//$hoverRoute.toggleClass('route-hover');
			//$hoverStroke.css('stroke','none');
		}
	});
});