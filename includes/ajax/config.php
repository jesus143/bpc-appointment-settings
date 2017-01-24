<?php
require("../helper.php");
require("../db/wpdb_queries.class.php");
require("../db/bpc_as_db.php");
require("../db/bpc_appointment_setting_breaks.php");
require("../db/bpc_user_api.php");
if(bpc_as_is_localhost()) {

    require_once("E:/xampp/htdocs/wordpress/wp-load.php");
} else {
    require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
}
use App\Bpc_Appointment_Settings_Breaks;
use App\BPC_AS_DB;
use App\Bpc_User_Api;

$bpc_AS_DB = new BPC_AS_DB('wp_bpc_appointment_settings');
$bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();
$bpc_User_Api = new Bpc_User_Api();





