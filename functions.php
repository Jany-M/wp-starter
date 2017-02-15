<?php
/* --------------------------------------------------------------------------------
*
* [WP] Starter - SETUP
* [WP] Starter is a custom framework developed by Shambix @ http://www.shambix.com
*
-------------------------------------------------------------------------------- */

// TO DO
// move admin styles to assets/css/admin.css

define('WP_STARTER_VERS', '3');

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
    	wp_register_script( 'boostrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
    	wp_enqueue_script( 'boostrap_js' );

    	// -------------- CSS
    	wp_register_style( 'fontawesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', 'all');
    	wp_enqueue_style( 'fontawesome_css' );
    	wp_register_style( 'bootstrap_css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), '3.3.7', 'all');
    	wp_enqueue_style( 'bootstrap_css' );
}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'load_files');
}

// Remove the emoji detection
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Add css for Backend Editor
function admin_styles() {
    add_editor_style(WP_STARTER_ASSETS_URL.'css/admin.css' );
}
if(file_exists(WP_STARTER_ASSETS_PATH.'css/admin.css')) {
	add_action( 'admin_init', 'admin_styles' );
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEV* HELPERS
*
-------------------------------------------------------------------------------- */

if(file_exists(WP_STARTER_ASSETS_PATH.'scripts/contextual_help.php')) {
    require_once WP_STARTER_LIB_PATH.'scripts/contextual_help.php';
}

// Theme Notices
function dont_activate_msg() { ?>
	<div class="notice notice-error">
	    <p><?php _e('<code>[WP] Starter</code> is a parent theme and it\'s not supposed to be activated nor edited', THEME_DOMAIN); ?>.</p>
		<p><?php _e('In order to build on top of this parent, please download <code>[WP] Starter Child Theme</code> from <a href="https://github.com/Jany-M/WP-Starter-Child-Theme" target="_blank">GitHub</a> and place it in the folder <code>/wp-content/themes/</code>', THEME_DOMAIN); ?>.</p>
        <p><?php _e('You can then start editing the child theme, rename it, add template files etc.', THEME_DOMAIN); ?>.</p>
	</div>
    <?php
}
$get_theme = wp_get_theme();
if($get_theme->get( 'Name' ) == '[WP] Starter')
    add_action( 'admin_notices', 'dont_activate_msg' );

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEV* REQUIRED & RECOMMENDED PLUGINS
*
-------------------------------------------------------------------------------- */

if(file_exists(WP_STARTER_LIB_PATH.'plugins/install_plugins.php')) {
    require_once(WP_STARTER_LIB_PATH.'plugins/install_plugins.php');
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - CREDITS & LOGIN
*
-------------------------------------------------------------------------------- */

// Backend Footer Credits
// Please leave this in place or add your own links next to ours.
function wp_starter_admin_footer() {
	echo '<div id="shambix_credits"><p>Theme built with <a href="http://www.shambix.com" target="_blank">[WP] Starter</a> - Developed by <a href="http://www.shambix.com" target="_blank">Shambix</a> for WordPress.</p></div>';
}
add_filter('admin_footer_text', 'wp_starter_admin_footer');

// Customize Footer for Login page
function custom_login_css() {
	?>
	<style type="text/css">
		#shambix_credits {
			margin: auto;
			padding: 8% 0 0;
			width: 320px;
			text-align: center;
		}
	</style>
	<?php
}
add_action('login_head', 'custom_login_css');
function wp_starter_login_footer() {
	echo '<div id="shambix_credits" class="mute credits"><p id="backtoblog"><a href="https://github.com/Jany-M/WP-Starter" target="_blank">[WP] Starter</a> developed by <a href="http://www.shambix.com" target="_blank">Shambix</a></p></div>';
}
add_action('login_footer', 'wp_starter_login_footer');

function wp_starter_login_url() {
	get_bloginfo('siteurl');
}
add_filter('login_headerurl', 'wp_starter_login_url');

function wp_starter_login_title() {
	get_option('blogname');
}
add_filter('login_headertitle', 'wp_starter_login_title');

?>
