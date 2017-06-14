<?php
/**
 * The custom programs post type archive template
 */



//* Remove the post date, author name
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

// * Removing Comment Section
remove_action( 'genesis_after_post', 'genesis_get_comments_template' );

// Removing Genesis Before Loop and Footer Default Copy Right Section
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );

remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );

// * Add the featured image after post title
add_action( 'genesis_before_content', 'custom_about_heroimage' );
function custom_about_heroimage() {
	echo '<div class="content"><div class="post-hero-image">';
	if ( has_post_thumbnail() ) { 
		the_post_thumbnail(); 
	} else {
		echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
		. '/images/empty-image.png" />';
	}
	echo '</div></div>';
}


remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action('genesis_entry_header','custom_single_post_title');
function custom_single_post_title() {
	echo '<h1 class="blog-post-title">';
	echo the_title() . '</h1>';
}


//* Removes only the comment form
remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );

genesis();