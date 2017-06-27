<?php
/**
 * This file adds the Landing template to the Parallax Pro Theme.
 *
 * @author StudioPress
 * @package Parallax
 * @subpackage Customizations
 */

/*
Template Name: Donate Page
*/

//* Add custom body class to the head
add_filter( 'body_class', 'parallax_add_body_class' );
function parallax_add_body_class( $classes ) {

	$classes[] = 'parallax-landing';
	return $classes;

}


	/* Add the featured image */
	add_action( 'genesis_before_entry', 'programs_featured_image' );
	function programs_featured_image() {
		echo '<div class="programs-hero-image"><div class="wrap"><div class="hero-content"><div class="donate-desc">';
		echo the_field("donate_text");
		echo '<h3 class="page-title">';
		echo the_title() . '</h3></div>';
		echo the_field("donate_shortcode");
		echo '</div></div>';
		if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
			printf( '<img src="%s" alt="%s" />', $image, the_title_attribute( 'echo=0' ) );
			echo '</div>';
		} else {
			echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
			. '/images/empty-image.png" /></div>';
		}


	}

  /* For Icons section */
	add_action('genesis_after_entry','custom_list_content');
	function custom_list_content() {
		$donation_data = get_field('donation_data');
		$questions = get_field('question_field');
		if($donation_data) {	
			?>
			<article class="entry donate-entry">
				<div class="real-time-data entry-content">
					<?php echo $donation_data; ?>
				</div>
			</article>
			<?php
		} else { echo '';	}

		if($questions) {
			?>
			<article class="entry questions-section">
				<div class="entry-content">
					<?php echo $questions; ?>
				</div>
			</article>
			<?php
		} else { echo ''; }

	}

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();
