<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Stellen Sie sicher, dass die HTTP-Erweiterung installiert ist
if (!class_exists('http\Client')) {
    die("Die PHP-Erweiterung 'pecl_http' ist nicht installiert.");
}
eco
$client = new http\Client;
$request = new http\Client\Request;

$request->setRequestUrl('https://v3.football.api-sports.io/leagues');
$request->setRequestMethod('GET');
$request->setHeaders(array(
    'x-rapidapi-host' => 'v3.football.api-sports.io',
    'x-rapidapi-key' => 'ffa54e94150fc112f27aa4d0a36e240a'
));

$client->enqueue($request)->send();
$response = $client->getResponse();

// Überprüfen Sie den HTTP-Statuscode
if ($response->getResponseCode() !== 200) {
    die("API-Anfrage fehlgeschlagen mit Statuscode: " . $response->getResponseCode());
}
//print_r($response->getBody());
return $response->getBody();
?>














// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://v3.football.api-sports.io/leagues',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'GET',
//   CURLOPT_HTTPHEADER => array(
//     'x-rapidapi-key: 0175d8f1cb54f362e35dc7eb59ad0275',
//     'x-rapidapi-host: v3.football.api-sports.io'
//   ),
// ));

// $response = curl_exec($curl);
// curl_close($curl);

// // Die API-Antwort als JSON dekodieren
// $data = json_decode($response, true);

// print_r($data);

// // Die dekodierten Daten zurückgeben
// return $data;

?>



