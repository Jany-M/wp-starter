<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter - SECURITY
*
-------------------------------------------------------------------------------- */

// Remove xmlrpc completely - Might Block some apps too
//add_filter('xmlrpc_enabled', '__return_false');

function sar_block_xmlrpc_attacks( $methods ) {
   unset( $methods['pingback.ping'] );
   unset( $methods['pingback.extensions.getPingbacks'] );
   return $methods;
}
add_filter( 'xmlrpc_methods', 'sar_block_xmlrpc_attacks' );

function sar_remove_x_pingback_header( $headers ) {
   unset( $headers['X-Pingback'] );
   return $headers;
}
add_filter( 'wp_headers', 'sar_remove_x_pingback_header' );

// disable JSON
$dra_current_WP_version = get_bloginfo('version');
if ( version_compare( $dra_current_WP_version, '4.7', '>=' ) ) {
    DRA_Force_Auth_Error();
} else {
    DRA_Disable_Via_Filters();
}
/**
 * This function is called if the current version of WordPress is 4.7 or above
 * Forcibly raise an authentication error to the REST API if the user is not logged in
 */
function DRA_Force_Auth_Error() {
    add_filter( 'rest_authentication_errors', 'DRA_only_allow_logged_in_rest_access' );
}
/**
 * This function gets called if the current version of WordPress is less than 4.7
 * We are able to make use of filters to actually disable the functionality entirely
 */
function DRA_Disable_Via_Filters() {
	// Filters for WP-API version 1.x
    add_filter( 'json_enabled', '__return_false' );
    add_filter( 'json_jsonp_enabled', '__return_false' );
    // Filters for WP-API version 2.x
    add_filter( 'rest_enabled', '__return_false' );
    add_filter( 'rest_jsonp_enabled', '__return_false' );
    // Remove REST API info from head and headers
    remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}
/**
 * Returning an authentication error if a user who is not logged in tries to query the REST API
 * @param $access
 * @return WP_Error
 */
function DRA_only_allow_logged_in_rest_access( $access ) {
	if( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
    }
    return $access;
}

// remove WP version from RSS
function wp_rss_version() {
	return '';
}
add_filter('the_generator', 'wp_rss_version');

// Cleaning up the Wordpress Head output
function wp_starter_head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                         // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator', 999 );                      // WP version
	//remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );		  // Uncomment if you are using a custom url shortener
}
add_action('init', 'wp_starter_head_cleanup');

// More cleanup - optional
/*function wp_starter_head_cleanup_extra() {
	add_filter( 'index_rel_link', 'remove_code' );
	add_filter( 'parent_post_rel_link', 'remove_code' );
	add_filter( 'start_post_rel_link', 'remove_code' );
	add_filter( 'previous_post_rel_link', 'remove_code' );
	add_filter( 'next_post_rel_link', 'remove_code' );
	add_filter('post_comments_feed_link','remove_code');
}
function remove_code( $data ) {
	return false;
}
add_action('init', 'wp_starter_head_cleanup_extra');*/

?>
