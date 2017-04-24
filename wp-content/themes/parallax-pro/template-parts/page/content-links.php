<?php
/**
 * Template part for displaying image, overlay content in Two Column Layout Template
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
		// global $post;
		// $post_slug=$post->post_name;
		// echo $post_slug;

$args = array(
	'post_type' => 'post',
	'posts_per_page' => -1,
	'category_name' => $post_slug,
	'exclude' => '216,214'
	);

$videos = get_posts( $args );

foreach( $videos as $post ) : setup_postdata( $post );

?>

<div class="post-images">
	<div class="entry-content">
		<h3><?php the_title(); ?></h3>
		<?php the_content(); ?>
	</div>
</div>
<?php

endforeach;
wp_reset_postdata();

endif;

