<?php

/*

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('config.php');

// JSON data from extract_players.php
$jsonData = include('extract_players.php');

// Decode the JSON data into an associative array
$data = json_decode($jsonData, true);

// Debugging raw API data
echo "<pre>";
print_r($data); // This shows the raw API data
echo "</pre>";

// Check if the JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Fehler beim Dekodieren der JSON-Daten: " . json_last_error_msg());
}

// Transformed data
$transformedData = [];

if (isset($data['response']) && is_array($data['response'])) {
    foreach ($data['response'] as $playersData) {
        // Check if the data structure is correct
        if (isset($playersData['player']) && isset($playersData['statistics'][0]['goals']) && isset($playersData['season'])) {
            $transformedData[] = [
                'player_id_api' => $playersData['player']['id'], // Store player ID from the API
                'player_name' => $playersData['player']['name'],
                'player_nationality' => $playersData['player']['nationality'],
                'player_goals' => $playersData['statistics'][0]['goals']['total'] ?? 0,
                'player_assists' => $playersData['statistics'][0]['goals']['assists'] ?? 0,
                'season' => $playersData['season']  // Add the season data
            ];
        }
    }
} else {
    die("Unerwartete API-Antwort: 'response' wurde nicht gefunden.");
}

// Debugging transformed data before insertion
echo "<pre>";
print_r($transformedData); // Check if 2019 data appears correctly
echo "</pre>";

// Prepare SQL Insert Statement
$insertSql = "INSERT INTO `players` (`name`, `nationality`, `goals`, `assists`, `player_ID_API`, `season`) 
              VALUES (?,?,?,?,?,?)";

$selectSql = "SELECT COUNT(*) FROM `players` WHERE `player_ID_API` = ? AND `season` = ?";

try {
    // Connect to the database (adjust with your credentials)
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements
    $insertStmt = $pdo->prepare($insertSql);
    $selectStmt = $pdo->prepare($selectSql);

    // Insert data into the database
    foreach ($transformedData as $dataRow) {
        // Check if the combination of player_ID_API and season exists
        $selectStmt->execute([$dataRow['player_id_api'], $dataRow['season']]);
        $exists = $selectStmt->fetchColumn(); // Get the count of existing records

        if ($exists == 0) {
            // If it doesn't exist, insert the new record
            $insertStmt->execute([
                $dataRow['player_name'],
                $dataRow['player_nationality'],
                $dataRow['player_goals'],
                $dataRow['player_assists'],
                $dataRow['player_id_api'], // Use the player_ID_API from the API
                $dataRow['season']  // Insert the season data
            ]);
        }
    }

    echo "Datensätze erfolgreich eingefügt!";
} catch (PDOException $e) {
    echo "Fehler bei der Datenbankoperation: " . $e->getMessage();
}

*/



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('config.php');

// JSON data from extract_players.php
$jsonData = include('extract_players.php');

// Decode the JSON data into an associative array
$data = json_decode($jsonData, true);

// Check if the JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error decoding JSON data: " . json_last_error_msg());
}

// Transformed data
$transformedData = [];

if (isset($data['response']) && is_array($data['response'])) {
    foreach ($data['response'] as $playersData) {
        // Check if the data structure is correct
        if (isset($playersData['player']) && isset($playersData['statistics'][0]['goals']) && isset($playersData['season'])) {
            $transformedData[] = [
                'player_id_api' => $playersData['player']['id'], // Store player ID from the API
                'player_name' => $playersData['player']['name'],
                'player_nationality' => $playersData['player']['nationality'],
                'player_goals' => $playersData['statistics'][0]['goals']['total'] ?? 0,
                'player_assists' => $playersData['statistics'][0]['goals']['assists'] ?? 0,
                'season' => $playersData['season']  // Add the season data
            ];
        }
    }
} else {
    die("Unexpected API response: 'response' not found.");
}

// Prepare SQL statements
$updateSql = "UPDATE `players` SET `name` = ?, `nationality` = ?, `goals` = ?, `assists` = ? 
               WHERE `player_ID_API` = ? AND `season` = ?";

$insertSql = "INSERT INTO `players` (`name`, `nationality`, `goals`, `assists`, `player_ID_API`, `season`) 
              VALUES (?,?,?,?,?,?)";

$selectSql = "SELECT COUNT(*) FROM `players` WHERE `player_ID_API` = ? AND `season` = ?";

try {
    // Connect to the database (adjust with your credentials)
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statements
    $updateStmt = $pdo->prepare($updateSql);
    $insertStmt = $pdo->prepare($insertSql);
    $selectStmt = $pdo->prepare($selectSql);

    // Insert or update data into the database
    foreach ($transformedData as $dataRow) {
        // Check if the combination of player_ID_API and season exists
        $selectStmt->execute([$dataRow['player_id_api'], $dataRow['season']]);
        $exists = $selectStmt->fetchColumn(); // Get the count of existing records

        if ($exists > 0) {
            // If it exists, update the record
            $updateStmt->execute([
                $dataRow['player_name'],
                $dataRow['player_nationality'],
                $dataRow['player_goals'],
                $dataRow['player_assists'],
                $dataRow['player_id_api'], // Use the player_ID_API from the API
                $dataRow['season']  // Update the season data
            ]);
        } else {
            // If it doesn't exist, insert the new record
            $insertStmt->execute([
                $dataRow['player_name'],
                $dataRow['player_nationality'],
                $dataRow['player_goals'],
                $dataRow['player_assists'],
                $dataRow['player_id_api'], // Use the player_ID_API from the API
                $dataRow['season']  // Insert the season data
            ]);
        }
    }

    echo "Records successfully inserted/updated!";
} catch (PDOException $e) {
    echo "Database operation error: " . $e->getMessage();
}




?>
