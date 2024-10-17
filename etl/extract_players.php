
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!class_exists('http\Client')) {
    die("The PHP extension 'pecl_http' is not installed.");
}

$seasons = [2019, 2020, 2021, 2022, 2023, 2024];  // Define the seasons you want to fetch data for
$league = 207;  // Define the league

$allData = [];

foreach ($seasons as $season) {
    // Create new http\Client and http\Request objects for each iteration
    $client = new http\Client;
    $request = new http\Client\Request;

    $request->setRequestMethod('GET');
    $request->setRequestUrl('https://v3.football.api-sports.io/players/topscorers');
    $request->setQuery(new http\QueryString(array(
        'season' => $season,
        'league' => $league
    )));
    
    $request->setHeaders(array(
        'x-rapidapi-host' => 'v3.football.api-sports.io',
        'x-rapidapi-key' => 'ffa54e94150fc112f27aa4d0a36e240a'  // Replace with your actual API key
    ));

    // Send the request and get the response
    $client->enqueue($request)->send();
    $response = $client->getResponse();

    // Check if the response is successful
    if ($response->getResponseCode() !== 200) {
        die("API request failed with status code: " . $response->getResponseCode());
    }
    
    // Decode the API response into an array
    $responseData = json_decode($response->getBody(), true);
    
    // Add the season to the data
    if (isset($responseData['response'])) {
        foreach ($responseData['response'] as &$playerData) {
            $playerData['season'] = $season;  // Add the current season to each player's data
        }
        // Merge with allData
        $allData = array_merge($allData, $responseData['response']);
    }
}

print_r($allData);

// Return all the combined data
return json_encode(['response' => $allData]);


?>