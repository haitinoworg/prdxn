<?php
/**
* Template Name: Sponsors
*/

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove site header elements
// remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
// remove_action( 'genesis_header', 'genesis_do_header' );
// remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
// remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_entry_footer', 'sponsors_loop' );
function sponsors_loop(){
?>
      <div class="sponsors-container">
           <?php
           $wp_query = new WP_Query(array('post_type'=>'sponsors', 'post_status'=>'publish', 'posts_per_page'=>-1, 'order' => 'ASC')); 

            if($wp_query->have_posts() ): ?>
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                       <div class="sponsor-list">
                           <div class="news-image">
                              <a class="sponsor" title="<?php the_field('sponsor_name') ?>" target="_blank" href="<?php the_field('sponsor_link') ?>"><?php the_post_thumbnail(); ?></a>
                           </div>
                        </div>
                <?php endwhile; // end of the loop. ?>
            <?php endif; ?>
      </div>
<?php
}


//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();