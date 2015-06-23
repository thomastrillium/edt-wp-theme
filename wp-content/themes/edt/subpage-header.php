<?php 
get_header(); 
get_template_part('template-header'); ?>
<div id="subpage-container" class="full-width centered" >
	<div id="subpage-inner-container" class="max-width centered">
	<div id="home-map-top-border" class="centered max-width" ></div>
	<div id="subpage-sidebar">
		<a id="subpage-interactive-map-button" href="#">
			Full Interactive Map 
			<svg rel="commuter-svg"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#map"></use></svg>
		</a><!-- end #subpage-interactive-map-button -->
						<?php 
				//	$walker = new Main_Nav_Walker(); 
					//wp_nav_menu( array( 'theme_location' => 'main_navigation', 'walker' => $walker) ); 
			$defaults = array(
			'theme_location'  => 'subpage_navigation',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => 'subpage-nav-container',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true, 
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);
  
		wp_nav_menu( $defaults );	
		?>
		<div id="subpage-route-shout-holder">
			Get real time updates with
			<a href="#">
				<svg rel="commuter-svg"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#routeshout"></use></svg>
			</a>
		</div>
		<a id="subpage-newsletter">
			Sign up for<br />our newsletter
		</a>
		<div id="subpage-social-holder">
			<?php get_template_part('social-icons'); ?>
		</div>
	</div><!-- end #subpage-sidebar -->
	<div id="subpage-main-col">
	
