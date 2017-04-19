<?Php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//load settings
$album_gallery_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_ag_settings_'.$post->ID, true)));
//print_r($album_gallery_settings);
$album_gallery_id = $post->ID;

//js
wp_enqueue_script('awl-ag-bootstrap-js',  AG_PLUGIN_URL .'js/bootstrap.js', array( 'jquery' ), '', true  );
wp_enqueue_script('awl-ag-go-to-top-js',  AG_PLUGIN_URL .'js/go-to-top.js', array( 'jquery' ), '', true  );
//css
wp_enqueue_style('awl-styles-css', AG_PLUGIN_URL .'css/styles.css' );
wp_enqueue_style('awl-animate-css', AG_PLUGIN_URL .'css/animate.css' );
wp_enqueue_style('awl-bootstrap-css', AG_PLUGIN_URL .'css/bootstrap.css' );
wp_enqueue_style('awl-go-to-top-css', AG_PLUGIN_URL .'css/go-to-top.css' );
wp_enqueue_style('awl-toogle-button-css', AG_PLUGIN_URL .'css/toogle-button.css' );
wp_enqueue_style('awl-font-awesome-min-css', AG_PLUGIN_URL .'css/font-awesome.min.css' );

?>
<style>
.setting-toggle-div {
	background-color: #FFFFFF;
	padding: 10px;
	margin-bottom: 15px;
	border: 2px solid #CCCCCC;
	border-radius: 3px;
}

.gallery-settings, .hover_stack_effect_settings, .hover_overlay_effect_settings {
	padding: 8px 0px 8px 8px !important;
	margin: 10px 10px 5px 0px !important;
}

.gallery-settings label {
	font-size: 13px !important;
	font-weight: bold;
}

.ag_comment_settings {
	font-size: 16px !important;
	font-family:Geneva;
	padding-left: 4px;
	font: initial;
	margin-top: 5px;
	padding-left:14px;
}

.ag-lower-title {
	background-color: #F4F0EF;
    color: #23282d;
    font-family: icon;
    font-size: 20px;
    font-weight: 500;
    margin-left: 10px;
    padding-left: 10px;
}

.selectbox_position {
	margin-left: 18px !important;
	border-width: 1px 1px 1px 6px !important;
	border-color: #32CC24 !important;
	width: 30% !important; 
}

.wp-color-result {
	height: auto;
	margin: 6px 6px 6px 15px;
}
.wp-picker-container input.wp-color-picker[type="text"] {
	width: 80px !important;
	height: 22px !important;
	float: left;
	font-size: 11px !important;
	margin: 8px 0px 6px 0px
}
.iris-border .iris-palette-container {
	bottom: 6px;
}
.wp-core-ui .button, .wp-core-ui .button.button-large, .wp-core-ui .button.button-small, a.preview, input#publish, input#save-post {
	height: auto !important;
	padding: 0 12px !important;
	margin: 6px;
}
</style>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<p class="gallery-settings">
	<p class="ms-title"><?php _e('1. Loop', AGP_TXTDM); ?></p></br>
	<p class="switch-field em_size_field">
		<?php if(isset($album_gallery_settings['loop_lightbox'])) $loop_lightbox = $album_gallery_settings['loop_lightbox']; else $loop_lightbox = "false"; ?>
		<input type="radio" class="form-control" id="loop_lightbox1" name="loop_lightbox" value="true" <?php if($loop_lightbox == "true") echo "checked" ; ?>>
			<label for="loop_lightbox1"><?php _e('Yes', AGP_TXTDM); ?></label>
		<input type="radio" class="form-control" id="loop_lightbox2" name="loop_lightbox" value="false" <?php if($loop_lightbox == "false") echo "checked" ; ?>> 
			<label for="loop_lightbox2"><?php _e('No', AGP_TXTDM); ?></label></br></br></br>					
		<p class="ag_comment_settings"><?php _e('Select if the album gallery is loopable.', AGP_TXTDM); ?></p>
	</p>
</p>

<p class="gallery-settings range-slider">
	<p class="ms-title"><?php _e('2. Hide Bars Delay', AGP_TXTDM); ?></p></br>
	<?php if(isset($album_gallery_settings['hide_bars_delay'])) $hide_bars_delay = $album_gallery_settings['hide_bars_delay']; else $hide_bars_delay = 3000; ?>	
	<input type="range" class="range-slider__range" id="hide_bars_delay" name="hide_bars_delay" value="<?php echo $hide_bars_delay; ?>" min="500" max="10000" step="100" style="width: 300px !important; margin-left: 10px;">
	<span class="range-slider__value">3000</span></br></br></br>
	<p class="ag_comment_settings"><?php _e('Sets the hide bars Delay time in seconds.', AGP_TXTDM); ?></p>
</p>

<p class="gallery-settings">
	<p class="ms-title"><?php _e('3. Hide Close Button On Mobile', AGP_TXTDM); ?></p></br>
	<p class="switch-field em_size_field">
		<?php if(isset($album_gallery_settings['hide_close_btn_mobile'])) $hide_close_btn_mobile = $album_gallery_settings['hide_close_btn_mobile']; else $hide_close_btn_mobile = "false"; ?>
		<input type="radio" class="form-control" id="hide_close_btn_mobile1" name="hide_close_btn_mobile" value="true" <?php if($hide_close_btn_mobile == "true") echo "checked" ; ?>>
			<label for="hide_close_btn_mobile1"><?php _e('Hide', AGP_TXTDM); ?></label>
		<input type="radio" class="form-control" id="hide_close_btn_mobile2" name="hide_close_btn_mobile" value="false" <?php if($hide_close_btn_mobile == "false") echo "checked" ; ?>> 
			<label for="hide_close_btn_mobile2"><?php _e('Show', AGP_TXTDM); ?></label></br></br></br>					
		<p class="ag_comment_settings"><?php _e('Select if the Close Button is displayed on mobile.', AGP_TXTDM); ?></p>
	</p>
</p>

<p class="gallery-settings">
	<p class="ms-title"><?php _e('4. Remove Bars On Mobile', AGP_TXTDM); ?></p></br>
	<p class="switch-field em_size_field">
		<?php if(isset($album_gallery_settings['remove_bars_mobile'])) $remove_bars_mobile = $album_gallery_settings['remove_bars_mobile']; else $remove_bars_mobile = "true"; ?>
		<input type="radio" class="form-control" id="remove_bars_mobile1" name="remove_bars_mobile" value="true" <?php if($remove_bars_mobile == "true") echo "checked" ; ?>>
			<label for="remove_bars_mobile1"><?php _e('Yes', AGP_TXTDM); ?></label>
		<input type="radio" class="form-control" id="remove_bars_mobile2" name="remove_bars_mobile" value="false" <?php if($remove_bars_mobile == "false") echo "checked" ; ?>> 
			<label for="remove_bars_mobile2"><?php _e('No', AGP_TXTDM); ?></label></br></br></br>					
		<p class="ag_comment_settings"><?php _e('Select if the gallery bars are displayed on mobile.', AGP_TXTDM); ?></p>
	</p>
</p>

<p class="gallery-settings">
	<p class="ms-title"><?php _e('5. Animation', AGP_TXTDM); ?></p></br>
	<?php if(isset($album_gallery_settings['animations'])) $animations = $album_gallery_settings['animations']; else $animations = "wobble"; ?>
	<select id="animations" name="animations" class="selectbox_position">
		<option value="none" <?php if($animations == "none") echo "selected=selected"; ?>>Wobble</option>
		<option value="wobble" <?php if($animations == "wobble") echo "selected=selected"; ?>>Wobble</option>
		<option value="bounce" <?php if($animations == "bounce") echo "selected=selected"; ?>>Bounce</option>
		<option value="flash" <?php if($animations == "flash") echo "selected=selected"; ?>>Flash</option>
		<option value="jello" <?php if($animations == "jello") echo "selected=selected"; ?>>Jello</option>
		<option value="pulse" <?php if($animations == "pulse") echo "selected=selected"; ?>>Pulse</option>
		<option value="rubberBand" <?php if($animations == "rubberBand") echo "selected=selected"; ?>>Rubber Band</option>
		<option value="shake" <?php if($animations == "shake") echo "selected=selected"; ?>>Shake</option>
		<option value="tada" <?php if($animations == "tada") echo "selected=selected"; ?>>Tada</option>
		<option value="swing" <?php if($animations == "swing") echo "selected=selected"; ?>>Swing</option>
		<option value="rollIn" <?php if($animations == "rollIn") echo "selected=selected"; ?>>Roll In</option>
	</select></br></br>
	<p class="ag_comment_settings"><?php _e('Select to apply animation on gallery.', AGP_TXTDM); ?></p>
</p>

<p class="gallery-settings">
	<p class="ms-title"><?php _e('6. Hover Effects', AGP_TXTDM); ?></p></br>
	<p class="switch-field em_size_field">
		<?php if(isset($album_gallery_settings['hover_effects'])) $hover_effects = $album_gallery_settings['hover_effects']; else $hover_effects = "none"; ?>
		<input type="radio" class="form-control" id="hover_effects1" name="hover_effects" value="stacks" <?php if($hover_effects == "stacks") echo "checked" ; ?>>
			<label for="hover_effects1"><?php _e('Stacks', AGP_TXTDM); ?></label>
		<input type="radio" class="form-control" id="hover_effects2" name="hover_effects" value="none" <?php if($hover_effects == "none") echo "checked" ; ?>> 
			<label for="hover_effects2"><?php _e('None', AGP_TXTDM); ?></label>
		<input type="radio" class="form-control" id="hover_effects3" name="hover_effects" value="overlay" <?php if($hover_effects == "overlay") echo "checked" ; ?>> 
			<label for="hover_effects3"><?php _e('Overlay', AGP_TXTDM); ?></label></br></br></br>
		<p class="ag_comment_settings"><?php _e('Select the hover effect to apply.', AGP_TXTDM); ?></p>
	</p>
</p>

<hr>
<?php
	// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
	wp_nonce_field( 'ag_save_settings', 'ag_save_nonce' );
?>

<script>
// start pulse on page load
	function pulseEff() {
	   jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff,1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff,2000);
	}
	
//range slider
	var rangeSlider = function(){
	  var slider = jQuery('.range-slider'),
		  range = jQuery('.range-slider__range'),
		  value = jQuery('.range-slider__value');
		
	  slider.each(function(){

		value.each(function(){
		  var value = jQuery(this).prev().attr('value');
		  jQuery(this).html(value);
		});

		range.on('input', function(){
		  jQuery(this).next(value).html(this.value);
		});
	  });
	};
	rangeSlider();
	
//on load 
var hover_effects = jQuery('input[name="hover_effects"]:checked').val();
var column_settings = jQuery('input[name="column_settings"]:checked').val();
	
	if(column_settings == "true"){
		jQuery('.column_individual_settings').hide();
	}
	if(column_settings == "false"){
		jQuery('.column_individual_settings').show();
	}
	if(hover_effects == "stacks"){
		jQuery('.hover_stack_effect_settings').show();
		jQuery('.hover_overlay_effect_settings').hide();
	}
	if(hover_effects == "none"){
		jQuery('.hover_stack_effect_settings').hide();
		jQuery('.hover_overlay_effect_settings').hide();
	}
	if(hover_effects == "overlay"){
		jQuery('.hover_overlay_effect_settings').show();
		jQuery('.hover_stack_effect_settings').hide();
	}
	
//on change
	jQuery(document).ready(function() {
		jQuery('input[name="column_settings"]').change(function(){
			var column_settings = jQuery('input[name="column_settings"]:checked').val();
			if(column_settings == "true"){
				jQuery('.column_individual_settings').hide();
			}
			if(column_settings == "false"){
				jQuery('.column_individual_settings').show();
			}
		});
		
		jQuery('input[name="hover_effects"]').change(function(){
			var hover_effects = jQuery('input[name="hover_effects"]:checked').val();
			if(hover_effects == "stacks"){
				jQuery('.hover_stack_effect_settings').show();
				jQuery('.hover_overlay_effect_settings').hide();
			}
			if(hover_effects == "none"){
				jQuery('.hover_stack_effect_settings').hide();
				jQuery('.hover_overlay_effect_settings').hide();
			}
			if(hover_effects == "overlay"){
				jQuery('.hover_overlay_effect_settings').show();
				jQuery('.hover_stack_effect_settings').hide();
			}
		});
	});

//color-picker
(function( jQuery ) {
	jQuery(function() {
		// Add Color Picker 
		jQuery('#titlebar_color').wpColorPicker();
		jQuery('#titlebar_font_color').wpColorPicker();
	});
})( jQuery );
jQuery(document).ajaxComplete(function() {
	jQuery('#titlebar_color, #titlebar_font_color').wpColorPicker();
});	
</script>