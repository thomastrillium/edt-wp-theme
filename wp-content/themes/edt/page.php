<?php 
	
	get_template_part('subpage-header');
	
	if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<h1><?php the_title(); ?></h3> 
			
				<?php
								  
				 $children = get_pages('child_of='.$post->ID.'&parent='.$post->ID);
				 if(sizeof($children)> 0) {
				 ?>
					<div id="child-page-holder" >
						<!--<div id="subpage-link-title">Subpages:</div>--!>
						<ul>
							 <?php
				
							 foreach($children as &$child) {
								echo '<li><a href="'.get_the_permalink($child->ID).'">'.$child->post_title.'</a></li>';
							 }
							 ?>
							
						 </ul>
																	 <br style="clear: both;" />
				</div><!-- end #child-page-holder -->
				 <?php
				  }
				  
				  		wp_reset_postdata();

				 ?>
			
			
			<br style="clear: both;" />
			<div id="subpage-main-content">
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
						<?php the_content(); ?>
					</div>
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
		
		