<?php

require_once ('map-includes/config.inc.php');
require_once ('map-includes/mysql_connect.php');

$agency_ids = mysql_real_escape_string($_GET['agency_ids']);


if (isset($_GET['default_icon_color'])) {
	$default_icon_color = $_GET['default_icon_color'];
	}
else {$default_icon_color = '575757';}

// Select all the routes
$route_colors_query = "select distinct route_color from routes where agency_id IN (".$agency_ids.") and route_color IS NOT NULL and route_color != '' and route_color != '$default_icon_color';";
$route_colors_result = mysql_query($route_colors_query);
if (!$route_colors_result) {
    die('Invalid query: '.mysql_error());
}

$num_of_rows = mysql_num_rows($route_colors_result);

header("Content-type: application/json");


// Start JSON output, echo parent object
echo '[';

$i = 1;

while ($row = mysql_fetch_array($route_colors_result, MYSQL_ASSOC)) {
	echo '"'.$row['route_color'].'"';
	echo ",";
}

if ($num_of_rows != 0) {echo '"'.$default_icon_color.'"';}

// End JSON file
echo ']';

?>