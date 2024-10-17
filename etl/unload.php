<?php


require_once __DIR__ . '/config.php'; // Include database configuration

// Specify the season you want to retrieve data for, default to the latest season
$season = isset($_GET['season']) ? $_GET['season'] : 2022; // Default season if none is provided

try {
    // Create a new PDO instance with the configuration from config.php
    $pdo = new PDO($dsn, $username, $password, $options);

    // SQL query to retrieve player names, goals, and nationalities for the specific season
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

    // SQL query to fetch distinct seasons from the players table
    $seasonsSql = "SELECT DISTINCT season FROM players ORDER BY season ASC";

    // Prepare and execute the SQL statement for seasons
    $seasonsStmt = $pdo->prepare($seasonsSql);
    $seasonsStmt->execute();
    $availableSeasons = $seasonsStmt->fetchAll(PDO::FETCH_COLUMN); // Fetch only the season column

    // Prepare the response
    $response = [
        'seasons' => $availableSeasons,
        'data' => $nationalityGoals,
        'currentSeason' => $season // Include the current season
    ];

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}



?>








