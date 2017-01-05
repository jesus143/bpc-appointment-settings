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
        $dateInput = date_create(bpc_as_get_request_date());
        return date_format($dateInput,"Y-m-d");
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
function bpc_as_get_request_option()
{
    return $_GET['option'];
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
    return $data['callBackLength'][0] . $data['callBackLength'][1];
}
function bpc_as_check_call_back_delay($data)
{
    return $data['callBackDelay'][0] . $data['callBackDelay'][1];
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