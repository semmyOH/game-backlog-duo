<?php

// Eenmalige lokale inrichting; bestaande instellingen en data blijven staan.
$root = dirname(__DIR__);
$envPath = $root.'/.env';
$database = $root.'/database/database.sqlite';
$template = $root.'/database/template.sqlite';

if (! is_file($envPath)) {
    if (! copy($root.'/.env.example', $envPath)) {
        throw new RuntimeException('Kan .env niet aanmaken. Controleer de schrijfrechten.');
    }
    echo ".env aangemaakt.\n";
}

$env = file_get_contents($envPath);
if (preg_match('/^APP_KEY=\s*$/m', $env)) {
    $key = 'base64:'.base64_encode(random_bytes(32));
    $env = preg_replace('/^APP_KEY=\s*$/m', 'APP_KEY='.$key."\n", $env, 1);
    if (file_put_contents($envPath, $env) === false) {
        throw new RuntimeException('Kan de lokale applicatiesleutel niet opslaan.');
    }
    echo "Eigen applicatiesleutel aangemaakt.\n";
} elseif (! preg_match('/^APP_KEY=.+$/m', $env)) {
    throw new RuntimeException('APP_KEY ontbreekt in .env. Voeg APP_KEY= toe en voer composer run setup-local uit.');
}

if (! is_file($database)) {
    if (! is_file($template) || ! copy($template, $database)) {
        throw new RuntimeException('De voorbereide database ontbreekt of is niet kopieerbaar.');
    }
    echo "Eigen database aangemaakt uit database/template.sqlite.\n";
}
echo "Lokale instellingen gereed. Bestaande gegevens zijn behouden.\n";
