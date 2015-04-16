<?php

global $theme_name;

/* -------------------------------------------------------------------------------- 
*
* [WP] Starter - SHORTCODES
* v 2.5
*
-------------------------------------------------------------------------------- */

// Buttons
// [button type='info' size='large' url='#' target='_blank' text='Buy Me' sub='now or never' modal='x']
function buttons( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => 'default', /* primary, default, info, success, danger, warning, inverse, some custom style */
	'size' => 'default', /* mini, small, default, large */
	'url'  => '',
	'target' => '',
	'text' => '', 
	'sub' => '',
	'modal' => '',
	), $atts ) );
	
	if($type == "default"){
		$type = "";
	}
	else{ 
		$type = "btn-".$type;
	}
	
	if($size == "default"){
		$size = "";
	}
	else{
		$size = "btn-".$size;
	}

	if($target !== '') {
		$target = 'target="'.$target.'"';
	}

	if($sub !== '') {
		$sub = '<small>'.$sub.'</small>';
	}

	if($modal !== '') {
		$modal = 'data-toggle="modal" data-target=".'.$modal.'"';
	}
	
	if($url !== '') {
		$output = '<a href="'.$url.'" '.$target.' class="btn '.$type.' '.$size.'">';
	} else {
		$output = '<button class="btn '.$type.' '. $size.'" '.$modal.'>';
	}
	
	$output .= $text;
	$output .= $sub;

	if($url !== '') {
		$output .= '</a>';
	} else {
		$output .= '</button>';
	}

	return $output;
}
add_shortcode('button', 'buttons'); 

// Icons (font awesome)
function icons( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => '', /* http://fortawesome.github.io/Font-Awesome/icons/ */
	), $atts ) );
		
	$output = '<i class="fa fa-'.$type.'"></i>';
	return $output;
}
add_shortcode('icon', 'icons'); 

// Alerts
// [box color='blu' close='true']
function alerts( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'color' => 'green', 
	'close' => 'false' /* display close link */
	), $atts ) );

	/* info, success, warning, danger */
	if($color == 'green') $color = 'success';
	if($color == 'blu') $color = 'info';
	if($color == 'yellow') $color = 'warning';
	if($color == 'red') $color = 'danger';
	
	if($close == 'true') {
		$dismiss = 'alert-dismissible ';
	}

	$output = '<div class="'.$dismiss.'alert alert-'.$color.'" role="alert">';
	if($close == 'true') {
		$output .= '<button type="button" class="close" data-dismiss="alert" aria-label="'.__('Close', $theme_name).'"><span aria-hidden="true">&times;</span></button>';
	}
	$output .= $content . '</div>';
	
	return $output;
}
add_shortcode('box', 'alerts');

// Block Messages
function blockquotes( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'float' => '' /* left, right */
	), $atts ) );
	
	$output = '<blockquote';
	if($float == 'left') {
		$output .= ' class="pull-left"';
	}
	elseif($float == 'right'){
		$output .= ' class="pull-right"';
	}
	$output .= '><p>' . $content . '</p>';
	
	if($cite){
		$output .= '<small>' . $content . '</small>';
	}
	
	$output .= '</blockquote>';
	return $output;
}
add_shortcode('blockquote', 'blockquotes'); 
 



?>