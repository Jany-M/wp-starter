<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter - DEBUG
* [WP] Starter is a custom framework developed by Shambix @ http://www.shambix.com
*
-------------------------------------------------------------------------------- */

ini_set('log_errors',TRUE);
ini_set('error_reporting', E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING));
ini_set('error_log', ABSPATH.'/error_log.txt'); // site root

/* --------------------------------------------------------------------------------
*
* [WP] Starter - SETUP
*
-------------------------------------------------------------------------------- */
require_once (dirname(__FILE__) . '/lib/setup/setup.php');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - REMOVE STUFF
*
-------------------------------------------------------------------------------- */

// Remove the emoji detection
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



?>
