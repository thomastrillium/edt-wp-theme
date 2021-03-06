<?php // hello edt 

add_theme_support( 'post-thumbnails' ); 

$labels = array(
		'name'               => _x( 'Routes &amp; Schedules', 'post type general name' ),
		'singular_name'      => _x( 'route', 'post type singular name' ),
		'menu_name'          => _x( 'Routes', 'admin menu'),
		'name_admin_bar'     => _x( 'Route', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'route'),
		'add_new_item'       => __( 'Add New route'),
		'new_item'           => __( 'New route'),
		'edit_item'          => __( 'Edit Route'),
		'view_item'          => __( 'View Route'),
		'all_items'          => __( 'All Routes'),
		'search_items'       => __( 'Search Routes'),
		'parent_item_colon'  => __( 'Parent Routes:'),
		'not_found'          => __( 'No routes found.'),
		'not_found_in_trash' => __( 'No routes found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'routes' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'revisions' )
	);

	register_post_type( 'route', $args );
	
	
	$labels = array(
		'name'               => _x( 'Alerts', 'post type general name' ),
		'singular_name'      => _x( 'alert', 'post type singular name' ),
		'menu_name'          => _x( 'Alerts', 'admin menu'),
		'name_admin_bar'     => _x( 'Alert', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'alert'),
		'add_new_item'       => __( 'Add New Alert'),
		'new_item'           => __( 'New Alert'),
		'edit_item'          => __( 'Edit Alert'),
		'view_item'          => __( 'View Alert '),
		'all_items'          => __( 'All Alerts'),
		'search_items'       => __( 'Search Alerts'),
		'parent_item_colon'  => __( 'Parent Alert:'),
		'not_found'          => __( 'No alerts found.'),
		'not_found_in_trash' => __( 'No alerts found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'alerts' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions' )
	);

	register_post_type( 'alert', $args );
	
	register_taxonomy(
		'alert-zone',
		array( 'alert'),
		array(
			'label' => __( 'Alert Zone' ),
			'description' => 'Use this to properly associate the alert with the route.',
			'rewrite' => array( 'slug' => 'alert-zone' ),
			'hierarchical' => false,
		)
	);


if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('edt_jquery');
   wp_register_script('edt_jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js", false, null);
   wp_enqueue_script('edt_jquery');
}

function edt_add_stylesheets() {
        wp_enqueue_style( 'google-fonts-karla', 'http://fonts.googleapis.com/css?family=Karla:400,400italic,700,700italic'  );
        wp_enqueue_style( 'main-stylesheet', get_template_directory_uri().'/library/css/style.css'  );
        wp_enqueue_style( 'jquery-ui-stylesheet', get_template_directory_uri() . '/library/js/jquery-ui-1.11.4/jquery-ui.min.css'  );
        wp_enqueue_style( 'jquery-ui-stylesheet-smoothness', 'http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css'  );
      
    
		wp_enqueue_script(
			'custom-script',
			get_stylesheet_directory_uri() . '/library/js/main.js',
			array( 'edt_jquery' )
		);
		wp_enqueue_script(
			'planner-functionality',
			get_stylesheet_directory_uri() . '/library/js/planner.js',
			array( 'edt_jquery', 'google_places' )
		);
		wp_enqueue_script(
			'map-interactivity',
			get_stylesheet_directory_uri() . '/library/js/map.js',
			array( 'edt_jquery' )
		);
		
		wp_enqueue_script(
			'map-svg-zoom-plugin',
			get_stylesheet_directory_uri() . '/library/js/jquery.svg.pan.zoom.js',
			array( 'edt_jquery' )
		);
		wp_enqueue_script(
			'load_svg_icons',
			get_stylesheet_directory_uri() . '/library/js/icons.js',
			array( 'edt_jquery' )
		);
		
		wp_enqueue_script(
			'main_nav',
			get_stylesheet_directory_uri() . '/library/js/nav.js',
			array( 'edt_jquery' )
		);
		wp_enqueue_script(
			'edt_jquery_ui',
			get_stylesheet_directory_uri() . '/library/js/jquery-ui-1.11.4/jquery-ui.min.js',
			array( 'edt_jquery' )
		);
		wp_enqueue_script(
			'single_route',
			get_stylesheet_directory_uri() . '/library/js/single-route.js',
			array( 'edt_jquery_ui' )
		);
		
		wp_enqueue_script(
			'modernizr',
			get_stylesheet_directory_uri() . '/library/js/modernizr.js',
			array( )
		);
		wp_enqueue_script(
			'imap',
			get_stylesheet_directory_uri() . '/library/js/imap.js',
			array( 'edt_jquery')
		);
		
		wp_enqueue_script(
			'google_places',
			'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places',
			array( )
		);
		
		
		
		
    }

add_action( 'wp_enqueue_scripts', 'edt_add_stylesheets' );

register_nav_menus( array(
	'main_navigation' => 'Main Navigation',
	'subpage_navigation' => 'Subpage Navigation',
	'home_rider_info' => 'Home Rider Info Links',
	'home_about' => 'Home About Links',
) );


class Main_Nav_Walker extends Walker {

    // Tell Walker where to inherit it's parent and id values
   
     var $db_fields = array( 'parent' => 'parent_id', 'id' => 'object_id' );
     
     
    function start_lvl(&$output, $depth=0, $args) {
        $output .= "\n<ul>\n";
    }
 
    // Displays end of a level. E.g '</ul>'
    // @see Walker::end_lvl()
    function end_lvl(&$output, $depth=0, $args) {
        $output .= "</ul>\n";
    }
   
    /**
     * At the start of each element, output a <li> and <a> tag structure.
     * 
     * Note: Menu objects include url and title properties, so we will use those.
     */
   function start_el(&$output, $item, $depth=0, $args=array()) {
   		
        $output .= "<li>".$item->title;
    }
 
    // Displays end of an element. E.g '</li>'
    // @see Walker::end_el()
    function end_el(&$output, $item, $depth=0, $args=array()) {
        $output .= "</li>\n";
    }
    
    
    

}

// adds item id
function custom_walker_nav_menu_start_el($item_output, $item, $depth, $args){
	if($args->theme_location == "main_navigation"){
  		$output = '<div class="main-nav-svg-holder"><svg rel="'.slugify($item->title).'-svg"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#'.slugify($item->title).'-svg" ></use></svg></div>';
  		$output .= $item_output;
	}else {
		$output .= $item_output;
	}
	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'custom_walker_nav_menu_start_el' , 10, 4 );



// create custom plugin settings menu
add_action('admin_menu', 'trillium_gtfs_update_create_menu');

function trillium_gtfs_update_create_menu() {

	//create new top-level menu
	add_menu_page('GTFS Site Update', 'GTFS Update', 'administrator', __FILE__, 'trillium_gtfs_update_settings_page', plugins_url('/images/icon-sml.png',  __FILE__));
	
}

function add_first_and_last($items) {
    $items[1]->classes[] = 'first';
    $items[count($items)]->classes[] = 'last';
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_first_and_last');



function create_new_nav_menu($menu_name) {
		
	// Check if the menu exists
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	// If it doesn't exist, let's create it.
	$menu_id = -1;
	if( !$menu_exists){
		$menu_id = wp_create_nav_menu($menu_name);
		
	} else {
	
		wp_delete_nav_menu($menu_name);
		$menu_id = wp_create_nav_menu($menu_name);
	}
	return $menu_id;
		
}

///create custom plugin settings menu
add_action('admin_menu', 'edt_create_menu');

function edt_create_menu() {

	//create new top-level menu
	add_menu_page('Template Settings', 'Home Page Settings', 'administrator', __FILE__, 'edt_settings_page', get_template_directory_uri()+'/favicon.png');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'edt-settings-group', 'home_description' );
	register_setting( 'edt-settings-group', 'home_quote' );
	register_setting( 'edt-settings-group', 'home_quote_author' );

}

function edt_settings_page() {
?>
<div class="wrap">
<h2>Art Template Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'edt-settings-group' ); ?>
    <?php do_settings_sections( 'edt-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Homepage description</th>
        <td><textarea rows="8" cols="40"  name="home_description" > <?php echo esc_attr( get_option('home_description') ); ?></textarea></td>
        </tr>  
        <tr valign="top">
        <th scope="row">Homepage quote</th>
        <td><textarea rows="8" cols="40"  name="home_quote" > <?php echo esc_attr( get_option('home_quote') ); ?></textarea></td>
        </tr> 
        <tr valign="top">
        <th scope="row">Homepage quote author</th>
        <td><textarea rows="8" cols="40"  name="home_quote_author" > <?php echo esc_attr( get_option('home_quote_author') ); ?></textarea></td>
        </tr> 
         
       
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php 


}





function trillium_gtfs_update_settings_page() {
?>
<div class="wrap">
<img src="<?php echo get_template_directory_uri()?>/library/images/trillium-logo.png" />
<h2>GTFS Site Update</h2>
<?php

	echo '<h2>GTFS update - - uses the trillium GTFS api to sync site to live data</h2>';
	
	echo 'This pulls data from the gtfs api to update the site, only do this, while it should update smoothly, you should always make a backup before doing this. ';
	
	echo "<h3>If you want to update the site, you need to add <a href=\"".get_site_url()."/wp-admin/admin.php?page=Applications%2FMAMP%2Fhtdocs%2Fedt%2Fwp-content%2Fthemes%2Fedt%2Ffunctions.php&update=true\">&update=true</a> to the end of the url.  <br/><strong>DO NOT DO THIS IF YOU ARE UNSURE YOU?RE DOING THE RIGHT THING!!</strong></h3>";
	
	
	
	if($_GET["update"] == "true") {
		
		echo '<br /><br />updating';
		/*
		echo getcwd();
		
		echo 'br/>';
		
		include get_template_directory().'/library/php/simple_html_dom.php';
		
		
		$clever_deviced_json = file_get_contents('http://96.10.227.28/art/packet/json/shelter');
		$json = json_decode($clever_deviced_json );
		
		
		foreach($json->ShelterArray as &$shelter) {
			echo '<br /><br /><br />';
			$web_label_html = str_get_html($shelter->Shelter->WebLabel);
			echo $web_label_html->find('.labelShelterArrivalRowOdd')[0];
			//echo $shelter->Shelter->WebLabel;
			//echo trim(preg_replace('/<[^>]*>/', '****',$shelter->Shelter->WebLabel));
		}
		
			//print_r($json);*/
			
			
		
		
		// load
		
		$existing_route_lines = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'route_line',
		));
		
		foreach($existing_route_lines as &$route_line) {
			echo "route lines reset.<br />";
			wp_delete_post( $route_line->ID, true );
			
		}
		
		$existing_route = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'route',
		));
		
		foreach($existing_route as &$route) {
			echo "route reset.<br />";
			wp_delete_post( $route->ID, true );
			
		}
		
	
		
		$handle = fopen(get_site_url()."/wp-content/transit-data/eldoradotransit-ca-us/routes.txt", "r");
		$route_lines = array();
	
	
	wp_insert_term(
		 'System-Wide', // the term 
		  'alert-zone', // the taxonomy
		  array(
			'description'=> '',
			'slug' => 'all-routes'
		  )
		);
	echo "inserted term";
	
		if ($handle) {
			
			$lineCount = 0;
			 while (($line = fgets($handle)) !== false) {
				
				if($lineCount > 0) {
			
					//echo $line;
					echo "<br/>.".$line;
			
					$splitLine          =   explode(",", $line);
					$agency_id          = $splitLine[0];
					$route_id           = $splitLine[1];
					$route_short_name   = $splitLine[2];
					$route_long_name    = $splitLine[3];
					$route_desc    		= $splitLine[4];
					$route_type 		= $splitLine[5];
					$route_url		 	= $splitLine[6];
					$route_color 		= $splitLine[7];
					$route_text_color 	= preg_replace('/^\s+|\n|\r|\s+$/m', '', $splitLine[8]); // strips line break on last entry
					
					
					
					wp_insert_term(
					 'route_'.$route_short_name, // the term 
					  'alert-zone', // the taxonomy
					  array(
						'description'=> '',
						'slug' => 'route_'.$route_short_name
					  )
					);
					
					
					// make or update route_line array
					if(!array_key_exists($route_long_name, $route_lines)) {
						$route_lines[$route_long_name] = array();
					} 
						
					$route_lines[$route_long_name][] = str_replace("\"","",$route_short_name);
		
					
					$my_post = array(
					  'post_title'    => $route_long_name,
					  'post_name' => slugify($route_long_name),
					  'post_status'   => 'publish',
					  'post_type'      => 'route',
					  'post_author'   => 1
						);
	
						// Insert the post into the database
						$post_to_update_id = wp_insert_post( $my_post );
						
					 
						update_field('field_557b451a67dc8', $route_id        	, $post_to_update_id); 
						update_field('field_557b458667dc9', $route_short_name, $post_to_update_id); 
						update_field('field_557b459067dca',$route_long_name 	, $post_to_update_id); 
						update_field('field_557b459867dcb', $route_desc   	, $post_to_update_id); 
						update_field('field_557b45b367dcd', $route_text_color		 , $post_to_update_id); 
						update_field('field_557b45a067dcc', $route_color 			, $post_to_update_id); 
						
						
						
					
				}
				$lineCount ++;
			}
			
			
		 
		 };
	}
	
	?>
	
</div>
<?php


 } 
 
 function slugify($text)
{
    // Swap out Non "Letters" with a -
    $text = preg_replace('/[^\\pL\d]+/u', '-', $text); 

    // Trim out extra -'s
    $text = trim($text, '-');

    // Convert letters that we have left to the closest ASCII representation
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Make text lowercase
    $text = strtolower($text);

    // Strip out anything we haven't been able to convert
    $text = preg_replace('/[^-\w]+/', '', $text);

    return $text;
}
 


?>