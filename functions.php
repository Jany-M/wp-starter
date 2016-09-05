<?php
/* --------------------------------------------------------------------------------
*
* [WP] Starter - SETUP
* [WP] Starter is a custom framework developed by Shambix @ http://www.shambix.com
*
-------------------------------------------------------------------------------- */

// TO DO
// move admin styles to assets/css/admin.css

define('WP_STARTER_VERS', '2.8.1');

if(!defined('WP_STARTER_LIB_PATH'))
    define('WP_STARTER_LIB_PATH', TEMPLATEPATH.'/lib/');
if(!defined('WP_STARTER_LIB_URL'))
    define('WP_STARTER_LIB_URL', get_template_directory_uri().'/lib/');
if(!defined('WP_STARTER_ASSETS_PATH'))
    define('WP_STARTER_ASSETS_PATH', TEMPLATEPATH.'/assets/');
if(!defined('WP_STARTER_ASSETS_URL'))
    define('WP_STARTER_ASSETS_URL', get_template_directory_uri().'/assets/');

// ADD THEME SUPPORT
function wp_starter_theme_setup() {
	add_theme_support('post-thumbnails');
	add_theme_support( 'menus' );
    add_theme_support( 'widgets' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ));
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

        // --------------- JS
    	wp_register_script( 'boostrap_js', 'http'.($_SERVER['SERVER_PORT'] == 443 ? 's' : '').'://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), '3.3.6', true);
    	wp_enqueue_script( 'boostrap_js' );

    	// -------------- CSS
    	wp_register_style( 'fontawesome_css', 'http'.($_SERVER['SERVER_PORT'] == 443 ? 's' : '').'://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.6.3', 'all');
    	wp_enqueue_style( 'fontawesome_css' );
    	wp_register_style( 'bootstrap_css', 'http'.($_SERVER['SERVER_PORT'] == 443 ? 's' : '').'://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6', 'all');
    	wp_enqueue_style( 'bootstrap_css' );
}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'load_files');
}

// Remove the emoji detection - Who asked for it anyway
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Add css for Backend Editor
function admin_styles() {
    add_editor_style(WP_STARTER_ASSETS_URL.'css/admin.css' );
}
if(file_exists(WP_STARTER_ASSETS_PATH.'css/admin.css')) {
	add_action( 'admin_init', 'admin_styles' );
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

require_once(WP_STARTER_LIB_PATH.'scripts/contextual_help.php');

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

//require_once(WP_STARTER_LIB_PATH.'plugins/install_plugins.php');

?>
