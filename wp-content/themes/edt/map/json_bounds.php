<?php

require_once ('map-includes/config.inc.php');
require_once ('map-includes/mysql_connect.php');

$list_of_routes = mysql_real_escape_string($_GET['route_id']);

$agency_id = mysql_real_escape_string($_GET['agency_id']);

$select_min_lat_query = "select stops.stop_id,stop_lat,stop_lon from stops inner join stop_times on stops.stop_id = stop_times.stop_id inner join trips on stop_times.trip_id = trips.trip_id where stops.stop_lat <> 0 AND stops.stop_lon <> 0 AND stop_lat IS NOT NULL and stop_lon IS NOT NULL and route_id IN ($list_of_routes) AND stop_times.agency_id IN ($agency_id) order by stop_lat asc limit 1;";
	$select_min_lat_result = mysql_query($select_min_lat_query);
	$select_min_lat_row = mysql_fetch_assoc($select_min_lat_result);
	$lat1=$select_min_lat_row['stop_lat'];

	$select_max_lat_query = "select stops.stop_id,stop_lat,stop_lon from stops inner join stop_times on stops.stop_id = stop_times.stop_id inner join trips on stop_times.trip_id = trips.trip_id where stops.stop_lat <> 0 AND stops.stop_lon <> 0 AND stop_lat IS NOT NULL and stop_lon IS NOT NULL and route_id IN ($list_of_routes) AND stop_times.agency_id IN ($agency_id) order by stop_lat desc limit 1;";
	$select_max_lat_result = mysql_query($select_max_lat_query);

	if (mysql_num_rows($select_max_lat_result) > 0) {
	$lat2=mysql_result($select_max_lat_result,0,"stop_lat");	
	}
		
	$select_min_lon_query = "select stops.stop_id,stop_lat,stop_lon from stops inner join stop_times on stops.stop_id = stop_times.stop_id inner join trips on stop_times.trip_id = trips.trip_id where stops.stop_lat <> 0 AND stops.stop_lon <> 0 AND stop_lat IS NOT NULL and stop_lon IS NOT NULL and route_id IN ($list_of_routes) AND stop_times.agency_id IN ($agency_id) order by stop_lon asc limit 1;";
	$select_min_lon_result = mysql_query($select_min_lon_query);
	$select_min_lon_row = mysql_fetch_assoc($select_min_lon_result);
	$lon1=$select_min_lon_row['stop_lon'];

	$select_max_lon_query = "select stops.stop_id,stop_lat,stop_lon from stops inner join stop_times on stops.stop_id = stop_times.stop_id inner join trips on stop_times.trip_id = trips.trip_id where stops.stop_lat <> 0 AND stops.stop_lon <> 0 AND stop_lat IS NOT NULL and stop_lon IS NOT NULL and route_id IN ($list_of_routes) AND stop_times.agency_id IN ($agency_id) order by stop_lon desc limit 1;";
	$select_max_lon_result = mysql_query($select_max_lon_query);
	$select_max_lon_row = mysql_fetch_assoc($select_max_lon_result);
	$lon2=$select_max_lon_row['stop_lon'];


header("Content-type: application/json");

// Start JSON output, echo parent object
echo '
{';
//  echo 'list_of_routes="' .  str_replace('"','',$row['list_of_routes']) . '" ';
  echo '"lat1":"' . $lat1 . '",';
  echo '"lon1":"' . $lon1 . '",';
  echo '"lat2":"' . $lat2 . '",';
  echo '"lon2":"' . $lon2 .'"';

echo '}';

?>