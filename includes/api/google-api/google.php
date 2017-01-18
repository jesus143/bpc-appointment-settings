<?php 

require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName("97151394217-heibk7ujhjm260oq06nhsm3kdm0d0flg.apps.googleusercontent.com");
$client->setDeveloperKey("F9EmDWu0JtRDPIM8z3MAOdBY");

$service = new Google_Service_Books($client);
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

foreach ($results as $item) {
    echo $item['volumeInfo']['title'], "<br /> \n";
}