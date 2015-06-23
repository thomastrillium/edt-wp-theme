<script>
// distill this into more generic functions -- add layer and remove layer

function remove_active_tile_layer() {
//		id = typeof a !== 'undefined' ? id : null;
	if (typeof (active_layer.base) != "undefined") {
		map.removeLayer(active_layer.base); }
	if (typeof (active_layer.labels) != "undefined") {map.removeLayer(active_layer.labels);}
}

function add_base_tile_layer() {
	var set_base_layer = 0;
	if (typeof active_layer !== undefined) {
		set_base_layer = 1;
		}
	else {
		if (active_layer.getName() != 'default')  {
			set_base_layer = 1;
		}
	}
if (set_base_layer == 1)  {
	if (typeof (active_layer) != "undefined") {
		if (active_layer.getName() != 'default') {remove_active_tile_layer(); }
		}
	console.log('set_base_layer == 1');
	active_layer = default_tile_layer;
		if (typeof (active_layer.base) != "undefined") {					
			active_layer.base.addTo(map);
			if (typeof (active_layer.labels) != "undefined") {

				// below is borrowed from http://bl.ocks.org/rsudekum/5431771
				topPane = map._createPane('leaflet-top-pane', map.getPanes().mapPane);
				topLayer = active_layer.labels.addTo(map);
				topPane.appendChild(topLayer.getContainer());
				topLayer.setZIndex(5);
			}
		}
	}
}


// initial_route_bounds is set in transit_map_core_config
fit_map_bounds(initial_route_bounds);

// add selected routes
for (var i = 0, len = routes_active.length; i < len; ++i) {
    add_route_alignment(routes_active[i]);
}

// during the load process, show stops if the zoom level is sufficient		
toggle_stop_visibility();

// when the zoom level changes, assess whether to show stops
map.on('zoomend', toggle_stop_visibility);

if (google_analytics) {
map.on('zoomend', function() {
	ga('send', 'event', 'map', 'zoomend', 'Zoom level', map.getZoom());
});
}


add_base_tile_layer();

</script>