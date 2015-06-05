<?php
//home-map
?>
<div id="home-map" class="full-width" >
	<div id="home-map-top-border" class="centered max-width" ></div>
	<div id="home-map-inner" class="centered max-width">
	
<?php
		
		$svg = file_get_contents('wp-content/themes/edt/library/svg/home_map.svg');
		echo $svg;
		?>
	</div><!-- end home-map-inner -->
	<div id="home-map-bottom-border" class="centered max-width" ></div>
</div>