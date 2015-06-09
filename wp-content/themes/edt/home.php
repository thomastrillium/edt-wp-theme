<?php 
get_header(); 
get_template_part('template-header');
get_template_part('planner');
get_template_part('home-map'); 

// do home pagey stuff like pull in image 
?>
<div id="interactive-map-link-holder" class="centered strd-width" >
	<div id="interactive-map-link-dashed-line" class="centered">
		<a href="<?php echo get_site_url(); ?>/map"><div id="interactive-map-home-button" class="centered">See Full Zoomable Map<i></i></div></a>

	</div><!-- end id="interactive-map-link-dashed-line" -->
</div><!-- end id="interactive-map-link-holder" -->
<div id="home-banner-holder" class="centered strd-width" >
	<img src="<?php echo get_template_directory_uri(); ?>/library/images/home-banner-temp.jpg" width="100%"/>
</div><!-- end home-banner-holder -->
<div id="home-page-quote-holder" class="centered strd-width">
	 <div class="inner">
	 	<div id="home-page-quote">"<?php echo esc_attr( get_option('home_quote') ); ?>"</div>
	 	<div id="home-page-quote-author">- <?php echo esc_attr( get_option('home_quote_author') ); ?></div>	 	
	 </div><!-- end class="inner" -->
	 <br style="clear: both;" />
</div><!-- end home-page-quote -->
<div id="dark-home-bg" class="full-width">
<div id="home-links-holder" class="centered strd-width" >
	<?php get_template_part('footer-links-1'); ?>
	<br style="clear: both;" />
</div><!-- end #home-links-holder -->
<div id="home-page-service-description" class="centered strd-width">
	 <div class="inner">
	 	<?php echo esc_attr( get_option('home_description') ); ?><a href="<?php echo get_site_url(); ?>/about-us">Read More >></a>
	 </div><!-- end class="inner" -->
	 <br style="clear: both;" />
</div><!-- end home-page-service-description -->
</div><!-- end id="dark-home-bg" -->
<?php
get_footer(); 
?>