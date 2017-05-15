<?php
/**
* Template Name: Two Column Layout
* Author: PRDXN
*/
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );


// echo get_page_template_slug( $post_id );
global $post;
$post_slug=$post->post_name;

if($post_slug == "program" || $post_slug == "get-involved") {
	// * Add the featured image after post title
	add_action( 'genesis_before_entry', 'programs_featured_image' );
	function programs_featured_image() {
		echo '<div class="programs-hero-image"><div class="wrap"><div class="hero-content">';
		echo '<h3>Donate for this programs</h3>';
		echo '<p>';
		echo the_field("donate_text") . '</p>';
		echo do_shortcode('[direct-stripe type="donation" button_id="stripe_donate_btn" name="Pay for Ayiti Now" label="Donate" panellabel="Pay Amount" capture="true" display_amount="false" currency="USD" success_url="prdxnstaging2.com/ayiti"]').'</div>';
		echo '<h3>';
		echo the_title() .'</h3></div>';
		if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
			printf( '<img src="%s" alt="%s" />', $image, the_title_attribute( 'echo=0' ) );
			echo '</div>';
		}
	}

	add_action( 'genesis_loop', 'programs_loop' );
	function programs_loop() {
		global $post;
		$post_slug=$post->post_name;

		$cat_id = get_field('select_post_category');
		?>

		<!-- Program Post Images -->
		<section class="program-posts">
			<div class="entry">
				<?php
				$post_style = get_field('select_post_styling');

				if($post_style == "Content Default") {
					get_template_part( 'template-parts/page/content', 'default' );
				}	
				if($post_style == "Products") {
					get_template_part( 'template-parts/page/content', 'pages' );
				}
				?>
			</div>
		</section>
		<?php
	}

} 
/*
* Movies Post Setup with Load More
*/
else {

	global $post_title;
	$slug_name = $post_title->post_name;

	add_action( 'genesis_entry_header', 'genesis_do_post_title' );
	add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );

	add_action( 'genesis_loop', 'programs_loop' );
	function programs_loop() {
		$scroller_query = array( 
			'post_type' => 'post',
			'category_name' => $slug_name,
			'posts_per_page' => 8,
			);

			?>
			<section class="program-posts" >
				<div class="entry" id="loadmore-data">
					<?php
					$loop = new WP_Query( $scroller_query );
					if( $loop->have_posts() ): 
						while( $loop->have_posts() ): $loop->the_post();
					?>
					<div class="post-images two-columns" >
						<?php 
						if ( has_post_thumbnail() ) { 
							the_post_thumbnail();	
						} else {
							echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
							. '/images/empty-image.png" />';
						}
						?>

						<div class="entry-content">
							<h3><?php the_title(); ?></h3>
							<div class="excerpt-content active">
								<?php 
								$content = get_the_content();
								echo '<p>' . mb_strimwidth($content, 0, 135, "...") . '</p>'; ?>
								<a href="#FIXME" class="custom-links read-more more-content">Read More</a>
							</div>
							<div class="detailed-content">
								<?php the_content(); ?>
								<a href="#FIXME" class="custom-links read-more less-content">Read Less</a>
							</div>
						</div>

					</div>
					<?php
					endwhile; endif; wp_reset_postdata();
					?>
				</div>
			</section>
			<?php

		}

		add_action('genesis_after_loop','load_more_btn');
		function load_more_btn() {
			echo '<button class="loadmore" data-page="1" data-category="movies" data-url="' . admin_url('admin-ajax.php') .'">View More</button>';
		}
	}



	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	genesis();


