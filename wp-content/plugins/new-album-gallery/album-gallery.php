<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
@package New Album Gallery
Plugin Name: New Album Gallery
Plugin URI: http://awplife.com/
Description: A Newly Amazing Different Most Powerful Responsive Easy To Use Album Gallery Plugin For WordPress
Version: 0.0.1
Author: A WP Life
Author URI: http://awplife.com/
Text Domain: AGP_TXTDM
Domain Path: /languages
*/

if ( ! class_exists ( 'Awl_Album_Gallery' ) ) {
	
	class Awl_Album_Gallery {
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}
		
		protected function _constants() {
			
			//Plugin Version
			define( 'AG_PLUGIN_VER', '0.0.1' );
			
			//Plugin Text Domain
			define("AGP_TXTDM","Awl_Album_Gallery");
			
			//Plugin Name
			define( 'AG_PLUGIN_NAME', __( 'Album Gallery', AGP_TXTDM ) );
			
			//Plugin Slug
			define( 'AG_PLUGIN_SLUG', 'album_gallery');
			
			//Plugin Directory Path
			define( 'AG_PLUGIN_DIR', plugin_dir_path(__FILE__) );
			
			//Plugin Driectory URL
			define( 'AG_PLUGIN_URL', plugin_dir_url(__FILE__) );
			
			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'AGP_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		/**
		 * Setup the default filters and actions
		 */
		protected function _hooks() {
			
			//Load Text Domain
			add_action( 'plugins_loaded', array( $this , '_load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, 'ag_gallery_menu' ), 101 );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, 'ag_gallery_menu_docs' ), 101 );
			
			//Create Album Gallery Custom Post
			add_action( 'init', array( $this, '_Album_Gallery') );
			
			//Add Meta Box To Custom Post
			add_action( 'add_meta_boxes', array( $this, '_ag_admin_add_meta_box') );
			
			add_action( 'wp_ajax_album_gallery_js', array(&$this, 'ajax_album_gallery') );
			
			add_action( 'save_post', array( &$this, '_ag_save_settings') );
			
			//Shortcode Compatibility in Text Widegts
			add_filter( 'widget_text', 'do_shortcode');
			
		} // end of hook function
		
		public function _load_textdomain() {
			load_plugin_textdomain( AGP_TXTDM, false, dirname( plugin_basename(__FILE__) ) .'/languages' );			
		}
		
		/* Add Gallery menu*/
		public function ag_gallery_menu() {
			$help_menu = add_submenu_page( 'edit.php?post_type='.AG_PLUGIN_SLUG, __( 'Column Settings', 'AGP_TXTDM' ), __( 'Column Settings', 'AGP_TXTDM' ), 'administrator', 'ag-column-page', array( $this, '_ag_column_page') );
		}
		/* Add Gallery menu*/
		public function ag_gallery_menu_docs() {
			$help_menu = add_submenu_page( 'edit.php?post_type='.AG_PLUGIN_SLUG, __( 'Docs', 'AGP_TXTDM' ), __( 'Docs', 'AGP_TXTDM' ), 'administrator', 'ag-doc-page', array( $this, '_ag_doc_page') );
		}
		
		/**
		 * Album Gallery Custom Post
		 * Create gallery post type in admin dashboard.
		*/
		public function _Album_Gallery() {
			$labels = array(
				'name'                => _x( 'Album Gallery', 'post type general name', AGP_TXTDM ),
				'singular_name'       => _x( 'Album Gallery', 'post type singular name', AGP_TXTDM ),
				'menu_name'           => __( 'Album Gallery', AGP_TXTDM ),
				'name_admin_bar'      => __( 'Album Gallery', AGP_TXTDM ),
				'parent_item_colon'   => __( 'Parent Item:', AGP_TXTDM ),
				'all_items'           => __( 'All Album Gallery', AGP_TXTDM ),
				'add_new_item'        => __( 'Add Album Gallery', AGP_TXTDM ),
				'add_new'             => __( 'Add Album Gallery', AGP_TXTDM ),
				'new_item'            => __( 'Album Gallery', AGP_TXTDM ),
				'edit_item'           => __( 'Edit Album Gallery', AGP_TXTDM ),
				'update_item'         => __( 'Update Album Gallery', AGP_TXTDM ),
				'search_items'        => __( 'Search Album Gallery', AGP_TXTDM ),
				'not_found'           => __( 'Album Gallery Not found', AGP_TXTDM ),
				'not_found_in_trash'  => __( 'Album Gallery Not found in Trash', AGP_TXTDM ),
			);

			$args = array(
				'label'               => __( 'Album Gallery', AGP_TXTDM ),
				'description'         => __( 'Custom Post Type For Album Gallery', AGP_TXTDM ),
				'labels'              => $labels,
				'supports'            => array( 'title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-images-alt',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);

			register_post_type( 'album_gallery', $args );
		}//end of post type function
		
		/**
		 * Adds Meta Boxes
		*/
		public function _ag_admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( '', __('Add Images', AGP_TXTDM), array(&$this, 'ag_upload_multiple_images'), 'album_gallery', 'normal', 'default' );
		}
		
		public function ag_upload_multiple_images($post) {
				wp_enqueue_script('jquery');
				wp_enqueue_script('media-upload');				
				wp_enqueue_script('awl-ag-uploader.js', AG_PLUGIN_URL . 'js/awl-ag-uploader.js', array('jquery'));
				wp_enqueue_style('awl-ag-uploader-css', AG_PLUGIN_URL . 'css/awl-ag-uploader.css');
				wp_enqueue_media();	

				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'awl-lg-color-picker-js', plugins_url('js/lg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
				
				?>
				<div id="album-gallery">
					<input type="button" id="remove-all-image-slides" name="remove-all-image-slides" class="button button-large remove-all-image-slides" rel="" value="<?php _e('Delete All Images', AGP_TXTDM); ?>">
					<ul id="remove-image-slides" class="imagebox">
					<?php
					$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_ag_settings_'.$post->ID, true)));
					if(isset($allimagesetting['image-slide-ids'])) {
						$count = 0;
					foreach($allimagesetting['image-slide-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						$slide_link =  $allimagesetting['image-slide-link'][$count];
						$slide_type =  $allimagesetting['image-slide-type'][$count];
						?>
						<li class="image-slide">
							<img class="new-image-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="image-slide-ids[]" name="image-slide-ids[]" value="<?php echo $id; ?>" />
							<select id="image-slide-type[]" name="image-slide-type[]" class="form-control selectbox_position_newslide" value="<?php echo $slide_type; ?>" >
								<option value="i" <?php if($slide_type == "i") echo "selected=selected"; ?>>Image</option>
								<option value="v" <?php if($slide_type == "v") echo "selected=selected"; ?>>Video</option>
							</select>
							<!-- Image Title-->
							<input type="text" name="image-slide-title[]" id="image-slide-title[]" class="input_box_newslide" placeholder="Title Here" value="<?php echo get_the_title($id); ?>">
							<input type="text" name="image-slide-link[]" id="image-slide-link[]" class="input_box_newslide" placeholder="Enter URL / ID" value="<?php echo $slide_link; ?>">
							<input type="button" name="remove-image-slide" id="remove-image-slide" class="button remove-single-image-slide button-danger" style="width: 100%;" value="Delete">
						</li>
					<?php $count++; } // end of foreach
					} //end of if
					?>
					</ul>
				</div>
				<style>
				.selectbox_position_newslide {
					border-width: 1px 1px 1px 6px !important;
					border-color: #32CC24 !important;
					width: 100% !important; 
					margin-bottom : 3px;
					margin-left: 4px;
					margin-top: 3px;
				}
				.input_box_newslide {
					border-width: 2px 2px 2px 2px !important;
					border-color: #32CC24 !important;
					width: 100% !important;
					border-radius : 5px;
					margin-bottom : 3px;
					margin-left: 4px;					
				}
				</style>
				
				<!--Add New Image Button-->
				<div name="add-new-image-slides" id="add-new-image-slides" class="new-image-slide" style="height: 200px; width: 220px; border-radius: 20px;">
					<img class="dashicons" src="<?php echo AG_PLUGIN_URL ?>/css/new-slide.png" height="100px" width="100px;"/>
					<div class="add-text"><?php _e('Image / Poster', 'AGP_TXTDM'); ?></div>
				</div><br><br>
				<div style="clear:left;"></div>
				<br>
				<h1 style="font-family:Geneva; margin-bottom:-10px;"><?php _e('Copy Album Gallery Shortcode', AGP_TXTDM); ?></h1>
				<hr>
				<p class="input-text-wrap">
					<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your album gallery on your site.', AGP_TXTDM); ?><br></p>
					<input type="text" name="shortcode" id="shortcode" value="<?php echo "[AGAL id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" onmouseover="return pulseOff();" onmouseout="return pulseStart();">
				</p>
				<br>
				<hr>				
				<br>
				<h1 class="text-center" style="font-family:Geneva;"><?php _e('ALBUM &nbsp; GALLERY &nbsp; SETTINGS', AGP_TXTDM); ?></h1>
				<hr>
				<?php
				require_once('album-gallery-settings.php');
		}
		
		public function _ag_ajax_callback_function($id) {
			//wp_get_attachment_image_src ( int $attachment_id, string|array $size = 'thumbnail', bool $icon = false )
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			$description = $attachment->post_content; // desc
			?>
			<li class="image-slide">
				<img class="new-image-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="image-slide-ids[]" name="image-slide-ids[]" value="<?php echo $id; ?>" />
				<select id="image-slide-type[]" name="image-slide-type[]" class="form-control" style="width: 100%;" value="<?php echo $slide_type; ?>" >
					<option value="i" <?php if($slide_type == "i") echo "selected=selected"; ?>>Image</option>
					<option value="v" <?php if($slide_type == "v") echo "selected=selected"; ?>>Video</option>
				</select>
				<!-- Image Title-->
				<input type="text" name="image-slide-title[]" id="image-slide-title[]" style="width: 100%;" placeholder="Title Here" value="<?php echo get_the_title($id); ?>">
				<input type="text" name="image-slide-link[]" id="image-slide-link[]" style="width: 100%;" placeholder="Enter URL / ID" value="<?php echo $slide_link; ?>">
				<input type="button" name="remove-image-slide" id="remove-image-slide" style="width: 100%;" class="button" value="Delete">
			</li>
			<?php
		}
		
		public function ajax_album_gallery() {
			echo $this->_ag_ajax_callback_function($_POST['slideId']);
			die;
		}
		
		public function _ag_save_settings($post_id) {
			if(isset($_POST['ag_save_nonce'])) {
				if ( !isset( $_POST['ag_save_nonce'] ) || !wp_verify_nonce( $_POST['ag_save_nonce'], 'ag_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
				$image_ids = sanitize_text_field($_POST['image-slide-ids']);
				$image_titles = sanitize_text_field($_POST['image-slide-title']);
				$image_types = sanitize_text_field($_POST['image-slide-type']);
				$i = 0;
				foreach($image_ids as $image_id) {
					$single_image_update = array(
						'ID'           => $image_id,
						'post_title'   => $image_titles[$i],
					);
					wp_update_post( $single_image_update );
					$i++;
					}				
					$awl_album_gallery_shortcode_setting = "awl_ag_settings_".$post_id;
					update_post_meta($post_id, $awl_album_gallery_shortcode_setting, base64_encode(serialize($_POST)));
				}
			}
		}// end save setting
		
		public function _ag_column_page() {
			require_once('album-gallery-column-layout.php');
		}
		
		public function _ag_doc_page() {
			require_once('docs.php');
		}
	}// end of class
	
	$ag_gallery_object = new Awl_Album_Gallery();
	require_once('shortcode.php');
}
?>
