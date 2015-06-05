<?php 


if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

function edt_add_stylesheets() {
        wp_enqueue_style( 'google-fonts-karla', 'http://fonts.googleapis.com/css?family=Karla'  );
        wp_enqueue_style( 'main-stylesheet', get_template_directory_uri().'/library/css/style.css'  );
		wp_enqueue_script(
			'custom-script',
			get_stylesheet_directory_uri() . '/library/js/main.js',
			array( 'jquery' )
		);
    }

add_action( 'wp_enqueue_scripts', 'edt_add_stylesheets' );



?>

