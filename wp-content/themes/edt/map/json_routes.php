<?php

require_once ('map-includes/config.inc.php');
require_once ('map-includes/mysql_connect.php');

$agency_id = mysql_real_escape_string($_GET['agency_id']);

// Select all the rows in the markers table
$query = "select * from routes where agency_id IN (".$agency_id.") ORDER BY route_short_name ASC, route_long_name ASC";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

$num_of_rows = mysql_num_rows($result);

header("Content-type: application/json");

// Start JSON output, echo parent object
echo '[
';

// initialize counter
$i = 0;

// Iterate through the rows
while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {

  $i++;
  
  echo '{';
//  echo 'list_of_routes="' .  str_replace('"','',$row['list_of_routes']) . '" ';
  echo '"agency_id":"' . $row['agency_id'] . '",';
  echo '"route_id":"' . $row['route_id'] . '",';
  echo '"route_short_name":"' . str_replace('"','',$row['route_short_name']) . '",';
  echo '"route_long_name":"' . $row['route_long_name'].'",';
  echo '"route_url":"' . $row['route_url'].'",';
  echo '"route_color":"' . $row['route_color'].'",';
  echo '"route_text_color":"'.$row['route_text_color'].'"';
  echo '}';
  
  if ($i != $num_of_rows) {echo ",";}
  
}

// End JSON file
echo ']';

?>