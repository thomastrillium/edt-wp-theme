<?php
//footer stacked links
	

		//	$walker = new Main_Nav_Walker(); 
			//wp_nav_menu( array( 'theme_location' => 'main_navigation', 'walker' => $walker) ); 
			
	$menu_name = 'home_rider_info';

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

	$menu_items = wp_get_nav_menu_items($menu->term_id,array(
															'posts_per_page' => 2));
	
	$menu_list = '<div class="menu-' . $menu_name .'-container"><h3>Rider Information</h3><ul id="menu-' . $menu_name . '">';
	$item_count = 0;
	foreach ( (array) $menu_items as $key => $menu_item ) {
	    $title = $menu_item->title;
	    $url = $menu_item->url;
	    $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
	    if($item_count == 3) $menu_list .= '</ul><ul class="second-col">';
		$item_count ++;
	}
	$menu_list .= '</ul></div>';
    } else {
	$menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
    }
			
	echo $menu_list;	
		


	$menu_name = 'home_about';

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

	$menu_items = wp_get_nav_menu_items($menu->term_id,array(
															'posts_per_page' => 2));

	$menu_list = '<div class="menu-' . $menu_name .'-container"><h3>El Dorado Transit Authority</h3><ul id="menu-' . $menu_name . '">';
	$item_count = 0;
	foreach ( (array) $menu_items as $key => $menu_item ) {
	    $title = $menu_item->title;
	    $url = $menu_item->url;
	    $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
	    if($item_count == 3) $menu_list .= '</ul><ul class="second-col">';
		$item_count ++;
	}
	$menu_list .= '</ul></div>';
    } else {
	$menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
    }
			
	echo $menu_list;	



?>