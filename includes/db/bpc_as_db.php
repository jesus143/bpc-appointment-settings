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
//        print $startDate . ' '.  $endDate;
        $user_id = bpc_as_get_current_user_logged_in_id();
        $response = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from wp_bpc_appointment_settings where date >= '$startDate' and date <= '$endDate' and user_id = $user_id ");
        return $response;
    }
}