<?php 

namespace App; 

use APP\PBC_AS_WPDB_QUERIES;  

/**
* This class manage table name  "bpc_appointment_setting_standard" this will be the storage of all the 
* entry of standard calendar inputs
*/
class bpc_appointment_setting_standard 
{ 

    protected $table_name = 'wp_bpc_appointment_setting_standard';
    protected $bpc_as_wpdb_queries;

    function __construct()
    {
        $this->bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES($this->table_name);
    }
 	
 	/**
 	 *  Get entry that matched with user id, expecting the user id is from wordpress
 	 * @param  [type] $where [description]
 	 * @return [type]        [description]
 	 */
    public function selectByUserId($user_id) 
    { 
    	$response = $this->bpc_as_wpdb_queries->wpdb_get_result("SELECT * FROM $this->table_name WHERE user_id = " . $user_id);
    	return $response;
    }

    public function delete($where=[]) {}

    public function insert($where=[]) {}

    public function update($data=[], $where=[]) {
        return $this->bpc_as_wpdb_queries->wpdb_update($data, $where);
    }


    public function getResultByDay($day, $response, $counter)
    {
    	$day = strtolower($day); 
    	$data = [];  
    	$data[$counter]['open_from'] = $response[0][$day . '_open_from']; 
    	$data[$counter]['open_to']   = $response[0][$day . '_open_to']; 
    	$data[$counter]['close']     = $response[0][$day . '_close']; 
    	$data[$counter]['breaks']    = $response[0][$day . '_break']; 

    	return $data;
    }

    public function convertToPropperDateTime($var_array)
    {
        $data  = [];     
        $index = 0;
        $c     = 1;
        $custom_break = [];  
        foreach($var_array as $b) {      
            if($c==1) {
                $custom_break[$index]['break_from'] .= $b;
            } else if ($c==2) {
                $custom_break[$index]['break_from'] .= ':' . $b; 
            } else if ($c==3) {
                $custom_break[$index]['break_to'] .= $b; 
            } else if ($c==4){
                $custom_break[$index]['break_to'] .= ':' . $b;  
            }   
            $c++;
            if($c%5 == 0) {
                $c=1;
                $index++;
            } 
        }    

        return $custom_break; 
    }


}