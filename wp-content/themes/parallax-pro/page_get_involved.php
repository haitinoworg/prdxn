<?php
/**
* Template Name: Get Involved
* Author: PRDXN
*/

remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );

// Add our custom loop
// remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'programs_loop' );
function programs_loop() {

	?>

	<!-- Program Post Images -->
	<section class="get-involved-page-template">
		<div class="get-involved-page entry">

			<?php
		// $permalink = the_permalink();
		// echo '<pre>';
		// var_dump($permalink);
		// echo '</pre>';
		// exit();
			if(have_posts()): the_post();
			global $post;
			$args = array(
				'post_type'  => 'post',
				'posts_per_page' => 4,
				'post' =>'get_involved',
				'orderby' => 'ID',
				'order' => 'ASC',
				'include' => '239,241,243,245'
				);

			$sections = get_posts( $args );

			foreach ( $sections as $post ) : setup_postdata( $post );

			?>
			<section class="post-sections" id="post-<?php the_ID();?>" >
				<h2><?php the_title(); ?></h2>
				<p><?php  ?></p>
			</section>

			<?php

			endforeach;
			wp_reset_postdata();
			endif;
			?>

		</div>
	</section>
	<?php
	the_meta();
}

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
genesis();
