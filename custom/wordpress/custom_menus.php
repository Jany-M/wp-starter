<?php

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - CUSTOM MENUS
*
-------------------------------------------------------------------------------- */

// Add Custom Menus
function wp_starter_main_nav() { // add the menu - copy the whole function to add another menu and change names to it a
    wp_nav_menu( 
    	array( 
    		'menu' => 'top_nav', /* menu name */
    		'menu_class' => 'nav navbar-nav',
    		'theme_location' => 'top_nav', /* where in the theme it's assigned */
    		'container' => 'false', /* container class */
    		//'fallback_cb' => 'top_nav_fallback', /* menu fallback */
    		// 'depth' => '2',  suppress lower levels for now 
    		//'walker' => new Bootstrap_walker()
    	)
    );
}

// this is the fallback for header menu
function top_nav_fallback() { 
	// Figure out how to make this output bootstrap-friendly html
	//wp_page_menu( 'show_home=Home&menu_class=nav' ); 
}


// Assign Menu to Location
register_nav_menus(	array( // add the theme_location set above
	'top_nav' => 'Top Menu',
	//'footer_links' => 'Footer Menu' // nav in footer
	)
);

?>