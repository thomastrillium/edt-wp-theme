<?php


?>

<div id="page-header" class="centered max-width">
	<a href="<?php echo get_site_url();?>"><div id="top-links">
		<div id="top-links-transit-description">
			Public transportation for the Western Slope of El Dorado County
		</div><!-- end #top-links-transit-description -->
		<div id="top-links-phone">
			Info: 000-000-0000
		</div><!-- end #top-links-phone -->
		<br style="clear: both;" />
	</div><!-- end #top-links -->
	<div id="logo-holder">
	 
		<img id="logo" src="<?php echo get_template_directory_uri();?>/library/images/logo.png" />
		<img id="logo-text" src="<?php echo get_template_directory_uri();?>/library/images/logo_text.png" />
		<br style="clear: both;" />
	</div><!-- end #logo -->
	</a><!-- home link -->
	
	<nav id="main-nav" >
		<?php 
		//	$walker = new Main_Nav_Walker(); 
			//wp_nav_menu( array( 'theme_location' => 'main_navigation', 'walker' => $walker) ); 
				$defaults = array(
	'theme_location'  => 'main_navigation',
	'menu'            => '',
	'container'       => 'div',
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => 'menu',
	'menu_id'         => '',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '<i></i>',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s<br style="clear:both"/></ul>',
	'depth'           => 0,
	'walker'          => ''
);

wp_nav_menu( $defaults );			
						
		
		
		?>
	

	</nav>
	<br style="clear: both;" />
</div> <!-- end #page-header -->