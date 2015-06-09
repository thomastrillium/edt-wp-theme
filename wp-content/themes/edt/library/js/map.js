var hoverObjs = [];
//var $hoverStroke;
function showHighlight(routeName) {

	var $routeGroups = $('#path-highlights > path, #path-highlights > g,#solid-overs > g, #solid-overs >path');
		
	$.each($routeGroups, function(i, val) {
		//console.log($(val).attr('id') + ' comp to: ' + routeName);
		if($(val).attr('id').indexOf(routeName) !== -1)
		{
			var $potentialObjs = $(val).find('polygon, line, polyline, path');
			
			//$potentialObjs.attr('filter','url(#f1)');
			 //$potentialObjs.css('stroke-width','30px');
			 //$potentialObjs.css('stroke','white');
			 $potentialObjs.css('opacity','1');
							  
			 hoverObjs.push($potentialObjs);
			 hoverObjs.push($(val));
			 
			 $.each(hoverObjs, function(k, hoverItem) {
			
					$(hoverItem).css('opacity','1');
				
			});
			 
		
		}
	});

}

function hideHighlights() {

	if(hoverObjs.length > 0) {

			$.each(hoverObjs, function(k, hoverItem) {
				console.log('clearing: '+ hoverItem.attr('id'));
//				 $(hoverItem).css('stroke-width','10px');
				 $(hoverItem).css('opacity','0');
			});

			hoverObjs = [];
		}
		

}  

jQuery(document).ready(function($) {

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 		// some code..
	}


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
		showHighlight(routeName);
		
	}).on('mouseout mouseleave', function() {
		hideHighlights();
	});
});

