<?php     
	error_reporting(1); 
	/**
	 * Require files
	 */ 
	
/**
 * display errors 
 */
// Turn off error reporting
error_reporting(1);

// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Report all errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

/* That's all, stop editing! Happy blogging. */
 	
 	/** Call core files */
	require("../../helper.php"); 
	require $_SERVER['DOCUMENT_ROOT'] .'/wp-load.php'; 
	require_once("../../db/wpdb_queries.class.php");
	require_once('../../db/bpc_appointment_setting_standard.class.php'); 
 	 
 	/**  Call namespace */
	use App\bpc_appointment_setting_standard;
 
	/**  Instantiate standard database class */
	$appointment_setting_standard =  new bpc_appointment_setting_standard();  
	 
	/** get current user id logged in */
	$user_id = bpc_as_get_current_user_logged_in_id();  

	/** accept post request from server via ajax request */
	$post = $_REQUEST;  
	$day  = $post['day']; 	   

	print_r($post);  
	
	/** seriazlized break post and prepare to insert database */
	$post_serizlized = serialize($post); 
	$data = [$day . '_break'=>$post_serizlized];

	bpc_as_print_r_pre($data); 

	// update specific date with parameter user id, day and serialized post
	$isUpdated = $appointment_setting_standard->update($data, ['user_id'=>$user_id]); 
 
	/**
	 * Print status 
	 */
	if($isUpdated) { 
		print  "Successfully updated!"; 
	} else {
		print "Failed to update"; 
	}
