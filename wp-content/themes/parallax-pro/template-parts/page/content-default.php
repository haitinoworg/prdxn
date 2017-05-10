<?php
/**
 * Template part for displaying image, title excerpt and view more content in Two Column Layout
 *
 *
 * @package WordPress
 * @subpackage Parallax_Pro
 * @since 1.0
 * @version 1.0
 */
global $post;
$post_slug = $post->post_name;

if(have_posts()): the_post();

if($post_slug == "program") {
	$args = array(
		'post_type' => 'programs',
		'post_per_page' => -1
		);

	$post_query = get_posts( $args );

	foreach( $post_query as $post ) : setup_postdata( $post );
	?>
	<div class="post-images content-default" >
		<?php 
	// Condition for Featured Image
		?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php 
			if ( has_post_thumbnail() ) { 
				the_post_thumbnail();	
			} else {
				echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
				. '/images/empty-image.png" />';
			}
			?>
		</a>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<?php the_excerpt(); ?>
		</div>
	</div>

	<?php 
	endforeach;
	wp_reset_postdata();

} else {
	$args = array(
		'post_type' => 'post',
		'category_name' => $post_slug,
		'posts_per_page' => -1
		);	

	$post_query = get_posts( $args );
	
	foreach( $post_query as $post ) : setup_postdata( $post );
	?>
	<div class="post-images content-default" >
		<?php 
	// Condition for Featured Image
		?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php 
			if ( has_post_thumbnail() ) { 
				the_post_thumbnail();	
			} else {
				echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
				. '/images/empty-image.png" />';
			}
			?>
		</a>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<?php the_excerpt(); ?>
		</div>
	</div>

	<?php 
	endforeach;
	wp_reset_postdata();
}

endif;


