<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * video Gallery Premium Shortcode
 */
add_shortcode('AGAL', 'awl_album_gallery_shortcode');
function awl_album_gallery_shortcode($post_id) {
	wp_enqueue_style('awl-ms-bootstrap-css', AG_PLUGIN_URL .'css/bootstrap.css');
	ob_start();
	
	//output code file
	require("album-gallery-code.php");
	
	return ob_get_clean();
}
?>