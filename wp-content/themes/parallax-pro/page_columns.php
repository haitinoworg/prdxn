<?php
/**
* Template Name: Columns
* Author: PRDXN
*/
//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );


// Add our custom loop
add_action( 'genesis_loop', 'columns_loop' );
function columns_loop() {
	global $post;
	$post_slug=$post->post_name;

	$post_style = get_field('column_layout');

	//* Condition for checking post thumbnail
	if($post_style == "Two Columns") {
		get_template_part( 'template-parts/page/two', 'columns' );

	}  
	if($post_style == "Three Columns") {
		get_template_part( 'template-parts/page/three', 'columns' );
	}

}


remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
genesis();
