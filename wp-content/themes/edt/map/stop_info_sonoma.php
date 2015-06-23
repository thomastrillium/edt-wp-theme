<?php

require_once ('map-includes/config.inc.php');
require_once ('map-includes/database_connect.php');
require_once ('map-includes/db_functions.inc.php');

$stop_id = $_GET['stop_id'];

$stop_info = get_stop_info($stop_id);
$routes_list = get_routes_for_stop ($stop_id);

$routes_query = "select distinct routes.* from stop_times inner join trips on stop_times.trip_id = trips.trip_id INNER JOIN routes on trips.route_id = routes.route_id where stop_times.stop_id = $stop_id order by route_short_name ASC";

$routes_result = db_query($routes_query);

echo '<div style="padding:3px;margin:4px;font-weight:bold;border-bottom:1px solid;font-size:18px;margin-bottom:3px;margin:0px;"><nobr>';
echo db_result($stop_result,0,"stop_name");
echo '</nobr></div>';

if (db_result($stop_result,0,"stop_code") != "") {echo '<div style="font-size:11px;">Stop ID: '.db_result($stop_result,0,"stop_code").'</div>';}

echo '<div style="font-size:11px;">Fare zone: ' . $stop_info['zone_name'] . '</h3>

<h3>Routes that serve this stop:</h3>';



while ($row=db_fetch_array($routes_result, MYSQL_ASSOC))

	{echo '<div class="fancy-route-row selected" style="display: block; width:310px; cursor: default;"> 
				<div class="route-icon route-'.$row['route_short_name'].'-small"></div>
				<div class="title">
					<span class="text" style="font-size:10px;">'.$row["route_long_name"].'</span>
					<br>
					<span class="route-row-days">&nbsp;</span>
				</div><!-- end .title -->';
				
				if ($row['route_url'] != "") {echo '<a href="'.$row['route_url'].'">View Schedule</a>';}

echo '</div>';}
	
	
?>

</table>