<?php

// Transformations-Skript als '230_transform.php' einbinden
$jsonData = include('transform.php');

// Dekodiert die JSON-Daten zu einem Array
$dataArray = json_decode($jsonData, true);

require_once 'config.php'; // Bindet die Datenbankkonfiguration ein

try {
    // Erstellt eine neue PDO-Instanz mit der Konfiguration aus config.php
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // SQL-Query mit Platzhaltern für das Einfügen von Ligen-Daten (leagues)
    $sqlLeagues = "INSERT INTO leagues (id, name, type, logo, country_id) VALUES (?, ?, ?, ?, ?)";

    // SQL-Query mit Platzhaltern für das Einfügen von Ländern (countries)
    $sqlCountries = "INSERT INTO countries (id, name, code, flag) VALUES (?, ?, ?, ?)";

    // Bereitet die SQL-Anweisungen vor
    $stmtLeagues = $pdo->prepare($sqlLeagues);
    $stmtCountries = $pdo->prepare($sqlCountries);

    // Fügt die Ligen und Länder-Daten aus dem Array in die Datenbank ein
    foreach ($dataArray['response'] as $item) {
        // Zuerst die Länderdaten einfügen
        $stmtCountries->execute([
            $item['country']['id'], // Länder-ID
            $item['country']['name'], // Name des Landes
            $item['country']['code'], // Länder-Code
            $item['country']['flag'] // Länder-Flagge
        ]);

        // Dann die Ligen-Daten einfügen, wobei die Country-ID referenziert wird
        $stmtLeagues->execute([
            $item['league']['id'], // Liga-ID
            $item['league']['name'], // Name der Liga
            $item['league']['type'], // Typ der Liga (z.B. "Cup" oder "League")
            $item['league']['logo'], // Logo der Liga
            $item['country']['id'] // Verweis auf die Länder-ID (Foreign Key)
        ]);
    }

    echo "Daten erfolgreich eingefügt.";
} catch (PDOException $e) {
    die("Verbindung zur Datenbank konnte nicht hergestellt werden: " . $e->getMessage());
}