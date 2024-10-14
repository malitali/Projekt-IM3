<?php
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
?>
