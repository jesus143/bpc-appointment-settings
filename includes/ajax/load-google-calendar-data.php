<?php
if(!session_id()) {
    session_start();
}

require_once("includes/helper.php");
require_once('includes/db/Bpc_As_Calendar.php');
require_once("includes/db/wpdb_queries.class.php");
require_once("includes/db/bpc_as_db.php");
require_once("includes/db/bpc_appointment_setting_breaks.php");
require_once("includes/db/bpc_user_api.php");
require_once __DIR__.'/includes/api/google-api/vendor/autoload.php';
require_once __DIR__.'/includes/api/google-api/helper.php';

if(bpc_as_is_localhost()) {
    require_once("E:/xampp/htdocs/wp-load.php");
} else {
    require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
}

use App\Bpc_Appointment_Settings_Breaks;
use App\BPC_AS_DB;
use App\Bpc_As_Calendar;
use App\Bpc_User_Api;

$bpc_AS_DB                        = new BPC_AS_DB('wp_bpc_appointment_settings');
$bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();
$bpc_User_Api                     = new Bpc_User_Api();
$client                           = new Google_Client();
$bpc_As_Calendar                  = new Bpc_As_Calendar();

$client->setAuthConfig( __DIR__ . '/includes/api/google-api/client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR);

//		print "<pre>";
//		print_r($_SESSION);
//		print "</pre>";
//      google calendar connect

// execute insert to wp_bpc_user_api
// set if not empty, meaning its already authenticated

if (!empty($bpc_User_Api->getGoogleCalendarAccessToken())) {
    print "<div style='width: 96%;' class='alert alert-success'>Authenticated with google calendar..</div>";
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
                        $break_from     = $break['break_from'];
                        $break_to       = $break['break_to'];
                        $description    = $break['description'];
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
    }catch (Exception $e){
        //			print "<br> Error " . $e->getMessage();
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php';
        bpc_as_redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }
} else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php';
    //bpc_as_redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
    print "
			<a href='".$redirect_uri."'>
				<input type='button' value='Sync with google calendar' />
			</a>
		";
}