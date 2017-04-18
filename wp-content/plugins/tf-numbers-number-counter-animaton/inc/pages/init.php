<?php
/*
 Custom dashboard that will be opened on install, or update
*/

class TF_Pages {
 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
 
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() { 
	
		add_action('admin_menu', array( $this,'tf_register_menu') );
		//add_action('load-index.php', array( &$this,'tf_redirect') );
		$active = get_option('tf-activated');
		if( !isset( $active ) || '' === $active ) {
  			add_action( 'activated_plugin', array( $this,'tf_redirect' ) );
  			update_option('tf-activated', 'active');
		}
  		
  		//add_action( 'upgrader_process_complete', 'tf_upgrate_function', 10, 2 );
 
	} // end constructor
 
	
	function tf_register_menu() {
		add_submenu_page( 'edit.php?post_type=tf_stats', 'About', 'About', 'read', 'tf-dashboard', array( $this,'tf_dashboard') );
		add_submenu_page( 'edit.php?post_type=tf_stats', 'Addons', 'Addons', 'read', 'tf-addons', array( $this,'tf_addons') );
	}

	 function tf_redirect() {
	     exit( wp_redirect( admin_url( 'edit.php?post_type=tf_stats&page=tf-dashboard' ) ) );
	 }

	  function tf_upgrate_function( $upgrader_object, $options ) {
	    $current_plugin_path_name = plugin_basename( __FILE__ );

	      if ($options['action'] == 'update' && $options['type'] == 'plugin' ){
	         foreach($options['packages'] as $each_plugin){
	            if ($each_plugin==$current_plugin_path_name){
	                tf_redirect();
	            }
	         }
	      }
	  }
	
	function tf_dashboard() {
		include_once( 'dashboard.php'  );
	}

	function tf_addons() {
		include_once( 'addons.php'  );
	}

}

?>