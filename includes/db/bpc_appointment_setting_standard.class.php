<?php 

namespace App; 

use App\PBC_AS_WPDB_QUERIES;  

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

    public function update($data=[], $where=[]) {}


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
}