<?php

/*

// Verbindung zur Datenbank herstellen
require_once('config.php');

try {
    // PDO-Verbindung herstellen
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // SQL-Anweisung für das Abrufen von Spieler-Daten
    $sql = "SELECT p.name AS player_name, p.goals AS total_goals, c.name AS country_name 
            FROM players p 
            JOIN countries c ON p.country_code = c.code 
            ORDER BY p.goals DESC"; // Order by the highest number of goals

    // Bereite die SQL-Anweisung vor
    $stmt = $pdo->prepare($sql);
    // Führe die Abfrage aus
    $stmt->execute();

    // Daten abrufen
    $topScorers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Setze den Content-Type auf JSON
    header('Content-Type: application/json');

    // Überprüfen, ob Ergebnisse vorhanden sind
    if ($topScorers) {
        // Gebe die Daten als JSON aus
        echo json_encode($topScorers);
    } else {
        echo json_encode(['message' => 'Keine Spieler gefunden.']);
    }

} catch (\PDOException $e) {
    // Fehlerbehandlung
    http_response_code(500);
    echo json_encode(['error' => 'Datenbankfehler: ' . $e->getMessage()]);
}

*/


require_once __DIR__ . '/config.php'; // Include database configuration

// Specify the season you want to retrieve data for
$season = 2022; // Change this as needed

try {
    // Create a new PDO instance with the configuration from config.php
    $pdo = new PDO($dsn, $username, $password, $options);

    // SQL query to retrieve player names, goals, and nationalities
    $sql = "
        SELECT name, goals, nationality
        FROM players
        WHERE season = :season
    ";

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['season' => $season]);

    // Fetch all results
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate total goals per nationality
    $nationalityGoals = [];
    foreach ($players as $player) {
        $nationality = $player['nationality'];
        $goals = $player['goals'];

        // Initialize the nationality if not already set
        if (!isset($nationalityGoals[$nationality])) {
            $nationalityGoals[$nationality] = 0;
        }

        // Add the player's goals to the respective nationality's total
        $nationalityGoals[$nationality] += $goals;
    }

    // Sort nationalities by total goals scored (highest first)
    arsort($nationalityGoals);

    // Return the sorted results as JSON
    echo json_encode($nationalityGoals);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>



