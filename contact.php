<?php
session_start();

$message = $_SESSION['contact_message'] ?? '';
$success = $_SESSION['contact_success'] ?? false;

unset($_SESSION['contact_message'], $_SESSION['contact_success']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Contact - Zoo Naturel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Zoo Naturel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="bg-success text-white text-center py-5 mt-5">
  <h1>Contactez le Zoo</h1>
  <p>Une question ? Un message ? Nous sommes à votre écoute.</p>
</header>

<main class="container py-5" style="max-width: 600px;">
  <?php if ($message): ?>
    <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <?php if (!$success): ?>
  <form method="POST" action="traitement_contact.php" novalidate>
    <div class="mb-3">
      <label for="titre" class="form-label">Titre</label>
      <input type="text" class="form-control" id="titre" name="titre" required />
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Votre adresse email</label>
      <input type="email" class="form-control" id="email" name="email" required />
    </div>

    <button type="submit" class="btn btn-success w-100">Envoyer</button>
  </form>
  <?php endif; ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-5">
  &copy; 2025 Zoo Naturel. Tous droits réservés.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

