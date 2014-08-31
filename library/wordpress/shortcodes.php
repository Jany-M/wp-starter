<?php

// Buttons
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
function alerts( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => 'alert-info', /* alert-info, alert-success, alert-error */
	'close' => 'false', /* display close link */
	'text' => '', 
	), $atts ) );
	
	$output = '<div class="fade in alert alert-'. $type . '">';
	if($close == 'true') {
		$output .= '<a class="close" data-dismiss="alert">×</a>';
	}
	$output .= $text . '</div>';
	
	return $output;
}

add_shortcode('alert', 'alerts');

// Block Messages
function block_messages( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'type' => 'alert-info', /* alert-info, alert-success, alert-error */
	'close' => 'false', /* display close link */
	'text' => '', 
	), $atts ) );
	
	$output = '<div class="fade in alert alert-block alert-'. $type . '">';
	if($close == 'true') {
		$output .= '<a class="close" data-dismiss="alert">×</a>';
	}
	$output .= '<p>' . $text . '</p></div>';
	
	return $output;
}

add_shortcode('block-message', 'block_messages'); 

// Block Messages
function blockquotes( $atts, $content = null ) {
	extract( shortcode_atts( array(
	'float' => '', /* left, right */
	'cite' => '', /* text for cite */
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
		$output .= '<small>' . $cite . '</small>';
	}
	
	$output .= '</blockquote>';
	return $output;
}
add_shortcode('blockquote', 'blockquotes'); 
 



?>