<?php

// Datenbankverbindungsparameter
$host = 'ny9kvf.myd.infomaniak.com';
$dbname = 'ny9kvf_im3';
$username = 'ny9kvf_im3';
$password = 'Passwort.6!!';

// DSN (Datenquellenname) für PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

// Optionen für PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Aktiviert die Ausnahmebehandlung für Datenbankfehler
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Legt den Standard-Abrufmodus auf assoziatives Array fest
    PDO::ATTR_EMULATE_PREPARES => false, // Deaktiviert die Emulation vorbereiteter Anweisungen, für bessere Leistung
];

?>