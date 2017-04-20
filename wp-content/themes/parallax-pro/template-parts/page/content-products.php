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

$args = array(
	'post_type' => 'post',
	'posts_per_page' => 4,
	'category_name' => $post_slug,
	'exclude' => '216,214'
	);

$videos = get_posts( $args );

foreach( $videos as $post ) : setup_postdata( $post );



		//* Condition for checking post thumbnail
if(has_post_thumbnail()){

	?>

	<div class="post-images content-products">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php	the_post_thumbnail();		?>
		</a>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<?php the_content(); ?>
		</div>
	</div>
	<?php
}
else {
	$value = get_field( "videos" );

	if( $value ) {
		?>
		<div class="post-images content-products">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php	echo $value; ?></a>
			<div class="entry-content">
				<h3><?php the_title(); ?></h3>
				<?php the_content(); ?>
			</div>
		</div>
		<?php
	}
	else {
		?>
		<div class="post-images content-products">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php
				echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
				. '/images/empty-image.png" />'; ?>
			</a>
			<div class="entry-content">
				<h3><?php the_title(); ?></h3>
				<?php the_content(); ?>
			</div>
		</div>
		<?php
	}
}

endforeach;
wp_reset_postdata();
endif;

		/*
		Image Post Section Ends Here
		*/
		// $permalink = the_permalink();
		// echo '<pre>';
		// var_dump($permalink);
		// echo '</pre>';
		// exit();


