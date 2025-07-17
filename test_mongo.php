<?php
require 'vendor/autoload.php'; // charge le package mongodb

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");

    $dbs = $client->listDatabases();

    echo "✅ Connexion réussie à MongoDB !\n";
    foreach ($dbs as $db) {
        echo "- " . $db->getName() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur de connexion à MongoDB: " . $e->getMessage() . "\n";
}
