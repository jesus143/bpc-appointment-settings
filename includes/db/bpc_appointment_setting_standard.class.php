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




    public function getSpecificSchedule($user_id)
    { 
        return $this->bpc_as_wpdb_queries->wpdb_get_result("select * from $this->table_name where  user_id = $user_id ");
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
    
    /**
     *  This will convert the serialized format of data 
     */
    public function convertToPropperDateTime($var_array)
    { 
        // bpc_as_print_r_pre($var_array); 
 
        // if(!empty($var_array)) {  
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
        // } else {
        //     return null;
        // }
    }



    public function generateSpecificUserWithDefaultStandarSettings()
    {

        $user_id     = bpc_as_get_current_user_logged_in_id();
        $partner_id  = bpc_as_get_current_user_partner_id();

        //        print " user id $user_id and partner id $partner_id<Br>";

        $isStandardExist= $this->bpc_as_wpdb_queries->wpdb_get_result("select * from $this->table_name where user_id = $user_id ");

        //        bpc_as_print_r_pre($isStandardExist);

       if(count($isStandardExist) < 1) {

           $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            foreach ($days as $day) {
                $data[$day . '_open_from'] = '9:00';
                $data[$day . '_open_to'] = '17:30';
            }

            $data['user_id'] = $user_id;
            $data['partner_id'] = $partner_id;

            $data['call_back_length'] = '15 mins';
            $data['call_back_delay'] = '15 mins';

            //            bpc_as_print_r_pre($data);

            //            print " not exist user standard and generated";
            return $this->bpc_as_wpdb_queries->wpdb_insert($data);

       } else{

            //           print " exist user standard and generated";
           return false;

       }

    }
 

}