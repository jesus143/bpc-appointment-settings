<?php
if(!session_id()) {
    session_start();
} 
require_once('config.php');  

if($bpc_User_Api->disconnectGoogleCalendar()){
    unset($_SESSION['access_token']);
    print "Successfully disconnected from google calendar";
} else {
    print "Failed to disconnect from google calendar";
}