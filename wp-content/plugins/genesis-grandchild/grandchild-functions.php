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

	
}
add_action( 'wp_print_scripts', 'grandchild_add_files' );

function custom_footer_script() {
	// Static url given because, its post publishing error on new post.
	wp_enqueue_script(  'grandchild-script', plugins_url( 'grandchild-scripts.js', __FILE__ ), array( 'jquery'), true);
}
<<<<<<< HEAD

add_action('wp_footer','custom_footer_script');

=======
>>>>>>> e9223894e14201e71f95fd334e0453d32eaf0c29

add_action('wp_footer','custom_footer_script');



// Post Format Supports
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link','image','video','quote' ) );


/**
* Custom Programs post
*/
add_theme_support('post-thumbnails');
add_post_type_support( 'programs', 'thumbnail' );
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'programs',
		array(
			'labels' => array(
				'name' => __( 'Programs' ),
				'singular_name' => __( 'Programs' )
				),
			'has_archive' => true,
			'hierarchical' => true,
			'public' => true,
			'rewrite'=> array('slug'=>'programs'),
			'supports'            => array( 'title', 'editor','post-formats', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo' ),
			'taxonomies' => array('category')
			)
		);
}

add_action( 'init', 'create_post_types' );
function create_post_types() {
	register_post_type( 'sponsors',
		array(
			'labels' => array(
				'name' => __( 'Sponsors' ),
				'singular_name' => __( 'Sponsors' )
				),
			'has_archive' => true,
			'hierarchical' => true,
			'public' => true,
			'rewrite'=> array('slug'=>'sponsors'),
			'supports'            => array( 'title', 'editor','post-formats', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo' ),'taxonomies' => array('category')
			)
		);
}


// Custom Programs Tags
add_action( 'init', 'people_init' );
function people_init() {
	// create a new taxonomy
	register_taxonomy(
		'program-tags',
		'programs',
		array(
			'label' => __( 'New Tags' ),
			'rewrite' => array( 'slug' => 'program-tags' )
			)
		);
}


//* Unregister primary navigation menu
add_theme_support( 'genesis-menus', array( 'secondary' => __( 'Secondary Navigation Menu', 'genesis' ) ) );

// Excerpt

add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 15; // pull first 50 words
}

// Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
<<<<<<< HEAD
	return '<div><a class="common-links" href="' . get_permalink() . '">Read&nbsp;More</a></div>';
=======
	return '<div><a class="common-links read-more" href="' . get_permalink() . '">Read&nbsp;More</a></div>';
>>>>>>> e9223894e14201e71f95fd334e0453d32eaf0c29
}

/** Add support for post format images */
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

// ShortCode for Site Title

function custom_site_logo( $atts ) {
	return do_action( 'genesis_site_title', 'genesis_seo_site_title' );
}
add_shortcode( 'site_title', 'custom_site_logo' );

