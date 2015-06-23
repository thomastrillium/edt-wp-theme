<?php 
	
		//Template Name: map
		get_header(); 
get_template_part('template-header'); 
if (have_posts()) : while (have_posts()) : the_post(); 
?>
<div id="subpage-container" class="full-width centered" >

	<div id="subpage-inner-container" class="full-width centered">
	<iframe id="imap-holder" src="<?php echo get_site_url(); ?>/wp-content/themes/edt/map/"></iframe> 
	<div id="ui-big-buttons" class="exited">
		<div id="big-button-wrapper">
			<div id="big-buttons-label">Which routes do you want to see on the map?</div>
			<a id="commuter-large-ui-button" class="ui-big-button" href="javascript:void(0)">
				<svg> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#commuter-svg-3" ></use></svg>
				Commuter Routes
			</a>
			<a id="local-large-ui-button" class="ui-big-button" href="javascript:void(0)">
				<svg > <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#local-svg-3" ></use></svg>
				Local Routes
			</a>
		</div><!-- end id="big-button-wrapper" -->
	</div><!-- end ui-big-buttons -->
	<div id="map-ui-hover">
		<div id="map-ui-container">
		<h1>
			
			<div id="show-panel-button">
				<div id="inner">
					<svg> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrows-right-svg" ></use></svg>
					<span>Show Options</span>
				</div><!-- id="inner" -->
			</div><!-- end #show-pannel-button -->
			System Map <div class="only-sml">Options</div>
			<div id="hide-panel-button">
				<svg> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrows-left-svg" ></use></svg>
				<span>Hide Map Options</span>
			</div><!-- end #hide-pannel-button -->
			</h1>
		<div id="map-ui-inner">
			Click a colored route button to zoom in on that route.
			<div id="spacer-1"></div>
			All routes run Mon - Fri with the exception of the Saturday Express.  No sunday service.
			<div id="spacer-2"></div>
			<div id="legend-toggles">
				<div id="show-all-routes-button">
					<svg> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#all-routes-svg" ></use></svg>
					Show All Routes</div>
				<div id="hide-all-routes-button">
					<svg> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#close-svg" ></use></svg>
					Hide All Routes</div>
			</div>
			<?php //route list

$type = 'route';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1,
  'meta_key'			=> 'route_short_name',
	'orderby'			=> 'meta_value_num',
	'order'				=> 'ASC'); 

$my_query = null;
$my_query = new WP_Query($args);
$legend_out = "";
$legend_end = "";
if( $my_query->have_posts() ) {
	echo '<ul id="map-legend">';
  while ($my_query->have_posts()) : $my_query->the_post(); 
  	$checkbox = '<input type="checkbox" ><label ></label>';
   if(ctype_digit(get_field('route_short_name'))) {// if route short name only contains numbers 
		 $legend_out .= '<li>'.$checkbox.'<a id="'.slugify(get_field('route_short_name')).'" class="home-legend-button" style="background-color: #'.get_field('route_color').'; color: #'.get_field('route_text_color').';" rel="'.get_field('route_id').'" >'.get_field('route_short_name').' - '. get_the_title().'</a><a class="legend-link" href="'.get_the_permalink().'">See Schedule</a></li>';
     } else {
		$legend_out .= '<li>'.$checkbox.'<a id="'.slugify(get_field('route_short_name')).'" class="home-legend-button" style="background-color: #'.get_field('route_color').'; color: #'.get_field('route_text_color').';" rel="'.get_field('route_id').'" >'.get_the_title().'</a><a class="legend-link" href="'.get_the_permalink().'">See Schedule</a></li>';    	

     }
     
  endwhile;
  		echo $legend_out;
  		echo $legend_end;
		echo '</ul><!-- end id="map-legend" -->';
}
wp_reset_query();  // Restore global post data stomped by the_post().


?>	
<div id="spacer-2"></div>
	Show locations for:
	<div id="map-toggle-tiles">
		<a id="dial-a-ride">Dial-A-Ride</a>
		<a id="bike-paths">Bike Paths</a>
		<a id="ticket-sales">Ticket Sales</a>
		<a id="parks-and-ride">Park &amp; Ride</a>
	</div><!-- end #map-toggle-tiles -->
		</div><!-- end #map-ui-inner -->
	</div><!-- end #map-ui-container -->
</div><!-- end #map-ui-hover -->
	
	</div> <!-- id="subpage-inner-container" -->
	
</div><!-- end subpage-container -->
<div id="dark-home-bg" class="full-width">
<div id="home-links-holder" class="centered strd-width" >
	<?php get_template_part('footer-links-1'); ?>
	<br style="clear: both;" />
</div><!-- end #home-links-holder -->

</div><!-- end #dark-home-bg -->

<?php endwhile; else: ?>
			<div class="no-results">
				<p><strong>There has been an error.</strong></p>
				<p>We apologize for any inconvenience, please <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
				<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
			</div><!--noResults-->
		<?php endif; 
get_footer(); 
?>	