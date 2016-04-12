<?php
/* --------------------------------------------------------------------------------
*
* [WP] Starter - SETUP
* [WP] Starter is a custom framework developed by Shambix @ http://www.shambix.com
*
-------------------------------------------------------------------------------- */

define('WP_STARTER_VERS', '2.7.1');
if(!defined('WP_STARTER_LIB'))
    define('WP_STARTER_LIB', TEMPLATEPATH.'/lib/');

// get_stylesheet_directory_uri(); // Child Theme
// get_template_directory_uri(); // Parent Theme

// THEME & WP
global $locale;
$locale = get_locale();
if(!defined('WP_HOME'))
    define('WP_HOME', get_bloginfo('url'));
if(!defined('WP_SITEURL'))
    define('WP_SITEURL', get_bloginfo('url'));

// WPML / if installed
if(array_key_exists('sitepress', $GLOBALS)) {
	global $sitepress;
	$deflang = $sitepress->get_default_language(); // This is WP default lang, as set from WPML
    global $deflang;
	if(defined('ICL_LANGUAGE_CODE')) {
		$lang = ICL_LANGUAGE_CODE; // This is the
        global $lang;
	}
} else {
	//$lang = $locale; //set your default lang
}

// ADD THEME SUPPORT
function wp_starter_theme_setup() {
	add_theme_support('post-thumbnails');
	add_theme_support( 'menus' );
    add_theme_support( 'widgets' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' )); // allows the use of HTML5 markup for the comment lists, comment forms, search forms and galleries

    // ADD WOOCOMMERCE
    add_theme_support( 'woocommerce' ); // using woocommerce with child themes can lead to issues
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
    	// Latest jQuery - IE <9 not supported
        wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js", array(), '2.1.4');

    	// This version is older and discontinued, but is more compatible with existing scripts & plugins
    	//wp_register_script( 'jquery', '//code.jquery.com/jquery-1.11.2.min.js', '', '1.11.2');*/
        wp_enqueue_script( 'jquery' );
    	wp_register_script( 'boostrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), '3.3.6', true);
    	wp_enqueue_script( 'boostrap_js' );


    	// -------------- CSS
    	wp_register_style( 'fontawesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0', 'all');
    	wp_enqueue_style( 'fontawesome_css' );
    	wp_register_style( 'bootstrap_css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6', 'all');
    	wp_enqueue_style( 'bootstrap_css' );
}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'load_files');
}

// Custom Login form CSS
/*function wp_starter_login_css() {
    echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/library/css/login.css">';
}
add_action('login_head', 'wp_starter_login_css');*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEV* HELPERS
*
-------------------------------------------------------------------------------- */

require_once(WP_STARTER_LIB.'wordpress/contextual_help.php');

// REMOVE WP DEFAULT HELP TABS
//$screen->remove_help_tab( $id )
add_action( 'admin_head', 'remove_wp_tabs', 1 );
function remove_wp_tabs () {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEV* REQUIRED & RECOMMENDED PLUGINS
*
-------------------------------------------------------------------------------- */

require_once(WP_STARTER_LIB.'helpers/install_plugins.php');

?>
