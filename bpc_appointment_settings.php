<?php
if(!session_id()) {
	session_start();
}
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
add_shortcode("bpc_as_calendar_google_apple", "bpc_as_calendar_google_apple_func");
add_shortcode("bpc_as_google_calendar_settings", "bpc_as_google_calendar_settings_func");
add_action("admin_menu", "bpc_as_admin_menu");



require_once('includes/helper.php');
require_once ('includes/db/Bpc_As_Calendar.php');
use App\Bpc_As_Calendar;




function bpc_as_admin_menu()
{

    add_menu_page('BPC Appointment Settings', 'BPC Appointment Settings', 'manage_options', "pbc-as-admin", 'bpc_as_admin'); 
}
function bpc_as_admin () { 
 	?> 
 		<br><br><br>
		1. Add short code post or page <b>[bpc_as_opening_hours]</b> in order to display the partner schedule calendar<br>
		1. Add short code post or page <b>[bpc_as_calendar_google_apple]</b> in order to display partner calendar from google or apple calendar<br>
		1. Add short code post or page <b>[bpc_as_google_calendar_settings]</b> google calendar settings<br>
 	<?php
}
function bpc_as_opening_hours_func() 
{	  
	ob_start();  
	print "<input type='hidden' value='". get_site_url() ."' id='bpc_as_rool_url' />"; 
	print "<div onload='bpc_init()'>";  
		$book_exact_time = 'checked';
		$book_exact_day = ''; 
			bpc_as_header();
			//	require_once('includes/initialized-data.php');
			echo "<form method='POST' id='testform' >";
			require_once('includes/pages/date-picker.php');
			// require_once('includes/pages/dashboard-settings-options-type-schedule.php'); 
				print "<div id='bpc-as-schedule-settings-content-and-type'>"; 
					//	require_once('includes/pages/dashboard-time-settings.php');
					//	require_once('includes/pages/dashboard-day-settings.php');
					// require_once('includes/pages/dashboard-settings-options.php');
				print "</div>";
			echo "</form>"; 
		require_once('includes/pages/dashboard-settings-options-save.php');  
	print "</div>"; 
 	ob_flush();  

}
function bpc_as_install_table()
{
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'bpc_appointment_settings';
	
	$charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name   (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        partner_id bigint(20) NOT NULL,  	
        open_from varchar(50) NOT NULL,  
        open_to varchar(50) NOT NULL,  
		call_back_length varchar(50) NOT NULL,
		call_back_delay varchar(50) NOT NULL,
		morning varchar(50) NOT NULL,
		afternoon varchar(50) NOT NULL,
		evening varchar(50) NOT NULL,
		close varchar(50) NOT NULL,
		book_time_type varchar(50) NOT NULL,
		day varchar(50) NOT NULL,
		date varchar(50) NOT NULL, 
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;"; 

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
	//when install also add talble
}
function bpc_as_calendar_google_apple_func()
{

 

	ob_start();

	require_once __DIR__.'/includes/api/google-api/vendor/autoload.php';
	require_once __DIR__.'/includes/api/google-api/helper.php';





	print "<pre>";
	print_r($_SESSION);
	print "</pre>";

	// google calendar connect
	$client = new Google_Client();
	$client->setAuthConfig( __DIR__ . '/includes/api/google-api/client_secret.json');
	$client->addScope(Google_Service_Calendar::CALENDAR);
	$bpc_As_Calendar = new Bpc_As_Calendar();


	// set if not empty, meaning its already authenticated
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
		// allow try ang catch functions
		try {
			$client->setAccessToken($_SESSION['access_token']);
			$service = new Google_Service_Calendar($client);
			// Print the next 10 events on the user's calendar.
			$calendarId = 'primary';
			$optParams = array(
					'maxResults' => 100,
					'orderBy' => 'startTime',
					'singleEvents' => TRUE,
					'timeMin' => date("c", strtotime($bpc_As_Calendar->getCurrentDate()))
					// 'timeMax' => '2017-03-28T23:59:59-04:00'
			);
			$results = $service->events->listEvents($calendarId, $optParams);
			if (count($results->getItems()) == 0) {
				print "No upcoming events found.\n";
			} else {
				print "Upcoming events:\n";
				foreach ($results->getItems() as $index => $event) {


					$bpc_As_Calendar->setEventResult([
							'event'=>$event,
							'summary'=>$event->getSummary(),
					]);

					print "<br>";
//					$eventDate = $bpc_As_Calendar->getEventDate($bpc_As_Calendar->getDateTimeStart());
//					$description = $bpc_As_Calendar->getDescription();
//					print "<br> description: $description date: $eventDate";


					// print " start time " . $event->start->dateTime;
					print $index  . ' .) description ' .  $bpc_As_Calendar->getDescription() . " date " . $bpc_As_Calendar->getEventDate() . ' time from ' . $bpc_As_Calendar->getEventTimeStart() . ' time to ' . $bpc_As_Calendar->getEventTimeEnd();
					//					print "<br>";
					// print_r_pre_exit($event);




				}
			}
		}catch (Exception $e){
			print "<br> Error " . $e->getMessage();
			$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php';
			bpc_as_redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
	} else {
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php';
		//bpc_as_redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
		print "
			<a href='".$redirect_uri."'>
				<input type='text' value='Sync with google calendar' >
			</a>
		";

	}


	ob_flush();
}
function bpc_as_google_calendar_settings_func()
{
	?>
		<h1>This is the google calendar settings</h1>
	<?php
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
	
		<style type="text/css" media="screen">
			#page-content {
				width: 0px !important;
			}

		</style>

	<?php
}
