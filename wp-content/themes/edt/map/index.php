<!DOCTYPE html>
<html>
<head>
	<title>El Dorado Transit Map</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<link rel="stylesheet" href="map.css" />

	<base target="_parent" />

	<style type="text/css">
		html { height: 100% }
		body { height: 100%; margin: 0; padding: 0; font-family: helvetica, sans-serif;}
		#key {
			width:370px;
			height:100%;
			position: fixed;
			left: 0;
			float:left;
			padding:10px;
			overflow-y:scroll;
			overflow-x:none;
			margin-top: 165px;
			// background-color:rgba(156,186,239,0.8);
         }
        #map {
	      position:fixed;
	      right: 0;
	      bottom: 0;
	      width:72%;
	      height:100%;
         }
        td {padding:4px;}
		/* = MAP KEY ----------------------------------------------- */
        .keybox {
			position: absolute;
			bottom: 23px;
			right: 10px;
			padding: 10px 15px;
			background: #ffffff;
			background: rgba(255, 255, 255, 0.93);
			border-radius: 4px;
			z-index: 3;
		}

		.keybox h1 {
			font-size:1.1em;
		    padding:0;
		}

		.keybox ul {
		list-style:none;
		list-style-type:none;
		padding:0;
		}
		.keybox ul li {
			margin: 0 0 5px 0;
			list-style: none;
			font-size: .88em;
			color: #444444;
		}

		.keybox ul li img {
			width: 30px;
			margin: 0 10px 0 0;
		}
		
		.numberCircle {
			border-radius: 50%;
			/* behavior: url(PIE.htc); */ /* remove if you don't care about IE8 */

			width: 24px;
			height: 24px;
			padding: 5px;
	
			/* background: #fff; */
			/* border: 2px solid #666; */
			/* color: #666; */
			text-align: center;
	
			font: 20px Arial, sans-serif;
			font-weight:bold;
		}

    </style>

</head>

<body>

	<div id="map"></div>

	<?php
		require_once ('transit_map_parameters.php');
		require_once ('transit_map_core_setup.php');

		// if there are custom features & layers, insert those configuration files here
		require_once ('custom_layers/transit_map_custom_setup.inc.php');
	?>

	<div id='top-key'>
		<h1 class='services'>Routes</h1>
		<div id='select_all_routes' class='select-all-button' >Show All Routes</div>
		<div id='deselect_all_routes' class='select-all-button'>Hide All Routes</div>
		<div class='instructions instructions-first'>Scroll to see all routes<br/>Click a numbered circle to zoom in on that route.
		<br/>Routes operate Monday through Saturday unless noted otherwise.</div>
<!-- 		<div class='instructions'>Click a magnifying glass to zoom in on that route. <span class="search-icon"></span></div> -->
	</div>


<script>

var landmarks_status_array = new Array(0,0,0,0,0);

function toggle_landmark_layer(layer_id) {

    if (landmarks_status_array[layer_id] == 0) {
    	console.log('landmarks_status_array[layer_id] == 0');
        load_landmarks(layer_id);
        landmarks_status_array[layer_id] = 1;

        for (var i = 0; i < landmarks_status_array.length; i++) {
			if (i !== layer_id) {landmarks_status_array[i] = 0;}
		}


    } else {
        landmarks_status_array[layer_id] = 0;
        remove_landmarks(layer_id);
        console.log('remove_landmarks('+layer_id+')');
		add_base_tile_layer();
    }
}


</script>


<div id='bottom-key'>
		<div class="filter-icon" id="toggle-bike" onclick="toggle_landmark_layer(0);">
			<img src="icons/SCT_BikeRack.png" width="36" height="36">
			<span>Bike & Hike</span>
		</div>
	</div>




<div id="key">
		<?php
/* BEGIN making the route rows on the left of the page. */
/* Note: I need to add back in route_ids for some of the connected routes */
//agency_id	route_id(array)	Days of Service	Quadrant	Shortname	longname	color	text-color	URL	route_id
		$routeInfo =
"261;1963;;;;Diamond Springs;F7A6C9;FFFFFF;;1963
261;1964;;;;Cameron Park;FA985B;FFFFFF;;1964
261;1968;;;;50 Express;2A2A2A;FFFFFF;;1968
261;1961;;;;Pollock Pines;00801F;FFFFFF;;1961
261;1965;;;;AM Commuter;00245D;FFFFFF;;1965
261;1962;;;;Placerville;345B8A;FFFFFF;;1962
261;1966;;;;PM Commuter;00245D;FFFFFF;;1966
261;1967;;;;Reverse Commuter;008470;FFFFFF;;1967
261;1970;;;;Saturday Express;B2508F;FFFFFF;;1970";


// 175;[1029,1051];Monday - Sunday;East;30;Santa Rosa, Sonoma Valley;7238;ffffff;http://www.sctransit.com/maps-schedules/route-30/;1051

// http://jsfiddle.net/thirtydot/dQR9T/2637/
// http://css3pie.com

// this text can be generated from the routes xls file, exporting as tab separated list then find replace tabs with semicolons.
// https://docs.google.com/spreadsheet/ccc?key=0ArkC-1z7T8ujdFl0dFU2YTJ6aTR2azNERVROWWU4Y2c&usp=drive_web#gid=0
		$routeLines = explode("\n",$routeInfo);

		$routes = array();

		foreach($routeLines as &$routeLine) {
			$explodedLine = explode(";", $routeLine);

				array_push($routes, $explodedLine);
		}


		// if (!isset($_GET['routes_array'])) {$routes_initial = $routes_array;}
		// var_dump($routes_initial);

		function makeRoutes($routes) {
			foreach($routes as &$routeLine) {
				
				$selected = "";
				
				if (isset($_GET['routes'])) {
				
				$route_ids = json_decode($routeLine[1]);
				
				if (is_array($route_ids)) {$route_ids_to_loop = $route_ids;} else {$route_ids_to_loop = array($route_ids);}
				
				foreach($route_ids_to_loop as &$test_for_route_id) {
				
				if ($test_for_route_id == $_GET[routes])
					{$selected = "selected";
					}
				}
				
				} else { $selected = "selected";}
				
				
				
// 				$route_ids = json_decode($routeLine[1]);
// 				
// 				if (is_array($route_ids)) {$route_ids_to_loop = $route_ids;} else {$route_ids_to_loop = array($route_ids);}
// 				
// 				// var_dump($route_ids_to_loop);
// 				
// 				foreach($route_ids_to_loop as &$test_for_route_id) {
// 				echo 'testing for '.$test_for_route_id.'<br/>';
// 				echo 'in_array: ';
// 				var_dump(in_array($test_for_route_id, $routes_initial));
// 				if (array_search($test_for_route_id, $routes_initial))
// 					{	// echo "it's in the initial array.";
// 						$selected = "selected";
// 						// break;
// 					}
// 				}
// 				// var_dump((int)$routeLine[9]);
				
				?>
				<div class="fancy-route-row <?php echo $selected ?> " style="display:block;" rel="<?php echo $routeLine[1]; ?>" onmouseover="highlight_route_alignment(<?php echo $routeLine[1]; ?>)" onmouseout="unhighlight_route_alignment(<?php echo $routeLine[1]; ?>)" onclick="focus_routes(<?php echo $routeLine[1]; ?>);load_stop_markers();remove_route_activation_highlight();activate_route_highlight(this );">
				<div class="numberCircle" style="background-color:#<?php echo $routeLine[6]; ?>;color:#<?php echo $routeLine[7]; ?>" class="route-icon"><?php echo $routeLine[4]; ?></div>
				<div class="title" style="margin-top:0px;">
					<?php if ($routeLine[5] != '') { ?><span class="text"><?php echo $routeLine[5]; ?></span>
					<br /><?php }?>
					<span class="route-row-days"><?php echo $routeLine[2]; ?></span>
				</div><!-- end .title -->
				<a href="<?php echo $routeLine[8]; ?>">View Schedule</a>
				<!-- <div class="search-icon"></div> -->
				<input type="checkbox"  name="route_checkboxes" id="<?php echo $routeLine[1]; ?>" value="<?php echo $routeLine[1]; ?>" checked="checked" style="display: none;"></div>

			<?php
			}

		}

		makeRoutes($routes);


	/* END making the route rows on the left of the page. */
?>
</div>


<!--	<div id="landmarks_key" style='display: none;'>
		<form name="landmarks_layers">


		<table border="0">
			<tr>
				<td><input type="checkbox" id="bikeRack" value="0" onclick="toggle_landmark_layer(this.value,this.checked);" /></td>
				<td><img src="icons/SCT_BikeRack.png" width="36" height="36"/>Bike Rack Locations</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="parknRide" value="1" onclick="toggle_landmark_layer(this.value,this.checked);" /></td>
				<td><img src="icons/SCT_Parking.png" width="36" height="36"/>Park and Ride</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="retail" value="2" onclick="toggle_landmark_layer(this.value,this.checked);"/ ></td>
				<td><img src="icons/SCT_PassSales.png" width="36" height="36"/>Pass Sales Outlets</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="transitCenter" value="3" onclick="toggle_landmark_layer(this.value,this.checked);"/ ></td>
				<td><img src="icons/SCT_TransitCenter.png" width="36" height="36"/>Transit Centers</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="transitAndTrails" value="4" onclick="toggle_trails_layer(this.checked);"/ ></td>
				<td><img src="icons/SCT_TransitTrails.png" width="36" height="36"/>Transit to Trails</td>
			</tr>

		</table>

	</form>
	</div>

	-->

	</div>

	<?php

	// require any customized plug-ins
	// require_once ('custom_layers/transit_map_custom_parameters.js');
	require_once ('custom_layers/transit_map_custom.inc.php');
	require_once ('custom_layers/transit_map_custom_config.js');
	// require_once ('outdoor/outdoor-setup.js');

	require_once ('transit_map_core_initialize.js');
	?>
	
	<script type="text/javascript" src="outdoor/outdoor-setup.js"></script>

<script>
	function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function activateRouteByNameString(route_name) {
		$('.route-icon').each( function(i,val) {
			if($(val).attr('class').replace(/[A-Za-z]|-|\s/g, '') == route_name.replace(/[A-Za-z]|-|\s/g, '')) {
				$(val).trigger('click');
				//return false;
			}
		});
	}

	var site_url = getParameterByName('site_url');

	function sizeKey() {
		var mapHeight = $("#map").height();
		var key = $('#key');
		var new_key_height = mapHeight - 270;
		key.height(new_key_height);
	}

	function sizeMap() {
		$('#map').width( $(window).width() - $('#key').width() );
	}
	
	function remove_route_activation_highlight() {
			$('.fancy-route-row.selected').removeClass('selected');
		}
		
	function activate_route_highlight(the_div) {
		$(the_div).addClass('selected');
	}

	var setupPrettyStuff = function() {
		$('document').ready( function(){
			


			$('#select_all_routes').click( function() {
				$('.fancy-route-row:not(.selected)').addClass('selected');
				activate_all_routes();
			});
						
			$('#deselect_all_routes').click( function() {
				remove_route_activation_highlight();
				deactivate_all_routes();
			});

			

			//setup landmark filters
			$('.filter-icon').click( function(e) {
				var el = $(e.target);
				if( !$(e.target).hasClass('filter-icon') ) {
					el = $(e.target).closest('.filter-icon');
				}
				el.toggleClass('selected');

				var bottom_key_elements = $( "#bottom-key" ).children();
				bottom_key_elements.not(el).removeClass('selected');

			})

			/*$('#routes_list table td a').each( function(i,val) {
			var row_placeholder = $('#fancy-row-template').clone().removeAttr('id');
				var route_val = $(val).html().replace(/\s/g, '');
				row_placeholder.attr('onmouseover', $(val).closest('td').attr('onmouseover'));
				row_placeholder.attr('onmouseout', $(val).closest('td').attr('onmouseout'));
				row_placeholder.attr('onclick', $(val).attr('onclick'));
				row_placeholder.find('.route-icon').addClass('route-' + route_val + '-small');
				row_placeholder.find('.text').html($(val).closest('td').next().html());
				row_placeholder.addClass('selected');
				var route_id = $(val).attr('href').replace('#','');


				if(row_placeholder.find('.text').html().length > 50)
					row_placeholder.find('.title').addClass('double');


				site_url = site_url.substr(0,site_url.indexOf('?') != -1 ? site_url.indexOf('?') : site_url.length);
				// set link
				if(route_val.replace(/[A-Za-z]/g, '') != '12' && route_val.replace(/[A-Za-z]/g, '') != '14' && route_val.replace(/[A-Za-z]/g, '') != '44' && route_val.replace(/[A-Za-z]/g, '') != '48')
					row_placeholder.find('a').attr('href', site_url + '/maps-schedules/route-' + route_val)

				if(route_val.replace(/[A-Za-z]/g, '') == '12' || route_val.replace(/[A-Za-z]/g, '') == '14')
					row_placeholder.find('a').attr('href', site_url + '/maps-schedules/route-12-route-14')

				if(route_val.replace(/[A-Za-z]/g, '') == '44' || route_val.replace(/[A-Za-z]/g, '') == '48')
					row_placeholder.find('a').attr('href', site_url + '/maps-schedules/route-44-route-48')


				$('#routes_list').before(row_placeholder);



			});*/

/*
			$('.fancy-route-row').each( function( i, val ) {
				$(val).addClass('selected');
				var val_a = $(val).find('a');
				$(val_a).parent().parent().find('input').each( function(i,val_input) {
					$(val_input).attr('style','display: block; position:fixed; top: -1000px');
				});
				// replace href attrs
				// $(val_a).attr('href', $(val_a).attr('href').replace('sctransit.com', '74.85.244.50/~sct'));
				val = $(val);
				if(val.find('.text').html().length > 50)
					val.find('.title').addClass('double');

				$(val).attr('onclick','');

			});
*/

/*

			$('.fancy-route-row').click(function(e) {

					var routeID = $(this).attr('rel');
					//alert(routeID);

					focus_routes(routeID);
					load_stop_markers();



				if( e.target.nodeName != "A" && e.target.nodeName != 'INPUT') {
				 if( $(e.target).hasClass('search-icon') ) {
					el = $(e.target);
					if( !$(e.target).hasClass() )
						el = $(e.target).closest('.fancy-route-row');
					if(routes_active.length > 0) {
						var route_id = parseInt(el.find('input').attr('id'));
					 	change_map_bounds(route_id);
					}
				 } else {
					var el = $(e.target);
					if( !$(e.target).hasClass() )
						el = $(e.target).closest('.fancy-route-row');

					var route_id = parseInt(el.find('input').attr('id'));
					if( el.hasClass('selected') ) {
						// we are unselectiung
						el.find('input')[0].checked = false;
					} else {
						change_map_bounds(route_id);
						el.find('input')[0].checked = true;
					}
				 	el.toggleClass('selected');
					toggle_route( el.find('input')[0] );
				 }

				 } else if (e.target.nodeName != 'INPUT') {
				 	if(window.parent != null)
				 		window.parent.location = $(e.target).attr('href');
				 	e.stopPropagation();
				 }

			});
			*/

			$('#fancy-row-template').remove();

			//let's load the map with preselected routes
			//this needs to be changed to automatically affect which routes are highlighted
			var routes_preload_raw = getParameterByName('preselected');
			if(routes_preload_raw != '') {
			  if( routes_preload_raw.split(',').length > 1  ) {
			  	for(var i=0; i<routes_preload_raw.split(',').length; ++i) {
			  		focus_routes(routes_preload_raw.split(',')[i]);
			  	}
			  } else {
					focus_routes(routes_preload_raw);
			  }
			}



		});
	};


	setupPrettyStuff();

$(document).ready(function () {
	sizeMap();
	sizeKey();
    $(window).resize(function() {
		sizeMap();
		sizeKey();
    });
});



</script>

</body>
</html>
