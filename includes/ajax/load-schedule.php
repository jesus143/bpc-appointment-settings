<?php
require_once('../helper.php');
//sleep(2);
$dates = bpc_as_get_scheduled_date_array();
if(bpc_as_get_request_option() == 'book exact time') {
    require_once('../pages/dashboard-time-settings.php');
} else {
    require_once('../pages/dashboard-day-settings.php');
}
require_once('../pages/dashboard-settings-options.php');