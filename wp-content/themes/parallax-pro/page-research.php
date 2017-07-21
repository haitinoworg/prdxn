<?php
/**
* Template Name: Research
*/

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

/*
* Removing Post Content
*/
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );


// * Add the featured image after post title
add_action( 'genesis_before_loop', 'custom_featured_image' );
function custom_featured_image() {
 echo '<div class="programs-hero-image"><div class="wrap"><div class="hero-content">';
 echo '<h3>';
 echo the_title() .'</h3></div></div>';
 if ( $image = genesis_get_image( 'format=url&size=programs' ) ) {
  printf( '<img src="%s" alt="%s" />', $image, the_title_attribute( 'echo=0' ) );
}
echo '<div id="research-tabs" class="tabs"><ul>';

}


add_action('genesis_loop','research_tabs_loop');
function research_tabs_loop() {
  global $post;
  $post_slug = $post->post_name;

  ?>
  <li class="active"><?php the_title(); ?></li>
  <?php

  $page_object = get_field('select_tab_pages');

  if( $page_object ): setup_postdata( $page_object ); 
  foreach($page_object as $post):
    ?>
  <li><?php the_title(); ?></li>
  <?php 
  endforeach;
  endif;
  wp_reset_postdata(); 
}

//* Remove site footer widgets
// remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after_loop', 'sponsors_loop' );
function sponsors_loop(){
  ?>     
</ul></div></div></div> 
<div class="gallery research-accordions">
  <div id="tab-content" class="tabs">
    <?php
    global $post;
    $post_slug = $post->post_name;
    $accordion_code = get_field('accordion_shortcode'); 

      ?>
      <div class="tab-detail">
        <div class="tab-page-content">
          <?php the_content(); ?>
        </div>
        <?php if($accordion_code) { echo do_shortcode($accordion_code); }   ?>
      </div>
      <?php
    $page_object = get_field('select_tab_pages');
    if( $page_object ): setup_postdata( $page_object ); 
    foreach($page_object as $post): 
      ?>
    <div class="tab-detail">
    <div class="tab-page-content">
          <?php 
          $content = $post->post_content;
          echo $content;
          ?>
    </div>
      <?php
      $accordion_code = get_field('accordion_shortcode'); 
      if($accordion_code) {  echo do_shortcode($accordion_code); }
      ?>
    </div>
    <?php 
    endforeach;
    endif;
    wp_reset_postdata(); 
    ?>
  </div>
</div>
<?php
}


//* Run the Genesis loop
genesis();