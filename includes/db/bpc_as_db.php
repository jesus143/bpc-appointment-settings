<?php

namespace App;

use APP\PBC_AS_WPDB_QUERIES;

class BPC_AS_DB {

    protected $table_name;
    protected $wpdb;
    protected $db_class;
    protected $bpc_as_wpdb_queries;

    function __construct ($table_name) {
        global $wpdb;
        $this->table_name = $table_name;
        $this->wpdb = $wpdb;
        $this->bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES('wp_bpc_appointment_settings');
    }
    public function isExistScheduleByDbDate($user_id, $dateDb)
    {
        $response = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where user_id = $user_id and date = '$dateDb' ");
        //            print_r($response);
        //        print count($response) ;
        if(count($response) > 0) {
            return $response;
        } else {
            return false;
        }
    }

    public function updateEntryByDateDb($data=[], $condition=[])
    {
        return $this->bpc_as_wpdb_queries->wpdb_update(
            $data, $condition
        );
    }
    public function insertEntry($data)
    { 
        // print "<br><br> to be insert ";
        // print "<pre>";
        // unset($data['updated_at']);
        // print_r($data);
        // print"</pre>";
        return $this->bpc_as_wpdb_queries->wpdb_insert($data);
    }
    public function addOrCreate($data, $user_id, $dateDb)
    {
        if($this->isExistScheduleByDbDate($user_id, $dateDb)){
            return $this->updateEntryByDateDb($data, ['user_id'=>$user_id, 'date'=>$dateDb]);
        } else {
            $this->insertEntry($data);
        }
    }
    public function selectOneWeek($startDate, $endDate)
    { 
        $user_id = bpc_as_get_current_user_logged_in_id();
        $response = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where date >= '$startDate' and date <= '$endDate' and user_id = $user_id ");
        return $response;
    }
    public function InsertGetOrGetPhoneCallSettings($date)
    {

        // get appointment settings based on the user_id and date

        $user_id  = bpc_as_get_current_user_logged_in_id();



        $response = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where date = '$date' and user_id = $user_id ");


        // if exist then return specific id 

        if($response) {

            return $response;

        } else {

            // if not exist then do insert
            // after insert return specific id

            $this->bpc_as_wpdb_queries->wpdb_insert(
                [

                    'user_id'=>$user_id,
                    'partner_id'=>bpc_as_get_current_user_partner_id(),
                    'open_from'=>'09:30',
                    'open_to'=>'17:30',
                    'close'=>'no',
                    'book_time_type'=>'book exact time',
                    'date'=>$date
                ]
            );

            $response = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where date = '$date' and user_id = $user_id ");

            return $response;

        }

    }

    public function getPhoneCallSettings($date) {

        $user_id  = bpc_as_get_current_user_logged_in_id();
        $response = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where date = '$date' and user_id = $user_id ");

        return $response;
    }
}