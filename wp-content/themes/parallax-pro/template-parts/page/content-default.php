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
		// global $post;
		// $post_slug=$post->post_name;
		// echo $post_slug;
//Protect against arbitrary paged values
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$args = array(
	'post_type' => 'post',
	'category_name' => $post_slug
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
	}
	?>

	<h3><?php the_title(); ?></h3>
	<?php the_excerpt(); ?>
</div>

<?php 
endforeach;
endif;


