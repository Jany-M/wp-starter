<?php

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - SETUP
*
-------------------------------------------------------------------------------- */

// ERROR HANDLING - If you need to debug
/*if(current_user_can('edit_posts')) :
	error_reporting(E_ALL); // everything
	else :
	error_reporting(0);
endif;*/

// THEME
$theme = wp_get_theme();
$theme_name = $theme->get( 'TextDomain' ); //use this var when necessary, for inline translations eg. _e('Contact us', $theme_name);
$locale = get_locale(); 

// WPML 
if(array_key_exists('sitepress', $GLOBALS)) {
	global $sitepress;
	$deflang = $sitepress->get_default_language();
	if(defined('ICL_LANGUAGE_CODE')) {
		$lang = ICL_LANGUAGE_CODE; //use this var when necessary
	}
} else {
	//$lang = 'en';
}


function wp_starter_theme_setup() {
	global $theme_name;
	// ADD THEME SUPPORT
	add_theme_support('post-thumbnails');      // wp thumbnails
	add_theme_support( 'menus' );            // wp menus - Add menus from custom_menus.php
	/*add_theme_support( 'post-formats',      // post formats
		array( 
			'aside',   // title less blurb
			'gallery', // gallery of images
			'link',    // quick link to other site
			'image',   // an image
			'quote',   // a quick quote
			'status',  // a Facebook like status update
			'video',   // video 
			'audio',   // audio
			'chat'     // chat transcript 
		)
	);*/	
	//set_post_thumbnail_size(125, 125, true);   // default thumb size
	//add_theme_support( 'custom-background' );  // wp custom background
	//add_theme_support('automatic-feed-links'); // rss thingy
	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	// ADD WOOCOMMERCE 
	//add_theme_support( 'woocommerce' );
	// ADD LANGUAGE FILE
	load_theme_textdomain( $theme_name, get_template_directory() . '/languages' );
}
add_action('after_setup_theme','wp_starter_theme_setup');

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CSS & JS
*
-------------------------------------------------------------------------------- */

function load_files() {
	// ------------- JS
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', '', '2.1.0');
    wp_enqueue_script( 'jquery' );
	wp_register_script( 'boostrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', array('jquery'), '3.3.1', true);
	wp_enqueue_script( 'boostrap_js' );

	// -------------- CSS
	wp_register_style( 'bootstrap_css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css', '3.3.1', 'all');
	wp_enqueue_style( 'bootstrap_css' );
	wp_register_style( 'fontawesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', '4.2.0', 'all');
	wp_enqueue_style( 'fontawesome_css' );
	
	wp_register_style( 'theme_css', ''.get_stylesheet_uri().'', null, 'screen');
	wp_enqueue_style( 'theme_css' );

	if(file_exists(get_template_directory_uri().'/custom/css/responsive.css')) {
		wp_register_style( 'resp_theme_css', get_template_directory_uri().'/custom/css/responsive.css', null, 'screen');
		wp_enqueue_style( 'resp_theme_css' );
	}

	// -------------- STYLES, ICONS & HELPERS
	wp_register_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr.full.min.js', '', '2.8.3', true );
	wp_enqueue_script('modernizr');

	/*wp_register_style( 'fancybox_css', ''.get_template_directory_uri() . '/library/helpers/fancybox/jquery.fancybox.css', '2.1.5', 'screen');
	wp_enqueue_style( 'fancybox_css' );
	wp_register_script( 'fancybox_js', get_template_directory_uri().'/library/helpers/fancybox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true);
	wp_enqueue_script( 'fancybox_js' );*/

	/*wp_register_script( 'videojs_js', '//vjs.zencdn.net/4.2/video.js','', '4.2', true);
	wp_enqueue_script( 'videojs_js' );
	wp_register_style( 'videojs_css', '//vjs.zencdn.net/4.2/video-js.css', '4.2', 'all');
	wp_enqueue_style( 'videojs__css' );*/

	/*wp_register_script( 'img_loaded', ''.get_template_directory_uri().'/library/js/imagesloaded.pkgd.min.js', '', '3.1.8', true);
	wp_enqueue_script( 'img_loaded' );

	wp_register_script( 'isotope', ''.get_template_directory_uri().'/library/js/isotope.pkgd.min.js', '', '2.1.0', true);
	wp_enqueue_script( 'isotope' );

	wp_register_script( 'infinite_scroll', ''.get_template_directory_uri().'/library/js/jquery.infinitescroll.min.js', array('jquery'), '2.1.0', true);
	wp_enqueue_script( 'infinite_scroll' );

	wp_register_script( 'easing', '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js',  array('jquery'), '1.3', true);
	wp_enqueue_script( 'easing' );*/

	/*wp_register_style( 'metro_normalizer_css', ''.get_template_directory_uri() . '/library/styles/metro/css/m-normalize-min.css', null, 'screen');
	wp_enqueue_style( 'metro_normalizer_css' );
	wp_register_style( 'metro_buttons_css', ''.get_template_directory_uri() . '/library/styles/metro/css/m-buttons-min.css', null, 'screen');
	wp_enqueue_style( 'metro_buttons_css' );
	wp_register_style( 'metro_forms_css', ''.get_template_directory_uri() . '/library/styles/metro/css/m-forms-min.css', null, 'screen');
	wp_enqueue_style( 'metro_forms_css' );
	wp_register_style( 'metro_icons_css', ''.get_template_directory_uri() . '/library/styles/metro/css/m-icons-min.css', null, 'screen');
	wp_enqueue_style( 'metro_icons_css' );
	wp_register_style( 'metro_style_css', ''.get_template_directory_uri() . '/library/styles/metro/css/m-styles-min.css', null, 'screen');
	wp_enqueue_style( 'metro_styles_css' );
	*/

	// -------------- CUSTOM
}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
	add_action('wp_enqueue_scripts', 'load_files');
}

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CUSTOM FILES & HELPERS
*
-------------------------------------------------------------------------------- */

include('library/helpers/wp-imager.php'); // script to resize and cache images.. and more
include('library/wordpress/cool_scripts.php'); // wide selection of functions for your theme, some are disabled by default, some you can copy here and customize (but comment them there, then)
include('library/wordpress/shortcodes.php');
//include('custom/wordpress/custom_post_types.php'); // use this file to Add Custom Post Types and Custom Taxonomies
//include('custom/wordpress/custom_panel.php'); // use this file to customize the WP backend/panel
//include('custom/wordpress/custom_menus.php'); // use this file to add menus
//include('custom/wordpress/custom_sidebars_widgets.php'); // use this file to add sidebars and custom widgets
//include('custom/wordpress/custom_meta_boxes.php'); // use this file to add custom meta boxes or edit system ones

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CUSTOM FUNCTIONS
*
-------------------------------------------------------------------------------- */

// WOOCOMMERCE
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

?>