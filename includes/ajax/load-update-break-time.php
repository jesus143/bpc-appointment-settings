<?php
	require("../helper.php");
	require("../db/wpdb_queries.class.php");
	require("../db/bpc_as_db.php");
	require("../db/bpc_appointment_setting_breaks.php");
	if(bpc_as_is_localhost()) {
		// require_once("D:/xampp/htdocs/wordpress/wp-load.php");
		require_once("E:/xampp/htdocs/wordpress/wp-load.php");
	} else {
		require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
	}
	use App\Bpc_Appointment_Settings_Breaks;
	use App\BPC_AS_DB;

	$bpc_AS_DB = new BPC_AS_DB('wp_bpc_appointment_settings');
	$bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();

	bpc_as_print_r_pre($_POST);

	$strDate = bpc_as_set_date_as_db_format($_POST['strDate']);

	print "<br>  before " . $_POST['strDate'] . " db format date " .$strDate;
	// print "update this break now";  
	// check if exist date for specific user if exist then get id  
	// else if not exist then insert new phone settings for specific date and user and partner id return specific id

	$phoneSettings = $bpc_AS_DB->InsertGetOrGetPhoneCallSettings($strDate);
	$appointment_setting_id = $phoneSettings[0]['id'];
	print "<br> appointment id " .$appointment_setting_id;

	// delete bpc_appointment_setting_break where appointment_id is equals to id 
	$isDeleted = $bpc_Appointment_Settings_Breaks->deleteAllAppointmentSettingBreakByAppointmentId($appointment_setting_id);
 
	// foreach insert new breaks  
	$breakUpdated = $bpc_Appointment_Settings_Breaks->addNewAppointmentBreaks($appointment_setting_id, $_POST, $isDeleted);
  
	// bpc_as_print_r_pre($_POST);

	// $breakUpdated = true;   

	print " partner id " . bpc_as_get_current_user_partner_id();
	if($breakUpdated) { 
		return true; 
	} else {
		return false;
	}
