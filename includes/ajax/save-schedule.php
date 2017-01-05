<?php
require_once("E:/xampp/htdocs/practice/wordpress/wp-load.php");
require_once('../helper.php');
require_once('../db/wpdb_queries.class.php');
require_once('../db/bpc_as_db.php');



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
print "call back length $callBackLength call back delay $callBackDelay book time type $bookTimeType";



print "<pre>";

    $counter = 0;
    $counter1 = 0;
    $counter2 = 0;
    $previewDate = '';
    $dataToUpdate = [];
    $dataToUpdateWhere = [];
    foreach ($data as $fieldName => $fieldValue) {
        if($bookTimeType == 'book exact time') {

            $dateDb = bpc_as_get_date_db_format($fieldName);
            $day = bpc_as_get_day($fieldName);
            $fieldNameDb = bpc_as_get_field_name($fieldName);
            $fieldValueDb = bpc_as_get_value($fieldName, $fieldValue);


            print "<br>$counter) $dateDb $day $fieldNameDb $fieldValueDb";

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
                $counter2++;
            } else {
                $dataToUpdate[$counter2]['close']              = 'yes';
                $dataToUpdate[$counter2]['call_back_length']  = $callBackLength;
                $dataToUpdate[$counter2]['call_back_delay']   = $callBackDelay;
                $dataToUpdate[$counter2]['book_time_type']    = $bookTimeType;
                $dataToUpdate[$counter2]['user_id']           = $user_id;
                $dataToUpdate[$counter2]['date']              = $dateDb;
                $dataToUpdate[$counter2]['open_from']         = "00:00";
                $dataToUpdate[$counter2]['open_to']           = "00:00";
                $counter2++;
            }









//            if (!empty($dateDb)) {
//                if ($counter1 == 1) {
//                    $previewDate = $dateDb;
//                }
//
//                print "$previewDate != $dateDb";
//                if ($previewDate != $dateDb) {
//
//                    print "<br> execute update or insert";
//
//
//                    $response = $bpc_as_db->isExistScheduleByDbDate($user_id, $dateDb);
//
//                    if (!empty($response)) {
//
//                        print "<br> exec update";
//
//                        // data to update
//                        $dataToUpdate['call_back_length'] = $callBackLength;
//                        $dataToUpdate['call_back_delay'] = $callBackDelay;
//                        $dataToUpdate['book_time_type'] = $bookTimeType;
//                        $dataToUpdate['user_id'] = $user_id;
//                        $dataToUpdate['where']['user_id'] = $user_id;;
//                        $dataToUpdate['where']['date'] = $dateDb;
//                        $dataToUpdate['action'] = 'update';
//
//                        // execute update
//                        // $bpc_as_db->updateEntryByDateDb($dataToUpdate, $dataToUpdateWhere);
//
//                    } else {
//                        print "<br> exec insert";
//                        // data to insert
//                        $dataToUpdate['call_back_length'] = $callBackLength;
//                        $dataToUpdate['call_back_delay'] = $callBackDelay;
//                        $dataToUpdate['book_time_type'] = $bookTimeType;
//                        $dataToUpdate['user_id'] = $user_id;
//                        $dataToUpdate['date'] = $dateDb;
//    //                    $dataToUpdate['action']           = 'insert';
//
//                        print_r($dataToUpdate);
//    //                     $bpc_as_db->insertEntry($dataToUpdate);
//                    }
//                    $previewDate = $dateDb;
//                } else {
//                    // compose update
//                    if ($fieldNameDb != 'display_checking' and !empty($fieldNameDb)) {
//                        $dataToUpdate[$fieldNameDb] = $fieldValueDb;
//                    }
//                }
//            } else {
//                print "<br> $counter date is emprt";
//            }
//
//
//            $result = $bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where date = '$dateDb' ");
//             $response = $bpc_as_db->isExistScheduleByDbDate($dateDb);
//            if(!empty($response)) {
//                $bpc_as_db->updateEntryByDateDb(
//                    [
//                        'user_id' => $user_id,
//                        'open_from' => '09:40',
//                        'open_to' => '12:40',
//                        'call_back_length' => '20 min',
//                        'call_back_delay' => '04 hour',
//                        'book_time_type' => $bookTimeType,
//                    ],
//                    [
//                        'date'=>$dateDb
//                    ]
//                );
//            } else {
//                print "<br> date $dateDb not exist";
//            }

//            print "<br> $dateDb $day $fieldNameDb $fieldValueDb";
//            $counter++;
        } else {
            $dateDb         = bpc_as_get_date_db_format($fieldName);
            $day            = bpc_as_get_day($fieldName);
            $fieldNameDb    = bpc_as_get_and_remove_day_from_field_name($fieldName);
            $fieldValueDb   = bpc_as_get_value($fieldName, $fieldValue);
            print "<br> $dateDb $day $fieldNameDb $fieldValueDb";
        }
//        if($counter > 20)
//            break;
        $counter++;
        $counter1++;
    }
//print_r($dataToUpdate);
foreach($dataToUpdate as $data) {
    $date = $data['date'];


    if(!empty($date)) {

        $user_id = $data['user_id'];

        print "user id ". $user_id . ' date ' . $date;

        if($bpc_as_db->isExistScheduleByDbDate($user_id, $date)) {
            print "<br> exist date $date ";
            // update
            $bpc_as_db->updateEntryByDateDb($data, ['user_id'=>$user_id, 'date'=>$date]);
        } else {
            // insert
            $bpc_as_db->insertEntry($data);
        }
    }
}

//unset($dataToUpdate);







exit;

$data = [
    'user_id' => 1,
    'open_from' => '09:30',
    'open_to' => '12:30',
    'call_back_length' => '10 min',
    'call_back_delay' => '01 hour',
    'morning' => 'available',
    'afternoon' => 'available',
    'evening' => 'available',
    'close' => 'yes',
    'date' => '2017-1-5',
];

$response = $bpc_as_wpdb_queries->wpdb_insert($data);

if($response){
    print "<br>success insert";
} else {
    print "<br>not success insert";
}


