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

add_action('wp_footer','custom_footer_script');

// Enable Custom Background
add_theme_support( 'custom-background' );


// Post Format Supports
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link','image','video','quote' ) );

/**
* Custom Post Types
*/
add_theme_support('post-thumbnails');
add_post_type_support( 'programs', 'thumbnail' );
add_action( 'init', 'create_post_type' );
function create_post_type() {

/*
* Custom Post Type Programs
*/

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

/*
* Custom Post Type Sponsors
*/

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

/*
* Custom Post Type Books
*/

register_post_type( 'books',
	array(
		'labels' => array(
			'name' => __( 'Books' ),
			'singular_name' => __( 'Books' )
			),
		'has_archive' => true,
		'hierarchical' => true,
		'public' => true,
		'rewrite'=> array('slug'=>'books'),
		'supports'            => array( 'title', 'post-formats', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes', 'genesis-seo' ),'taxonomies' => array('category')
		)
	);

/*
* Custom Post Type Movies
*/

register_post_type( 'movies',
	array(
		'labels' => array(
			'name' => __( 'Movies' ),
			'singular_name' => __( 'Movies' )
			),
		'has_archive' => true,
		'hierarchical' => true,
		'public' => true,
		'rewrite'=> array('slug'=>'movies'),
		'supports'            => array( 'title', 'editor', 'post-formats', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes', 'genesis-seo' ),'taxonomies' => array('category')
		)
	);

register_post_type( 'staff',
	array(
		'labels' => array(
			'name' => __( 'Staffs' ),
			'singular_name' => __( 'Staffs' )
			),
		'has_archive' => true,
		'hierarchical' => true,
		'public' => true,
		'rewrite'=> array('slug'=>'staff'),
		'supports'            => array( 'title', 'editor', 'post-formats', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes' ),'taxonomies' => array('category')
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
	return '<div><a class="common-links read-more more-content"  href="' . get_permalink() . '">Read&nbsp;More</a></div>';
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


//* Remove the site title
remove_action( 'genesis_site_title', 'genesis_seo_site_title' ,22);

// ShortCode for Site Title
function custom_site_logo( $atts ) {
	return do_action( 'genesis_site_title', 'genesis_seo_site_title' );
}
add_shortcode( 'site_title', 'custom_site_logo' );


/*
* Ajax Load More for Movies Page
*/

add_action('wp_ajax_ajax_load_more','ajax_load_more');
add_action('wp_ajax_nopriv_ajax_load_more','ajax_load_more');
function ajax_load_more() {
	$paged = $_POST["page"] + 1;
	$category = $_POST["category"];
	
	$query = new WP_Query( array(
		'post_type' => 'post',
		'category_name' => $category,
		'paged' => $paged,
		'posts_per_page' => 8
		));

	if( $query->have_posts() ): 
		while( $query->have_posts() ): $query->the_post();
	?>
	<div class="post-images two-columns movies" >
		<div class="image">
			<?php 
			if ( has_post_thumbnail() ) { 
				the_post_thumbnail();	
			} else {
				echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
				. '/images/empty-image.png" />';
			}
			?>
		</div>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<div class="excerpt-content active">
				<?php 
				$content = get_the_content();
				echo '<p>' . mb_strimwidth($content, 0, 135, "...") . '</p>'; ?>
				<a href="#FIXME" class="custom-links read-more more-content">Read More</a>
			</div>
			<div class="detailed-content">
				<?php the_content(); ?>
				<a href="#FIXME" class="custom-links read-more less-content">Read Less</a>
			</div>
		</div>

	</div>
	<?php
	endwhile; 
	endif; 
	wp_reset_postdata();
	die();
}


/*
* Ajax Load More for Books
*/


add_action('wp_ajax_ajax_load_more_books','ajax_load_more_books');
add_action('wp_ajax_nopriv_ajax_load_more_books','ajax_load_more_books');
function ajax_load_more_books() {
	$paged = $_POST["page"] + 1;
	$type = $_POST["books"];
	
	$query = new WP_Query( array(
		'post_type' => $type,
		'paged' => $paged,
		'posts_per_page' => 9
		));

	if( $query->have_posts() ): 
		while( $query->have_posts() ): $query->the_post();
	?>
	<div class="three-columns">
		<a href="<?php the_field('book_link'); ?>" title="<?php the_title(); ?>" target="_blank"><?php	
			if(has_post_thumbnail()){
				the_post_thumbnail();	
			} else {
				echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/empty-image.png" />';
			}
			?>
			<div class="entry-content">
				<h3><?php the_title(); ?></h3>
				<?php the_field('books_description'); ?>
			</div>
		</a>
	</div>
	<?php
	endwhile; 
	endif; 
	wp_reset_postdata();
	die();
}





remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );


//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );


//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );