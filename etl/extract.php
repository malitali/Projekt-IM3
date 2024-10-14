<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://v3.football.api-sports.io/leagues',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-rapidapi-key: 0175d8f1cb54f362e35dc7eb59ad0275',
    'x-rapidapi-host: v3.football.api-sports.io'
  ),
));

$response = curl_exec($curl);
curl_close($curl);

// Die API-Antwort als JSON dekodieren
$data = json_decode($response, true);

// print_r($data);

// Die dekodierten Daten zurückgeben
return $data;

?>
