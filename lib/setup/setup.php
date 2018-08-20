<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter - CONFIG
*
-------------------------------------------------------------------------------- */

if(!defined('WP_STARTER')) {
	define('WP_STARTER', 'wp-starter');
}
if(!defined('WP_STARTER_SETUP_PATH')) {
    define('WP_STARTER_SETUP_PATH', get_template_directory_uri().'/setup/');
}
if(!defined('WP_STARTER_LIB_PATH')) {
    define('WP_STARTER_LIB_PATH', TEMPLATEPATH.'/lib/');
}
if(!defined('WP_STARTER_LIB_URL')) {
    define('WP_STARTER_LIB_URL', get_template_directory_uri().'/lib/');
}
if(!defined('WP_STARTER_ASSETS_PATH')) {
    define('WP_STARTER_ASSETS_PATH', TEMPLATEPATH.'/assets/');
}
if(!defined('WP_STARTER_ASSETS_URL')) {
    define('WP_STARTER_ASSETS_URL', get_template_directory_uri().'/assets/');
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - INCLUDES
*
-------------------------------------------------------------------------------- */
// https://build.reduxframework.com/wp-admin/admin.php?page=_options&tab=1
include_once (WP_STARTER_SETUP_PATH.'redux/admin-init.php');
//require_once (dirname(__FILE__) . 'redux-config.php');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - SETUP
*
-------------------------------------------------------------------------------- */

// ADD THEME SUPPORT
if(!function_exists('wp_starter_theme_setup')) {
	function wp_starter_theme_setup() {
		add_theme_support('post-thumbnails');
		add_theme_support( 'menus' );
	    add_theme_support( 'widgets' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ));
	    // WooCommerce Support
	    add_theme_support( 'woocommerce' );
	}
	add_action('after_setup_theme','wp_starter_theme_setup');
}

//Add Excerpt Capability to Pages
if(!function_exists('wp_starter_page_excerpt_extend')) {
	function wp_starter_page_excerpt_extend() {
		add_post_type_support( 'page', 'excerpt' );
	}
	add_action('init', 'wp_starter_page_excerpt_extend');
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - CSS & JS
*
-------------------------------------------------------------------------------- */

// LOAD BASIC SCRIPTS
if(!function_exists('wp_starter_file_load')) {
	function wp_starter_file_load() {
	    // JS
		wp_deregister_script('jquery');
		// https://getbootstrap.com/docs/4.0/getting-started/introduction/
		wp_register_script( 'jquery_slim_js', '//code.jquery.com/jquery-3.2.1.slim.min.js', array(), '3.2.1-slim', true);
	    wp_enqueue_script( 'jquery_slim_js' );
		wp_register_script( 'popper_js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js', array(), '1.11.0', true);
	    wp_enqueue_script( 'popper_js' );
	    wp_register_script( 'boostrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js', array('jquery_slim_js', 'popper_js'), '4-beta', true);
	    wp_enqueue_script( 'boostrap_js' );
		wp_register_script( 'fontwaesome_js', '//use.fontawesome.com/b08bb716fc.js', array(), '4.7.0', true);
	    wp_enqueue_script( 'fontwaesome_js' );
	    // CSS
	    /*wp_register_style( 'fontawesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', 'all');
	    wp_enqueue_style( 'fontawesome_css' );*/
	    wp_register_style( 'bootstrap_css', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css', array(), '4-beta', 'all');
	    wp_enqueue_style( 'bootstrap_css' );
	}
}

// Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'wp_starter_file_load');
}

// Add css for Backend Editor
if(!function_exists('wp_starter_admin_styles')) {
	function wp_starter_admin_styles() {
	    add_editor_style(WP_STARTER_ASSETS_URL.'css/wp-starter_admin.css' );
	}
	if(file_exists(WP_STARTER_ASSETS_PATH.'css/wp-starter_admin.css')) {
		add_action( 'admin_init', 'wp_starter_admin_styles' );
	}
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEV* HELPERS
*
-------------------------------------------------------------------------------- */

if(file_exists(WP_STARTER_ASSETS_PATH.'scripts/contextual_help.php')) {
    require_once WP_STARTER_LIB_PATH.'scripts/contextual_help.php';
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEV* REQUIRED & RECOMMENDED PLUGINS
*
-------------------------------------------------------------------------------- */

if(file_exists(WP_STARTER_LIB_PATH.'plugins/install_plugins.php')) {
    require_once(WP_STARTER_LIB_PATH.'plugins/install_plugins.php');
}

// Theme Notices
/*function wp_starter_dont_activate_msg() { ?>
	<div class="notice notice-error">
	    <p><?php _e('<code>[WP] Starter</code> is a parent theme and it\'s not supposed to be activated nor edited', THEME_DOMAIN); ?>.</p>
		<p><?php _e('In order to build on top of this parent, please download <code>[WP] Starter Child Theme</code> from <a href="https://github.com/Jany-M/WP-Starter-Child-Theme" target="_blank">GitHub</a> and place it in the folder <code>/wp-content/themes/</code>', THEME_DOMAIN); ?>.</p>
        <p><?php _e('You can then start editing the child theme, rename it, add template files etc.', THEME_DOMAIN); ?>.</p>
	</div>
    <?php
}
$get_theme = wp_get_theme();
if($get_theme->get( 'Name' ) == '[WP] Starter') {
    add_action( 'admin_notices', 'wp_starter_dont_activate_msg' );
}*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter - CREDITS & LOGIN
*
* Please leave these in place or add your own links next to ours.
*
-------------------------------------------------------------------------------- */

// Backend Footer Credits
if(!function_exists('wp_starter_admin_styles')) {
	function wp_starter_admin_footer() {
		echo '<div id="shambix_credits"><p>Theme built with <a href="http://www.shambix.com" target="_blank">[WP] Starter</a> - Developed by <a href="http://www.shambix.com" target="_blank">Shambix</a> for WordPress.</p></div>';
	}
	//add_filter('admin_footer_text', 'wp_starter_admin_footer');
}

// Customize Footer for Login page
if(!function_exists('wp_starter_custom_login_css')) {
	function wp_starter_custom_login_css() {
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
	add_action('login_head', 'wp_starter_custom_login_css');
}
if(!function_exists('wp_starter_login_footer')) {
	function wp_starter_login_footer() {
		echo '<div id="shambix_credits" class="mute credits"><p><a href="https://github.com/Jany-M/WP-Starter" target="_blank">[WP] Starter</a> developed by <a href="http://www.shambix.com" target="_blank">Shambix</a></p></div>';
	}
	add_action('login_footer', 'wp_starter_login_footer');
}
if(!function_exists('wp_starter_login_url')) {
	function wp_starter_login_url() {
		get_bloginfo('siteurl');
	}
	add_filter('login_headerurl', 'wp_starter_login_url');
}
if(!function_exists('wp_starter_login_title')) {
	function wp_starter_login_title() {
		get_option('blogname');
	}
	add_filter('login_headertitle', 'wp_starter_login_title');
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - BACKEND
*
-------------------------------------------------------------------------------- */

// loading jquery reply elements on single pages automatically
if (!is_admin()){
	function comments_queue_js(){
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script( 'comment-reply' );
	}
}
// reply on comments script
if (!is_admin()){
	add_action('wp_print_scripts', 'comments_queue_js');
}

// Remove Comment Feed
function remove_comments_rss( $for_comments ) {
	return;
}
add_filter('post_comments_feed_link','remove_comments_rss');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - REMOVE CUSTOMIZER
*
-------------------------------------------------------------------------------- */

// Remove Customizer from Admin Menu
/*function remove_sub_menus () {
    remove_submenu_page('themes.php', 'customize.php'); //Customize
}
add_action('admin_menu', 'remove_sub_menus', 999);

// Remove Customizer from Admin Bar
function remove_customizer_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('customize');
}
add_action( 'wp_before_admin_bar_render', 'remove_customizer_admin_bar' );

// Drop some customizer actions
remove_action( 'plugins_loaded', '_wp_customize_include', 10);
remove_action( 'admin_enqueue_scripts', '_wp_customize_loader_settings', 11);

// Manually overrid Customizer behaviors
function override_load_customizer_action() {
    wp_die( __( 'The Customizer is currently disabled.', THEME_DOMAIN) );
}
add_action( 'load-customize.php','override_load_customizer_action', 999);

// Remove customize capability
function filter_to_remove_customize_capability( $caps = array(), $cap = '', $user_id = 0, $args = array() ) {
    if ($cap == 'customize') {
        return array('nope'); // thanks @ScreenfeedFr, http://bit.ly/1KbIdPg
    }
    return $caps;
}
add_filter( 'map_meta_cap', 'filter_to_remove_customize_capability', 10, 4 );
*/

// REMOVE WP DEFAULT HELP TABS
//$screen->remove_help_tab( $id )
if(!function_exists('wp_starter_remove_wp_tabs')) {
	function wp_starter_remove_wp_tabs () {
	    $screen = get_current_screen();
	    $screen->remove_help_tabs();
	}
	add_action( 'admin_head', 'wp_starter_remove_wp_tabs', 1 );
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - FRONTEND
*
-------------------------------------------------------------------------------- */

// Rimuovi lang attribute per HTML5
/*function create_valid_xhtml_1_1($language_attributes) {
	echo '';
}
add_filter('language_attributes', 'create_valid_xhtml_1_1');*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter - USER PROFILE
*
-------------------------------------------------------------------------------- */

// Remove dumb contact methods
if(!function_exists('wp_starter_remove_contact_fields')) {
	function wp_starter_remove_contact_fields($contactmethods) {
		unset($contactmethods['aim']);
		unset($contactmethods['jabber']);
		unset($contactmethods['yim']);
		//unset($contactmethods['url']); // this actually doesnt work -_-
		//$contactmethods['twitter'] = 'Twitter'; // add new one
		return $contactmethods;
	}
	add_filter('user_contactmethods','wp_starter_remove_contact_fields',10,1);
}

// Remove Personal options crap
if(is_admin()) {
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
}

/*function wp_starter_prefix_hide_personal_options() { ?>
	<script type="text/javascript">
	  jQuery(document).ready(function( $ ){
		$("#your-profile .form-table:first, #your-profile h3:first").remove();
	  });
	</script>
<?php }
if(is_admin()) {
  add_action( 'personal_options', 'wp_starter_prefix_hide_personal_options' );
}*/

// Remove Nickname for non admin
function hide_nickname() {
	if (current_user_can('manage_options')) return false;
	?>
		<script type="text/javascript">
		  jQuery(document).ready(function( $ ){
			$("#nickname,#display_name").parent().parent().remove();
		  });
		</script>
	<?php
	}
//if (is_admin()) add_action('personal_options', 'hide_nickname');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - RSS
*
-------------------------------------------------------------------------------- */

// Add images to Feeds
function wp_starter_img_rss($content) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ){
		$content = '<div>' . get_the_post_thumbnail( $post->ID, 'medium', array( 'style' => 'margin-bottom: 15px;' ) ) . '</div>' . $content;
	}
	return $content;
}
add_filter('the_excerpt_rss', 'wp_starter_img_rss');
add_filter('the_content_feed', 'wp_starter_img_rss');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - PERFORMANCE
*
-------------------------------------------------------------------------------- */

// Flush Transients button from Admin bar
if(!function_exists('wp_starter_flush_transients_button')) {
	function wp_starter_flush_transients_button() {
		global  $wp_admin_bar,
	            $_wp_using_ext_object_cache;

		if(file_exists(WP_CONTENT_DIR.'/object-cache.php')) {
		    return;
		    //wp_using_ext_object_cache(true);
		}

	    if($_wp_using_ext_object_cache === true)
	        return;

		// If User isnt even logged in or if admin bar is disabled
		if ( !is_user_logged_in() || !is_admin_bar_showing() )
			return false;

		// If user doesnt have the perms
		if ( function_exists('current_user_can') && false == current_user_can('activate_plugins') )
			return false;

		// Button args
		$wp_admin_bar->add_menu( array(
			'parent' => '',
			'id' => 'flush_transients_button',
			'title' => __( 'Flush Transients' ),
			'meta' => array( 'title' => __( 'Delete all WP Transients (in wp_options table)' )),
			'href' => wp_nonce_url( admin_url( 'index.php?action=deltransientpage'), 'flush_transients_button' ))
		);
	}
	add_action( 'admin_bar_menu', 'wp_starter_flush_transients_button', 35 );
}

// Flush transients function
if(!function_exists('wp_starter_flush_transients')) {
	function wp_starter_flush_transients() {
		global $_wp_using_ext_object_cache;

		if($_wp_using_ext_object_cache === true)
			return;

		// Check Perms
		if ( function_exists('current_user_can') && false == current_user_can('activate_plugins') )
			return false;

		// Flush Cache
		if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'deltransientpage' && ( isset( $_GET[ '_wpnonce' ] ) ? wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'flush_transients_button' ) : false ) ) {

	    	// Get all Transients
	    	global $wpdb;
	    	$sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
	    			FROM  $wpdb->options
	            	WHERE `option_name` LIKE '%transient_%'
	            	ORDER BY `option_name`";
	    	$get_all_site_transients = $wpdb->get_results( $sql );

			// Delete all Transients
	    	foreach ($get_all_site_transients as $transient) {
				$transient_name = str_replace(array('_transient_timeout_', '_transient_', '_site_transient_', '_site_transient_timeout_'), '', $transient->name);
	    		delete_transient($transient_name);
	    	}

	    	// If using object cache
	    	if($_wp_using_ext_object_cache) {
		    	wp_cache_flush();
	    	}

			wp_redirect(admin_url().'?cache_type=transients&cache_status=flushed');
			die();
		} else {
			wp_redirect(admin_url().'?cache_type=transients&cache_status=not_flushed');
			die();
		}

	}
	if ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'deltransientpage' ) {
		add_action( 'admin_init', 'wp_starter_flush_transients');
	}
}

// Flushed transients message
if(!function_exists('wp_starter_flush_display_admin_msg')) {
	function wp_starter_flush_display_admin_msg() {
		if(!isset($_GET[ 'cache_status' ]) || $_GET[ 'cache_status' ] == '')
			return;

		// Display Msg
		if ( $_GET[ 'cache_status' ] == 'flushed' ) { ?>
		    <div class="updated">
		        <p><?php echo ucwords($_GET[ 'cache_type' ]); ?> Cache was successfully flushed.</p>
		    </div>
	    	<?php
		} elseif ( $_GET[ 'cache_status' ] == 'not_flushed' ) { ?>
		    <div class="error">
		        <p><?php echo ucwords($_GET[ 'cache_type' ]); ?> Cache was NOT flushed.</p>
		    </div>
	    	<?php
		}
	}
	add_action( 'admin_notices', 'wp_starter_flush_display_admin_msg' );
}

// Schedule the CRON Job to purge all expired transients
if (!wp_next_scheduled('purge_popup_transients_cron')) {
	/**
	 * wp_schedule_event
	 *
	 * @param - When to start the CRON job
	 * @param - The interval in for each subsequent run
	 * @param - The name of the CRON JOB
	 */
	wp_schedule_event( time(), 'daily', 'purge_popup_transients_cron');
}

add_action( 'purg_transients_cron',  'purge_transients', 10 ,2);

/**
 * Deletes all transients that have expired
 *
 * @access public
 * @static
 * @return void
 */
static function purge_popup_transients($older_than = '1 day', $safemode = true) {

	global $wpdb;
	$older_than_time = strtotime('-' . $older_than);

	/**
	 * Only check if the transients are older than the specified time
	 */

	if ( $older_than_time > time() || $older_than_time < 1 ) {
		return false;
	}

	/**
	 * Get all the expired transients
	 *
	 * @var mixed
	 * @access public
	 */
	$transients = $wpdb->get_col(
		$wpdb->prepare( "
				SELECT REPLACE(option_name, '_transient_timeout_', '') AS transient_name
				FROM {$wpdb->options}
				WHERE option_name LIKE '\_transient\_timeout\__%%'
					AND option_value < %s
		", $older_than_time)
	);

	/**
	 * If safemode is ON just use the default WordPress get_transient() function
	 * to delete the expired transients
	 */

	if ( $safemode ) {
		foreach( $transients as $transient ) {
			get_transient($transient);
		}
	}

	/**
	 * If safemode is OFF the just manually delete all the transient rows in the database
	 */

	else {
		$options_names = array();
		foreach($transients as $transient) {
			$options_names[] = '_transient_' . $transient;
			$options_names[] = '_transient_timeout_' . $transient;
		}
		if ($options_names) {
			$options_names = array_map(array($wpdb, 'escape'), $options_names);
			$options_names = "'". implode("','", $options_names) ."'";

			$result = $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name IN ({$options_names})" );
			if (!$result) {
				return false;
			}
		}
	}

	return $transients;
}

?>
