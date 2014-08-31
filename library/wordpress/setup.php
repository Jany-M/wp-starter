<?php

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - SETUP
*
-------------------------------------------------------------------------------- */

// THEME
$theme = wp_get_theme();
$theme_name = $theme->get( 'TextDomain' );
$locale = get_locale();

// WPML 
/*if(function_exists('get_default_language')) {
	global $sitepress;
	$deflang = $sitepress->get_default_language();
}*/


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

?>