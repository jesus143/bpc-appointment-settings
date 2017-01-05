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
{	ob_start();
		bpc_as_header();
		require_once('includes/helper.php');
		require_once('includes/initialized-data.php');
		echo "<form method='POST' id='testform' >";
		require_once('includes/pages/date-picker.php');
		require_once('includes/pages/dashboard-settings-options-type-schedule.php');
		print "<div id='bpc-as-schedule-settings-content'>";
			require_once('includes/pages/dashboard-time-settings.php');
			//	require_once('includes/pages/dashboard-day-settings.php');
			require_once('includes/pages/dashboard-settings-options.php');
		print "</div>";
		require_once('includes/pages/dashboard-settings-options-save.php');
		echo "</form>";
 	ob_flush(); 
}
function bpc_as_install_table()
{
	//when install also add talble
}

function bpc_as_header()
{	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php print bpc_as_plugin_url; ?>/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print bpc_as_plugin_url; ?>/assets/css/bootstrap-select.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print bpc_as_plugin_url; ?>/assets/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print bpc_as_plugin_url; ?>/assets/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print bpc_as_plugin_url; ?>/assets/css/style.css" />

		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/jquery-3.1.1.min.js"></script>
		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/angular-1.6.1.js"></script>
		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/bootstrap.min.js"></script>
		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/bootstrap-select.min.js"></script>

		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/my_js.js"></script>
		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/my_jquery.js"></script>
		<script src="<?php print bpc_as_plugin_url; ?>/assets/js/my_angular.js"></script>
	<?php
}