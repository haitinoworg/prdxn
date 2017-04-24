<?php
	/**
 * The custom programs post type archive template
 */

	//* Remove the post date, author name
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
// remove_action( 'genesis_entry_content', 'genesis_do_post_content'); 

// * Hero Image with donate content
	add_action( 'genesis_before_entry', 'programs_single_hero' );
	function programs_single_hero() {
		echo '<div class="programs-hero-image"><div class="wrap"><div class="hero-content">';
		echo '<h3>';
		echo the_title() .'</h3>';
		echo '<p>';
		echo the_field("donate_text") . '</p>';
		echo do_shortcode('[direct-stripe type="donation" name="My plugin" currency="USD" description="Help me improve the plugin" label="Donate Now" panellabel="This will add one more setting option!"]').'</div></div>';
		if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
			printf( '<img src="%s" alt="%s" />', $image, the_title_attribute( 'echo=0' ) );
			echo '</div>';

		}

	}



	// * Post List Content
	add_action('genesis_after_entry','custom_list_content');
	function custom_list_content() {
		$list_title = get_field('list-title');
		$left_content = get_field('left_column_topic');
		$right_content = get_field('right_column_topic');
		if($list_title) {	echo '<h2>'. $list_title . '</h2>';	} 
		else { echo '';	}
		if($left_content && $right_content) {	
			echo '<div class="wrap"><div class="one-half first">'. $left_content . '</div>';
			echo '<div class="one-half">' . $right_content . '</div></div>';
		} else { echo '';	}

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

	?>