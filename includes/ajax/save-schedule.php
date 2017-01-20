<?php
 
require_once('../helper.php');
if(bpc_as_is_localhost()) {

//    require_once("D:/xampp/htdocs/wordpress/wp-load.php");
    require_once("E:/xampp/htdocs/wp-load.php");
} else {
    require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';  
}
 
require_once('../db/wpdb_queries.class.php');
require_once('../db/bpc_as_db.php');


// bpc_as_print_r_pre($_POST);
//
//
//print "<pre>";
//print_r($_REQUEST);
//PRINT "</PRE>";


use APP\PBC_AS_WPDB_QUERIES;
use App\BPC_AS_DB;

$bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES('wp_bpc_appointment_settings');
$bpc_as_db           = new BPC_AS_DB('wp_bpc_appointment_settings');
 
$data = $_REQUEST;
 
$user_id        = bpc_as_get_current_user_logged_in_id();
$callBackDelay  = bpc_as_check_call_back_delay($data);
$callBackLength = bpc_as_check_call_back_length($data);
$bookTimeType   = bpc_as_get_book_time_type($data);
$partner_id     = bpc_as_get_current_user_partner_id();
 
print "call back length $callBackLength call back delay $callBackDelay book time type $bookTimeType partner id $partner_id";
 
print "<pre>";

    $counter = 0;
    $counter1 = 0;
    $counter2 = 0;
    $previewDate = '';
    $dataToUpdate = [];
    $dataToUpdateWhere = [];
    foreach ($data as $fieldName => $fieldValue) {
        if($bookTimeType == 'book exact time') {

            $dateDb       = bpc_as_get_date_db_format($fieldName);
            $day          = bpc_as_get_day($fieldName);
            $fieldNameDb  = bpc_as_get_field_name($fieldName);
            $fieldValueDb = bpc_as_get_value($fieldName, $fieldValue);

            // set data prepare for insert or update
            if($fieldNameDb == 'open_from') {
                $dataToUpdate[$counter2]['open_from'] = $fieldValueDb;
            } else if($fieldNameDb == 'open_to') {
                $dataToUpdate[$counter2]['open_to']           = $fieldValueDb;
                $dataToUpdate[$counter2]['call_back_length']  = $callBackLength;
                $dataToUpdate[$counter2]['call_back_delay']   = $callBackDelay;
                $dataToUpdate[$counter2]['book_time_type']    = $bookTimeType;
                $dataToUpdate[$counter2]['user_id']           = $user_id;
                $dataToUpdate[$counter2]['date']              = $dateDb;
                $dataToUpdate[$counter2]['close']             = 'no';
                $dataToUpdate[$counter2]['partner_id']        = $partner_id;
                $dataToUpdate[$counter2]['day']               = $day;
                $counter2++;
            } else {
                $dataToUpdate[$counter2]['call_back_length']  = $callBackLength;
                $dataToUpdate[$counter2]['call_back_delay']   = $callBackDelay;
                $dataToUpdate[$counter2]['book_time_type']    = $bookTimeType;
                $dataToUpdate[$counter2]['user_id']           = $user_id;
                $dataToUpdate[$counter2]['date']              = $dateDb;
                $dataToUpdate[$counter2]['open_from']         = "00:00";
                $dataToUpdate[$counter2]['open_to']           = "00:00";
                $dataToUpdate[$counter2]['close']             = 'yes';
                $dataToUpdate[$counter2]['partner_id']        = $partner_id;
                $dataToUpdate[$counter2]['day']               = $day;
                $counter2++;
            }

        } else {
            $dateDb         = bpc_as_get_date_db_format($fieldName);
            $day            = bpc_as_get_day($fieldName);
            $fieldNameDb    = bpc_as_get_and_remove_day_from_field_name($fieldName);
            $fieldValueDb   = bpc_as_get_value($fieldName, $fieldValue);

            print "<br>$counter) $dateDb $day $fieldNameDb $fieldValueDb";


            if($fieldNameDb == 'checking') {
                // update or insert
                $dataUpdateOrInsert['morning']   = 'no';
                $dataUpdateOrInsert['afternoon'] = 'no';
                $dataUpdateOrInsert['evening']   = 'no';
                $dataUpdateOrInsert['date']      = $dateDb;
                $dataUpdateOrInsert['close']     = 'no';
                $dataUpdateOrInsert['user_id']   = $user_id;
                $dataUpdateOrInsert['book_time_type'] = $bookTimeType;
                $dataUpdateOrInsert['partner_id']        = $partner_id;
                $dataUpdateOrInsert['day']               = $day;
                $dataUpdateOrInsert['call_back_delay']   = $callBackDelay;
                $dataUpdateOrInsert['call_back_length']  = $callBackLength;
                $bpc_as_db->addOrCreate($dataUpdateOrInsert, $user_id, $dateDb);
//                bpc_as_print_r_pre($dataUpdateOrInsert);

                unset($dataUpdateOrInsert);

            } else {

                if(!empty($dateDb)) {
                    $updateData['partner_id'] = $partner_id;
                    $updateData['day'] = $day;
                    $updateData[$fieldNameDb] = ($fieldValueDb == 'on') ? 'yes' : $fieldValueDb; // set on to yes
                    $updateData['book_time_type'] = $bookTimeType;
                    $updateData['date'] = $dateDb;
                    $updateData['user_id'] = $user_id;
                    $updateData['call_back_delay']   = $callBackDelay;
                    $updateData['call_back_length']  = $callBackLength;

//                    bpc_as_print_r_pre($updateData);
                    $bpc_as_db->addOrCreate($updateData, $user_id, $dateDb);
                    unset($updateData);
                }
            }
        }





//        exit;
    }


bpc_as_print_r_pre($dataToUpdate);




foreach($dataToUpdate as $data) {
    $date = $data['date'];

    if(!empty($date)) {

        $user_id = $data['user_id'];

        print "user id ". $user_id . ' date ' . $date;

        if($bpc_as_db->isExistScheduleByDbDate($user_id, $date)) {
            // update
            $bpc_as_db->updateEntryByDateDb($data, ['user_id'=>$user_id, 'date'=>$date]);
        } else {
            // insert
            $bpc_as_db->insertEntry($data);
        }
    }
}