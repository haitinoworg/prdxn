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
$args = array( 
	'post_parent' => get_the_ID(),
	'post_type' => 'page'
	);

$subpost = get_posts( $args );

foreach( $subpost as $posts ) : setup_postdata( $posts );

?>
<div class="post-images content-default" >
	<?php 
	
	
	$thumbnail_image = get_the_post_thumbnail_url($posts);
	?>
	<a href="<?php the_permalink($posts); ?>" title="<?php echo get_the_title($posts); ?>">
		<?php
		if ( isset($thumbnail_image) ) {  
			?>
			<img src='<?php echo $thumbnail_image; ?>' alt="<?php echo get_the_title($posts); ?>" />
			<?php
		}
		else {
			echo '<img src="' . get_bloginfo( 'stylesheet_directory' )	. '/images/empty-image.png" />';
		}
		?>
	</a>

	<div class="entry-content">
		<h3><?php echo get_the_title($posts); ?></h3>
		<div class="post-object-content">
		<p>
			<?php 
				$excerpt = wp_trim_words( $posts->post_content, $num_words = 20 );
				echo $excerpt;
			?>
		</p>
			<div><a class="common-links read-more more-content"  href="<?php the_permalink($posts); ?>">Read More</a></div>
		</div>
	</div>
</div>

<?php 
endforeach;
endif;


