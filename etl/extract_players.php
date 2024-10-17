 <?php


/*
$client = new http\Client;
$request = new http\Client\Request;

$request->setRequestUrl('https://v3.football.api-sports.io/players/topscorers');
$request->setRequestMethod('GET');
$request->setQuery(new http\QueryString(array(
	'season' => '2020',
	'league' => '61'
)));

$request->setHeaders(array(
	'x-rapidapi-host' => 'v3.football.api-sports.io',
	'x-rapidapi-key' => '0175d8f1cb54f362e35dc7eb59ad0275'
));

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();
*/
?> 



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Stellen Sie sicher, dass die HTTP-Erweiterung installiert ist
if (!class_exists('http\Client')) {
    die("Die PHP-Erweiterung 'pecl_http' ist nicht installiert.");
}

$client = new http\Client;
$request = new http\Client\Request;

$request->setRequestUrl('https://v3.football.api-sports.io/players/topscorers');
$request->setRequestMethod('GET');
$request->setQuery(new http\QueryString(array(
	'season' => '2022',
	'league' => '135'
)));

$request->setHeaders(array(
	'x-rapidapi-host' => 'v3.football.api-sports.io',
	'x-rapidapi-key' => '138eafdb50adc36eca03a04c329b59eb'
));

$client->enqueue($request)->send();
$response = $client->getResponse();


echo $response->getBody();


// Überprüfen Sie den HTTP-Statuscode
if ($response->getResponseCode() !== 200) {
    die("API-Anfrage fehlgeschlagen mit Statuscode: " . $response->getResponseCode());
}
//print_r($response->getBody());
return $response->getBody();
?>