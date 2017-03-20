<?php
if(!session_id()) { 
	session_start();
}

require_once __DIR__.'/vendor/autoload.php';

$type = (!empty($_GET['type'])) ? $_GET['type'] : null;


$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  $_SESSION['type'] = 'auth'; 
  // exit; 
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
 	$_SESSION['type'] = 'auth'; 
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
  	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google-calendar-settings'; 
  // print "else";
  // exit; 
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
 
//https://accounts.google.com/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php
//google-calendar.hopto.org/wp-content/plugins/bpc-appointment-settings/includes/api/google-api/oauth2callback.php