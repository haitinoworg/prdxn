<?php
/**
 * Two Columns Layout
 *
 *
 * @package WordPress
 * @subpackage Parallax_Pro
 * @since 1.0
 * @version 1.0
 */
global $post;
$post_slug=$post->post_name;

echo do_shortcode('[ajax_load_more container_type="div" post_type="post" posts_per_page="2" category="$post_slug" scroll="false" images_loaded="false" button_label="View More" button_loading_label="load-more-btn"]');




