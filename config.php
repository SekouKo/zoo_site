<?php
// Vérifie si on est sur Heroku (car ces variables sont définies dans l'environnement Heroku)
if (getenv("DB_HOST")) {
    $host = getenv("DB_HOST");
    $port = getenv("DB_PORT");
    $db   = getenv("DB_NAME");
    $user = getenv("DB_USER");
    $pass = getenv("DB_PASS");
} else {
    // Sinon on est en local : paramètres de XAMPP
    $host = "localhost"; // 
    $port = "3306";
    $db   = "zoo_db"; // 🔁 remplace par le vrai nom
    $user = "root";
    $pass = ""; // mot de passe vide dans XAMPP
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    // echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
?>


