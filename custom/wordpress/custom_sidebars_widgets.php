<?php

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - SIDEBARS
*
-------------------------------------------------------------------------------- */

function wp_starter_register_sidebars() {
	/*register_sidebar(array(
	  'name' => __( 'Shoutbox' ),
	  'id' => 'shoutbox-block',
	  'description' =>  '',
	  'before_widget' => '',
	  'after_widget' => '',
	  'before_title' => '',
	  'after_title' => ''
	)); 
	register_sidebar(array(
	  'name' => __( 'Single Sidebar' ),
	  'id' => 'single-sidebar',
	  'description' =>  '',
	  'before_widget' => '',
	  'after_widget' => '',
	  'before_title' => '',
	  'after_title' => ''
	));*/
}

add_action( 'widgets_init', 'wp_starter_register_sidebars' );

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - WIDGETS
*
-------------------------------------------------------------------------------- */

?>