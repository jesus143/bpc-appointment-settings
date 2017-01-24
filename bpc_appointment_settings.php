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

require_once("includes/helper.php");
require_once('includes/db/Bpc_As_Calendar.php');
require_once("includes/db/wpdb_queries.class.php");
require_once("includes/db/bpc_as_db.php");
require_once("includes/db/bpc_appointment_setting_breaks.php");
require_once("includes/db/bpc_user_api.php");

if(bpc_as_is_localhost()) {
	require_once("E:/xampp/htdocs/wp-load.php");
} else {
	require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
}

use App\Bpc_Appointment_Settings_Breaks;
use App\BPC_AS_DB;
use App\Bpc_As_Calendar;
use App\Bpc_User_Api;

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
	bpc_as_calendar_google_apple_authenticate();
	print "<input type='hidden' value='". get_site_url() ."' id='bpc_as_rool_url' />";
	print "<div onload='bpc_init()'>";  
		$book_exact_time = 'checked';
		$book_exact_day = ''; 
			bpc_as_header();
			echo "<form method='POST' id='testform' >";
			require_once('includes/pages/date-picker.php');
				print "<div id='bpc-as-schedule-settings-content-and-type'>";
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

   $sql1 = "CREATE TABLE $table_name   (
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
		updated_at datetime NOT NULL,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

	$table_name = $wpdb->prefix . 'bpc_appointment_setting_breaks';
	$sql2 = "CREATE TABLE $table_name   (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        appointment_setting_id bigint(20) NOT NULL,
        break_from varchar(50) NOT NULL,
      	break_to varchar(50) NOT NULL,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
   
	/**
	 * example input
	 * [access_token] => ya29.GlzZA_oQrsou7xDzCqQuslKTTdE9qqaXvrH1QnLrMEhaWmwoEBSpragLQCnPXqR7uyp1WE_3ScK5lUlGL6skuPTVfjFdtYYtI58aOqQJg5HE4j3y7eqVbpkT58YDtQ
	 * [token_type] => Bearer
	 * [expires_in] => 3598
	 * [created] => 1484899159
	 */

	$table_name = $wpdb->prefix . 'bpc_user_api';
	$sql3 = "CREATE TABLE $table_name   (
        id int(11) NOT NULL AUTO_INCREMENT,
        user_id int(11) NOT NULL,
        name varchar(50) NOT NULL,
        access_token varchar(500) NOT NULL,
      	token_type varchar(50) NOT NULL,
        expires_in varchar(50) NOT NULL,
        created varchar(50) NOT NULL,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";



	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql1 );
	dbDelta( $sql2 );
	dbDelta( $sql3 );


	add_option( 'jal_db_version', $jal_db_version );
	//when install also add talble
}
function bpc_as_calendar_google_apple_func()
{
//	unset($_SESSION['access_token']);
	ob_start();

	?>
	<style>
		#page-content {
			width:1024px !important;
		}
	</style>
	<?php
	bpc_as_header();
	$bpc_AS_DB					      = new BPC_AS_DB('wp_bpc_appointment_settings');
	$bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();
	require_once __DIR__.'/includes/api/google-api/vendor/autoload.php';
	require_once __DIR__.'/includes/api/google-api/helper.php';

	//		print "<pre>";
	//		print_r($_SESSION);
	//		print "</pre>";
	// google calendar connect

	$bpc_User_Api		 			  = new Bpc_User_Api();


	// execute new insert for google authentication
	if(!empty($_SESSION['access_token'])) {
		//		print "session is not emopty";
		$_SESSION['access_token']['name'] = 'google calendar';
		$bpc_User_Api->addOrUpdate($_SESSION['access_token']);
	} else {
		//		print "sesssion is empty";
	}


	$client = new Google_Client();
	$client->setAuthConfig( __DIR__ . '/includes/api/google-api/client_secret.json');
	$client->addScope(Google_Service_Calendar::CALENDAR);
	$bpc_As_Calendar = new Bpc_As_Calendar();

	// execute insert to wp_bpc_user_api
	$accessToken  = $bpc_User_Api->getGoogleCalendarAccessToken();
	//	print "token $accessToken";
	// set if not empty, meaning its already authenticated
	if (!empty($accessToken)) {



		print "<div style='width: 96%;' class='alert alert-success'>Authenticated with google calendar..</div>";
		// allow try ang catch functions
		try {
			$client->setAccessToken($accessToken);
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
				print "<div style='width: 96%;' class='alert alert-danger'> No upcoming events found. </div>";
			} else {
				print "<div style='width: 96%;' class='alert alert-info'> Upcoming events synced to <a href='/phone-appointment-settings'> phone appointment settings</a> </div>";
				$googleSchedule = [];
				foreach ($results->getItems() as $index => $event) {
					$bpc_As_Calendar->setEventResult([
							'event'=>$event,
							'summary'=>$event->getSummary(),
					]);
					// print "<br>";
					// print $index  . ' .)  ' . " date " . $bpc_As_Calendar->getEventDate() . ' time from ' . $bpc_As_Calendar->getEventTimeStart() . ' time to ' . $bpc_As_Calendar->getEventTimeEnd();
					$googleSchedule[$bpc_As_Calendar->getEventDate()][] = ["break_from"=>$bpc_As_Calendar->getEventTimeStart(),"break_to"=>$bpc_As_Calendar->getEventTimeEnd(), 'description'=>$bpc_As_Calendar->getDescription()];
				}

				// bpc_as_print_r_pre($googleSchedule);
				$date = '';
				$break_from = '';
				$break_to = '';
				$counter = 0;

				print '<div style="width:102%" class="list-group" >';
					foreach($googleSchedule as $date => $breaks) {
						if(!empty($date)) {
							$appointment_setting_id = $bpc_AS_DB->InsertGetOrGetPhoneCallSettings($date)[0]['id'];
							// print "<br> appointment id $appointment_setting_id";
							 $bpc_Appointment_Settings_Breaks->deleteAllAppointmentSettingBreakByAppointmentId($appointment_setting_id);
							foreach ($breaks as $break) {
								$counter ++;
								$break_from = $break['break_from'];
								$break_to   = $break['break_to'];
								$description   = $break['description'];
								if(!empty($break_from) and !empty($break_to)) {
									print '<button  style="width:94%" type="button" class="list-group-item"> '. $counter .'
									 	date ' . $date . ' break from ' . $break_from . '  ' . $break_to . ' - <b> ' . $description . '</b>' . ' - <span style=\'color:green\'>Break successfully added</span>
									</button>';
									$bpc_Appointment_Settings_Breaks->addNewAppointmentBreakIndividual($appointment_setting_id, $break_from, $break_to);
								}
							}
						}
					}
				print '<div class="list-group">';
			}


			// print disconnect button
			bpc_as_google_calendar_print_disconnect_button();

			unset($_SESSION['access_token']);

		}catch (Exception $e){
			bpc_as_google_calendar_auto_connect_with_popup(bpc_as_google_calendar_get_path_call_back_file());
		}
	} else {
		print "<div style='width: 96%;' class='alert alert-info'> Click <a href='/phone-appointment-settings'>here</a> to visit phone appointment settings  </div>";
		bpc_as_google_calendar_print_connect_button(bpc_as_google_calendar_get_path_call_back_file());
	}
	ob_flush();
}
function bpc_as_calendar_google_apple_authenticate()
{
	ob_start();
	bpc_as_header();
	?>
	<style>
		#page-content {
			width:1024px !important;
		}
	</style>
	<?php

	$bpc_AS_DB = new BPC_AS_DB('wp_bpc_appointment_settings');
	$bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();

	require_once __DIR__.'/includes/api/google-api/vendor/autoload.php';
	require_once __DIR__.'/includes/api/google-api/helper.php';

	$client = new Google_Client();
	$client->setAuthConfig( __DIR__ . '/includes/api/google-api/client_secret.json');
	$client->addScope(Google_Service_Calendar::CALENDAR);

	$bpc_As_Calendar = new Bpc_As_Calendar();
	$bpc_User_Api 	 = new Bpc_User_Api();
	$accessToken  	 = $bpc_User_Api->getGoogleCalendarAccessToken();

	if (!empty($accessToken)) {
		print "<div style='width: 96%;' class='alert alert-info'>Synced with google calendar.. click <a href='/google-calendar-settings'>here</a> to visit google calendar settings </div>";
		try {
			$client->setAccessToken($accessToken);
			$service = new Google_Service_Calendar($client);
			// Print the next 10 events on the user's calendar.
			$calendarId = 'primary';
			$optParams = array(
				'maxResults' => 100,
				'orderBy' => 'startTime',
				'singleEvents' => TRUE,
				'timeMin' => date("c", strtotime($bpc_As_Calendar->getCurrentDate()))
			);
			$results = $service->events->listEvents($calendarId, $optParams);
			if (count($results->getItems()) == 0) {
			} else {
				$googleSchedule = [];
				foreach ($results->getItems() as $index => $event) {
					$bpc_As_Calendar->setEventResult([
							'event'=>$event,
							'summary'=>$event->getSummary(),
					]);
					$googleSchedule[$bpc_As_Calendar->getEventDate()][] = ["break_from"=>$bpc_As_Calendar->getEventTimeStart(),"break_to"=>$bpc_As_Calendar->getEventTimeEnd(), 'description'=>$bpc_As_Calendar->getDescription()];
				}
				$date = '';
				$break_from = '';
				$break_to = '';
				$counter = 0;
				print '<div style="width:102%" class="list-group" >';
					foreach($googleSchedule as $date => $breaks) {
						if(!empty($date)) {
							$appointment_setting_id = $bpc_AS_DB->InsertGetOrGetPhoneCallSettings($date)[0]['id'];
							 $bpc_Appointment_Settings_Breaks->deleteAllAppointmentSettingBreakByAppointmentId($appointment_setting_id);
							foreach ($breaks as $break) {
								$counter ++;
								$break_from 	= $break['break_from'];
								$break_to   	= $break['break_to'];
								$description   	= $break['description'];
								if(!empty($break_from) and !empty($break_to)) {
									//									print '<button  style="width:94%" type="button" class="list-group-item"> '. $counter .'
									// 									 	date ' . $date . ' break from ' . $break_from . '  ' . $break_to . ' - <b> ' . $description . '</b>' . ' - <span style=\'color:green\'>Break successfully added</span>
									// 									</button>';
									$bpc_Appointment_Settings_Breaks->addNewAppointmentBreakIndividual($appointment_setting_id, $break_from, $break_to);
								}
							}
						}
					}
				print '<div class="list-group">';
			}
		}catch (Exception $e){
			bpc_as_google_calendar_auto_connect_with_popup(bpc_as_google_calendar_get_path_call_back_file());
		}
	} else {
		print "<div style='width: 96%;' class='alert alert-info'> Click <a href='/google-calendar-settings'>here</a> to visit google calendar settings </div>";
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

	<?php
}
