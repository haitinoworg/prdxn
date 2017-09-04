<?php
/**
* Template Name: About
*/

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );


// * Add the featured image after post title
add_action( 'genesis_before_content', 'custom_about_heroimage' );
function custom_about_heroimage() {
 echo '<div class="programs-hero-image"><div class="wrap"><div class="hero-content">';
 echo '<h3>';
 echo the_title() .'</h3></div></div>';
  if ( has_post_thumbnail() ) { 
        the_post_thumbnail(); 
      } else {
        echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
        . '/images/empty-image.png" />';
      }
      echo '</div>';
}

add_action( 'genesis_loop', 'custom_about_loop' );
function custom_about_loop() {
      

}


//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();