<?php

require_once (dirname(__FILE__).'/config.inc.php');
require_once (dirname(__FILE__).'/database_connect.php');
require_once (dirname(__FILE__).'/db_functions.inc.php');

function get_stop_info ($stop_id) {

$stop_query = "select stops.stop_name,stops.stop_code,zones.zone_name,count(DISTINCT routes.route_id) as num_routes from stops left join zones on stops.zone_id = zones.zone_id
LEFT JOIN stop_times on stops.stop_id = stop_times.stop_id
LEFT JOIN trips on stop_times.trip_id = trips.trip_id
LEFT JOIN routes on trips.route_id = routes.route_id
where stops.stop_id = $stop_id GROUP BY stops.stop_id,stops.stop_name,stops.stop_code,zones.zone_name";
$stop_result = db_query($stop_query);

$stop_name = db_result($stop_result,0,"stop_name");
$stop_code = db_result($stop_result,0,"stop_code");
$zone_name = db_result($stop_result,0,"zone_name");
$num_routes = db_result($stop_result,0,"num_routes");

$stop_info_array = array(
	"stop_name" => $stop_name,
	"stop_code" => $stop_code,
	"zone_name" => $zone_name,
	"num_routes" => $num_routes
);

return $stop_info_array;

}

function get_routes_for_stop ($stop_id) {

$routes_query = "select distinct routes.* from stop_times inner join trips on stop_times.trip_id = trips.trip_id INNER JOIN routes on trips.route_id = routes.route_id where stop_times.stop_id = $stop_id order by route_short_name ASC";
$routes_result = db_query($routes_query);

$routes_array = array();
$i = 0;

while ($row=db_fetch_array($routes_result, MYSQL_ASSOC))

	{$routes_array[$i] = array(
		"route_id" => $row['route_id'],
		"route_short_name" => $row['route_short_name'],
		"route_long_name" => $row['route_long_name'],
		"route_color" => $row['route_color'],
		"route_text_color" => $row['route_text_color'],
		"route_url" => $row['route_url']
		);
	$i++;
	}

return $routes_array;

}
	
?>