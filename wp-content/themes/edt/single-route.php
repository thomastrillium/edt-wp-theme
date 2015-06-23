<?php 
	
	get_template_part('subpage-header');
	
	if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php
				$icon = '';
				$agency_id = get_field('agency_id');
				$route_id = get_field('route_id');
				$route_short_name = get_field('route_short_name');
				$route_long_name = get_field('route_long_name');
				$route_desc = get_field('route_desc');
				$route_type = get_field('route_type');
				$route_url = get_field('route_url');
				$route_color = get_field('route_color');
				$route_text_color = get_field('route_text_color');
				// customize icon depending if service is commuter or local
				if($route_short_name == "C" ||
					$route_short_name == "50X" ) {
					$icon = '<svg class="route-icon"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#commuter-svg-2"></use></svg>';
				} else {
					$icon = '<svg class="route-icon"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#local-svg-2"></use></svg>';
				}
			?>
			

				
			<h1 style="background-color: #<?php echo $route_color; ?>;">
				<?php echo $icon; ?>Route <?php the_field('route_short_name'); ?> : <?php the_title(); ?>
				<div id="route-select-button">
					<i></i>
					Change Route
				</div><!-- end #route-select-button -->
			</h1> 
	
			<div id="subpage-main-content">
				<div id="route-links">
					<div id="route-jump-links">
						
						Jump to:
						<ul>
							<li><a href="#timetable">Timetables</a>
							<li><a href="#map">Map</a>
						</ul>
					</div><!-- end #route-jump-links -->
					<a id="pdf-link" href="#download-pdf"><i></i>El Dorado Transit Riders Guide</a>
				</div><!-- end #route-links -->
				
			
			<?php if( has_post_thumbnail()) { ?>
					<div id="subpage-image-holder">
						<img class="featured-image" src="
						<?php
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
							echo $thumb_url_array[0];
						?>
						">
					</div><!-- end subpage-image-holder -->
			<?php } ?>
					<div id="content-holder">
						<?php echo $route_desc; ?>
					</div>
					<? $timetableFiles = scandir(getcwd().'/wp-content/transit-data/timetables/');
						$this_route_name = strtolower (str_replace(" ", "_",$route_long_name));
						//echo $this_route_name;
						$stop_table_html = array();
						$stop_table_names = array();
						foreach($timetableFiles as &$timetableFile){
							//echo $timetableFile;
							if(strpos($timetableFile, $this_route_name) !== false) {
								//echo $this_route_name;
								$stop_table_html[] = file_get_contents (getcwd().'/wp-content/transit-data/timetables/'.$timetableFile);
								$stop_table_names[] = ucfirst(split('_',str_replace('.html','',$timetableFile))[1]);

							}	
						} ?>
					<a name="timetable"></a>
					<?php
						//print_r($stop_table_html);
						foreach($stop_table_html as $ind=>$html) { ?>
						<div id="timetable-holder"  >
						
						<h2 id="timetable-banner-<?php echo $ind; ?>" class="timetable-banner" ><?php echo $stop_table_names[$ind]; ?> Timetable<i></i><span>(Click to Expand)</span></h2>
						<div id="timetable-content" style="display: none;">
							<?php
						// get all files in transit-data/timetables folder
						
						echo $html;
						//$stop_table_url =  getcwd().'/wp-content/transit-data/timetables/'.strtolower (str_replace(".", "",str_replace(" ", "_",get_field('route_long_name')))).'.html';
						//$stop_table_html = str_get_html(file_get_contents ($stop_table_url));

						?>
						</div><!-- end timetable-content -->
						
					</div><!-- end timetable-holder -->
							
							<?php
						}
						?>
					
			</div><!-- end #subpage-main-content -->
		<?php endwhile; else: ?>
			<div class="no-results">
				<p><strong>There has been an error.</strong></p>
				<p>We apologize for any inconvenience, please <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
				<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
			</div><!--noResults-->
		<?php endif; 
		
		get_template_part('subpage-footer');
		?>
		
		