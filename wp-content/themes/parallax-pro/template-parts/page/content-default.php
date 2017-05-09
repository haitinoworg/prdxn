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
$post_slug=$post->post_name;



if(have_posts()): the_post();

$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$args = array(
	'post_type' => 'programs'
	);

$videos = get_posts( $args );

foreach( $videos as $post ) : setup_postdata( $post );


		//* Condition for checking post thumbnail
?>
<div class="post-images content-default" >
	<?php 
	if ( has_post_thumbnail() ) { 
		?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_post_thumbnail(array(150,150));	
			?>
		</a>
		<?php
	} else {
		?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php 

			echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
			. '/images/empty-image.png" />';
			?>
		</a>
		<?php
	}
	?>
	<div class="entry-content">
		<h3><?php the_title(); ?></h3>
		<?php the_excerpt(); ?>
	</div>
</div>

<?php 
endforeach;
endif;


