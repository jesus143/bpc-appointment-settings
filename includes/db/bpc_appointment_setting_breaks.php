<?php

namespace App; 

use App\PBC_AS_WPDB_QUERIES; 

/**
* 
*/
class Bpc_Appointment_Settings_Breaks 
{

    protected $table_name = 'wp_bpc_appointment_setting_breaks';
    protected  $bpc_as_wpdb_queries;
    function __construct()
    {
        $this->bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES($this->table_name);
    }

    public function deleteAllAppointmentSettingBreakByAppointmentId($appointment_setting_id)
    {
        return $this->bpc_as_wpdb_queries->wpdb_delete(['appointment_setting_id'=>$appointment_setting_id]);
    }

    /**
     * @param $appointment_setting_id
     * @param array $breaks
     * @param $isDeleted
     * @return bool
     * [strDate] => 2017-January-16
        [break_time_hour_min] => Array
        (
        [0] => 00
        [1] => 00
        [2] => 00
        [3] => 00
        [4] => 00
        [5] => 00
        [6] => 00
        [7] => 00
        )

     */


    public function addNewAppointmentBreakIndividual($appointment_setting_id, $break_from, $break_to)
    {
        $this->bpc_as_wpdb_queries->wpdb_insert([
            'appointment_setting_id' => $appointment_setting_id,
            'break_from' => $break_from,
            'break_to' => $break_to
        ]);
    }

    public function addNewAppointmentBreaks($appointment_setting_id, $breaks=[], $isDeleted)
    {


        $counter = 0;
        if($isDeleted) {

            $break_time_hour_min = $breaks['break_time_hour_min'];
            $break_from = '';
            $break_to = '';

            foreach($break_time_hour_min as $num) {

                $counter++;


                if($counter == 1) {
                    $break_from .= $num;
                } else if ($counter == 2) {
                    $break_from .= ":" . $num;
                } else if ($counter == 3) {
                    $break_to  .= $num;
                } else if ($counter == 4) {
                    $break_to  .= ":" . $num;
                }

                if($counter == 4) {

                    // insert new breaks
                    $this->bpc_as_wpdb_queries->wpdb_insert([
                        'appointment_setting_id' => $appointment_setting_id,
                        'break_from' => $break_from,
                        'break_to' => $break_to
                    ]);


                    // clear data variables
                    $counter=0;
                    $break_from = '';
                    $break_to = '';
                }

            }
        }
    }


    /**
     * Delete appiontment break by specific apointment id
     * @param $appointment_setting_id
     * @return bool
     */
    public function deleteAppointmentBreaks($appointment_setting_id) {
        return $this->bpc_as_wpdb_queries->wpdb_delete(['appointment_setting_id'=>$appointment_setting_id]);
    }
    public function getAllBreaksByAppointmentId($appointment_setting_id)
    {
        return $this->bpc_as_wpdb_queries->wpdb_get_result("select * from $this->table_name where appointment_setting_id = $appointment_setting_id ");
    }
}