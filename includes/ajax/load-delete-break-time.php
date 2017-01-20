	<?php
	require("../helper.php");
	require("../db/wpdb_queries.class.php");
	require("../db/bpc_as_db.php");
	require("../db/bpc_appointment_setting_breaks.php");
	if(bpc_as_is_localhost()) {

//		require_once("D:/xampp/htdocs/wordpress/wp-load.php");
		require_once("E:/xampp/htdocs/wp-load.php");
	} else {
		require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php';
	}
	use App\Bpc_Appointment_Settings_Breaks;
	use App\BPC_AS_DB;

	$bpc_AS_DB = new BPC_AS_DB('wp_bpc_appointment_settings');
	$bpc_Appointment_Settings_Breaks  = new Bpc_Appointment_Settings_Breaks();

	//	bpc_as_print_r_pre($_POST);
	$strDate = bpc_as_set_date_as_db_format($_POST['strDate']);

    // get id from wp_bpc_appointment_settings where user id and date  
	$phoneSettings = $bpc_AS_DB->getPhoneCallSettings($strDate);
	$appointment_setting_id = $phoneSettings[0]['id'];

	//	print "<br>  before " . $_POST['strDate'] . " db format date " .$strDate . ' appointment id ' . $appointment_setting_id ;
	// delete bpc_appointment_setting_break where appointment_id is equals to id
	$breakDelete = $bpc_Appointment_Settings_Breaks->deleteAppointmentBreaks($appointment_setting_id);
  
	if($breakDelete) { 
		return true; 
	} else {
		return false;
	}

