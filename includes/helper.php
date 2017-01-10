<?php
if(!function_exists('bpc_as_1_to_2numbers'))
{
    function bpc_as_1_to_2numbers($number)
    {
        if($number < 10) {
            return '0' . $number;
        } else {
            return $number;
        }
    }
}
if(!function_exists('bpc_as_generate_hours_option'))
{
    function bpc_as_generate_hours_option($default=null)
    {
        for($i=0; $i<24; $i++):
            print "<option value='" . bpc_as_1_to_2numbers($i) . "' ".bpc_as_time_option_set_selected($i, $default)." >" . bpc_as_1_to_2numbers($i) . "</option>";
        endfor;
    }
}
if(!function_exists('bpc_as_generate_minutes_option'))
{
    function bpc_as_generate_minutes_option($default=null)
    {
        for($i=0; $i<60; $i++):

            print "<option  value='" . bpc_as_1_to_2numbers($i) . "'   ".bpc_as_time_option_set_selected($i, $default)." >" . bpc_as_1_to_2numbers($i) . "</option>";
        endfor;
    }
}



function bpc_as_generate_dropDown_option($data, $default=null)
{
    $response = '';
    foreach($data as $val) {
        print "if($default == $val)";
        if($default == $val) {
            $response .= "<option  value='" . $val . "' selected>" . $val . "</option>";
        } else {
            $response .= "<option  value='" . $val . "' >" . $val . "</option>";
        }
    }

    return $response;
}





if(!function_exists('bpc_as_time_option_set_selected'))
{
    function bpc_as_time_option_set_selected($i, $default=null)
    {
        if($default == $i) {
            return 'selected';
        } else {
            return '';
        }
    }
}
if(!function_exists('bpc_as_get_next_date')) {
    function bpc_as_get_next_date($date, $total=0)
    {
        $date = new DateTime($date);
        $date->add(new DateInterval('P' . $total . 'D'));
        return bpc_as_date_to_human_readable($date->format('Y-m-d'));
    }
}
if(!function_exists('bpc_as_get_next_date_readable')) {
    function bpc_as_date_to_human_readable($date)
    {
        $date = date_create($date);
        return date_format($date,"F d Y l");
    }
}
if(!function_exists('bpc_as_set_scheduled_selected_date_format')) {
    function bpc_as_set_scheduled_selected_date_format()
    {
       return  bpc_as_get_moday_in_date_week(bpc_as_get_request_date()); 
    }
}

function bpc_as_get_scheduled_date_array($date=null)
{
    if(empty($date)) {
        $date = bpc_as_set_scheduled_selected_date_format();
    }

    $dates = [];
    for($i=0; $i<7; $i++) {
        $nextDate = bpc_as_get_next_date($date, $i);
        $nextDateArr = explode(" ", $nextDate);
        $dates[intval($nextDateArr[1])] = [
            'day' => $nextDateArr[3],
            'year' => $nextDateArr[2],
            'month' => $nextDateArr[0]
        ];
    }
    return $dates;
}

// Request data
function bpc_as_get_request_date()
{
    return $_GET['date'];
}
function bpc_as_get_quest_type()
{
    return $_GET['base'];
}
function bpc_as_get_request_option()
{
    return (!empty($_GET['option']))? $_GET['option'] : 'book exact time';
}

function bpc_as_set_date_as_db_format($date)
{
    $date = date_create($date);
    return date_format($date, "Y-m-d");
}
/**
 * @param $fieldName
 * @return bool|string
 * Form post request
 * ex: data "5_January_2017_Thursday_open_from"
 */
function bpc_as_get_date_db_format($fieldName)
{
    if(bpc_as_check_if_input_date($fieldName)) {
        $date1  = explode('_', $fieldName);
        $petsa  = $date1[0];
        $month  = $date1[1];
        $year   = $date1[3];
        $day    = $date1[4];
        $date   = $petsa . ' ' . $month . ' ' . $year;
        $dateDb = bpc_as_set_date_as_db_format($date);
        return $dateDb;
    }
    return false;
}
function bpc_as_get_day($fieldName)
{
    if(bpc_as_check_if_input_date($fieldName)) {
        $date1  = explode('_', $fieldName);
        return strtolower($date1[3]);
    }
    return false;
}

function bpc_as_get_field_name($fieldName)
{
    if(bpc_as_check_if_input_date($fieldName)) {
        $data  = explode('_', $fieldName);
        return strtolower($data[count($data)-2] . '_' . $data[count($data)-1]);
    }
    return false;
}

function bpc_as_get_value($fieldName, $fieldValue)
{
    if(bpc_as_check_if_input_date($fieldName)) {
        if (count($fieldValue) > 1) {
            return $fieldValue[0] . ':' . $fieldValue[1];
        } else {
            return $fieldValue[0];
        }
    }
}

function bpc_as_check_if_input_date($fieldName)
{
    $underScore = strpos($fieldName, '_');
    if($underScore  > 0) {
        return true;
    } else {
        return false;
    }
}

function bpc_as_check_call_back_length($data)
{
    return $data['callBackLength'][0] . ' ' . $data['callBackLength'][1];
}
function bpc_as_check_call_back_delay($data)
{
    return $data['callBackDelay'][0] . ' ' . $data['callBackDelay'][1];
}
function bpc_as_get_book_time_type($data)
{
    return $data['bookTimeSorting'];
}

function bpc_as_get_current_user_logged_in_id()
{
    $current_user = wp_get_current_user();
    return $current_user->ID;
}
function bpc_as_get_and_remove_day_from_field_name($fieldName)
{
    $fn = bpc_as_get_field_name($fieldName);
    $fn_arr = explode("_", $fn);
    if(count( $fn_arr ) > 1) {
        return $fn_arr[1];
    }
    return false;
}
function bpc_as_print_r_pre($string)
{
    print "<pre>";

        print_r($string);

    print "</pre>";
}

function bpc_as_get_moday_in_date_week($dateRequest)
{   

    // print " request datae $dateRequest";
    //  2017-01-02
    // $date = bpc_as_set_date_as_db_format($date);  
     $date = bpc_as_set_date_as_db_format($dateRequest); 
    $dateArr = explode("-", $date); 
    $year = $dateArr[0];
    $month =  $dateArr[1];
    $day =  $dateArr[2];
    $monday=strtotime("monday this week", mktime(0,0,0, $month, $day, $year));
    $mondayOfTheWeek = date("Y-m-d",$monday);
    // print " monday of the week " . $mondayOfTheWeek . ' <<------ <br><br><Br>';
    return $mondayOfTheWeek; 
}


// get current user partner id from ontraport
function bpc_as_get_current_user_partner_id()
{
    $opResponse = bpc_as_get_ontraport_info();
    $opResponse = json_decode($opResponse, true ); 
    // return $opResponse['data'][0]['id'];
    return 12345;
}
function bpc_as_get_ontraport_info()
{   
    $method = 'GET'; 
    $user   = wp_get_current_user();
    $API_URL    = 'https://api.ontraport.com/1/objects?';
    //      print "<brr> current user email " . $user->user_email;

    $API_DATA   = array(
            'objectID'      => 0,
            'performAll'    => 'true',
            'sortDir'       => 'asc',
            'condition'     => "email='".$user->user_email."'", //use this format since its a sql query condition. For other fields, you may change this value to something else.
            'searchNotes'   => 'true'
    );

    $API_KEY    = 'fY4Zva90HP8XFx3';
    $API_ID     = '2_7818_AFzuWztKz';

    //$API_RESULT   = query_api_call($postargs, $API_ID, $API_KEY);

    $API_RESULT = bpc_as_op_query($API_URL, 'GET', $API_DATA, $API_ID, $API_KEY);

    $getName    = json_decode($API_RESULT);

    //      var_dump($getName->data[0]); //sample for getting all data from the decoded json

    $PARTNER_ID     = $getName->data[0]->id;
    //      echo $PARTNER_ID; //partner ID

    $FACEBOOK_EMAILSAMPLE = $faceBookEmail;

    $API_UDATA  = array(
            'objectID'          => 0,
            'id'            => $PARTNER_ID,
            'f1583'         => $FACEBOOK_EMAILSAMPLE
    );

    //GET PUT RESULT
    return bpc_as_op_query( $API_URL, $method, $API_UDATA, $API_ID, $API_KEY );
}
function bpc_as_op_query($url, $method, $data, $appID, $appKey){
    $ch = curl_init( );
    switch ($method){
        case 'POST': {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($data)), 'Api-Appid:' . $appID, 'Api-Key:' . $appKey));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            break;
        }
        case 'PUT': {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($data)), 'Api-Appid:' . $appID, 'Api-Key:' . $appKey));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            break;
        }
        case 'GET': {
            $finalURL = $url . urldecode(http_build_query($data));
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_URL, $finalURL);
            curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Api-Appid:' . $appID, 'Api-Key:' . $appKey));
            break;
        }
    }
    $response  = curl_exec($ch);
    curl_close($ch);

    return $response;
}
