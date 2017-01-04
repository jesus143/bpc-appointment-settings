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
