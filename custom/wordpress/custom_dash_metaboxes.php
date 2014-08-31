<?php 

/* -------------------------------------------------------------------------------- 
*
* DASHBOARD
*
-------------------------------------------------------------------------------- */

// disable default dashboard widgets
/*function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         // 
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //
	
	// removing plugin dashboard boxes 
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
}*/

// -- Remove template info and WP version from Right Now Metabox
/*add_action('wp_dashboard_setup', 'hide_dashstuff');
function hide_dashstuff() {
	if(!current_user_can('administrator')) {
	echo '<style type="text/css">
         #dashboard_right_now .versions { height:0;visibility: hidden; margin:0!important; padding:0!important; }
		 #dashboard_right_now .table_discussion {visibility: hidden;width: 0!important; height:0; }
		 #dashboard_right_now .table_content { width: 100%!important; height: 30px; }
		 #dashboard_right_now .table_content .b_pages, #dashboard_right_now .table_content .pages, #dashboard_right_now .table_content .b-cats, #dashboard_right_now .table_content .cats, #dashboard_right_now .table_content .b-tags, #dashboard_right_now .table_content .tags  { visibility: hidden;width: 0!important; height:0!important; }
		 </style>';
	}
}*/


// -- Add Custom Metabox SIDE
/*add_action( 'wp_dashboard_setup', 'my_dashboard_setup_function' );
function my_dashboard_setup_function() {
    add_meta_box( 'my_dashboard_widget', 'I Want EDM Support', 'my_dashboard_widget_function', 'dashboard', 'side', 'high' );
}
function my_dashboard_widget_function() {
    echo '<h2>Policy</h2><p>All the info you have filled in from your <a href="http://www.iwantedm.com/wp-admin/profile.php">Profile page</a> will be displayed below each of your posts.<br />That way you won\'t have to write in each post your/your company\'s contact info, they\'ll simply be displayed automatically.</p>
	<hr>
	Remember that you are responsible for the content you publish, at all times.
	<br />
	If we get copyright complaints, they will be forwarded directly to you and you may be banned from the site indeterminately.
	<br /><br />
	For site support, contact <a href="mailto:info@iwantedm.com">info@iwantedm.com</a>.
	<br />
	Send any PR material to <a href="mailto:pr@iwantedm.com">pr@iwantedm.com</a>.
	<br />
	Advertise with us <a href="mailto:adv@iwantedm.com">adv@iwantedm.com</a>.
	<br /><br />
	<hr>
	Developed by <a href="http://www.shambix.com/en" target="_blank"><img src="'.get_bloginfo('template_url').'/img/shambix_logo_grey.png" alt="Shambix" style="vertical-align: text-bottom;"/></a>';
}*/

// -- Add Custom Metabox BOTTOM
/*add_action('wp_dashboard_setup', 'dashboard_bottom');
function dashboard_bottom() {
    add_meta_box( 'dashboard_bottom_widget', 'I Want EDM News', 'dashboard_bottom_widget_function', 'dashboard', 'normal', 'core' );
}
function dashboard_bottom_widget_function() {
    echo '<h2>The website is going through a complete overhaul.</h2><p>New design and new features mean new opportunities.<br />Get in touch at <a href="mailto:adv@iwantedm.com">adv@iwantedm.com</a>.</p>
	<h2>Advertising</h2>
	<p>We provide banners/ads on site, revenue share programs, product reviews, shoutouts on social accounts and featured posts.<br />We can also plan and manage a global custom advertising campaign for you, through the best channels on the Internet.</p>
	<h2>Contests</h2>
	<p>We can develop custom web solutions and social media apps on/off site to promote events, EP launches and more.</p>
	<h2>Partnerships</h2>
	<p>A mix of everything we have to offer, in a custom package taylor-made to your needs.</p>
	<hr>
	<h2>Roadmap</h2>
	<ul>
	<li><strong>E-Commerce</strong>: we do all the work for you, just sit back and watch your sales grow</li>
	<li>...more to come!</li>
	</ul>';
}*/

// -- Set 1 column by default for non admin
/*if(!current_user_can('administrator')) {
	function so_screen_layout_columns( $columns ) {
    $columns['dashboard'] = 1;
    return $columns;
}
add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );
function so_screen_layout_dashboard() {
    return 1;
}
add_filter( 'get_user_option_screen_layout_dashboard', 'so_screen_layout_dashboard' );
}*/

// -- Add Custom Metabox SIDE
/*add_action( 'wp_dashboard_setup', 'my_dashboard_setup_function' );
function my_dashboard_setup_function() {
    add_meta_box( 'my_dashboard_widget', 'Nome MetaBox', 'my_dashboard_widget_function', 'dashboard', 'side', 'high' );
}
function my_dashboard_widget_function() {
    echo '';
}*/

// -- Add Custom Metabox BOTTOM
/*add_action('wp_dashboard_setup', 'dashboard_bottom');
function dashboard_bottom() {
    add_meta_box( 'dashboard_bottom_widget', 'Nome MetaBox 2', 'dashboard_bottom_widget_function', 'dashboard', 'normal', 'core' );
}
function dashboard_bottom_widget_function() {
    echo '';
}*/

?>