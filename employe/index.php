<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'employe') {
    header('Location: ../connexion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Employé</title>
</head>
<body>
    <h1>Bienvenue Employé, <?= htmlspecialchars($_SESSION['user']['username']) ?> !</h1>
    <p>Vous êtes connecté en tant qu'employé.</p>
    <a href="../logout.php">Déconnexion</a>
</body>
</html>
