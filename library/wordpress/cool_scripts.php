<?php

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - BACKEND
*
-------------------------------------------------------------------------------- */

// loading jquery reply elements on single pages automatically
function comments_queue_js(){
	if (!is_admin()){
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script( 'comment-reply' );
	}
}
// reply on comments script
add_action('wp_print_scripts', 'comments_queue_js');

// Rimuovi Feed Commenti
function remove_comments_rss( $for_comments ) { return; }
add_filter('post_comments_feed_link','remove_comments_rss');

// Rimuovi Barra Admin Top
//function shambixnobar() {
	if( has_filter('show_admin_bar') ) {
	add_filter( 'show_admin_bar', '__return_false' ); }
    wp_deregister_script( 'admin-bar' );
    //wp_deregister_style( 'admin-bar' );
    remove_action('wp_footer','wp_admin_bar_render',1000);
	remove_action('init','wp_admin_bar_init');
	remove_action('wp_head','wp_admin_bar_render',1000);
	remove_action('wp_head','wp_admin_bar_css');
	remove_action('wp_head','wp_admin_bar_dev_css');
	remove_action('wp_head','wp_admin_bar_rtl_css');
	remove_action('wp_head','wp_admin_bar_rtl_dev_css');
	remove_action('wp_footer','wp_admin_bar_js');
	remove_action('wp_footer','wp_admin_bar_dev_js');
	add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );
	/* Disable the Admin Bar. */
	add_filter( 'show_admin_bar', '__return_false' );
	/* Remove the Admin Bar preference in user profile */
	remove_action( 'personal_options', '_admin_bar_preferences' ); 
/*}
add_action('init', 'shambixnobar');*/


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
	//$contactmethods['twitter'] = 'Twitter';
    //$contactmethods['facebook'] = 'Facebook';
	return $contactmethods;
	//}
}
add_action( 'user_contactmethods', 'remove_contact_fields' );

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
/*function hide_nickname() {
	if (current_user_can('manage_options')) return false;
	?>
		<script type="text/javascript">
		  jQuery(document).ready(function( $ ){
			$("#nickname,#display_name").parent().parent().remove();
		  });
		</script>
	<?php
	}
if (is_admin()) add_action('personal_options', 'hide_nickname');*/

// User Avatars
function wpu_user_avatars($name, $user) {
	if ( !$user->user_id )
		return $name;

	$url = get_author_posts_url($user->user_id);
	$avatar = get_avatar($user->user_id, 32);

	return html("a href='$url' title='$user->user_name'", $avatar);
}
add_filter('useronline_display_user', 'wpu_user_avatars', 10, 2);

// Check if Gravatar exists
function validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}

// -- Get authors role
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

// Related Posts Function (call using wp_bootstrap_related_posts(); )
/*function wp_starter_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; } 
	    else { ?>
            <li class="no_related_post">No Related Posts Yet!</li>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
}*/

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - TRIM TITLES & EXCERPTS
*
-------------------------------------------------------------------------------- */

// Titoli
function short_title($after = '', $length) {
	$mytitle = get_the_title();
	if ( strlen($mytitle) > $length ) {
	$mytitle = substr($mytitle,0,$length);
	echo $mytitle . $after;
	} else {
	echo $mytitle;
	}
}

// Tronca i titoli
function truncate_title($after = '', $length) {
	$mytitle = explode(' ', get_the_title(), $length);
	if (count($mytitle)>=$length) {
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle). $after;
	} else {
		$mytitle = implode(" ",$mytitle);
	}
	echo $mytitle;
}

// Custom Excerpt
function shambixexcerpt($num) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    //$excerpt = implode(" ",$excerpt)."... (<a href='" .get_permalink($post->ID) ." '>Leggi</a>)";
    $excerpt = implode(" ",$excerpt)."...";
    echo strip_tags($excerpt);
}

// Custom Excerpt + Remove duplicated title in excerpt
function shambixexcerpt_titleoff($num) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    //$excerpt = implode(" ",$excerpt)."... (<a href='" .get_permalink($post->ID) ." '>Leggi</a>)";
    $excerpt = implode(" ",$excerpt)."...";
	// remove that shit
	$title = get_the_title();
	$excerpt = str_replace($title, '', $excerpt);
	$regex = '#(<script[^>]*>)\s?(.*)?\s?(<\/script\2>)#';
	$excerpt = preg_replace($regex,'', $excerpt);
	$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
    echo strip_tags($excerpt);
}

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - OBJECTS CAPABILITY
*
-------------------------------------------------------------------------------- */

//Add Excerpt Capability to Pages
/*function post_type_ext() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action('init', 'post_type_ext');*/

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
function wt_get_category_ID() {
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
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
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

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - PAGINATION
*
-------------------------------------------------------------------------------- */

// Pagination
function shambix_pag() {
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
    'prev_text' => __('Previous', 'shambix'),
    'next_text' => __('Next', 'shambix'),
    'type' => 'list'
    ));
	$pagination = str_replace('page-numbers', 'pagination', $pagination);
	echo $pagination;
}

// Numeric Page Navi (built into the theme by default)
/*Developed by: Eddie Machado
URL: http://themble.com/bones/*/
/*function page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
		
	echo $before.'<ul class="pagination">'."";
	if ($paged > 1) {
		$first_page_text = "&laquo";
		echo '<li class="prev"><a href="'.get_pagenum_link().'" title="First">'.$first_page_text.'</a></li>';
	}
		
	$prevposts = get_previous_posts_link('&larr; Previous');
	if($prevposts) { echo '<li>' . $prevposts  . '</li>'; }
	else { echo '<li class="disabled"><a href="#">&larr; Previous</a></li>'; }
	
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="active"><a href="#">'.$i.'</a></li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="">';
	next_posts_link('Next &rarr;');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "&raquo;";
		echo '<li class="next"><a href="'.get_pagenum_link($max_page).'" title="Last">'.$last_page_text.'</a></li>';
	}
	echo '</ul>'.$after."";
}*/

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - FORMATTING
*
-------------------------------------------------------------------------------- */

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
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
* [WP] Starter - MULTILANG (qTranslate / WPML)
*
-------------------------------------------------------------------------------- */

// qTranslate - return url
/*function curPageURL() {
    $pageURL = 'http';
     if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     }
    else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
return $pageURL;
}*/
// qTranslate - Search
/*function labelsearch(){
	if(qtrans_getLanguage()=='it'){
		echo 'cerca nel sito...';
	} else {
		echo 'search this website...';
	}
}*/

// WPML
/*function languages_list_header(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        foreach($languages as $l) {
			if(!$l['active']) echo '<a class="btnLang" href="'.$l['url'].'">';
			if(!$l['active']) echo  '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
			if(!$l['active']) echo '</a>';
        }
    }
}*/

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - SOCIALMEDIA SCRIPTS
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
* [WP] Starter - COMMENTS
*
-------------------------------------------------------------------------------- */

// COMMENTS
function shambix_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="alert"><p><?php _e( 'Someone talked about this post here:', $theme_name ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'shambix' ), '<span class="edit-link">', '</span>' ); ?></p></div><hr>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">

			<?php
				//$comauth = the_author_meta('nickname', $comment->user_id);
				$comemail = $comment->comment_author_email;
				if(validate_gravatar($comemail)) :
					echo '<div class="hidden-phone">';
					echo get_avatar( $comment, 100,90 );
					echo '</div>';
				else :
					//$altgrav = get_bloginfo('template_url').'/img/grumpy-cat.png';
					//echo '<div class="hidden-phone"><img src="'.get_bloginfo('url').'/cache_img/tt.php?src='.$altgrav.'&amp;w=100&amp;h=100&amp;zc=1&amp;q=100" alt="No. I dont like Gravatars." desc/></div>';
				endif;
			?>

			<!-- <div class="post_author">
				<?php
					/*if ( $comment->user_id === $post->post_author ) :
					echo '<span class="label label-info"> ' . __( 'Post author', $theme_name ) . '</span>';
					endif;*/
				?>
			</div> -->

			<div class="comment-meta comment-author vcard">
				<?php
					printf( '<cite class="fn"><strong>%1$s</strong></cite>',
						( $comment->user_id === $post->post_author ) ? '<span class="label label-info"> ' . get_the_author_meta('display_name', $post->post_author) . '</span>' : get_comment_author()
					);
					printf( '<a class="pull-right" href="%1$s"><small><time datetime="%2$s">%3$s</time></small></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						'',
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s', $theme_name ), get_comment_date(), '' )
					);
				?>
			</div><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', $theme_name ); ?></p>
			<?php endif; ?>

			<div class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', $theme_name ), '<p class="edit-link">', '</p>' ); ?>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', $theme_name ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<hr>
			</div><!-- .comment-content -->

		</div><!-- #comment-## -->

		</li>
	<?php
		break;
	endswitch; // end comment_type check
}

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
	remove_action( 'wp_head', 'wp_generator' );                           // WP version
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

// remove WP version from RSS
function wp_bootstrap_rss_version() { return ''; }
add_filter('the_generator', 'wp_bootstrap_rss_version');

// Rimuovi lang attribute per HTML5
function create_valid_xhtml_1_1($language_attributes) {
	echo '';
}
add_filter('language_attributes', 'create_valid_xhtml_1_1');
// qTranslate header
//add_filter('qtrans_header', 'create_valid_xhtml_1_1');

// Contact Form 7
if(is_home() || function_exists( 'wpcf7_enqueue_scripts' )) {
	wpcf7_enqueue_scripts();
	wpcf7_enqueue_styles();
}

// Delete from Front-End Link
function wp_delete_post_link($link = 'Delete This', $before = '', $after = '', $title="Move this item to the Trash", $cssClass="delete-post") {
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
}

// LOGIN PAGE
/*function wp_starter_login_css() {
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/library/css/login.css">';
}
// changing the logo link from wordpress.org to your site 
function wp_starter_login_url() { echo bloginfo('url'); }
// changing the alt text on the logo to show your site name 
function wp_starter_login_title() { echo get_option('blogname'); }
//add_action('login_head', 'wp_starter_login_css'); //uncomment to activate
//add_filter('login_headerurl', 'wp_starter_login_url'); // uncomment to activate
//add_filter('login_headertitle', 'wp_starter_login_title'); //uncomment to activate
*/

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
* [WP] Starter - CREDITS
*
-------------------------------------------------------------------------------- */

// Please leave this in place or add your own links next to ours.
function wp_starter_admin_footer() {
	echo '<span id="footer-thankyou">Theme built with <a href="http://www.shambix.com/wp-starter" target="_blank">[WP] Starter</a> - Developed by <a href="http://www.shambix.com" target="_blank">Shambix</a></span>';
}
add_filter('admin_footer_text', 'wp_starter_admin_footer');

?>