<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * Template Name: Blog
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

// The blog page loop logic is located in lib/structure/loops.php.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
// remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

add_action('genesis_before_loop','custom_blog_title');

function custom_blog_title() {
	do_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );


add_action('genesis_entry_content','custom_blog_loop');
function custom_blog_loop() {

	if(has_post_thumbnail()) {
		echo '';
	}
	else {
		?>
		<a href="<?php the_permalink(); ?>">
			<img src="<?php echo get_bloginfo( 'stylesheet_directory' )
			. '/images/empty-image.png'; ?>" alt="<?php the_title(); ?>">
		</a>

		<?php	
	}

	?>
	<div class="blog-post-main-title">
		<h3><?php the_title(); ?></h3>
		<div>
			<?php 
			$content = get_the_content();
			echo mb_strimwidth($content, 0, 100, "...");
			?>
		</div>
	</div>
	<?php
}

genesis();
