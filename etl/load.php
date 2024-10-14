<?php

// Verbindung zur Datenbank herstellen
require_once('config.php');

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Daten aus transform.php laden
$data = include('transform.php'); // Now it returns an array with leagues, countries, and seasons
$leagues = $data['leagues'];
$countries = $data['countries'];
$seasons = $data['seasons'];
$top_scorers = $data['top_scorers'];
$players = $data['players'];

// SQL-Anweisung für das Einfügen von Liga-Daten
$sql_leagues = "INSERT INTO leagues (id, name, type, logo) VALUES (:id, :name, :type, :logo) 
                ON DUPLICATE KEY UPDATE name = :name_update, type = :type_update, logo = :logo_update";
$stmt_leagues = $pdo->prepare($sql_leagues);

// Daten in die Tabelle 'leagues' einfügen
foreach ($leagues as $league) {
    $stmt_leagues->execute([
        ':id' => $league['id'],
        ':name' => $league['name'],
        ':type' => $league['type'],
        ':logo' => $league['logo'],
        ':name_update' => $league['name'], // Update parameters
        ':type_update' => $league['type'],
        ':logo_update' => $league['logo']
    ]);
}

// SQL-Anweisung für das Einfügen von Länder-Daten
$sql_countries = "INSERT INTO countries (name, code, flag) VALUES (:name, :code, :flag)
                  ON DUPLICATE KEY UPDATE flag = :flag_update";
$stmt_countries = $pdo->prepare($sql_countries);

// Länder in die Tabelle 'countries' einfügen
foreach ($countries as $country) {
    $stmt_countries->execute([
        ':name' => $country['name'],
        ':code' => $country['code'],
        ':flag' => $country['flag'],
        ':flag_update' => $country['flag'] // Update parameter
    ]);
}

// SQL-Anweisung für das Einfügen von Saison-Daten
$sql_seasons = "INSERT INTO seasons (league_id, year, start, end, current) VALUES (:league_id, :year, :start, :end, :current)
                ON DUPLICATE KEY UPDATE start = :start_update, end = :end_update, current = :current_update";
$stmt_seasons = $pdo->prepare($sql_seasons);

// Saison-Daten in die Tabelle 'seasons' einfügen
foreach ($seasons as $season) {
    $stmt_seasons->execute([
        ':league_id' => $season['league_id'],
        ':year' => $season['year'],
        ':start' => $season['start'],
        ':end' => $season['end'],
        ':current' => $season['current'],
        ':start_update' => $season['start'], // Update parameters
        ':end_update' => $season['end'],
        ':current_update' => $season['current']
    ]);
}

// SQL-Anweisung für das Einfügen von Top-Scorers-Daten
$sql_top_scorers = "INSERT INTO top_scorers (player_id, player_name, goals, team_id) 
                    VALUES (:player_id, :player_name, :goals, :team_id)
                    ON DUPLICATE KEY UPDATE goals = :goals_update";
$stmt_top_scorers = $pdo->prepare($sql_top_scorers);

// Top Scorers in die Tabelle 'top_scorers' einfügen
foreach ($top_scorers as $top_scorer) {
    $stmt_top_scorers->execute([
        ':player_id' => $top_scorer['player_id'],
        ':player_name' => $top_scorer['player_name'],
        ':goals' => $top_scorer['goals'],
        ':team_id' => $top_scorer['team_id'],
        ':goals_update' => $top_scorer['goals']
    ]);
}



// SQL-Anweisung für das Einfügen von Spieler-Daten
$sql_players = "INSERT INTO players (player_name, team_name) VALUES (:player_name, :team_name)
                ON DUPLICATE KEY UPDATE team_name = :team_name_update";
$stmt_players = $pdo->prepare($sql_players);

// Spieler in die Tabelle 'players' einfügen
foreach ($players as $player) {
    $stmt_players->execute([
        ':player_name' => $player['player_name'],
        ':team_name' => $player['team_name'],
        ':team_name_update' => $player['team_name']
    ]);
}


echo "Daten erfolgreich in die Tabellen 'leagues', 'countries', 'seasons', 'top_scorers' und 'players' eingefügt.";

?>
