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


$data['book_time_type'] = $_REQUEST['book_time_type'];



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

print "<br><br> after ready to insert database";

print_r($data);


/**
 * add business day close, this will help allow clear data before update database
 */
 $data = bpc_set_parameter_empty_close_tatus($data);
 print "<br><br> after set empty close status";
 print_r($data);

 $data = bpc_set_parameter_empty_morning_afternoon_evening_tatus($data);
 print "<br><br> after set empty morning, afternoon and evening status ";
 print_r($data);




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


    /**
     * Book Exact Time  calculation and data set
     */

    if(strpos($keyword, $dayUcase . '_open_from'))
    {
        $response[$dayLcase . '_open_from'] = $request[0] . ':' . $request[1];
    }
    elseif(strpos($keyword, $dayUcase . '_open_to'))
    {
        $response[$dayLcase . '_open_to'] = $request[0] . ':' . $request[1];
    }
    elseif(strpos($keyword, $dayUcase. '_business_close'))
    {
        $response[$dayLcase . '_close'] = ($request[0] == 'on') ? 'yes' : null;

    }

    /**
     * Book Time Of Day calculation and data set
     */
    elseif($keyword == $dayUcase. '_business_close')
    {
        if ($request == 'on')
        {
            print "<br> $keyword _morning request $request<br>";
            $response[$dayLcase . '_close'] = ($request == 'on') ? 'yes' : null;
        }
    }
    elseif($keyword == $dayUcase .  '_morning')
    {

        if ($request == 'on')
        {
            print "<br> $keyword _morning request $request<br>";
            $response[$dayLcase . '_morning'] = ($request == 'on') ? 'yes' : null;
        }

    }
    elseif($keyword == $dayUcase . '_afternoon')
    {
        if ($request == 'on')
        {
            $response[$dayLcase . '_afternoon'] = ($request == 'on') ? 'yes' : null;
            print "<br> $keyword _afternoon request $request<br>";
        }
    }
    elseif($keyword == $dayUcase . '_evening')
    {
        if ($request == 'on')
        {
            $response[$dayLcase . '_evening'] = ($request == 'on') ? 'yes' : null;
            print "<br> $keyword _evening request $request<br>";
        }
    }

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

/**
 *  Allow add blank content when content is empty this will allow remove first the close value and then allow update again, in short 
 *  its like refresh data 
 */
function bpc_set_parameter_empty_close_tatus($data)
{

    $rows = ['monday_close', 'tuesday_close', 'wednesday_close', 'thursday_close', 'friday_close', 'saturday_close', 'sunday_close'];

    foreach($rows as $row) {
        if(!array_key_exists($row, $data)) {
            $data[$row] = '';
        }
    }

    return $data;
}


function bpc_set_parameter_empty_morning_afternoon_evening_tatus($data)
{
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $dayType = ['morning', 'afternoon', 'evening'];
    foreach($days as $day) {
        foreach($dayType as $dayT) {
            $key = $day . '_' . $dayT;
            if(!array_key_exists($key, $data)) {
                $data[$key] = '';
            }
        }
    }
    return $data;
}