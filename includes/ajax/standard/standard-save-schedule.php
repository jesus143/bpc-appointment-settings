<?php  
/**
 * Require helper file
 */
require_once('../../helper.php'); 

/**
 * Require wp load file, this will allow us to use all the wordpress functions including activated plugin and themes
 */
if(bpc_as_is_localhost()) {  require_once("E:/xampp/htdocs/wp-load.php"); } else { require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php'; }
 
 /**
  * Require the database queries and BPC classess 
  */
require_once('../../db/wpdb_queries.class.php');
require_once('../../db/bpc_as_db.php');
    
/**
 * Call use classes
 */
use APP\PBC_AS_WPDB_QUERIES;
use App\BPC_AS_DB;

/** 
*  Set queries point to standard database schedule
*/
$bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES('wp_bpc_appointment_setting_standard'); 

/**
 *  Initialized variable and assignments 
 */
$data       = [];  
$table_name = 'wp_bpc_appointment_setting_standard';  
$partner_id = bpc_as_get_current_user_partner_id();
$user_id    = bpc_as_get_current_user_logged_in_id();

/** 
 *  Set user id as current authenticated wordpress user id and partner id
 */
$data = ['user_id'=>$user_id, 'partner_id'=>$partner_id];

/**
 * Display current request and print as human visible array
 */
print "<pre>";
print_r($_REQUEST); 
Print "</pre>";    

/**
 *  Check if current partner has already saved standard schedule to database
 */
$isExist = $bpc_as_wpdb_queries->wpdb_get_result("select * from $table_name where user_id = " . $user_id);
 
/**
 * if not exist then do insert new partner's settings for bpc standard calendar
 */ 
if(!$isExist)  { 
    $bpc_as_wpdb_queries->wpdb_insert($data);
}   

 /** 
  *  Compose parameter parameter and prepare to insert
  */
foreach($_REQUEST as $index => $request) {  
    // Monday
    $data = bpc_set_parameter_standardard('monday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('tuesday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('wednesday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('thursday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('thursday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('friday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('saturday', $index, $data, $request); 
    $data = bpc_set_parameter_standardard('sunday', $index, $data, $request); 
    $data = bpc_set_parameter_callbacks($index, $data, $request); 
    $data = bpc_set_parameter_callbacks($index, $data, $request); 
} 
     
bpc_as_print_r_pre($data); 

/**
 * Update standard schedule now 
 */ 
$isUpdated = $bpc_as_wpdb_queries->wpdb_update($data, array('user_id'=> $user_id)); 

/**
 * print status of update standard schedule
 */
if($isUpdated) {    echo "<br> Successfully updated";  } else {  echo "<br> Failed to update, something wrong!"; }
 
/**
 * This will prepare insert to database for days open from, open to and close
 * [bpc_set_parameter_standardard description]
 * @param  [type] $dayLcase [description]
 * @param  [type] $keyword  [description]
 * @param  [type] $response [description]
 * @return [type]           [description]
 */
function bpc_set_parameter_standardard($dayLcase, $keyword, $response, $request) 
{ 
    $dayUcase = ucfirst($dayLcase); 
    if(strpos($keyword, $dayUcase . '_open_from')):
        $response[$dayLcase . '_open_from'] = $request[0] . ':' . $request[1];
    elseif(strpos($keyword, $dayUcase . '_open_to')):
        $response[$dayLcase . '_open_to'] = $request[0] . ':' . $request[1]; 
    elseif(strpos($keyword, $dayUcase. '_business_close')):
        $response[$dayLcase . '_close'] = $request[0];  
    endif; 
    return $response;
}

/**
 * This will set prepare ready to insert database for callback delay and callback lenght
 * [bpc_set_parameter_callbacks description]
 * @param  [type] $keyword  [description]
 * @param  [type] $response [description]
 * @return [type]           [description]
 */
function bpc_set_parameter_callbacks($keyword, $response, $request) 
{  
    if(strpos($keyword, 'BackDelay')): 
        $response['call_back_delay'] = $request[0] . ' ' . $request[1];
    elseif(strpos($keyword, 'BackLength')): 
        $response['call_back_length'] = $request[0] . ' ' . $request[1];
    endif;   
    return $response;
}