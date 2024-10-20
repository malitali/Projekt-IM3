<?php

// Fehleranzeige aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('config.php');

// JSON-Daten aus dem extract.php Skript abrufen
$jsonData = include('extract.php');

// JSON-Daten dekodieren
$data = json_decode($jsonData, true);

// Überprüfen, ob die Daten erfolgreich dekodiert wurden
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Fehler beim Dekodieren der JSON-Daten: " . json_last_error_msg());
}

// Transformierte Daten vorbereiten
$transformedData = [];

// Überprüfen, ob die benötigten Daten vorhanden sind
if (isset($data['response']) && is_array($data['response'])) {
    foreach ($data['response'] as $leagueData) {


        // Überprüfen, ob die Struktur der API-Daten korrekt ist
        if (isset($leagueData['league']) && isset($leagueData['country'])) {
            $transformedData[] = [
                'league_id' => $leagueData['league']['id'],
                'league_name' => $leagueData['league']['name'],
                'league_type' => $leagueData['league']['type'],  // Beispielhaft den ersten Season-Eintrag verwenden
                'country_name' => $leagueData['country']['name'],
                'country_code' => $leagueData['country']['code'],
                 ];
        }
    }
} else {
    die("Unerwartete API-Antwort: 'response' wurde nicht gefunden.");
}
/* echo "<pre>";
print_r($transformedData);
echo "</pre>"; */
// SQL Insert Statement vorbereiten
$sql = "INSERT INTO `leagues` (`id`, `name`, `type`, `country_name`, `country_code`) VALUES (?,?,?,?,?)";

try {
    // Verbindung zur Datenbank herstellen (Datenbankname, Benutzername und Passwort anpassen)
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL Query vorbereiten
    $stmt = $pdo->prepare($sql);

    // Daten in die Datenbank einfügen
    foreach ($transformedData as $dataRow) {
        $stmt->execute([
            $dataRow['league_id'],
            $dataRow['league_name'],
            $dataRow['league_type'],
            $dataRow['country_name'],
            $dataRow['country_code']
        ]);
    }

    echo "Datensätze erfolgreich eingefügt!";
} catch (PDOException $e) {
    echo "Fehler bei der Datenbankoperation: " . $e->getMessage();
}
?>

