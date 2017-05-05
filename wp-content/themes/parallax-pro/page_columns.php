<?php
/**
* Template Name: Columns
* Author: PRDXN
*/
//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove site header elements
// remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
// remove_action( 'genesis_header', 'genesis_do_header' );
// remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
// remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );


// Add our custom loop
add_action( 'genesis_loop', 'columns_loop' );
function columns_loop() {
	global $post;
	$post_slug=$post->post_name;

	// $cat_id = get_field('select_post_category');
	?>

	<!-- Program Post Images -->
	<section class="program-posts">
		<div class="entry">
			<?php
			$post_style = get_field('column_layout');

			// $select_post = get_field('select_post');
		/*
		Image Post Section Ends Here ========================
		*/

		//* Condition for checking post thumbnail
		if($post_style == "Image with Overlay") {
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



remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
genesis();



