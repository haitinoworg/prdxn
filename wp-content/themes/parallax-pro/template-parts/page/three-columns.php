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


global $post;
$post_slug=$post->post_name;

?>
<section class="program-posts columns-page books">
	<div class="entry" id="load-books">
		<?php
		$args = array( 
			'post_type' => $post_slug,
			'posts_per_page'=> 9
			);

		$post_count = new WP_Query( $args );
		$max = $post_count->max_num_pages;

		if($post_count->have_posts()): setup_postdata($post_count);


		while ($post_count->have_posts() ): $post_count->the_post();
		?>
		<div class="three-columns">
			<?php
			$book_link = get_field('book_link'); 
			 if($book_link) {
			?>
			<a href="<?php echo $book_link; ?>" title="<?php echo the_title_attribute(); ?>" target="_blank">
			<?php
			} else {
				?> 
				<a class="team-link" href="javascript:void(0)" title="<?php echo the_title_attribute(); ?>">
				<?php
			}

			if(has_post_thumbnail()){
				the_post_thumbnail();	
			} else {
				echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/movies-empty.png" />';
			}
			?>
			<div class="entry-content">
				<div>
						<h3><?php the_title(); ?></h3>
						<div><?php 
							$book_desc = get_field('books_description'); 
							if($book_desc) {
								echo $book_desc;
							}
							else { the_content(); }
							
							?>
						</div>
				</div>
			</div>
		</a>
	</div>
		<?php 

		endwhile;
		endif;
		wp_reset_postdata();

		echo '</div><button class="loadmore-books" data-page="1" data-post="'. $post_slug .'" data-url="' . admin_url('admin-ajax.php') .'" data-totalcount="'. $max .'" >View More</button></section>';

		?>
	</div>
</section>

