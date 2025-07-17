<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
</head>
<body>
    <h1>Bienvenue Administrateur, <?= htmlspecialchars($_SESSION['user']['username']) ?> !</h1>
    <p>Vous êtes connecté en tant qu'administrateur.</p>
    <a href="../logout.php">Déconnexion</a>
</body>
</html>
