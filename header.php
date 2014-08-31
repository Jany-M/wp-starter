<!doctype html>  
<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Shambix.com">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Tour operator, planning outdoor activities in Florence and Tuscany - <?php bloginfo('description'); ?>">
	<meta name="keywords" content="fun in tuscany,tour in tuscany,tours in tuscany,horse riding in tuscany,horseback riding in tuscany,wine tours in tuscany,chianti wine tour,tuscany wine tours,wine tour in tuscany,scooter tour in tuscany,vespa tour in tuscany,stuff to do in tuscany">
	<!-- <meta name="robots" content="INDEX, FOLLOW">
	<meta name="revisit-after" content="7 days">
	<meta name="document-classification" content="Tour operator">
	<meta name="document-distribution" content="Global">
	<meta name="Audience" content="General">
	<meta name="Rating" content="General">
	<meta name="expires" content="never"> -->

	<title><?php
		if (is_home() || is_front_page()) {
			echo bloginfo('name'); echo ' - '; bloginfo('description'); }
		elseif (!(is_404()) && (is_single()) || (is_page())) {
			echo the_title(); echo ' - '; bloginfo('name'); }
		elseif (function_exists('is_tag') && is_tag()) {
			single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		elseif (is_archive()) {
			wp_title(''); echo ' - '; }
		elseif (is_search()) {
			echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		elseif (is_404()) {
			echo 'Not Found - '; }
		else {
			echo bloginfo('name'); }
		if ($paged>1) {
			echo ' - page '. $paged; }
	?></title>
	
	<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/images/favicon.ico">
       
	<!-- media-queries.js (fallback) -->
	<!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<!-- html5.js -->
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		
  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php //if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
	
<body <?php body_class(); ?>>


<h1><a class="navbar-brand" href="<?php //echo icl_get_home_url(); ?>"><img class="img-responsive" src="<?php bloginfo('template_directory');?>/images/logo.png" title="<?php echo bloginfo('name'); echo ' - '; bloginfo('description'); ?>"></a></h1>