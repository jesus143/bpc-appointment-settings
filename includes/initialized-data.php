<?php


$dates = bpc_as_get_scheduled_date_array(date('Y-m-d'));
$call_back_delay_arr = [];
$call_back_length_arr =[];
$call_back_length_arr0 = '';
$call_back_length_arr1 = '';
$call_back_delay_arr0 = '';
$call_back_delay_arr1 = '';
$call_back_delay_val_num = [1,2,3,4,5,6];
$call_back_delay_val_text = ['mins', 'hours', 'days'];


$call_back_length_val_num = [1,2,3,4,5,6];
$call_back_length_val_text = ['mins', 'hours', 'days'];

$book_exact_time = 'checked';
$book_exact_day = '';

//$dates = [
//    '1'=>['day'=>'Monday', 'year'=>'2017', 'month'=>'February'],
//    '2'=>['day'=>'Tuesday', 'year'=>'2017',   'month'=>'February'],
//    '3'=>['day'=>'Wednesday', 'year'=>'2017',    'month'=>'February'],
//    '4'=>['day'=>'Thursday', 'year'=>'2017',    'month'=>'February'],
//    '5'=>['day'=>'Friday', 'year'=>'2017',   'month'=>'February'],
//    '6'=>['day'=>'Saturday', 'year'=>'2017',   'month'=>'February'],
//    '7'=>['day'=>'Sunday', 'year'=>'2017', 'month'=>'February']
//];