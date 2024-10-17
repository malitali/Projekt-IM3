<?php




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

echo "<pre>";
print_r($transformedData);
echo "</pre>";

// Prepare SQL Insert Statement
$sql = "INSERT INTO `players` (`name`, `nationality`, `goals`, `assists`, `player_ID_API`, `season`) 
        VALUES (?,?,?,?,?,?)
        ON DUPLICATE KEY UPDATE 
            `name` = VALUES(`name`),
            `nationality` = VALUES(`nationality`),
            `goals` = VALUES(`goals`),
            `assists` = VALUES(`assists`),
            `season` = VALUES(`season`)"; // Update season in case of conflicts

try {
    // Connect to the database (adjust with your credentials)
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL query
    $stmt = $pdo->prepare($sql);

    // Insert data into the database
    foreach ($transformedData as $dataRow) {
        $stmt->execute([
            $dataRow['player_name'],
            $dataRow['player_nationality'],
            $dataRow['player_goals'],
            $dataRow['player_assists'],
            $dataRow['player_id_api'], // Use the player_ID_API from the API
            $dataRow['season']  // Insert the season data
        ]);
    }

    echo "Datensätze erfolgreich eingefügt oder aktualisiert!";
} catch (PDOException $e) {
    echo "Fehler bei der Datenbankoperation: " . $e->getMessage();
}




?>



