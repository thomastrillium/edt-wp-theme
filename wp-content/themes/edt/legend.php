<?php //route list

$type = 'route';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1); 

$my_query = null;
$my_query = new WP_Query($args);
$legend_out = "";
$legend_end = "";
if( $my_query->have_posts() ) {
	echo '<ul id="map-legend">';
  while ($my_query->have_posts()) : $my_query->the_post(); 
  	if(get_field('route_short_name') == "SE"){ 
  		$legend_end .= '<li id="'.slugify(get_field('route_short_name')).'" class="home-legend-button" style="background-color: #'.get_field('route_color').'" >'.get_the_title().'<span>(Not shown on map)</span><a class="legend-link" href="'.get_the_permalink().'"></a></li>';
	// 		$legend_end += 'sdf';
     } else { 
    	$legend_out .= '<li id="'.slugify(get_field('route_short_name')).'" class="home-legend-button" style="background-color: #'.get_field('route_color').'" >'.get_the_title().'<a class="legend-link" href="'.get_the_permalink().'"></a></li>';

     }
     
  endwhile;
  		echo $legend_out;
  		echo $legend_end;
		echo '</ul><!-- end id="map-legend" -->';
}
wp_reset_query();  // Restore global post data stomped by the_post().


?>