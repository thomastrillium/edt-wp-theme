<?php

require_once ('map-includes/config.inc.php');
require_once ('map-includes/mysql_connect.php');


if (isset($_GET['route_ids'])) {
	$route_ids = mysql_real_escape_string($_GET['route_ids']);
	$routes_conditional = " AND routes.route_id IN ($route_ids) ";
	}
else {$routes_conditional = "";}

if (isset($_GET['agency_id'])) {
	$agency_id = mysql_real_escape_string($_GET['agency_id']);
	$agency_conditional = " AND routes.agency_id = $agency_id ";
	}
else {$agency_conditional = "";}

if (isset($_GET['default_icon_color'])) {
	$default_icon_color = $_GET['default_icon_color'];
	}
else {$default_icon_color = '575757';}

// Select all the rows in the markers table
$query = "SELECT DISTINCT stops.stop_id, stop_lat, stop_lon, stop_name, GROUP_CONCAT( routes.route_short_name
SEPARATOR  ', ' ) AS list_of_routes, IF( COUNT(DISTINCT routes.route_color) = 1 , routes.route_color, $default_icon_color ) AS route_color
FROM stop_times
INNER JOIN trips ON stop_times.trip_id = trips.trip_id
LEFT JOIN stops ON stop_times.stop_id = stops.stop_id
INNER JOIN routes ON trips.route_id = routes.route_id
WHERE stop_lat <> 0
AND stop_lon <> 0
$agency_conditional
$routes_conditional
GROUP BY stops.stop_id;";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


$num_of_stops = mysql_num_rows($result);

header("Content-type: application/json");

// Start JSON output, echo parent object
echo '[
';

// initialize counter
$i = 0;

// Iterate through the rows, printing XML nodes for each
while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {

  $i++;
  
  echo '{';
//  echo 'list_of_routes="' .  str_replace('"','',$row['list_of_routes']) . '" ';
  echo '"lat":"' . $row['stop_lat'] . '",';
  echo '"lon":"' . $row['stop_lon'] . '",';
  echo '"name":"' . str_replace('"','',$row['stop_name']) . '",';
  echo '"color":"' . $row['route_color'].'",';
  echo '"stop_id":"'.$row['stop_id'].'"';
  echo '}';
  
  if ($i != $num_of_stops) {echo ",";}
  
}

// End XML file
echo ']';

?>