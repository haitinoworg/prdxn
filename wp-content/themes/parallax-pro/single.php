<?php
/**
 * The custom programs post type archive template
 */



//* Remove the post date, author name
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );


// * Add the featured image after post title
add_action( 'genesis_before_entry', 'programs_featured_image' );
function programs_featured_image() {
	if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
		printf( '<div class="programs-hero-image"><img src="%s" alt="%s" /></div>', $image, the_title_attribute( 'echo=0' ) );
	}
}


add_action( 'genesis_entry_footer', 'programs_custom_video' );
function programs_custom_video() {
	?>
	<div class="lightbox-video">
		<?php

		if ( $value1 = get_field( "video1" ) ) {
			echo '<div>'. wp_oembed_get($value1) . '</div>';
		}
		if( $value2 = get_field("video2")) {
			echo '<div>'. wp_oembed_get($value2) . '</div>';
		}

		?>
	</div>
	<?php
}

// * Removing Comment Section
remove_action( 'genesis_after_post', 'genesis_get_comments_template' );

// Removing Genesis Before Loop and Footer Default Copy Right Section
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );

remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );


//* Removes only the comment form
remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );

genesis();