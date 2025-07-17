<?php
require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

function getMongoClient() {
    return new Client("mongodb://localhost:27017");
}
