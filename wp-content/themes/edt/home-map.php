<?php
//home-map
?>

<div id="map-hover-routes"> 


</div>
<div id="home-map" class="full-width main-blue-grad-bg" >
<div id="home-map-spacer"></div>
	<div id="home-map-top-border" class="centered max-width" ></div>
	<div id="home-map-inner" class="centered max-width">
	
<?php
		
		$svg = file_get_contents('wp-content/themes/edt/library/svg/home_map.svg');
		echo $svg;
		?>
		<br style="clear;" />
		<div id="home-map-bottom-border" class="centered max-width" ></div>
	<?php	get_template_part('desktop-legend'); ?>
	</div><!-- end home-map-inner -->
	
</div>