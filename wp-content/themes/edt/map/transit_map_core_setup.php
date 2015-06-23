<script src='https://api.tiles.mapbox.com/mapbox.js/v2.1.5/mapbox.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v2.1.5/mapbox.css' rel='stylesheet' />

<script>

// get URL parameters
// borrowed from this http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript/2880929#2880929
// urlParameters do not appear to be used anywhere; perhaps I should remove this code
var urlParams;
(window.onpopstate = function () {
    var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
        query  = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query))
       urlParams[decode(match[1])] = decode(match[2]);
})();


// set up global variables
var stop_markers = Array();
var stops_layer_group = L.layerGroup();
var route_styles = Array();
var route_layers = Array();
var stops = Array();
var ZoomLevelThreshhold = 12;
var route_colors = Array();
var StopIcons = new Array();
var gtfs_archive_base_url = 'http://gtfs-api.ed-groth.com/gtfs-api/';
var active_layer;

<?php


// set up the variables from what was previously defined (transit_map_parameters.php)
$agencies_list = implode($agency_id,",");
$routes_list = implode($routes_array,",");

// to eventually replace some of this PHP with Javascript use the following resource
// http://stackoverflow.com/a/2880929

if (isset($_GET['routes'])) {
	$routes_initial = explode(",", $_GET['routes']);
	$initial_route_bounds = explode(",", $_GET['routes']);


	}
else {
	$routes_initial = $routes_array;
	$initial_route_bounds = $default_routes_bounds;

}


for($i = 0; $i < count($routes_initial); ++$i) {
    $routes_initial[$i] = intval($routes_initial[$i]);
}


?>

var agency_id = [<?php echo $agencies_list; ?>];
var route_ids_array = [<?php echo $routes_list; ?>];

// set up array of routes
var routes = load_data('json_routes.php?agency_id=' + encodeURIComponent(agency_id.join()),null,null,remote_base);

// define which routes are active, based on variable passed to page

<?php
echo 'var routes_active = ['.implode(",", $routes_initial).'];
';
echo 'var initial_route_bounds = ['.implode(",", $initial_route_bounds).'];
';
?>

// Set map bounds -- are in which map can be panned
var point_A = L.latLng( bounds_point_A[0], bounds_point_A[1]),
    point_B = L.latLng(bounds_point_B[0], bounds_point_B[1]),
    map_limits = L.latLngBounds(point_A, point_B);


L.mapbox.accessToken = accessToken;

// set up map
var map = L.mapbox.map('map', {
	minZoom: min_zoom,
	maxZoom: max_zoom,
	scrollWheelZoom: false,
	zoomControl:false,
});
$(".leaflet-control-zoom").css("visibility", "hidden");
new L.Control.Zoom({ position: 'topright' }).addTo(map);
map.scrollWheelZoom.disable();
// define the StopIcon
var StopIcon = L.Icon.extend({
    options: {
        iconSize: [10, 10],
        iconAnchor: [5, 5],
        popupAnchor: [0, 0]
    }
});

// Note that the tile layer is set up in the config file

function load_data_async(url, dataType, baseUrl, successResponse) {
    dataType = typeof dataType !== 'undefined' ? dataType : null;
    baseUrl = typeof baseUrl !== 'undefined' ? baseUrl : null;
    dataType = dataType !== null ? dataType : "json";
    baseUrl = baseUrl !== null ? baseUrl : map_app_base;
    var returned_data = null;
    successResponse = successResponse !== null ? successResponse : function(data){
        returned_data = data;
    };
    $.ajax({
        'global': false,
        'url': baseUrl + url,
        'dataType': dataType,
        'success': successResponse
    });
    return returned_data;
}

// set up load data function
// borrowed from stackoverflow.com/questions/2177548/load-json-into-variable
function load_data(url, dataType, async, baseUrl) {
    dataType = typeof dataType !== 'undefined' ? dataType : null;
    async = typeof async !== 'undefined' ? async : null;
    baseUrl = typeof baseUrl !== 'undefined' ? baseUrl : null;
    dataType = dataType !== null ? dataType : "json";
    async = async !== null ? async : false;
    baseUrl = baseUrl !== null ? baseUrl : map_app_base;

    console.log(dataType);
    console.log('async: ' + async);
    console.log('baseUrl: ' + baseUrl);
	console.log('url: ' + url);
    console.log(baseUrl + url);

    var returned_data = null;
    $.ajax({
        'async': async,
        'global': false,
        'url': baseUrl + url,
        'dataType': dataType,
        'success': function (data) {
            returned_data = data;
        }
    });
    console.log('returned_data: ' + returned_data);
    return returned_data;
}

function get_index(value, array) {
	var index = array.indexOf(parseInt(value));
	return index;
}

function remove_from_array(value, array) {
    var index = get_index(value, array);
    if (index > -1) {
        array.splice(index, 1);
    }
}


// set up map functions

function fit_map_bounds(routes_bounds_array) {

	routes_bounds_array = encapsulate_in_array(routes_bounds_array);

    var map_bounds_json_url = 'json_bounds.php?agency_id=' + encodeURIComponent(agency_id.join()) + '&route_id=' + routes_bounds_array.join();
    var map_bounds = load_data(map_bounds_json_url,null,null,remote_base);

   if(map_bounds != null) {
	 map.fitBounds([
        [map_bounds.lat1, map_bounds.lon1],
        [map_bounds.lat2, map_bounds.lon2]
    ]);
   }
}


function is_in_array(search_value,search_array) {

    var result = false;

    for (var i = 0, len = search_array.length; i < len; i++) {
        if (search_array[i] === search_value) {
            active = true;
            break;
        }
    }

    return result;
}



function get_routes_array_index_from_id(id) {
    var index = -1;
    for (var i = 0, len = routes.length; i < len; i++) {
        if (routes[i].route_id == id) {
            index = i;
            // console.log(index);
            break;
        }
    }

    return index;

}

function get_route_info(id) {
	return routes[get_routes_array_index_from_id(id)];
}


function add_route_alignment(ids) {

	ids = encapsulate_in_array(ids);

	    for (var i = 0, len = ids.length; i < len; i++) {
	    	var id = ids[i];

	    var index = get_routes_array_index_from_id(id);

	    var geojson_url = gtfs_archive_base_url + 'routes/by-feed/' + gtfs_api_feed_name + '/route-id/' + id;

//		assign the dashes array to "dashArray" in the route_styles to get dashes
//		var dashes = '0.5, 15';

	    if (typeof route_layers[id] == 'undefined' || route_layers[id] == null) {

	        $.ajax({
	            url: geojson_url,
	            dataType: 'json',
	            success: function (response) {

	                if (response !== null) {

	                	route_styles[id] = [];
	                	
	                	if (routes[index].route_color == '') {var route_color = default_icon_color;} else {var route_color = routes[index].route_color;}

	                	route_styles[id][0] = {
	                        "color": '#' + route_color,
	                        "weight": 5,
	                        "opacity": 1,
	                        "dashArray": "",
	                        "clickable": true
	                    };

	                	route_styles[id][1] = {
	                        "color": '#' + route_color,
	                        "weight": 10,
	                        "opacity": 1,
	                        "dashArray": "",
	                        "clickable": true
	                    };
						
						console.log(response[0]);
						
	                    
	                    if (response[0].simple_00004_geojson == null) {
							route_layers[id] = L.geoJson(response[0].geojson, {
								style: route_styles[id][0]
							});
	                    }
	                    else {
							route_layers[id] = L.geoJson(response[0].simple_00004_geojson, {
								style: route_styles[id][0]
							});
	                    }
	                    
	                    route_layers[id].addTo(map);

	                }

	            }
	        });

	    } else {
	        route_layers[id].addTo(map);
	    }

	    if (routes_active.indexOf(parseInt(id)) == -1) {
	        routes_active.push(parseInt(id));
	        // console.log('adding route_id '+id+' to routes_active');
	    }
	}

}


function remove_route_alignment(ids) {
	ids = encapsulate_in_array(ids);

   for (var i = 0, len = ids.length; i < len; i++) {
	   	var id = ids[i];


    map.removeLayer(route_layers[id]);
    remove_from_array(id, routes_active);

}
}

function encapsulate_in_array(variable) {
	if (Array.isArray(variable)) {return variable;}
	else {
		var new_array = Array();
		new_array.push(variable);
		return new_array;
		}
	}

function highlight_route_alignment(route_ids) {

	route_ids = encapsulate_in_array(route_ids);

	    for (var i = 0, len = route_ids.length; i < len; i++) {
			var route_id = route_ids[i];
	    	if (routes_active.indexOf(route_id) > -1) {
				route_layers[route_id].bringToFront();
				route_layers[route_id].setStyle(route_styles[route_id][1]);
		    }

	    }
}

function unhighlight_route_alignment(route_ids) {

		route_ids = encapsulate_in_array(route_ids);

	    for (var i = 0, len = route_ids.length; i < len; i++) {
	    	var route_id = route_ids[i];
		    route_layers[route_id].setStyle(route_styles[route_id][0]);
	    }

}


/*pushing items into array each by each and then add markers*/
function load_stop_markers() {

    // if the map has the stops_layer_group, get rid of it
    if (map.hasLayer(stops_layer_group)) {
        map.removeLayer(stops_layer_group);
    }

    // clear out the current stops array
    stops = [];
    stop_markers = [];
    stops_layer_group = L.layerGroup();

   // console.log(routes_active);

	//	/gtfs-api/stops/by-feed/sonomacounty-ca-us/route-id/1036

    // json_stops_url = "json_stops.php?route_ids=" + encodeURI(routes_active.join(","));

	var json_stops_url = gtfs_archive_base_url + 'stops/by-feed/' + gtfs_api_feed_name + '/route-id/' + routes_active.join(",");
	console.log(json_stops_url);
	
// structure of this output
// {
//   "routes" : [ {
//     "feed_name" : "sonomacounty-ca-us",
//     "route_id" : "1026"
//   }... ],
//   "geojson" : {"type":"Point","coordinates":[-122.7177412,38.44802358]},
//   "stop_code" : "164",
//   "stop_name" : "Mendocino Ave. & Benton",
//   "stop_id" : "757293",
//   "feed_name" : "sonomacounty-ca-us"
// }
	
	console.log('load stops from GTFS-API here.');
    load_data_async(json_stops_url, null,'', function(data){
        stops = data;
        // console.log(stops);
        if (stops !== null) {

            for (i = 0; i < stops.length; i++) {
//                 if(typeof(stops[i].color) === 'undefined' || stops[i].color == '') {
//                     stops[i].color ='575757';
//                 }
                var LamMarker = new L.marker([stops[i].geojson.coordinates[1], stops[i].geojson.coordinates[0]], {
                    icon: StopIcons[default_icon_color]
                }).bindPopup(stops[i].stop_name, {maxWidth: 400});
                console.log(LamMarker);
                LamMarker.stop_id = stops[i].stop_id;
                LamMarker.stop_name = stops[i].stop_name;
                LamMarker.marker_id = i;

                LamMarker.on('click', update_stop_info);

                // I think the answer for setting the content of the markers is here -- https://github.com/Leaflet/Leaflet/issues/1031

                // class="leaflet-popup-content" of the markers

                stop_markers.push(LamMarker);
                stops_layer_group.addLayer(stop_markers[i]);
            }

        }
        map.addLayer(stops_layer_group);
    });






    // stops_layer_group.addTo(map);

}

function get_stop_info(stop_id_lookup) {
	var result = null;
		for(var i = 0; i < stops.length; i++) {
			if( stops[i].stop_id == stop_id_lookup ) {
				result = stops[i];
				break;
			}
		}
	return result;
}

function update_stop_info(e) {
    // console.log(e);
    
    if (google_analytics) {ga('send', 'event', 'map', 'click stop', e.target.stop_name);}
    
    var stop_info = get_stop_info(e.target.stop_id);
    
    popup_content = '<h3 class="map_stop_name"><nobr>' + stop_info.stop_name + '</nobr></div>';

	if (stop_info.stop_code != "") {popup_content += '<div style="font-size:11px;">Stop ID: ' + stop_info.stop_code + '</div>';}

	popup_content += '<h4>Routes that serve this stop:</h4><ul>';

for (var i = 0, len = stop_info.routes.length; i < len; ++i) {
	var route_info = get_route_info(stop_info.routes[i].route_id);
	popup_content += '<li><a href="'+route_info.route_url+'">'+route_info.route_short_name+' - '+ route_info.route_long_name +'</a></li>';	
}

popup_content += '</ul>'

e.target.setPopupContent(popup_content);

}


function toggle_stop_visibility() {
    if (map.getZoom() < ZoomLevelThreshhold && map.hasLayer(stops_layer_group)) {
        map.removeLayer(stops_layer_group);
    }
    if (map.getZoom() >= ZoomLevelThreshhold && map.hasLayer(stops_layer_group) == false) {
        load_stop_markers();
    }
}


// these are the functions to show / hide the routes
function activate_all_routes() {

    for (var i = 0, len = route_ids_array.length; i < len; ++i) {
        add_route_alignment(route_ids_array[i]);
    }

    toggle_stop_visibility();

}

// this turns off all the checkboxes
function deactivate_all_routes(keep_route_ids) {

	console.log('function deactivate_all_routes() fired.');
	console.log('keep_route_ids '+keep_route_ids);

	if (typeof keep_route_ids === 'undefined')
		{ var keep_route_ids = [];}
	else
		{var keep_route_ids = encapsulate_in_array(keep_route_ids);}

	var route_ids_to_deactivate = route_ids_array.slice();
	console.log('route_ids_to_deactivate '+route_ids_to_deactivate);

	for (var i = 0, len = keep_route_ids.length; i < len; i++) {
		console.log('remove_from_array route_ids_to_deactivate '+keep_route_ids[i]);
		remove_from_array(keep_route_ids[i], route_ids_to_deactivate);
	}

	console.log('route_ids_to_deactivate '+route_ids_to_deactivate);


    for (var i = 0, len = route_ids_to_deactivate.length; i < len; ++i) {
        remove_route_alignment(route_ids_to_deactivate[i]);
    }

    load_stop_markers();
}

function focus_routes(route_ids) {
	deactivate_all_routes(route_ids);
	add_route_alignment(route_ids);
	fit_map_bounds(route_ids);

}


function toggle_route(routeNum) {
	if(routes_active.indexOf(route_id) == -1) {
        add_route_alignment(routeNum);
        }
     else {
        remove_route_alignment(routeNum);
    }

    load_stop_markers();
}



function stop_icons() {
StopIcons[default_icon_color] = new StopIcon({iconUrl:"create_image.php?r=10&bc="+default_icon_color});

//         var json_route_colors = "json_route_colors.php?default_icon_color=" + default_icon_color + "&agency_ids=" + encodeURI(agency_id.join(","));
//         load_data_async(json_route_colors,null,remote_base, function(route_colors){
//             for (i = 0; i < route_colors.length; i++) {
//                 StopIcons[route_colors[i]] = new StopIcon({iconUrl:"create_image.php?r=10&bc="+route_colors[i]});
//             }
//         });

	}

stop_icons();


function GTFSMapLayer (layer_name, base, labels) {
    this.layer_name = layer_name;
    this.base = base;
    this.labels = labels;
    this.getName = function getName() {
        return this.layer_name;
    };
}
 
//instantiate object using the constructor function

var base_layer = new L.tileLayer('http://{s}.tiles.mapbox.com/v4/' + map_id_base + '/{z}/{x}/{y}.png?access_token=' + accessToken, {
     maxZoom: max_zoom,
     attribution: attribution
 });

var labels_layer  = new L.tileLayer('http://{s}.tiles.mapbox.com/v4/'+map_id_labels+'/{z}/{x}/{y}.png?access_token=' + accessToken, {
     maxZoom: max_zoom
 });

var default_tile_layer = new GTFSMapLayer('default',base_layer,labels_layer);

// var default_tile_layer = new Array();

</script>
