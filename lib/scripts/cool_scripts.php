<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter - BACKEND
*
-------------------------------------------------------------------------------- */


/* --------------------------------------------------------------------------------
*
* [WP] Starter - FRONTEND
*
-------------------------------------------------------------------------------- */

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
?>
