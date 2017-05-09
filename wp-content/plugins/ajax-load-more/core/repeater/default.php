<div class="three-columns">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php	
		if(has_post_thumbnail()){
			the_post_thumbnail();	
		} else {
			echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/empty-image.png" />';
		}
		?>
		<div class="entry-content">
			<h3><?php the_title(); ?></h3>
			<?php the_content(); ?>
		</div>
	</a>
</div>