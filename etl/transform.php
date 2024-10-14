<?php
// Daten aus extract.php laden
$data = include('extract.php');

// Überprüfen, ob die API-Antwort korrekt ist
if (!$data || !isset($data['response'])) {
    die("Fehler beim Abrufen der Daten.");
}

// Leere Arrays für die Transformation
$leagues = [];
$countries = [];
$seasons = [];
$top_scorers = [];
$players = [];

// Durchlaufen der Ligen-Daten
foreach ($data['response'] as $item) {
    $league = $item['league'];
    $country = $item['country'];
    $seasonsData = $item['seasons'];
    
    // Liga-Daten vorbereiten
    $leagues[] = [
        'id' => $league['id'],
        'name' => $league['name'],
        'type' => $league['type'],
        'logo' => $league['logo']
    ];
    
    // Länder-Daten vorbereiten (vermeide Duplikate)
    $countries[] = [
        'name' => $country['name'],
        'code' => $country['code'],
        'flag' => $country['flag']
    ];
    
    // Saison-Daten vorbereiten
    foreach ($seasonsData as $season) {
        $seasons[] = [
            'league_id' => $league['id'],
            'year' => $season['year'],
            'start' => $season['start'],
            'end' => $season['end'],
            'current' => $season['current']
        ];
    }
    
    // Top Scorers verarbeiten
    if (isset($item['top_scorers'])) {
        foreach ($item['top_scorers'] as $top_scorer) {
            $top_scorers[] = [
                'player_id' => $top_scorer['player_id'],
                'player_name' => $top_scorer['player_name'],
                'goals' => $top_scorer['goals'],
                'team_id' => $top_scorer['team_id'],
                'team_name' => $top_scorer['team_name']
            ];
        }
    }
    
    // Spieler verarbeiten
    if (isset($item['players'])) {
        foreach ($item['players'] as $player) {
            $players[] = [
                'player_id' => $player['player_id'],
                'player_name' => $player['player_name'],
                'team_id' => $player['team_id'],
                'team_name' => $player['team_name']
            ];
        }
    }
}

// Optional: Überprüfen der transformierten Daten
// echo "<pre>";
// print_r($leagues);
// print_r($countries);
// print_r($seasons);
// print_r($top_scorers);
print_r($players);
// echo "</pre>";

// Rückgabe der transformierten Daten
return [
    'leagues' => $leagues,
    'countries' => array_unique($countries, SORT_REGULAR), // Use unique countries
    'seasons' => array_unique($seasons, SORT_REGULAR), // Use unique seasons
    'top_scorers' => $top_scorers,
    'players' => $players
];



?>
