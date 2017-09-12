<?php
/**
* Template Name: Our Impact
* Author: PRDXN
*/

remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );

add_action( 'genesis_entry_content', 'custom_impact_function' );
function custom_impact_function() {
	global $post;
	$post_slug = $post->post_name;
	global $amount,$count;

	if(have_posts()): the_post();
	$args = array(
		'post_type' => 'sfdonation',
		'post_per_page' => -1
		);

	$post_query = get_posts( $args );
	foreach( $post_query as $post ) : setup_postdata( $post );
	$count = get_the_content();
	$amount = $count + $amount;
	endforeach;
	wp_reset_postdata();
	?>

	<article class="entry">	
		<?php 
		echo $total = $amount;
		?>

	</article>
	<?php 
	endif;
}
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
genesis();


