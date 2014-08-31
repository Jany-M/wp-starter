<?php 

// -- Remove YOURLS metabox from Post editor
/*if(!current_user_can('administrator')) {
	function my_remove_meta_boxes() {
		//remove_meta_box('linktargetdiv', 'link', 'normal');
		//remove_meta_box('linkxfndiv', 'link', 'normal');
		//remove_meta_box('linkadvanceddiv', 'link', 'normal');
		//remove_meta_box('postexcerpt', 'post', 'normal');
		//remove_meta_box('trackbacksdiv', 'post', 'normal');
		//remove_meta_box('commentstatusdiv', 'post', 'normal');
		//remove_meta_box('postcustom', 'post', 'normal');
		//remove_meta_box('commentstatusdiv', 'post', 'normal');
		//remove_meta_box('commentsdiv', 'post', 'normal');
		//remove_meta_box('revisionsdiv', 'post', 'normal');
		//remove_meta_box('authordiv', 'post', 'normal');
		//remove_meta_box('sqpt-meta-tags', 'post', 'normal');
		remove_meta_box('yourlsdiv', 'post', 'side');
		remove_meta_box('yourlsdiv', 'post', 'normal');
		remove_meta_box('yourlsdiv', 'post', 'advanced');
	}
	add_action( 'add_meta_boxes', 'my_remove_meta_boxes' );
}*/


// -- Add Help Metabox
// -- Add Custom Metabox SIDE
/*function iwantedm_posthelp() {
    add_meta_box( 'iwantedm_posthelp_widget', 'YouTube, SoundCloud, Tweets, etc.', 'iwantedm_posthelp_function', 'post', 'side', 'high' );
}
function iwantedm_posthelp_function() {
    echo '<p><strong>Never assign more than 2 categories to posts.</strong><br /><br />To embed a <strong>YouTube</strong> video inside the post, use <code>[youtube http://youtu.be/HzqD5cWbDQ0]</code>, replacing the link with yours.<br />To embed a <strong>SoundCloud</strong> track get the "WordPress code" you find below each track, after clicking on the "Share" button. It looks like this <code>[soundcloud url="http://api.soundcloud.com/tracks/70323752" width=" 100%" height="80" iframe="true" /]</code>.<br />To nicely embed a <strong>Tweet</strong> use <code>[tweet https://twitter.com/twitterapi/status/133640144317198338]</code>, replacing the link.<br /><a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Full list of sites you can embed from.</a></p>';
}
add_action( 'add_meta_boxes', 'iwantedm_posthelp' );
*/
?>