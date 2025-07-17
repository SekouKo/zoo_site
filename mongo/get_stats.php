<?php
require_once 'config.php';

function getAnimalStats() {
    $client = getMongoClient();
    $collection = $client->zoo->consultations;

    return $collection->find([], ['sort' => ['compteur' => -1]]);
}
