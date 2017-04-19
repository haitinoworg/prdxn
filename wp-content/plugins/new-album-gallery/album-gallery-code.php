<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//js
wp_enqueue_script('jquery');
//wp_enqueue_script('awl-jquery-swipebox-js',  AG_PLUGIN_URL .'js/awl-jquery.swipebox.js', array( 'jquery' ), '', true  );
//wp_enqueue_script('awl-jquery-swipebox-min-js',  AG_PLUGIN_URL .'js/awl-jquery.swipebox.min.js', array( 'jquery' ), '', true  );

//css
//wp_enqueue_style('awl-swipebox-css', AG_PLUGIN_URL .'css/awl-swipebox.css');
wp_enqueue_style('awl-animate-css', AG_PLUGIN_URL .'css/awl-animate.css');
wp_enqueue_style('awl-swipebox-min-css', AG_PLUGIN_URL .'css/awl-swipebox.min.css');
wp_enqueue_style('awl-hover-stack-style-css', AG_PLUGIN_URL .'css/awl-hover-stack-style.css');
wp_enqueue_style('awl-hover-overlay-effects-css', AG_PLUGIN_URL .'css/awl-hover-overlay-effects.css');
wp_enqueue_style('awl-hover-overlay-effects-style-css', AG_PLUGIN_URL .'css/awl-hover-overlay-effects-style.css');
 
$album_gallery_id = $post_id['id'];
 
$all_albums = array(  'p' => $album_gallery_id, 'post_type' => 'album_gallery', 'orderby' => 'ASC');
$loop = new WP_Query( $all_albums );

while ( $loop->have_posts() ) : $loop->the_post();

	$post_id = get_the_ID();
	$album_gallery_settings = unserialize(base64_decode(get_post_meta( $post_id, 'awl_ag_settings_'.$post_id, true)));
	$album_gallery_column_settings = unserialize(base64_decode(get_option('album_gallery_column_settings')));
	//main settings
	$column_settings = $album_gallery_settings['column_settings'];
	$loop_lightbox = $album_gallery_settings['loop_lightbox'];
	$hide_bars_delay = $album_gallery_settings['hide_bars_delay'];
	$hide_close_btn_mobile = $album_gallery_settings['hide_close_btn_mobile'];
	$remove_bars_mobile = $album_gallery_settings['remove_bars_mobile'];
	$animations = $album_gallery_settings['animations'];
	$hover_effects = $album_gallery_settings['hover_effects'];
	
	//columns settings
	$col_large_desktops = $album_gallery_column_settings['col_large_desktops'];
	$col_desktops = $album_gallery_column_settings['col_desktops'];
	$col_tablets = $album_gallery_column_settings['col_tablets'];
	$col_phones = $album_gallery_column_settings['col_phones'];
	
	// start the Media Slider contents
	?>
	<div id="album_gallery_<?php echo $album_gallery_id; ?>">
		<?php
			if(isset($album_gallery_settings['image-slide-ids']) && count($album_gallery_settings['image-slide-ids']) > 0) {
				$count = 0;
				foreach($album_gallery_settings['image-slide-ids'] as $attachment_id) {
					$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
					$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
					$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
					$large = wp_get_attachment_image_src($attachment_id, 'large', true);
					$full = wp_get_attachment_image_src($attachment_id, 'full', true);
					$attachment_details = get_post( $attachment_id );
					$title = $attachment_details->post_title;
					$slide_type =  $album_gallery_settings['image-slide-type'][$count];
					$slide_link =  $album_gallery_settings['image-slide-link'][$count];
					?>
					<div class="<?php echo $col_large_desktops; ?> <?php echo $col_desktops; ?> <?php echo $col_tablets; ?> <?php echo $col_phones; ?> <?php if($count > 0) { echo "hidden"; }?>">
						<?php if($hover_effects == "none") { ?>
							<!-- None Effect -->
							<a href="<?php if($slide_type == "i") { echo $full[0]; } else if($slide_type == "v") { echo $slide_link; } ?>" class="swipebox-<?php echo $album_gallery_id; ?>" title="<?php echo $title; ?>">
								<img src="<?php echo $medium[0]; ?>" class=" animated <?php echo $animations; ?>">
							</a>
						<?php } else if($hover_effects == "stacks") { ?>
							<!-- Stacks Hover Effect -->
							<a href="<?php if($slide_type == "i") { echo $full[0]; } else if($slide_type == "v") { echo $slide_link; } ?>" class="swipebox-<?php echo $album_gallery_id; ?>" title="<?php echo $title; ?>">
								<div class="group">
									<div class="stack twisted animated <?php echo $animations; ?>">
										<img src="<?php echo $medium[0]; ?>">
									</div>
								</div>
							</a>
						<?php } else if($hover_effects == "overlay") { ?>
							<!-- Overlay Hover Effect -->
							<a class="swipebox-<?php echo $album_gallery_id; ?>" href="<?php if($slide_type == "i") { echo $full[0]; } else if($slide_type == "v") { echo $slide_link; } ?>" title="<?php echo $title; ?>">
								<div class="view fifth-effect animated <?php echo $animations; ?>">
									<img src="<?php echo $medium[0]; ?>">
									<div class="mask"></div>
								</div>
							</a>
						<?php } ?>
					</div>
					<?php
					$count++;
				}// end of attachment foreach
			} else {
				_e('Sorry! No media slider found ', AGP_TXTDM);
				echo ": [AGAL id=$post_id]";
			} // end of if else of slides available check into slider
		?>		
	</div>	
	<?php
	endwhile;
	?>
<style>
<?php if($col_large_desktops == "col-lg-3") { ?> .stack { height : 100px; } <?php } ?>
<?php if($col_large_desktops == "col-lg-2") { ?> .fifth-effect .mask { border:45px solid rgba(0,0,0,0.7); } <?php } else if($col_large_desktops == "col-lg-3") { ?> .fifth-effect .mask { border:85px solid rgba(0,0,0,0.7); } <?php } else { ?> .fifth-effect .mask { border:100px solid rgba(0,0,0,0.7); } <?php }?>
.col-lg-12 .stack { margin: 3% 36%; } .col-lg-12 .view { margin: 5% 37%; }
.col-lg-6  .stack { margin: 6% 22%; } .col-lg-6  .view { margin: 5% 22%; } 
.col-lg-4  .stack { margin: 10% 7%; } .col-lg-4  .view { margin: 5% 6%; } 
.col-lg-3  .stack { margin: 15% 3%; } .col-lg-3  .view { margin: 5% 1%; }

.col-md-12 .stack {  }

.col-sm-12 .stack { margin: 3% 35%; }

.col-xs-12 .stack { margin: 5% 31%; }

<?php if($col_desktops == "col-md-2") { ?> .fifth-effect .mask { border:45px solid rgba(0,0,0,0.7); } <?php } else if($col_desktops == "col-md-3") { ?> .fifth-effect .mask { border:85px solid rgba(0,0,0,0.7); } <?php } else { ?> .fifth-effect .mask { border:100px solid rgba(0,0,0,0.7); } <?php }?>
<?php if($col_desktops == "col-xs-12") { ?> .fifth-effect .mask { border:45px solid rgba(0,0,0,0.7); } <?php } else if($col_desktops == "col-xs-12") { ?> .fifth-effect .mask { border:85px solid rgba(0,0,0,0.7); } <?php } else { ?> .fifth-effect .mask { border:100px solid rgba(0,0,0,0.7); } <?php }?>
.view {	 
	<?php if($col_desktops == "col-md-12") { ?> margin: 0 0 5% 0%; <?php } 
	 else if($col_desktops == "col-md-6") { ?> margin: 0 0 5% 10%; <?php } 
	 else if($col_desktops == "col-md-4") { ?> margin: 0 0 5% 0%; <?php } 
	 else if($col_desktops == "col-md-3") { ?> margin: 0 0 5% 0%; <?php } ?>
		
	 <?php if($col_tablets == "col-sm-12") { ?> margin: 5% 33%; <?php } 
	 else if($col_tablets == "col-sm-6") { ?> margin: 5% 15%; <?php } 
	 else if($col_tablets == "col-sm-4") { ?> margin: 5% 0%; <?php } 
	 else if($col_tablets == "col-sm-3") { ?> margin: 5% 0%; <?php } ?>
}

.mask {
	cursor : pointer;
}
</style>
<script src="<?php echo AG_PLUGIN_URL ?>js/awl-jquery.swipebox.min.js"></script>
<script type="application/javascript">
//Code
;( function( jQuery ) { 

	jQuery( '.swipebox-<?php echo $album_gallery_id; ?>' ).swipebox( {
		loopAtEnd: <?php echo $loop_lightbox; ?>, // true will return to the first image after the last image is reached	
		hideBarsDelay : <?php echo $hide_bars_delay; ?>, // delay before hiding bars on desktop
		hideCloseButtonOnMobile : <?php echo $hide_close_btn_mobile; ?>, // true will hide the close button on mobile devices
		removeBarsOnMobile : <?php echo $remove_bars_mobile; ?>, // false will show top bar on mobile devices
	});

} )( jQuery );
</script>