<?php
/**
 * Two Columns Layout
 *
 *
 * @package WordPress
 * @subpackage Parallax_Pro
 * @since 1.0
 * @version 1.0
 */
global $post;
$post_slug=$post->post_name;

if(have_posts()): the_post();

$args = array( 
	'post_type' => 'post',
	'posts_per_page'=> -1,
	'category_name' => $post_slug
	);
$post_count = get_posts( $args );

$i = 0;

foreach ($post_count as $posts) : setup_postdata( $post );
$i++;

endforeach;
wp_reset_postdata();
endif;

$rows_count = round($i/3);

echo do_shortcode('[ajax_load_more container_type="div" post_type="post" posts_per_page="3" category="'. $post_slug .'" scroll="false" button_label="View More" button_loading_label="Loading..." transition_container="false" destroy_after="'. $rows_count .'"]');


global $wp_query; // you can remove this line if everything works for you

