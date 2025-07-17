<?php
// 🔧 Affichage des erreurs pour debug (à désactiver en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php'; // Connexion à la base avec PDO

// ✅ Redirection si l'utilisateur est déjà connecté avec rôle valide
if (isset($_SESSION['user']) && isset($_SESSION['user']['role'])) {
    $role = $_SESSION['user']['role'];

    switch ($role) {
        case 'admin':
            header('Location: admin/index.php');
            break;
        case 'veto': // ✅ doit correspondre exactement à la BDD
            header('Location: veterinaire/index.php');
            break;
        case 'employe':
            header('Location: employe/index.php');
            break;
        default:
            session_destroy();
            header('Location: connexion.php');
            exit;
    }
    exit;
}


// ✅ Gestion des erreurs depuis traitement_connexion.php
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Zoo Naturel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
</head>
<body>

<!-- ✅ NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Zoo Naturel</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <li class="nav-item"><a href="connexion.php" class="nav-link active">Connexion</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ EN-TÊTE -->
<header class="bg-success text-white text-center py-5 mt-5">
    <h1>Connexion</h1>
    <p>Accès réservé au personnel du Zoo</p>
</header>

<!-- ✅ CONTENU -->
<main class="container py-5">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h2 class="text-center mb-4">Se connecter</h2>
            <form method="POST" action="traitement_connexion.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Connexion</button>
            </form>
        </div>
    </div>
</main>

<!-- ✅ PIED DE PAGE -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; 2025 Zoo Naturel. Tous droits réservés.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>







