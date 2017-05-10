<?php
// Shortcode output
do_action( 'direct_stripe_before_form' );
//Chrome for iOS hack to disable custom button styles and get Stripe modal forme to open
if ( strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== false) {
	$crios = 'crios';
} else {
	$crios = 'false';
}
if ( $crios === 'crios' ) { ?>
<style type=text/css>
	.stripe-button-el {
		visibility:visible !important;
		display: inline-block !important;
	}
</style>
<?php } ?>
<!-- pass in the $params array and the URL -->
<form action="https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" id="stripeForm" value="submit" method="POST" >
	

		<?php //Donation condition and input
		if(  isset($directStripeAttrValues['type']) && $directStripeAttrValues['type'] === 'donation' ) { ?>
		<div class="donation-box">
			<span>$</span>
			<input type="text" name="donationvalue" id="donationvalue" value="60" required />
			<span>USD</span>
		</div>
		<?php } ?>
		<script class="stripe-button" src="https://checkout.stripe.com/checkout.js"
		<?php if( isset($d_stripe_general['direct_stripe_checkbox_api_keys']) && $d_stripe_general['direct_stripe_checkbox_api_keys'] === '1' ) { ?>
		data-key="<?php echo esc_attr($d_stripe_general['direct_stripe_test_publishable_api_key']); ?>"
		<?php } else { ?>
		data-key="<?php echo esc_attr($d_stripe_general['direct_stripe_publishable_api_key']); ?>"
		<?php } ?>
		<?php if (is_user_logged_in()) {
			$user = wp_get_current_user(); ?>
			data-email="<?php echo esc_attr($user->user_email); ?>"
			<?php } ?>
			data-image="<?php echo esc_url($d_stripe_general['direct_stripe_logo_image']); ?>"
			data-name="<?php echo esc_attr($directStripeAttrValues['name']) ?>"
			data-description="<?php echo esc_attr($directStripeAttrValues['description']); ?>"
			data-label="<?php echo esc_attr($directStripeAttrValues['label']); ?>"
			data-panel-label="<?php echo esc_attr($directStripeAttrValues['panellabel']); ?>"
			data-locale="<?php echo esc_attr($directStripeAttrValues['locale']) ?>"
			data-currency="<?php if( $directStripeAttrValues['currency'] != 'false' ) {
				echo esc_attr($directStripeAttrValues['currency']);
			} else {
				echo esc_attr($d_stripe_general['direct_stripe_currency']);
			} ?>"
			<?php if( $directStripeAttrValues['display_amount'] != 'false' ) { ?>
			data-amount="<?php echo absint($original_amount); ?>"
			<?php } ?>
			<?php if( isset($d_stripe_general['direct_stripe_billing_infos_checkbox']) && $d_stripe_general['direct_stripe_billing_infos_checkbox'] === '1' ) { ?>
			data-address="true"
			<?php } ?>
			<?php do_action( 'direct_stripe_after_data_fields' ); ?>
			>
		</script>
		<?php do_action( 'direct_stripe_after_script_tag' ); ?>
		<?php //Custom styles button condition
		if( isset($d_stripe_styles['direct_stripe_use_custom_styles']) && $d_stripe_styles['direct_stripe_use_custom_styles'] === '1' && $crios != 'crios' ) { ?>
		<button id="directStripe" class="direct-stripe-button" type="submit" ><?php echo esc_attr($directStripeAttrValues['label']) ?></button>
			<?php //T&C Check box condition
			if( isset($d_stripe_styles['direct_stripe_use_tc_checkbox']) && $d_stripe_styles['direct_stripe_use_tc_checkbox'] === '1' ) { ?>
			<br/><input type="checkbox" class="conditions" id="conditions" required>&nbsp; <?php echo esc_attr($d_stripe_styles['direct_stripe_tc_text']); ?> <a target="_blank" href="<?php echo get_permalink($d_stripe_styles['direct_stripe_tc_link']); ?>"><?php  echo $d_stripe_styles['direct_stripe_tc_link_text']; ?></a><br />
			<?php } ?>
			<?php } ?>
			
			<input type="hidden" id="sf_oid" class="w2linput hidden" name="oid" value="00D7F0000002Vh5">		
			<input type="hidden" id="sf_retURL" class="w2linput hidden" name="retURL" value="http://localhost/ayiti2/">		
			<input type="hidden" id="sf_debug" class="w2linput hidden" name="debug" value="1">		
			<input type="hidden" id="sf_debugEmail" class="w2linput hidden" name="debugEmail" value="pravin.chukkala.prdxn@gmail.com">	
			<input type="hidden" name="form_id" class="w2linput" value="6">	

		</form>
		<?php do_action( 'direct_stripe_after_form' ); ?>