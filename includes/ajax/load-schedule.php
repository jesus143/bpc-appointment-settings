<?php
require_once("E:/xampp/htdocs/practice/wordpress/wp-load.php");
require_once('../helper.php');
require_once('../db/wpdb_queries.class.php');
require_once('../db/bpc_as_db.php');
use APP\PBC_AS_WPDB_QUERIES;
use App\BPC_AS_DB;
$bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES('wp_bpc_appointment_settings');
$bpc_as_db           = new BPC_AS_DB('wp_bpc_appointment_settings');
$dates               = bpc_as_get_scheduled_date_array();




//bpc_as_print_r_pre($dates);
foreach($dates as  $petsa => $date) {
//    print " petsa $petsa";
    $dateStart = $petsa  . ' ' . $date['month'] . ' '.  $date['year'];
    break;
}
foreach($dates as $petsa => $date) {
    $dateEnd = $petsa  . ' ' . $date['month'] . ' '.  $date['year'];
}
$dateDbStart    = bpc_as_set_date_as_db_format($dateStart);
$dateDbEnd      = bpc_as_set_date_as_db_format($dateEnd);
$scheduleRange  = $bpc_as_db->selectOneWeek($dateDbStart, $dateDbEnd);

$option = bpc_as_get_request_option();

//bpc_as_print_r_pre($scheduleRange);


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
    $call_back_length_arr0 = $call_back_length_arr[0];
    $call_back_length_arr1 = $call_back_length_arr[1];
    $call_back_delay_arr0 = $call_back_delay_arr[0];
    $call_back_delay_arr1 = $call_back_delay_arr[1];
}

// callback values
$call_back_delay_val_num = [1,2,3,4,5,6];
$call_back_delay_val_text = ['mins', 'hours', 'days'];
$call_back_length_val_num = [1,2,3,4,5,6];
$call_back_length_val_text = ['mins', 'hours', 'days'];


// sorting option
$book_exact_time = '';
$book_exact_day = '';
$option  = (!empty($scheduleRange[0]['book_time_type'])) ? $scheduleRange[0]['book_time_type'] : $option;




if($option =='book exact time') {
    $book_exact_time = 'checked';
} else {
    $book_exact_day = 'checked';
}


//require_once('../pages/dashboard-settings-options-type-schedule.php');

if(bpc_as_get_request_option() == 'book exact time') {
    require_once('../pages/dashboard-time-settings.php');
} else {
    require_once('../pages/dashboard-day-settings.php');
}
require_once('../pages/dashboard-settings-options.php');