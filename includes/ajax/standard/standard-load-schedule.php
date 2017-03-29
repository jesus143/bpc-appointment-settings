<?php

require_once('../../helper.php');
require("../../db/bpc_appointment_setting_standard.class.php");

if(bpc_as_is_localhost()) {

//    require_once("D:/xampp/htdocs/wordpress/wp-load.php");
    require_once("E:/xampp/htdocs/wp-load.php");
} else {
    require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';  
}


require_once('../../db/wpdb_queries.class.php');
require_once('../../db/bpc_as_db.php');

use APP\PBC_AS_WPDB_QUERIES;
use App\BPC_AS_DB;
use App\bpc_appointment_setting_standard;

$dateRequest = bpc_as_get_request_date(); 
$mondayOfTheWeek = bpc_as_get_moday_in_date_week($dateRequest); 
  
$bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES('wp_bpc_appointment_settings');
$bpc_as_db           = new BPC_AS_DB('wp_bpc_appointment_settings');
$bpc_appointment_setting_standard = new bpc_appointment_setting_standard(); 
$dates                            = bpc_as_get_scheduled_date_array();
 
foreach($dates as  $petsa => $date) { 
    $dateStart = $petsa  . ' ' . $date['month'] . ' '.  $date['year'];
    break;
}
foreach($dates as $petsa => $date) {
    $dateEnd = $petsa  . ' ' . $date['month'] . ' '.  $date['year'];
}
$dateDbStart    = bpc_as_set_date_as_db_format($dateStart);
$dateDbEnd      = bpc_as_set_date_as_db_format($dateEnd);

// $scheduleRange  = $bpc_as_db->selectOneWeek($dateDbStart, $dateDbEnd);
/**
* Get schedule for standar settings of specific person
*/
$scheduleRange = $bpc_appointment_setting_standard->selectByUserId(bpc_as_get_current_user_logged_in_id());   
 
// print "test";
// bpc_as_print_r_pre($scheduleStandard); 


$option = bpc_as_get_request_option();
 
// footer
$call_back_length_arr = [];
$call_back_delay_arr  = [];
$call_back_length_arr0 = '';
$call_back_length_arr1 = '';
$call_back_delay_arr0 = '';
$call_back_delay_arr1 = '';
 
// call back value default
if(!empty($scheduleRange)) {

    $call_back_length_arr = explode(' ', $scheduleRange[0]['call_back_length']);
    $call_back_delay_arr  = explode(' ', $scheduleRange[0]['call_back_delay']);

//    bpc_as_print_r_pre($call_back_length_arr);
    if(!empty($call_back_length_arr[0])) {
        $call_back_length_arr0 = $call_back_length_arr[0];
        $call_back_length_arr1 = $call_back_length_arr[1];
    }

    if(!empty($call_back_delay_arr[0])) {
        $call_back_delay_arr0 = $call_back_delay_arr[0];
        $call_back_delay_arr1 = $call_back_delay_arr[1];
    }
}
 
// callback values
$call_back_delay_val_num = [1, 2, 4, 15, 30, 45, 60, 90];
$call_back_delay_val_text = ['mins', 'hours'];
$call_back_length_val_num = [ 10, 15, 20, 30, 45, 60, 90 ];
$call_back_length_val_text = ['mins', 'hours'];
 
// print "<br> request option [" . bpc_as_get_request_option() . '] db option in first date [' . $scheduleRange[0]['book_time_type'] . ']'; 

// sorting option
$book_exact_time = '';
$book_exact_day = ''; 

if(bpc_as_get_quest_type() == 'date_picker') {   
    // print "<br> date picker request";
    $option  = (!empty($scheduleRange[0]['book_time_type'])) ? strtolower($scheduleRange[0]['book_time_type']) : $option;
}  else {

 
    // print "<br> option type request";
}

$days  = [
   'Monday',
   'Tuesday',
   'Wednesday',
   'Thursday',
   'Friday',
   'Saturday',
   'Sunday',
];



if($option =='book exact time') {
    $book_exact_time = 'checked';
} else {
    $book_exact_day = 'checked';
}
  
if(bpc_as_get_quest_type() == 'date_picker') {   
    require_once('../../pages/dashboard-settings-options-type-schedule.php');
}  
print "<div id='bpc-as-schedule-settings-content' >"; 
if($option == 'book exact time') {
    require_once('pages/standard-dashboard-time-settings.php');
} else {
    require_once('pages/standard-dashboard-day-settings.php');
}
require_once('../../pages/dashboard-settings-options.php');
print "</div>";