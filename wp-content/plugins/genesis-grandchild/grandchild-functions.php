<?php
/*
Plugin Name: Genesis - Grandchild theme plugin
Description: Child theme for Parallax Pro build as a plugin.
Author: PRDXN
Version: 1.0
*/

// Adds our new file with styles and scripts
add_action( 'wp_enqueue_scripts', 'grandchild_add_files' );
function grandchild_add_files() {
	wp_enqueue_style('grandchild-style', plugins_url( 'grandchild-styles.css', __FILE__ ), array());
	
	// wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '4.5' );
	wp_enqueue_style( 'fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5' );
	wp_enqueue_style( 'select-bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css', array(), '4.5' );

	
}

add_action('wp_footer','custom_footer_script');
function custom_footer_script() {
	// Static url given because, its post publishing error on new post.
	wp_enqueue_script('multi-select-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js', array('jquery'), true);
	wp_enqueue_script(  'grandchild-script', plugins_url( 'grandchild-scripts.js', __FILE__ ), array( 'jquery'), true);
}

// Enable Custom Background
add_theme_support( 'custom-background' );


// Post Format Supports
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link','image','video','quote' ) );


/**
* Hook for creating custom post types
*/
add_theme_support('post-thumbnails');
add_post_type_support( 'programs', 'thumbnail' );
add_action( 'init', 'create_post_type' );
function create_post_type() {

/*
* Registering Custom Post Type Programs
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
* Registering Custom Post Type Sponsors
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
* Registering Custom Post Type Books
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
* Registering Custom Post Type Movies
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


/*
* Registering Custom Post Type Staff
*/

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
	return 15; // pull first 15 words
}

// Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link( ) {
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
		'post_type' => $category,
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
			<div class="detailed-content">
				<?php the_content(); ?>
			</div>
			<span class="custom-links read-more more-content">Read More</span>
			<span class="custom-links read-more less-content">Read Less</span>
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
				<div>
					<h3><?php the_title(); ?></h3>
					<p><?php 
						$book_desc = get_field('books_description'); 
						if($book_desc) {
							echo $book_desc;
						}
						else { the_content(); }
						
						?>
					</p>
				</div>
			</div>
		</a>
	</div>
	<?php
	endwhile; 
	endif; 
	wp_reset_postdata();
	die();
}


add_shortcode( 'donate_shortcode', 'custom_dn_shortcode' );

function custom_dn_shortcode( ) {
	?>
	<section class="salesforce-form" >

		<div id="tabs" class="stripe-paypal dntplgn_form_wrapper">
			<ul>
				<li><a href="#tabs-1">Donate Once</a></li>
				<li><a href="#tabs-2">Donate Monthly</a></li>
			</ul>
			<div id="tabs-1">
				<form action="#" class="donate-form" value="submit" method="POST">

					<input type=hidden name="oid" value="00D7F0000002Vh5">
					<div class="salesforce-form">
						<div class="donation-box">
							<input  aria-labelledby="00N7F000001pAWj_pcl" id="00N7F000001pAWj" maxlength="100" name="00N7F000001pAWj" size="20" type="text" value="60" />
						</div>
						<button type="button" class="donate-btn">Donate</button>
					</div>
				</form>
				<div class="stripe-paypal-form">
					<?php 
					echo do_shortcode('[direct-stripe type="donation" amount="" name="Pay for Ayiti Now" label="Credit Card" panellabel="Pay Amount" currency="USD" display_amount="true"]');
					echo do_shortcode('	[wp_paypal button="donate" amount="1.00" name="My product"]');
					?>
				</div>
				<div class="clear"></div>
			</div>

			<div id="tabs-2">
				<form action="#" class="donate-form" value="submit" method="POST">
					<input type=hidden name="oid" value="00D7F0000002Vh5">
					<div class="salesforce-form">
						<div class="donation-box">
							<input  aria-labelledby="00N7F000001pAWj_pcl" id="00N7F000001pAWj" maxlength="100" name="00N7F000001pAWj" size="20" type="text" value="60" />
						</div>
						<button type="button" class="donate-btn">Donate</button>
					</div>
				</form>
				<div class="stripe-paypal-form">
					<?php 
					echo do_shortcode('[direct-stripe type="donation" amount="'. $value2 .'" name="Pay for Ayiti Now" label="Credit Card" panellabel="Pay Amount" currency="USD" display_amount="true"]');
					echo do_shortcode('	[wp_paypal button="donate" amount="1.00" name="My product"]');
					?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</section>
	<?php	
}


/*
* Removing Comments page
*/

add_action( 'admin_menu', 'remove_menus' );
function remove_menus(){
	remove_menu_page( 'edit-comments.php' );    
}

add_action( 'genesis_before', 'genesis_to_top');
function genesis_to_top() {
	echo '<a href="#0" class="to-top" title="Back To Top"><i class="fa fa-arrow-circle-up fa-2x" aria-hidden="true"></i></a>';
}