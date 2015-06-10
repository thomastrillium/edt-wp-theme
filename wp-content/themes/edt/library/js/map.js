var hoverObjs = [];
var floatingMap= false;
var origMapHeight;
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


function setMapBounds(bounds) {
	$('#home-map svg')[0].setAttribute('viewBox','');
	
	
	//// need to find contrained bounds
	//var maXWidthOverW =MaxWidth/w;
	//var maxHeightOverH = MaxHeight/h;
	//if(MaxWidth/w < MaxHeight/h) {
//		var newW = 
	//} 
	var paddingX = -40,
		paddingY = -40,
		paddingW = 80,
		paddingH = 80;
	$('#home-map svg')[0].setAttribute('viewBox',(bounds[0]+paddingX)+' '+(bounds[1]+paddingY)+' '+(bounds[2]+paddingW)+' '+(bounds[3]+paddingH));
}

function resetMapBounds() {
	$('#home-map svg')[0].setAttribute('viewBox','0 0 3030 1274.9');
}



jQuery(document).ready(function($) {

	//if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 		// some code..
 		var routeNames = [
							["commuter",[293, 444, 1998, 456]], 
							["placerville",[1864, 342, 438, 449]], 
							["cameronpark",[1317, 444, 285, 367]], 
							["fiftyX",[764, 457, 1200, 370]],
 						    ["pollockpines",[1914, 235, 821, 537]],
 						    ["diamondsprings",[1766, 440, 419, 603]]
 						  ];
 						  
 		console.log(routeNames);
 		

	
	var distance = $('#home-map').offset().top,
    $window = $(window);
    var mapPadding = 0;
    var mapScrollArea = 400;
    var mapScrollPieceSize = mapScrollArea/routeNames.length;
    origMapHeight = $('#home-map').height();
	
	$('#home-map').css('height',origMapHeight);
	//$('#home-map svg').attr('height',origMapHeight);
	//$('#home-map svg').attr('width',$('#home-map').width());
	
	$window.scroll(function() {
		var found = false;
		hideHighlights();
		for(var i = 0; i<routeNames.length; i++) {
			if ( $window.scrollTop() >= (distance-mapPadding+(i*mapScrollPieceSize)) &&  $window.scrollTop() < distance-mapPadding+((i+1)*mapScrollPieceSize)) {
				setMapBounds(routeNames[i][1]);
				showHighlight(routeNames[i][0]);
				console.log('200!!!!!: '+routeNames[i][1][0]);
				found = true;
				$('#home-map-spacer').css('height', 10000);//$window.scrollTop() - 	distance + origMapHeight);
				$('#home-map svg').attr('height',origMapHeight);
			//	$('#home-map svg').attr('width',$('#home-map').width());
			}
		}
		if(!found) {
			resetMapBounds();
			$('#home-map').removeClass('top-fixed');
			floatingMap = false;	
			$('#home-map svg').removeAttr('height');
			$('#home-map svg').removeAttr('width');		
			$('#home-map').css('height',origMapHeight);
			$('#home-map-spacer').css('height', 0)
			//$('#home-map svg').attr('height',origMapHeight);
			$('#stroke-paths').css('opacity',1);
			$('#paths-expanded').css('opacity',1);
		} else {
			$('#home-map').addClass('top-fixed');
			floatingMap = true;
			$('#stroke-paths').css('opacity',.3);
			$('#paths-expanded').css('opacity',.3);
		}
	});
 		
 		// find hiegh of top of map
 		//$('#').offset().top 
	//}
	
	


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
		if(!floatingMap){
			var routeName = $(this).attr('id').split('_')[0];
			//console.log(routeName);
			showHighlight(routeName);
		}
		
	}).on('mouseout mouseleave', function() {
		if(!floatingMap){
			hideHighlights();
		}		
	});
	
	
	// set up table/mobile map scroll behavior
	
/*	var $map = $("svg").svgPanZoom(
		{options:{limits: { // the limits in which the image can be moved. If null or undefined will use the initialViewBox plus 15% in each direction
			x: 0,
			y: 0,
			x2: 900,
			y2: 600
   		 }}});
	var zoomElem = $('fiftyX_x5F_1_2_');
	$map.setViewBox(100, 100, 400, 400, 1);*/
	
});

