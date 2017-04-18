<?php
/*
Plugin Name: Genesis - Grandchild theme plugin
Description: Child theme for Parallax Pro build as a plugin.
Author: PRDXN
Version: 1.0
*/

// Adds our new file with styles and scripts
function grandchild_add_files() {
	wp_enqueue_style('grandchild-style', plugins_url( 'grandchild-styles.css', __FILE__ ), array());
	
	wp_enqueue_style( 'fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5' );

	// Static url given because, its post publishing error on new post.
	wp_enqueue_script(  'grandchild-script', '/wp-content/plugins/genesis-grandchild/grandchild-scripts.js', array( 'jquery' ));
}
add_action( 'wp_print_scripts', 'grandchild_add_files' );


// Post Format Supports
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link','image','video','quote' ) );

add_theme_support( 'genesis-post-format-images' );

/**
Footer Simple Social Share
*/
add_action('genesis_before_footer','social_icons_section');

function social_icons_section() {
	

	genesis_widget_area( 'home-section-5', array(
		'before' => '<div class="home-odd home-section-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
		) );
}

