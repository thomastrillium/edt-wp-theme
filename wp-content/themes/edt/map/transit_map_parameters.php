<script>
var min_zoom = 3,
max_zoom = 19;

//Set map bounds -- are in which map can be panned
// select max(stop_lat),min(stop_lat),max(stop_lon),min(stop_lon) from stops where agency_id = 261
var bounds_point_A = new Array( 38.762956,-120.577716),
bounds_point_B = new Array(38.565587,-121.502804);


// select MIN(stop_lat),MIN(stop_lon) FROM stop_times inner join stops on stop_times.stop_id = stops.stop_id inner join trips on stop_times.trip_id = trips.trip_id WHERE trips.agency_id = 25 and trips.route_id != 161;

//40.4312255099341
//-122.4269664

//select max(stop_lat),max(stop_lon) FROM stop_times inner join stops on stop_times.stop_id = stops.stop_id inner join trips on stop_times.trip_id = trips.trip_id WHERE trips.agency_id = 25 and trips.route_id != 161;
// 40.69107814,-122.2857761

<?php

$agency_id = Array(261);

$routes_array = array(1963,1964,1968,1961,1965,1962,1966,1967,1970);

$default_routes_bounds = array(1963,1964,1968,1961,1965,1962,1966,1967,1970);

?>

var map_id_base = 'trilliumtransit.11e2641a',
map_id_labels = 'trilliumtransit.d575ec4e',
attribution = 'Street data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> (and) contributors, CC-BY-SA <a href="https://www.mapbox.com/map-feedback/" >Improve this map</a></div>',
default_icon_color = '575757';

// Provide your access token
var accessToken = 'pk.eyJ1IjoidHJpbGxpdW10cmFuc2l0IiwiYSI6ImVUQ2x0blUifQ.2-Z9TGHmyjRzy5GC1J9BTw';

// development
// var map_app_base = 'http://localhost:80/sctransit.com/wp-content/themes/sctransit/map/';
// var map_app_base = 'http://dev.sctransit.com/wp-content/themes/sctransit/map/';
var map_app_base = 'http://applications.trilliumtransit.com/GTFSMap/eledorado/';

// remote scripts
var remote_base = 'http://applications.trilliumtransit.com/GTFSMap/';
var gtfs_api_feed_name = 'eldoradotransit-ca-us';
var google_analytics = false;

</script>