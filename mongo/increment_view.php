<?php
require_once 'config.php';

function incrementAnimalView($animalId, $prenom) {
    $client = getMongoClient();
    $collection = $client->zoo->consultations;

    $collection->updateOne(
        ['animal_id' => (int)$animalId],
        [
            '$inc' => ['compteur' => 1],
            '$setOnInsert' => ['prenom' => $prenom]
        ],
        ['upsert' => true]
    );
}
