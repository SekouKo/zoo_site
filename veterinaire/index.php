<?php
session_start();

// Vérifier que l'utilisateur est bien un vétérinaire
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'veto') {
    header('Location: ../../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Vétérinaire</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <h1>Bienvenue, Vétérinaire</h1>

    <nav>
        <ul>
            <li><a href="comptes_rendus/index.php">Gérer les comptes rendus</a></li>
            <li><a href="consommation_animaux.php">Voir la consommation des animaux</a></li>
            <li><a href="commentaires_habitats.php">Commenter les habitats</a></li>
        </ul>
    </nav>
</body>
</html>
