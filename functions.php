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

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.4.0
 * @author     Thomas Griffin <thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo.com>
 * @copyright  Copyright (c) 2014, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'TGM Example Plugin', // The plugin name.
            'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),

        // This is an example of how to include a plugin from a private repo in your theme.
        array(
            'name'               => 'TGM New Media Plugin', // The plugin name.
            'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
            'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'BuddyPress',
            'slug'      => 'buddypress',
            'required'  => false,
        ),

    );

	// TGM Plugin Activation
	// Version: 2.4.0

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

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CUSTOM FUNCTIONS
*
-------------------------------------------------------------------------------- */

// WOOCOMMERCE
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

?>