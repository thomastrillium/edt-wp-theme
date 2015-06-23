<?php

require_once ('map-includes/stop_info_functions.php');

$stop_id = $_GET['stop_id'];

$stop_info = get_stop_info($stop_id);
$routes_list = get_routes_for_stop ($stop_id);

$routes_query = "select distinct routes.* from stop_times inner join trips on stop_times.trip_id = trips.trip_id INNER JOIN routes on trips.route_id = routes.route_id where stop_times.stop_id = $stop_id order by route_short_name ASC";

$routes_result = db_query($routes_query);

echo '<div style="padding:3px;margin:4px;font-weight:bold;border-bottom:1px solid;font-size:18px;margin-bottom:3px;margin:0px;"><nobr>';
echo $stop_info['stop_name'];
echo '</nobr></div>';

if ($stop_info['stop_code'] != "") {echo '<div style="font-size:11px;">Stop ID: '.$stop_info['stop_code'].'</div>';}

echo '<div style="font-size:11px;">Fare zone: '.$stop_info['zone_name'].'</h3>

<h3>Routes that serve this stop:</h3>';

foreach ($routes_list as &$route_row) {

echo '<div class="route_name">';
if ($route_row['route_short_name'] != '') {echo '<div class="route_short_name" style="display:inline-block;margin-right:8px;padding:3px;margin:3px;font-weight:bold;font-size:14pt;color:'.$route_row['route_text_color'].';background-color:#'.$route_row['route_color'].'">'.$route_row['route_short_name'].'</div>';}

echo '<div class="route_long_name" style="display:inline-block;">'.$route_row['route_long_name'].'</div>';

if ($route_row['route_url'] != "") {echo '<a href="'.$route_row['route_url'].'">View Schedule</a>';}

echo '</div>';

echo '</div>';

}
	
	
?>

</table>