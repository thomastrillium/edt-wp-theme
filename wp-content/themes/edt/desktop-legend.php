<?php //desktop-legend

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
	echo '<div id="map-legend-desktop">';
  while ($my_query->have_posts()) : $my_query->the_post(); 
  	if(get_field('route_short_name') == "SE"){ 
  		$legend_end .= '<a href="'.get_the_permalink().'" id="'.slugify(get_field('route_short_name')).'" class="home-legend-button" style="background-color: #'.get_field('route_color').';color: #'.get_field('route_text_color').';" >'.get_the_title().'<span>(Not shown on map)</span></a>';
	// 		$legend_end += 'sdf';
     } else { 
  		$legend_out .= '<a href="'.get_the_permalink().'" id="'.slugify(get_field('route_short_name')).'" class="home-legend-button" style="background-color: #'.get_field('route_color').';color: #'.get_field('route_text_color').';" >'.get_the_title().'</a>';

     }
     
  endwhile;
  		echo $legend_out;
  		echo $legend_end;
		echo '</div><!-- end id="map-legend-desktop" -->';
}
wp_reset_query();  // Restore global post data stomped by the_post().


?>