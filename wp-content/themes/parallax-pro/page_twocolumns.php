<?php
/**
* Template Name: Two Column Layout
* Author: PRDXN
*/
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );

// echo get_page_template_slug( $post_id );



// * Add the featured image after post title
add_action( 'genesis_before_entry', 'programs_featured_image' );
function programs_featured_image() {
	if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
		printf( '<div class="programs-hero-image"><img src="%s" alt="%s" /><header class="entry-header"><h1 class="entry-title" itemprop="headline">', $image, the_title_attribute( 'echo=0' ) );
		echo the_title(). '</h1></header></div>';

	}

}

// Add our custom loop
// remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'programs_loop' );
function programs_loop() {
	global $post;
	$post_slug=$post->post_name;

	$cat_id = get_field('select_post_category');
	?>

	<!-- Program Post Images -->
	<section class="program-posts">
		<div class="entry">
			<?php
			$post_style = get_field('select_post_styling');
		/*
		Image Post Section Ends Here ========================
		*/

		//* Condition for checking post thumbnail

		if($post_style == "Content Default") {
			get_template_part( 'template-parts/page/content', 'default' );
		}	elseif($post_style == "Products") {
			get_template_part( 'template-parts/page/content', 'pages' );
		} elseif($post_style == "Image with Overlay") {
			get_template_part( 'template-parts/page/content', 'image' );

		} else {
			get_template_part( 'template-parts/page/content', 'links' );
		}

		?>
	</div>
</section>
<?php

}


add_action('genesis_after_sidebar_widget_area','custom_sidebar');

function custom_sidebar() {
	global $post;
	$post_slug=$post->post_name;
	$category_id = get_cat_ID( $post_slug );
	// echo $post_slug;

	$category_link = get_category_link( $category_id );
	?>

	<a href="<?php echo esc_url( $category_link ); ?>" ><?php echo $post_slug; ?></a>
	<?php

}

// //Remove Default Post Pagination
// remove_action( 'genesis_post_content', 'genesis_do_post_content_nav' );


// function pagination_two_columns() {

// 	$args = array(
// 		'before' => '<div class="pagenums"><div class="pages">',
// 		'after' => '</div></div>',
// 		'next_or_number' => 'next',
// 		'nextpagelink' => __('Next Page'),
// 		'previouspagelink' => __('Previous Page'),
// 		'pagelink' => '%',
// 		'echo' => 1
// 		);
// 	wp_link_pages( $args );

// }

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
genesis();


