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


?>
<section class="program-posts columns-page links-page">
	<div class="entry">
		<?php

		global $post;
		$post_slug=$post->post_name;

		if(have_posts()): the_post();

		$args = array( 
			'post_type' => 'post',
			'posts_per_page'=> -1,
			'category_name' => $post_slug
			);

		$staff = get_posts( $args );

		foreach( $staff as $post ) : setup_postdata( $post );

		//* Condition for checking post thumbnail
		?>
		<div class="post-images content-links">
			<div class="entry-content">
				<h3><?php the_title(); ?></h3>
				<p><?php the_content(); ?></p>
			</div>
		</div>
		<?php

		endforeach;
		wp_reset_postdata();
		endif;
		?>
	</div>
</section>
