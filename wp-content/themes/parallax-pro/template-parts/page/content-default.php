<?php
/**
 * Template part for displaying image, title excerpt and view more content in Two Column Layout
 *
 *
 * @package WordPress
 * @subpackage Parallax_Pro
 * @since 1.0
 * @version 1.0
 */
global $post;
$post_slug=$post->post_name;
?>
<?php



echo do_shortcode('[ajax_load_more container_type="div" css_classes="entry" post_type="post" posts_per_page="4" post_format="standard" category='. $post_slug .' scroll="false" images_loaded="true" button_label="View More"]');

