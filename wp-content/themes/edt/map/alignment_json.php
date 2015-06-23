<?php

// deactivated because it doesn't work on RackSpace server
// ini_set('zlib.output_compression', 'On');

header("Content-type: application/json");

$file = 'route_alignments/json/'.$_GET['route_id'].'.json';

if (file_exists($file)) {
    header('Content-Type: application/json');
    ob_clean();
    flush();
    readfile($file);
    exit;
}
?>