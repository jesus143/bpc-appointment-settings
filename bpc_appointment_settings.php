<?php  
/**
 * Plugin Name:  BPC Appointment Settings
 * Plugin URI:  
 * Description: This will control the bpc appointment settings
 * Version: 1.0
 * Author: Jesus Erwin Suarez
 * Author URI: 
 * License:  
 */
define('bpc_as_plugin_url', get_site_url() . '/wp-content/plugins/bpc-appointment-settings'); 
register_activation_hook(__FILE__, 'bpc_as_install_table'); 
add_shortcode("bpc_as_opening_hours", "bpc_as_opening_hours_func"); 

function bpc_as_opening_hours_func() 
{ 
	ob_start();    


		require_once('includes/date-picker.php'); 
		require_once('includes/dashboard-settings-options-type-schedule.php'); 
		require_once('includes/dashboard-settings.php');  
		require_once('includes/dashboard-settings-options.php');  
		require_once('includes/dashboard-settings-options-save.php');  

 	ob_flush(); 
} 
function bpc_as_install_table()
{
	//when install also add talble
}