<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter - EXTRA SETUP
*
-------------------------------------------------------------------------------- */

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
function remove_sub_menus () {
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

// REMOVE WP DEFAULT HELP TABS
//$screen->remove_help_tab( $id )
function remove_wp_tabs () {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}
add_action( 'admin_head', 'remove_wp_tabs', 1 );

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

/* --------------------------------------------------------------------------------
*
* [WP] Starter - USER PROFILE
*
-------------------------------------------------------------------------------- */

// Remove dumb contact methods
function remove_contact_fields($contactmethods) {
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	//unset($contactmethods['url']); // this actually doesnt work -_-
	//$contactmethods['twitter'] = 'Twitter'; // add new one
	return $contactmethods;
}
add_filter('user_contactmethods','remove_contact_fields',10,1);

// Remove Personal options crap
if(is_admin()){
  remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
  add_action( 'personal_options', 'prefix_hide_personal_options' );
}
function prefix_hide_personal_options() { ?>
	<script type="text/javascript">
	  jQuery(document).ready(function( $ ){
		$("#your-profile .form-table:first, #your-profile h3:first").remove();
	  });
	</script>
<?php }

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
if (is_admin()) add_action('personal_options', 'hide_nickname');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - OBJECTS CAPABILITY
*
-------------------------------------------------------------------------------- */

//Add Excerpt Capability to Pages
function page_excerpt_extend() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action('init', 'page_excerpt_extend');

// Add images to Feeds
function featuredtoRSS($content) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ){
		$content = '<div>' . get_the_post_thumbnail( $post->ID, 'medium', array( 'style' => 'margin-bottom: 15px;' ) ) . '</div>' . $content;
	}
	return $content;
}
add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - PERFORMANCE
*
-------------------------------------------------------------------------------- */

// Flush Transients button from Admin bar
if(!function_exists('flush_transients_button')) {
	function flush_transients_button() {
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
	add_action( 'admin_bar_menu', 'flush_transients_button', 35 );
}

// Flush transients function
if(!function_exists('flush_transients')) {
	function flush_transients() {
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
		add_action( 'admin_init', 'flush_transients');
	}
}

// Flushed transients message
if(!function_exists('flush_display_admin_msg')) {
	function flush_display_admin_msg() {
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
	add_action( 'admin_notices', 'flush_display_admin_msg' );
}

// Schedule the CRON Job to purge all expired transients
if (!wp_next_scheduled('purge_popup_transients_cron')) {
	wp_schedule_event( time(), 'daily', 'purge_popup_transients_cron');
}
add_action( 'purg_transients_cron',  'purge_transients', 10 ,2);

/**
 * Deletes all transients that have expired
 */
function purge_popup_transients($older_than = '1 day', $safemode = true) {
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
