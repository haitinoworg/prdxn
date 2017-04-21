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
	'post_parent' => get_the_ID(),
	'post_type' => 'page'
	);

$videos = get_posts( $args );

foreach( $videos as $args ) : setup_postdata( $args );

	//* Condition for checking post thumbnail
?>
<div class="post-images content-default" >
	<?php 
	
	
	$thumbnail_image = get_the_post_thumbnail_url($args);
	?>
	<a href="<?php the_permalink($args); ?>" title="<?php echo get_the_title($args); ?>">
		<?php
		if ( isset($thumbnail_image) ) {  
			?>
			<img src='<?php echo $thumbnail_image; ?>' />
			<?php
		}
		else {
			echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
			. '/images/empty-image.png" />';
		}
		?>
	</a>
	<div class="entry-content">
		<h3><?php echo get_the_title($args); ?></h3>
		<?php the_excerpt($args); ?>
	</div>
</div>

<?php 
endforeach;
endif;


