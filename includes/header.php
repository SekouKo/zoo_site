<?php
// includes/header.php
session_start();

// Optionnel : redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php'); // adapte ce chemin si besoin
    exit;
}

// Récupération des infos utilisateur
$email = htmlspecialchars($_SESSION['user']['email']);
$role = ucfirst(htmlspecialchars($_SESSION['user']['role'])); // admin, employe, veterinaire
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Zoo - Espace <?= $role ?></title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: #fff;
            margin-left: 15px;
            text-decoration: none;
        }

        .user-info {
            font-size: 0.9em;
            background-color: #444;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<nav>
    <div><strong>Zoo 🦁</strong> — Espace <?= $role ?></div>
    <div class="user-info">
        Connecté en tant que : <?= $role ?> (<?= $email ?>)
        | <a href="/logout.php">Déconnexion</a>
    </div>
</nav>
