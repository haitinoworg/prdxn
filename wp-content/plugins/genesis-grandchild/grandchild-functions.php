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
	wp_enqueue_script(  'grandchild-script', plugins_url( 'grandchild-scripts.js', __FILE__ ), array( 'jquery' ));
}
add_action( 'wp_print_scripts', 'grandchild_add_files' );



// Post Format Supports
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link','image','video','quote' ) );

//hook into the init action and call create_book_taxonomies when it fires

add_action( 'init', 'programs_category' );


// // Now register the taxonomy
function programs_category() {
	register_taxonomy('program_category',array('programs'), array(
		'hierarchical' => true,
		'labels' => 'New Program Category',
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'program_category' ),
		));
}


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
			'supports'            => array( 'title', 'editor','post-formats', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo' )
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
			'rewrite' => array( 'slug' => 'program-tags' ),
			// 'capabilities' => array(
			// 	'assign_terms' => 'edit_guides',
			// 	'edit_terms' => 'publish_guides'
			// 	)
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
			'supports'            => array( 'title', 'editor','post-formats', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo' )
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
	return '<div><a class="common-links read-more" href="' . get_permalink() . '">Read&nbsp;More</a></div>';
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


/*
* Donation Form
*/

function custom_function_donation() {
	echo do_shortcode('[salesforce form="9"]');
	$value = $_POST['sf_00N7F000001aMVs'];
	if(isset($_POST['submit'])) {
		echo '<form action="/your-server-side-code" method="POST">		
		<script
		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		data-key="pk_test_KVecPez3pulhmvexufQsCrUi"
		data-amount="<?php echo $value; ?>"
		data-name="Demo Site"
		data-description="2 widgets"
		data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		data-locale="auto">
	</script>
</form>';
}
}

add_shortcode('dn_shortcode','custom_function_donation');
