<?php
/**
 * This file adds the Landing template to the Parallax Pro Theme.
 *
 * @author StudioPress
 * @package Parallax
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

//* Add custom body class to the head
add_filter( 'body_class', 'parallax_add_body_class' );
function parallax_add_body_class( $classes ) {

	$classes[] = 'parallax-landing';
	return $classes;

}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

add_action( 'genesis_before_entry_content', 'rtug_before_entry_content', 5 );
function rtug_before_entry_content() {
	$subtitle = get_field('sub_title');
	if($subtitle) {
		echo '<h3>' . $subtitle . '</h3>';
	}
}

//* Remove site footer widgets
// remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );


// Form Section Structure
add_action('genesis_after_entry','form_structure');
function form_structure() {
	$form_desc = get_field("form_description");
	$form = get_field( "form-field" );
	if($form_desc) {
		echo '<h3 class="form-title">' . $form_desc . '</h3>';
	}
	if ( $form) {
		echo '<div class="entry-content volunteer-form">'.  do_shortcode($form) . '</div>';
	}  
}

// Email Us Section Structure
add_action('genesis_after_content','email_us_func');
function email_us_func() {
	$email_us = get_field("email-us");
	if($email_us) {
		echo '<div class="email-us" >'. $email_us . '</div>';
	}
}

//* Remove site footer elements
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();
