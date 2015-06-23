<?php 
get_header(); 
get_template_part('template-header');
get_template_part('planner');
get_template_part('home-map'); 
//get_template_part('legend');


// do home pagey stuff like pull in image 
?>
<div id="interactive-map-link-holder" class="centered strd-width" >
	<div id="interactive-map-link-dashed-line" class="centered">
		<a href="<?php echo get_site_url(); ?>/map"><div id="interactive-map-home-button" class="centered">See Full Interactive Map<i></i></div></a>

	</div><!-- end id="interactive-map-link-dashed-line" -->
</div><!-- end id="interactive-map-link-holder" -->
<div id="home-banner-holder" class="centered strd-width" >
	<img src="<?php echo get_template_directory_uri(); ?>/library/images/home-banner-temp.jpg" width="100%"/>
</div><!-- end home-banner-holder -->

<div id="home-page-quote-holder" class="centered strd-width ">
	 <div class="inner">
	 	<div id="home-page-quote">"<?php echo esc_attr( get_option('home_quote') ); ?>"</div>
	 	<div id="home-page-quote-author">- <?php echo esc_attr( get_option('home_quote_author') ); ?></div>	 	
	 </div><!-- end class="inner" -->
	 <br style="clear: both;" />
</div><!-- end home-page-quote -->
<div id="dark-home-bg" class="full-width">
<div id="social-and-other-links" class="centered strd-width">
	<div id="social-icons-holder-home">
		<?php get_template_part('social-icons'); ?>
	</div><!-- id="social-icons-holder-home" -->
	<div id="route-shout-home">
		Get Real-time updates with 
		<a href="http://m.routeshout.com/"><svg> <use xlink:href="#routeshout-2" /></svg></a>
	</div><!-- end #route-shout-home -->
	<a id="newsletter-link">
		Sign up for our newsletter
	</a><!-- newsletter-signup -->
</div><!-- end "social-and-other-links" -->
<div id="home-links-holder" class="centered strd-width" >
	<?php get_template_part('footer-links-1'); ?>
	<br style="clear: both;" />
</div><!-- end #home-links-holder -->
<div id="home-page-service-description" class="centered strd-width">
	 <div class="inner">
	 	<?php echo esc_attr( get_option('home_description') ); ?><a href="<?php echo get_site_url(); ?>/about-us">Read More >></a>
	 	<svg  width="30" height="30" viewBox="0 0 100 100"> <use xlink:href="#commuter-icon" /></svg>
	 </div><!-- end class="inner" -->
	 <br style="clear: both;" />
</div><!-- end home-page-service-description -->
</div><!-- end id="dark-home-bg" -->
<?php
get_footer(); 
?>