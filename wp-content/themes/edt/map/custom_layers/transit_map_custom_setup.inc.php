<script>

<?php

if (isset($_GET['landmarks'])) {
	$landmarks_initial = explode(",", $_GET['landmarks']);
	}
else {
	$landmarks_initial = array();
} 

for($i = 0; $i < count($landmarks_initial); ++$i) {
    $landmarks_initial[$i] = intval($landmarks_initial[$i]);
}

?>

</script>