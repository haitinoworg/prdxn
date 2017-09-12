<?php
/**
* Template Name: Get Involved
* Author: PRDXN
*/
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );

global $post;
$post_slug=$post->post_name;

// * Add the featured image after post title
add_action( 'genesis_before_entry', 'get_involved_featured_image' );
function get_involved_featured_image() {
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

add_action( 'genesis_loop', 'get_involved_loop' );
function get_involved_loop() {
	global $post;
	$post_slug=$post->post_name;
	?>

	<!-- Program Post Images -->
	<section class="program-posts">
		<div class="entry">
			<?php
			get_template_part( 'template-parts/page/content', 'pages' );
			?>
		</div>
	</section>
	<?php
}


add_action('genesis_before_footer','subscribe_section');
add_action('genesis_before_footer','salesforce_section');
function salesforce_section() {
	global $post;


	$section_checkbox = get_field('add_sections',$post->ID);

	if(($section_checkbox[0] == "Add Fundraise Section") || ($section_checkbox[1] == "Add Fundraise Section") ) {
		genesis_widget_area( 'home-section-7', array(
			'before' => '<div class="home-odd home-section-7 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
			) );
	} 

	genesis_widget_area( 'home-section-9', array(
		'before' => '<div class="home-odd home-section-9 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
		) );

}
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
genesis();


