<script>

// begin  other layers

var landmarks_layer_group = Array();

landmarks_layer_group[0] = L.layerGroup();
landmarks_layer_group[1] = L.layerGroup();
landmarks_layer_group[2] = L.layerGroup();
landmarks_layer_group[3] = L.layerGroup();

var custom_tile_layers = new Array();

var custom_layers_keys = new Array();

var topPane;
var topLayer;

var num_landmarks_layers = 5;

function load_landmarks(id) {

	for (var i = 0; i < num_landmarks_layers; i++) {
		if (i !== id) {remove_landmarks(i);}
	}

	if (id === 4) {load_trailheads();}
	
	else {
		
		if (typeof (custom_layers_keys[id]) != "undefined") {
			$( "body" ).append( '<div class="' + custom_layers_keys[id][0] + '"></div>' );
			$("."+ custom_layers_keys[id][0]).load(custom_layers_keys[id][1]);

		}

		if (typeof (landmarks_layer_group[id]) != "undefined") {

			var landmarks = Array();
			var landmarks_makers = Array();


			var json_landmarks_url = landmarks_json_array[id].url;
			landmarks[id] = load_data(json_landmarks_url);

			for (i = 0; i < landmarks[id].length; i++) {


				var LamMarker = new L.marker([landmarks[id][i].lat, landmarks[id][i].lon], {
					icon: landmarks_json_array[id].icon
				}).bindPopup(landmarks[id][i].name);
				landmarks_makers.push(LamMarker);
				landmarks_layer_group[id].addLayer(landmarks_makers[i]);
			}

		}

		landmarks_layer_group[id].addTo(map);
    
    }

	
	add_tile_layer(custom_tile_layers[id]);
	
}

function remove_landmarks(id) {

	if (typeof (custom_layers_keys[id]) != "undefined") {
		$( "body" ).append( '<div class="' + custom_layers_keys[id][0] + '"></div>' );
		$("." + custom_layers_keys[id][0]).remove();

	}
	
	if (id === 4) {remove_trailheads();}
	
	else {map.removeLayer(landmarks_layer_group[id]);}
	
}


// function remove_active_layer(id) {
// 	if (typeof (custom_tile_layers[id]) != "undefined") {
// 	map.removeLayer(custom_tile_layers[id].base);
// 	if (typeof (custom_tile_layers[id].labels) != "undefined") {
// 		map.removeLayer(custom_tile_layers[id].labels);
// 	}
// }

function add_tile_layer(tile_layer_to_add) {
	console.log('tile_layer_to_add');
	console.log(tile_layer_to_add);
	if (typeof (tile_layer_to_add) != "undefined") {
		console.log('removing active tile layer -- remove_active_tile_layer();');
		remove_active_tile_layer();
		active_layer = tile_layer_to_add;
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


</script>