<?php 
/**
 * http://google-calendar.hopto.org/google-api/index.php
 * http://google-calendar.hopto.org/google-api/oauth2callback.php
 */
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/helper.php';

session_start();

print "<pre>";
	print_r($_SESSION);
print "</pre>"; 

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');

$client->addScope(Google_Service_Calendar::CALENDAR);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  $client->setAccessToken($_SESSION['access_token']);

  $service = new Google_Service_Calendar($client); 
	// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 100,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin'=>'2013-03-01T00:00:00-04:00',
  'timeMax' => '2017-03-28T23:59:59-04:00'
);
$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
    printf("%s (%s)\n", $event->getSummary(), $start);
    print "<br>";
  }
}

} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google-api/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}