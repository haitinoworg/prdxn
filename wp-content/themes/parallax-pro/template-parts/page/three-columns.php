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


if($post_slug == "books") { 
	?>
	<section class="program-posts columns-page books">
		<div class="entry" id="load-books">
			<?php
			$args = array( 
				'post_type' => $post_slug,
				'posts_per_page'=> 9
				);

			$i = $paged = $_POST["page"] + 1;

			$post_count = new WP_Query( $args );

			if($post_count->have_posts()): setup_postdata($post_count);


			while ($post_count->have_posts() ): $post_count->the_post();
			?>
			<div class="three-columns">
				<a href="<?php the_field('book_link'); ?>" title="<?php the_title(); ?>" target="_blank"><?php	
					if(has_post_thumbnail()){
						the_post_thumbnail();	
					} else {
						echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/empty-image.png" />';
					}
					?>
					<div class="entry-content">
						<h3><?php the_title(); ?></h3>
						<?php the_field('books_description'); ?>
					</div>
				</a>
			</div>
			<?php 

			endwhile;
			endif;
			wp_reset_postdata();
			$totalpages = round($i);

			echo '</div><button class="loadmore-books" data-page="1" data-post="'. $post_slug .'" data-url="' . admin_url('admin-ajax.php') .'" data-totalcount="'. $totalpages .'" data-count="empty">View More</button></section>';

		}

		else {
			?>
			<section class="program-posts columns-page">
				<div class="entry">
					<?php
					if(have_posts()): the_post();

					$args = array( 
						'post_type' => 'post',
						'posts_per_page'=> -1,
						'category_name' => $post_slug
						);
					$post_count = get_posts( $args );

					$i = 0;

					foreach ($post_count as $posts) : setup_postdata( $posts );
					$i++;

					endforeach;
					wp_reset_postdata();
					endif;

					$rows_count = round($i/3);

					echo do_shortcode('[ajax_load_more container_type="div" post_type="post" posts_per_page="3" category="'. $post_slug .'" scroll="false" button_label="View More"  transition_container="false" destroy_after="'. $rows_count .'"]');
				}
				?>
			</div>
		</section>

