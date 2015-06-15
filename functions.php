<?php
/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - SETUP
* [WP] Starter is a custom framework developed by Shambix @ http://www.shambix.com
* Version 2.6
*
-------------------------------------------------------------------------------- */

// THEME
$theme = wp_get_theme();
$theme_name = $theme->get( 'TextDomain' ); //use this var when necessary, for inline translations eg. _e('Contact us', $theme_name);
global $theme_name;
$locale = get_locale(); 
global $locale;

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
	//$lang = 'en'; //set your default lang
}

// ADD THEME SUPPORT
function wp_starter_theme_setup() {
	global $theme_name;
	add_theme_support('post-thumbnails');
	add_theme_support( 'menus' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' )); // allows the use of HTML5 markup for the comment lists, comment forms, search forms and galleries
	
	// ADD WOOCOMMERCE 
	add_theme_support( 'woocommerce' );

	// ADD LANGUAGE FILE - This will check for po/mo files in the Child theme
	load_theme_textdomain( $theme_name, get_stylesheet_directory_uri() . '/languages' );
}
add_action('after_setup_theme','wp_starter_theme_setup');

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CSS & JS
*
-------------------------------------------------------------------------------- */

if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'load_files');
    function load_files() {
        
    	// ------------- JS
        wp_deregister_script( 'jquery' );
    	// Latest jQuery - IE <9 not supported
        wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', '', '2.1.3');
    	// This version is older and discontinued, but is more compatible with existing scripts & plugins
    	//wp_register_script( 'jquery', '//code.jquery.com/jquery-1.11.2.min.js', '', '1.11.2');*/
        wp_enqueue_script( 'jquery' );
    	wp_register_script( 'boostrap_js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array('jquery'), '3.3.4', true);
    	wp_enqueue_script( 'boostrap_js' );
    	wp_register_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr.custom.js', '', '2.8.3', true );
    	wp_enqueue_script('modernizr');
    	
    	// -------------- CSS
    	wp_register_style( 'normalize_css', get_template_directory_uri().'/library/css/normalize.css', '', '1.1.3', 'screen');
    	wp_enqueue_style( 'normalize_css' );
    	wp_register_style( 'fontawesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array('normalize_css'), '4.3.0', 'all');
    	wp_enqueue_style( 'fontawesome_css' );
    	wp_register_style( 'bootstrap_css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array('normalize_css', 'fontawesome_css'), '3.3.4', 'all');
    	wp_enqueue_style( 'bootstrap_css' );

    	// Consider using this library for styles, buttons etc: http://metroui.org.ua/
    }
    // Don't load this stuff in Admin panel, it will slow down everything and maybe also break it
}

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CUSTOM FILES
*
-------------------------------------------------------------------------------- */
if(file_exists(TEMPLATEPATH .'/library/helpers/wp-imager.php')) {
	include('library/helpers/wp-imager.php'); // script to resize and cache images and more, download at  https://github.com/Jany-M/WP-Imager/
}

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - DEV* HELPERS
*
-------------------------------------------------------------------------------- */

// ERROR HANDLING - DEBUG for Admins
if(current_user_can('activate_plugins')) :
	//error_reporting(E_ALL); // everything
	//error_reporting(E_ALL & ~E_NOTICE);// Report all errors except E_NOTICE
	error_reporting(E_ERROR | E_WARNING | E_PARSE); // Report simple running errors
	else :
	error_reporting(0);
endif;

// DISPLAY SCREEN + REGISTERED POST TYPES for Admins
if(current_user_can('activate_plugins')) :
    add_action('contextual_help', 'add_screen_help', 10, 3);
endif;
function add_screen_help( $contextual_help, $screen_id, $screen ) {
    // The add_help_tab function for screen was introduced in WordPress 3.3.
    if ( ! method_exists( $screen, 'add_help_tab' ) )
        return $contextual_help;
    global $hook_suffix;
    // List screen properties
    $variables = '<ul style="width:50%;float:left;"><h3 style="cleare:both; width:100%">Screen variables</h3>'
        . sprintf( '<li> Screen id : %s</li>', $screen_id )
        . sprintf( '<li> Screen base : %s</li>', $screen->base )
        . sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
        . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
        . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
        . '</ul>';
    // Append global $hook_suffix to the hook stems
    $hooks = array(
        "load-$hook_suffix",
        "admin_print_styles-$hook_suffix",
        "admin_print_scripts-$hook_suffix",
        "admin_head-$hook_suffix",
        "admin_footer-$hook_suffix"
    );
    // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
    if ( did_action( 'add_meta_boxes_' . $screen_id ) )
        $hooks[] = 'add_meta_boxes_' . $screen_id;
    if ( did_action( 'add_meta_boxes' ) )
        $hooks[] = 'add_meta_boxes';
    // Get List HTML for the hooks
    $hooks = '<ul style="width:50%;float:left;"><h3 style="cleare:both; width:100%">Hooks</h3><li>' . implode( '</li><li>', $hooks ) . '</li></ul>';
    // Get Registered Post Types
    $post_types = get_post_types( '', 'names' );
    $regposts = '<h3 style="cleare:both; width:100%">Registered Post Types</h3><ul style="width:100%; display:block;">';
    foreach ( $post_types as $post_type ) {
       $regposts .= '<li style="float:left;">'.$post_type.'</li>';
    }
    $regposts .= '</ul>';
    // Combine $variables list with $hooks list.
    $help_content = $variables . $hooks . $regposts;
    // Add help panel
    $screen->add_help_tab( array(
        'id'      => 'wptuts-screen-help',
        'title'   => '[WP]Starter Debug',
        'content' => $help_content,
    ));
    return $contextual_help;
}

// ADD Custom Tab to HELP 
/*add_action( "load-{$GLOBALS['pagenow']}", 'add_debug_tab', 20 );
function add_debug_tab () {
    $screen = get_current_screen();
    $screen->add_help_tab( array(
        'id'    => 'wpstarter_debug_tab',
        'title' => __('DEBUG'),
        'content'   => '<p>' . __( '[WP] Starter - Debug Information.' ) . '</p>',
    ));
}*/

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
if(file_exists(TEMPLATEPATH .'/library/helpers/class-tgm-plugin-activation.php')) {

    // TGM Plugin Activation
    // Version: 2.4.0
    require_once dirname( __FILE__ ) . '/library/helpers/class-tgm-plugin-activation.php';

    // Uncomment this Action to activate the whole thing
    //add_action( 'tgmpa_register', 'register_required_plugins' );

    function register_required_plugins() {
    	$plugins = array(

    		// This is an example of how to include a plugin pre-packaged with a theme.
            /*array(
                'name'               => 'TGM Example Plugin', // The plugin name.
                'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
                'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            ),*/

            // This is an example of how to include a plugin from a private repo in your theme.
            /*array(
                'name'               => 'TGM New Media Plugin', // The plugin name.
                'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
                'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
            ),*/

            // This is an example of how to include a plugin from the WordPress Plugin Repository.
            array(
                'name'      => 'All in One SEO Pack',
                'slug'      => 'all-in-one-seo-pack',
                'required'  => false,
            ),
    		array(
                'name'      => 'Jetpack by WordPress.com',
                'slug'      => 'jetpack',
                'required'  => false,
            ),
    		array(
                'name'      => 'WP-DBManager',
                'slug'      => 'wp-dbmanager',
                'required'  => false,
            ),
    		array(
                'name'      => 'Types - Complete Solution for Custom Fields and Types',
                'slug'      => 'types',
                'required'  => false,
            ),
    		/*array(
                'name'      => 'WP Smush.it',
                'slug'      => 'wp-smushit',
                'required'  => false,
            ),*/
    		array(
                'name'      => 'Contact Form 7',
                'slug'      => 'wpcf7',
                'required'  => false,
            ),

        );

        $config = array(
            'default_path' => 'plugins',               // Default absolute path to pre-packaged plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            'strings'      => array(
                'page_title'                      => __( 'Install Recommended Plugins', 'tgmpa' ),
                'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
                'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
                'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
                'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
                'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
                'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
                'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
                'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
                'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
                'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
                'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
                'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
                'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
                'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );

        tgmpa( $plugins, $config );
    }

} // if tgm file exists
?>