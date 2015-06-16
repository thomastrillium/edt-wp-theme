var hoverObjs = [];
var floatingMap= false;
var origMapHeight;
var mapX ,
	mapY ,
	mapW ,
	mapH ;
	
var mapXTarg ,
	mapYTarg ,
	mapWTarg ,
	mapHTarg ;
	
var origMapX ,
	origMapY ,
	origMapW ,
	origMapH ;
	
var routeBounds;

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
	
	var paddingX = -60,
		paddingY = -60,
		paddingW = 120,
		paddingH = 120;
		
	mapXTarg = bounds.x+paddingX;
	mapYTarg = bounds.y+paddingY;
	mapWTarg = bounds.width+paddingW;
	mapHTarg = bounds.height+paddingH;
	
}

function resetMapBounds() {

	mapXTarg = origMapX;
	mapYTarg = origMapY;
	mapWTarg = origMapW;
	mapHTarg = origMapH;

}

function updateMap() {
	
	var smoothing = 10;
	mapX += (mapXTarg-mapX)/smoothing;
	mapY += (mapYTarg-mapY)/smoothing;
	mapW += (mapWTarg-mapW)/smoothing;
	mapH += (mapHTarg-mapH)/smoothing;
	
	$('#home-map svg')[0].setAttribute('viewBox',Math.round(mapX)+' '+
												 Math.round(mapY)+' '+
												 Math.round(mapW)+' '+
												 Math.round(mapH));
	
}



jQuery(document).ready(function($) {


	mapX = mapXTarg = origMapX = parseFloat($('#home-map svg')[0].getAttribute('viewBox').split(' ')[0]);
	mapY = mapYTarg = origMapY = parseFloat($('#home-map svg')[0].getAttribute('viewBox').split(' ')[1]);
	mapW = mapWTarg = origMapW = parseFloat($('#home-map svg')[0].getAttribute('viewBox').split(' ')[2]);
	mapH = mapHTarg = origMapH = parseFloat($('#home-map svg')[0].getAttribute('viewBox').split(' ')[3]);
	console.log(mapX,mapY,mapW,mapH);



	if (navigator.userAgent.match(/iPad;.*CPU.*OS 7_\d/i)) {
    	$('html').addClass('ipad ios7');
	}

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || $(window).width()<800 ) {
 		// some code..
 		var routeNames = [
							"commuter",  
							"placerville", 
							"cameron-park", 
							"50X",
							"pollock-pines",
							"diamond-springs"
 						 ];
 						  
 		routeBounds = [];
 		
 		for(var i = 0; i<routeNames.length; i++) {
 			var $routePath = $('#solid-overs ').find('*[id*='+routeNames[i]+']');
 			routeBounds.push($routePath[0].getBBox());
 			
 		};
 						  
 		console.log(routeNames);
 		

	
	var distance = $('#home-map').offset().top,
    $window = $(window);
    var mapPadding = 0;
    
   
    origMapHeight = $('#home-map-inner').height();
	$('#home-map-spacer').css('height',$('#home-map-inner').height());
	$('#home-map').css('height',origMapHeight);
	var mapScrollArea = $('#home-map-spacer').height()/1.5;
	 var mapScrollPieceSize = $('#map-legend li:first').outerHeight();
	 var paddingBetweenMapAndLegend = parseInt($('#map-legend').css('margin-top').replace('px',''));
	 $('#home-map svg').attr('height',origMapHeight);
	//$('#home-map svg').attr('height',origMapHeight);
	//$('#home-map svg').attr('width',$('#home-map').width());
	
	$window.scroll(function() {
		var found = false;
		var above = false;
		hideHighlights();
		for(var i = 0; i<routeNames.length; i++) {
			if ( $window.scrollTop() >= (distance + paddingBetweenMapAndLegend -mapPadding+(i*mapScrollPieceSize)) &&  $window.scrollTop() < distance+paddingBetweenMapAndLegend-mapPadding+((i+1)*mapScrollPieceSize)) {
				setMapBounds(routeBounds[i]);
				showHighlight(routeNames[i]);
				found = true;
				//$('#home-map-spacer').css('height', 10000);//$window.scrollTop() - 	distance + origMapHeight);
				$('#home-map svg').attr('height',origMapHeight);
				$('#home-map svg').attr('width',$('#home-map').width());
				$('#home-map-inner').css('opacity',1);
			} else if ($window.scrollTop() > distance+paddingBetweenMapAndLegend-mapPadding+((i+1)*mapScrollPieceSize)) {
				$('#home-map-inner').css('opacity',0);
				above = true;
			} else {
				$('#home-map-inner').css('opacity',1);
			}	
		}
		
		if(found || ($window.scrollTop() >= distance && $window.scrollTop() < distance + mapScrollArea)){
			$('#home-map').addClass('top-fixed');
			$('#planner-holder').addClass('hidden'); 
		} else if(!above){
			$('#home-map').removeClass('top-fixed');
			$('#planner-holder').removeClass('hidden'); 
		}
		if(!found && !above) {
			
			
			floatingMap = false;	
			//$('#home-map svg').removeAttr('height');
			//$('#home-map svg').removeAttr('width');		
			//$('#home-map').css('height',origMapHeight);
			//$('#home-map-spacer').css('height', 0)			
			//$('#home-map svg').attr('height',origMapHeight);
			$('#stroke-paths').css('opacity',1);
			$('#paths-expanded').css('opacity',1);
			resetMapBounds();
		} else {
			
			floatingMap = true;
			$('#stroke-paths').css('opacity',.3);
			$('#paths-expanded').css('opacity',.3);
			
		}
	});
 		
 		// find hiegh of top of map
 		//$('#').offset().top 
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
	
	$('#hovers_1_').find('polygon, path').on('click', function() {
	
		if(!floatingMap){
			var routeName = $(this).attr('id').split('_')[0];
			var getUrl = window.location;
			window.location = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + '/routes/'+routeName;
		}
		
	});
	
	 window.setInterval(function() {
  		updateMap();
	}, 13);
	
});

