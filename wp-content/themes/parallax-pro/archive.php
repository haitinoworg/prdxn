<?php
/**
 * Archive template
   Author: PRDXN
 */

//* Remove the post date, author name
   remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
   remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
   remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

   //* Remove the post content (requires HTML5 theme support)
   remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

   //* Remove the entry title (requires HTML5 theme support)
   remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

   add_action('genesis_before_loop','category_title');
   function category_title() {
      echo '<h2 class="entry-title">';
      single_term_title();
      echo '</h2>';
   }



//* Remove the entry meta in the entry footer
   remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
   remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
   remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );


//* Remove the entry meta in the entry footer
   remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );




   /** Add custom post image above post title */

   add_action( 'genesis_entry_content', 'generate_post_image', 5 );
   function generate_post_image() {
      if ( $image = genesis_get_image(array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' )) ) ) {
         ?>
         <div class="programs-hero-image">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
               <?php
               printf( '<img src="%s" alt="%s" />', $image, the_title_attribute( 'echo=0' ) );
               ?>
            </a>
         </div>
         <div class="post_content">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?> </a>
            <?php the_content(); ?>
         </div>
         <?php

      } else {
         ?>
         <div class="programs-hero-image">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
               <?php

               echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
               . '/images/empty-image.png" />';
               ?>
            </a>
         </div>
         <div class="post_content">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?> </a>
            <?php the_content(); ?>
         </div>
         <?php
      }

   }


   // * Removing default breadcrums and footer
   remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
   remove_action( 'genesis_footer', 'genesis_do_footer' );

//* Run the Genesis loop
   genesis();