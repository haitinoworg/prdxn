<?php
/**
 * Image With Overlay
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
//Protect against arbitrary paged values
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$args = array( 
	'post_parent' => get_the_ID(),
	'post_type' => 'page'
	);

$videos = get_posts( $args );

foreach( $videos as $post ) : setup_postdata( $post );

		//* Condition for checking post thumbnail
?>
<div class="post-images content-image">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php	
		if(has_post_thumbnail()){
			the_post_thumbnail();	
		} else {
			echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/empty-image.png" />';
		}
		?>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<?php the_content(); ?>
		</div>
	</a>
</div>
<?php

endforeach;
wp_reset_postdata();
endif;

$post_object = get_field('select_post');

if( $post_object ): 
	setup_postdata( $post_object ); 
?>
<div class="post-images content-image">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php	
		if(has_post_thumbnail()) {
			the_post_thumbnail();	
		} else {
			echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/empty-image.png" />';
		}
		?>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<?php the_content(); ?>
		</div>
	</a>
</div>
<?php wp_reset_postdata(); 
endif;

