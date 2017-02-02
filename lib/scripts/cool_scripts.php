<?php

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

/* --------------------------------------------------------------------------------
*
* [WP] Starter - FRONTEND
*
-------------------------------------------------------------------------------- */

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

// REMOVE WP DEFAULT HELP TABS
//$screen->remove_help_tab( $id )
function remove_wp_tabs () {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}
add_action( 'admin_head', 'remove_wp_tabs', 1 );

// remove WP version from RSS
function wp_rss_version() {
	return '';
}
add_filter('the_generator', 'wp_rss_version');

// Rimuovi lang attribute per HTML5
/*function create_valid_xhtml_1_1($language_attributes) {
	echo '';
}
add_filter('language_attributes', 'create_valid_xhtml_1_1');*/

// Delete from Front-End Link
/*function wp_delete_post_link($link = 'Delete This', $before = '', $after = '', $title="Move this item to the Trash", $cssClass="delete-post") {
    global $post;
    if ( $post->post_type == 'page' ) {
        if ( !current_user_can( 'edit_page' ) )
            return;
    } else {
        if ( !current_user_can( 'edit_post' ) )
            return;
    }
    $delLink = wp_nonce_url( site_url() . "/wp-admin/post.php?action=trash&post=" . $post->ID, 'trash-' . $post->post_type . '_' . $post->ID);
    $link = '<a class="' . $cssClass . '" href="' . $delLink . '" onclick="javascript:if(!confirm(\'Are you sure you want to move this item to trash?\')) return false;" title="'.$title.'" />'.$link."</a>";
    //return $before . $link . $after;
	echo $before . $link . $after;
}*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter - USER PROFILE
*
-------------------------------------------------------------------------------- */

// -- Remove dumb contact methods
function remove_contact_fields($contactmethods) {
	//if(!current_user_can('administrator')) {
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	//unset($contactmethods['url']); // this actually doesnt work -_-
	//$contactmethods['twitter'] = 'Twitter'; // add new one
	return $contactmethods;
	//}
}
//add_action( 'user_contactmethods', 'remove_contact_fields' );
add_filter('user_contactmethods','remove_contact_fields',10,1);


// -- Remove Personal options crap
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

// -- Remove Nickname for non admin
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

// User Avatars
/*function wpu_user_avatars($name, $user) {
	if ( !$user->user_id )
		return $name;

	$url = get_author_posts_url($user->user_id);
	$avatar = get_avatar($user->user_id, 32);

	return html("a href='$url' title='$user->user_name'", $avatar);
}
add_filter('useronline_display_user', 'wpu_user_avatars', 10, 2);*/

// Check if Gravatar exists
/*function validate_gravatar($email) {
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}*/

// Get authors role
function get_author_role() {
    global $authordata;
    $author_roles = $authordata->roles;
    $author_role = array_shift($author_roles);
    return $author_role;
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - RELATED POSTS
*
-------------------------------------------------------------------------------- */

// Related Posts by Tag
if (!function_exists('related_posts')) {
	function related_tag_posts($before = '<ul>', $num = '3', $after = '</ul>') {
		//echo '<ul>';
		global $post;
		$tags = wp_get_post_tags($post->ID);
		if($tags) {
			foreach($tags as $tag) {
				$tag_arr .= $tag->slug . ',';
			}
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => $num,
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts($args);
		if($related_posts) {
			$output = $before;
			foreach ($related_posts as $post) : setup_postdata($post);
				$output .= '<li class="related_post"><a href="'.get_the_permalink().'" title="'.get_the_title_attribute().'">'.get_the_title().'</a></li>';
			endforeach;
			wp_reset_query(); wp_reset_postdata();
			$output .= $after;
			return $output;
		} else {
			//$output = '<li class="no_related_post">No Related Posts</li>';
			//return $output;
			//return;
		}
		//echo '</ul>';
	}
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - EXCERPTS
*
-------------------------------------------------------------------------------- */

// Custom Excerpt
if (!function_exists('custom_excerpt')) {
	function custom_excerpt($num) {
		global $post;
		$limit = $num+1;
		//get_post_field('post_excerpt', $post->ID)
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt).' &hellip;';
		$excerpt = strip_tags($excerpt);
		$excerpt = wpautop($excerpt, false);
		return $excerpt;
	}
}

// Shorten any text
function shorten($string, $lenght) {
	if (strlen($string) >= $lenght) {
	    //echo substr($string, 0, 10). " ... " . substr($string, -5); // this is in case you wanted to shorten, add ... and then the last 5 letters of the sentence eg. "This is a ...script"
	    return substr($string, 0, $lenght)."&hellip;";
	} else {
	    return $string;
	}
}


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

/* --------------------------------------------------------------------------------
*
* [WP] Starter - RETRIEVE OBJECT INFO
*
-------------------------------------------------------------------------------- */

// Get the post slug
function the_slug($echo=true){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}

// Has attachment
function has_attachment() {
	$attachments = get_children( array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image') );
	if ($attachments) return true;
}

// Get Category ID
function get_category_ID() {
	$category = get_the_category();
	return $category[0]->cat_ID;
}

// Is Parent?
function is_parent( $parent_id, $post_id ) {
  if (get_post($post_id)->post_parent == $parent_id){
    return true;
  } else {
    return false;
  }
}

// Is child of category?
function is_child($parent) {
	if ( is_category() ) {
		//$parent = 8;
		$categories = get_categories('include='.get_query_var('cat'));
		if ( $categories[0]->category_parent == $parent ) {
			//echo 'category ' . $categories[0]->name . ' is a child of category ' . $parent;
			return true;
		}
	}
}

// Post in descendant categories?
if (!function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}

// Get page slug from ID
function get_page_slug($pageid) {
	$post_data = get_post($pageid, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug;
}

// Get Page ID by slug
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

// Check if a Plugin is active from Theme
function plugin_is_active($plugin_folder, $plugin_file) {
	if(!isset($plugin_file) || $plugin_file == '') $plugin_file = $plugin_folder;
	return in_array( $plugin_folder. '/' .$plugin_file. '.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - PAGINATION
*
-------------------------------------------------------------------------------- */

// Pagination
if (!function_exists('custom_pagination')) {
	function custom_pagination($prev = 'Previous', $next = 'Next') {
		wp_reset_query();
		wp_reset_postdata();
		global $wp_query;
		$big = 99999999;
		$pagination = paginate_links(array(
		'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'format' => '?page=%#%',
		'total' => $wp_query->max_num_pages,
		'current' => max(1, get_query_var('paged')),
		'show_all' => false,
		'end_size' => 2,
		'mid_size' => 3,
		'prev_next' => true,
		'prev_text' => __($prev, TEXT_DOMAIN),
		'next_text' => __($next, TEXT_DOMAIN),
		'type' => 'list'
		));
		$pagination = str_replace('page-numbers', 'pagination', $pagination);
		echo $pagination;
	}
}

// Custom Loop Pagination
if (!function_exists('custom_query_pagination')) {
	function custom_query_pagination($prev = 'Previous', $next = 'Next') {
		/* --------------------------------------------------------------------------
        If the query is on a STATIC FRONT page, then add before the query:
        $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
        otherwise use:
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        Then, inside your query add this argument:
        'paged' => $paged,
        Finally, once the query is done, add this:
		global $custom_query;
		$custom_query = $your_query_name;
        --------------------------------------------------------------------------- */
		global $custom_query;
		$big = 99999999;
		$pagination = paginate_links(array(
			'base' => str_replace($big, '%#%', get_pagenum_link($big)),
			'format' => '?page=%#%',
			'total' => $custom_query->max_num_pages,
			'current' => max(1, get_query_var('paged')),
			'show_all' => false,
			'end_size' => 2,
			'mid_size' => 3,
			'prev_next' => true,
			'prev_text' => __($prev, TEXT_DOMAIN),
			'next_text' => __($next, TEXT_DOMAIN),
			'type' => 'list'
		));
		$pagination = str_replace('page-numbers', 'pagination', $pagination);
		echo $pagination;
		// RESET THE TEMP QUERY
		$custom_query = NULL;
	}
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - FORMATTING
*
-------------------------------------------------------------------------------- */

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
//add_filter('the_content', 'filter_ptags_on_images');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - SEARCH CAPABILITIES
*
-------------------------------------------------------------------------------- */

// search filter
/*function sh_search_filter($query) {
	if ( !$query->is_admin && $query->is_search) {
		//$query->set('post_type', array('video-camera', 'software-solution','post') );
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter( 'pre_get_posts', 'sh_search_filter' );*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter - MULTILANG (WPML)
*
-------------------------------------------------------------------------------- */

// Custom Lang Selector
if (!function_exists('languages_list_header') && function_exists('icl_get_languages')) {
	function languages_list_header(){
	    $languages = icl_get_languages('skip_missing=0&orderby=code');
	    if(!empty($languages)){
	        foreach($languages as $l) {
				if(!$l['active']) echo '<a class="btnLang" href="'.$l['url'].'">';
				if(!$l['active']) echo  '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
				if(!$l['active']) echo '</a>';
	        }
	    }
	}
}

// Get native lang name from lang code
if (!function_exists('get_language_name') && function_exists('icl_get_languages')) {
	function get_language_name($code=''){
		global $sitepress;
		$details = $sitepress->get_language_details($code);
		return $details;

		/*  This is the return array. Echo the value you need.
			array(10) {   ["code"]=>   string(2) "it"   ["id"]=>   string(2) "27"   ["english_name"]=>   string(7) "Italian"   ["native_name"]=>   string(8) "Italiano"   ["major"]=>   string(1) "1"   ["active"]=>   string(1) "1"   ["default_locale"]=>   string(5) "it_IT"   ["encode_url"]=>   string(1) "0"   ["tag"]=>   string(5) "it-IT"   ["display_name"]=>   string(8) "Italiano" }
		*/
	}
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - BREADCRUMBS
*
-------------------------------------------------------------------------------- */
// https://gist.github.com/melissacabral/4032941
// http://www.html.it/articoli/breadcrumb-wordpress-senza-plugin/
if (!function_exists('breadcrumbs')) {
	function breadcrumbs() {
		global $post;

		$text['home']     = 'Home'; // text for the 'Home' link
		$text['category'] = 'Category "%s"'; // text for a category page
		$text['tax'] 	  = 'Archive for "%s"'; // text for a taxonomy page
		$text['search']   = 'Search Results for "%s" Query'; // text for a search results page
		$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
		$text['author']   = 'Articles Posted by %s'; // text for an author page
		$text['404']      = 'Error 404'; // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = ' / '; // delimiter between crumbs
		$before      = '<li class="active">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb

		$homeLink = get_bloginfo('url') . '/';
		$linkBefore = '<li typeof="v:Breadcrumb">';
		$linkAfter = '</li>';
		$linkAttr = ' rel="v:url" property="v:title"';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if (is_home() || is_front_page()) {

			if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

		} else {

			echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

			} elseif( is_tax() ){
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

			}elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;

			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				printf($link, get_permalink($parent), $parent->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				echo __('Page') . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</div>';

		}
	}
}

/* --------------------------------------------------------------------------------
*
* [WP] Starter - WOOCOMMERCE
*
-------------------------------------------------------------------------------- */

// Auto complete WooCommerce order
/*add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) {
    global $woocommerce;
    if ( !$order_id )
        return;
    $order = new WC_Order( $order_id );
    $order->update_status( 'completed' );
}*/

/* --------------------------------------------------------------------------------
*
* [WP] Starter - FONT AWESOME
*
-------------------------------------------------------------------------------- */

// Extract all icon classes from file and puts them into an array
function fontAwesome($path){
    $css = file_get_contents($path);
    $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
    preg_match_all($pattern, $css, $matches, PREG_SET_ORDER);
    $icons = array();
    foreach ($matches as $match) {
    	// Chose what kind of array you prefer
        //$icons[$match[1]] = $match[2]; //["fa-glass"]=> "\f000"
        $icons[] = str_replace ('fa-', '', $match[1]); // [0] => "fa-glass"
    }
    sort($icons);
    return $icons;
}
// Usage
//$icons = fontAwesome(get_stylesheet_directory_uri().'/css/font-awesome.css');

/* --------------------------------------------------------------------------------
*
* [WP] Starter - CREDITS & LOGIN
*
-------------------------------------------------------------------------------- */

// Backend Footer Credits
// Please leave this in place or add your own links next to ours.
function wp_starter_admin_footer() {
	echo '<div id="shambix_credits"><p>Theme built with <a href="http://www.shambix.com/wp-starter" target="_blank">[WP] Starter</a> - Developed by <a href="http://www.shambix.com" target="_blank">Shambix</a> for WordPress.</p></div>';
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


/* --------------------------------------------------------------------------------
*
* [WP] Starter - SOCIAL MEDIA SCRIPTS
*
-------------------------------------------------------------------------------- */

// Twitter Counter
/*function shambix_twitter_user( $username, $field, $display = false ) {
	$interval = 3600;
	$cache = get_option('twitter_user_count');
	$url = 'http://api.twitter.com/1/users/show.json?screen_name='.urlencode($username);

	if ( false == $cache )
	$cache = array();

	// if first time request add placeholder and force update
	if ( !isset( $cache[$username][$field] ) ) {
	$cache[$username][$field] = NULL;
	$cache[$username]['lastcheck'] = 0;
	}

	// if outdated
	if( $cache[$username]['lastcheck'] < (time()-$interval) ) {

	// holds decoded JSON data in memory
	static $memorycache;

	if ( isset($memorycache[$username]) ) {
	$data = $memorycache[$username];
	}
	else {
	$result = wp_remote_retrieve_body(wp_remote_request($url));
	$data = json_decode( $result );
	if ( is_object($data) )
	$memorycache[$username] = $data;
	}

	if ( is_object($data) ) {
	// update all fields, known to be requested
	foreach ($cache[$username] as $key => $value)
	if( isset($data->$key) )
	$cache[$username][$key] = $data->$key;

	$cache[$username]['lastcheck'] = time();
	}
	else {
	$cache[$username]['lastcheck'] = time()+60;
	}

	update_option( 'twitter_user_count', $cache );
	}

	if ( false != $display )
	echo $cache[$username][$field];
	return $cache[$username][$field];
}*/

// Facebook Likes Counter
/*function get_fb_likes($what) {
	if(false === ( $cached_fb_results = get_transient( 'cached_fb' ))) {
		$likes = 0;
		$json_url ='https://graph.facebook.com/'.$what.'';
		$json = file_get_contents($json_url);
		if($json) {
			$json_output = json_decode($json);
			set_transient( 'cached_fb', $json_output, 60*60*12 );
			if($json_output->likes){
				echo $json_output->likes;
			}
		}
	} else {
		if($cached_fb_results->likes){
			echo $cached_fb_results->likes;
		}
	}
}*/

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
