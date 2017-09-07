<?php
/**
 * The custom programs post type archive template
 */



//* Remove the post date, author name
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

// * Add the featured image after post title
add_action( 'genesis_before_content', 'custom_about_heroimage' );
function custom_about_heroimage() {
	echo '<div class="content"><div class="post-hero-image">';
	if ( has_post_thumbnail() ) { 
		the_post_thumbnail(); 
	} else {
		echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
		. '/images/empty-image.png" />';
	}
	echo '</div></div>';
}


remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action('genesis_entry_header','custom_single_post_title');
function custom_single_post_title() {
	echo '<h1 class="blog-post-title">';
	echo the_title() . '</h1>';
}


//* Removes only the comment form
	add_action( 'genesis_before_content_sidebar_wrap', 'custom_breadcrumbs', 15 );
	function custom_breadcrumbs() {
		?>
		<div class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">You are here: <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a href="<?php echo site_url(); ?>" itemprop="item"><span itemprop="name">Home</span></a></span> 
		<span aria-label="breadcrumb separator">/</span> 
		<span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a href="<?php echo site_url(); ?>/blog" itemprop="item"><span itemprop="name">Blog</span></a></span> 
		<span aria-label="breadcrumb separator">/</span> <?php echo get_the_title(); ?></div>
		<?php
	}
	
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );


/*
* Single Post Pagination
*/

//Remove Default Post Pagination
remove_action('genesis_after_endwhile','genesis_posts_nav');
add_action('genesis_after_endwhile','custom_post_pagination');
function custom_post_pagination() {
	$prev = get_previous_post_link();
	$next = get_next_post_link();
		?>
	<div class="post-navigations">
	<?php if($prev){ ?>
		<div class="left-link">
			<?php echo get_previous_post_link(); ?>
		</div>
		<?php } if($prev && $next) { ?>
		<div class="right-link">
			<?php echo get_next_post_link(); ?>
		</div>
		<?php } if($next && ! $next) { ?>
		<div class="left-link">
			<?php echo get_next_post_link(); ?>
		</div>
		<?php } ?>
	</div>
	<?php
}


genesis();