<?php
/**
* Template Name: Research
*/

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove site header elements
// remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
// remove_action( 'genesis_header', 'genesis_do_header' );
// remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// * Add the featured image after post title
add_action( 'genesis_before_entry', 'programs_featured_image' );
function programs_featured_image() {
 echo '<div class="programs-hero-image"><div class="wrap"><div class="hero-content">';
 echo '<h3>';
 echo the_title() .'</h3></div></div>';
 if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
  printf( '<img src="%s" alt="%s" />', $image, the_title_attribute( 'echo=0' ) );
  echo '     
  <div id="tabs" class="tabs">
    <ul>
      <li class="active">Research</li>
      <li>Sanitation</li>
      <li>History</li>
    </ul></div></div></div>';
  }
}

//* Remove site footer widgets
// remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_entry_footer', 'sponsors_loop' );
function sponsors_loop(){
  ?>      <div class="gallery">
  <div id="tab-content" class="tabs">
    <div class="tab-detail">
      <?php echo do_shortcode("[accordions id='964']"); ?>
    </div>
    <div class="tab-detail">  
      <?php  echo do_shortcode("[accordions id='965']"); ?>
    </div>
    <div class="tab-detail">  
      <?php  echo do_shortcode("[accordions id='965']"); ?>
    </div>
  </div>
</div>
<?php
}


//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();