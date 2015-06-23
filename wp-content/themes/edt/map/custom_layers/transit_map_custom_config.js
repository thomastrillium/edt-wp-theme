<script>
var bikeRackIcon = L.icon({
    iconUrl: 'icons/bikerack_pin.png',
    iconSize: [36, 36], // size of the icon
    iconAnchor: [18, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -37] // point from which the popup should open relative to the iconAnchor
});

var retailIcon = L.icon({
    iconUrl: 'icons/pass_sales_pin.png',
    iconSize: [36, 36], // size of the icon
    iconAnchor: [18, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -37] // point from which the popup should open relative to the iconAnchor
});

var transitCenterIcon = L.icon({
    iconUrl: 'icons/transit_center_pin.png',
    iconSize: [36, 36], // size of the icon
    iconAnchor: [18, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -37] // point from which the popup should open relative to the iconAnchor
});

var parknRideIcon = L.icon({
    iconUrl: 'icons/parking_pin.png',
    iconSize: [36, 36], // size of the icon
    iconAnchor: [18, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -37] // point from which the popup should open relative to the iconAnchor
});

var landmarks_json_array = [{
    name: "Bike Racks",
    url: "landmarks_json/bike_racks.json",
    icon: bikeRackIcon
}, {
    name: "Park and Ride",
    url: "landmarks_json/park_and_ride.json",
    icon: parknRideIcon
}, {
    name: "Pass Outlets",
    url: "landmarks_json/pass_outlets.json",
    icon: retailIcon
}, {
    name: "Transit Hubs",
    url: "landmarks_json/transit-hubs.json",
    icon: transitCenterIcon
}];


var bike_base_mapID = 'trilliumtransit.fde0d89f';
var bike_labels_mapID = 'trilliumtransit.0818c676';

var bike_base = new L.tileLayer('http://{s}.tiles.mapbox.com/v4/' + bike_base_mapID + '/{z}/{x}/{y}.png?access_token=' + accessToken, {
     maxZoom: max_zoom,
     attribution: attribution
 });

var bike_labels  = new L.tileLayer('http://{s}.tiles.mapbox.com/v4/'+bike_labels_mapID+'/{z}/{x}/{y}.png?access_token=' + accessToken, {
     maxZoom: max_zoom
 });

custom_tile_layers[0] = new GTFSMapLayer('bike',bike_base,bike_labels);


// key
// var custom_layers_keys = new Array();
custom_layers_keys[0] = new Array();
custom_layers_keys[0][0] = "keybox";
custom_layers_keys[0][1] = "bicycle_key.html";

<?php

// loop over the array of active landmarks to add those layers to the map
foreach ($landmarks_initial as &$landmarks_layer_group_id) {
echo "load_landmarks($landmarks_layer_group_id);
";
}

?>


</script>