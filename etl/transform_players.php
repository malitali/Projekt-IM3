<?php

// Fehleranzeige aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('config.php');

// JSON-Daten aus dem extract.php Skript abrufen
$data = include('extract_players.php');

print_r($data);

// JSON-Daten dekodieren
// $data = json_decode($jsonData, true);

// Überprüfen, ob die Daten erfolgreich dekodiert wurden
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Fehler beim Dekodieren der JSON-Daten: " . json_last_error_msg());
}

// Transformierte Daten vorbereiten
$transformedData = [];


echo "<pre>";
print_r($transformedData);
echo "</pre>";

// Überprüfen, ob die benötigten Daten vorhanden sind
if (isset($data['response']) && is_array($data['response'])) {
    foreach ($data['response'] as $playersData) {


        // Überprüfen, ob die Struktur der API-Daten korrekt ist
        if (isset($playersData['player']) && isset($playersData['statistics'])) {
            $transformedData[] = [
                'player_id' => $playersData['player']['id'],
                'player_name' => $playersData['player']['name'],
                'player_nationality' => $playersData['player']['nationality'],
                'player_goals' => $playersData['statistics']['goals']['total'],
                'player_assists' => $playersData['statistics']['goals']['assists'],
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
$sql = "INSERT INTO `players` (`id`, `name`, `nationality`, `goals`, `assists`) VALUES (?,?,?,?,?)";

try {
    // Verbindung zur Datenbank herstellen (Datenbankname, Benutzername und Passwort anpassen)
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL Query vorbereiten
    $stmt = $pdo->prepare($sql);

    // Daten in die Datenbank einfügen
    foreach ($transformedData as $dataRow) {
        $stmt->execute([
            $dataRow['player_id'],
            $dataRow['player_name'],
            $dataRow['player_nationality'],
            $dataRow['player_goals'],
            $dataRow['player_assists']
        ]);
    }

    echo "Datensätze erfolgreich eingefügt!";
} catch (PDOException $e) {
    echo "Fehler bei der Datenbankoperation: " . $e->getMessage();
}
?>

