<?php
$host = 'localhost';
$db   = 'zoo_db';
$user = 'root';
$pass = ''; // mot de passe vide par défaut sur XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Message d'erreur lisible
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
