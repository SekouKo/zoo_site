<?php
require_once 'config.php';

// Récupérer l’ID depuis l’URL (GET)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo "Animal non trouvé.";
    exit;
}

// Requête pour récupérer l'animal et son habitat
$sql = "SELECT a.id, a.name, a.race, a.image, a.description, h.name AS habitat_name
        FROM animaux a
        LEFT JOIN habitats h ON a.habitat_id = h.id
        WHERE a.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$animal = $stmt->fetch();

if (!$animal) {
    echo "Animal non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Détails de <?= htmlspecialchars($animal['name']) ?> - Zoo Naturel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Zoo Naturel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="animaux.php">Animaux</a></li>
        <li class="nav-item"><a class="nav-link" href="habitats.php">Habitats</a></li>
        <li class="nav-item"><a class="nav-link" href="services.html">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-5" style="padding-top: 80px;">
  <div class="card mx-auto" style="max-width: 600px;">
    <?php if (!empty($animal['image'])): ?>
      <img src="<?= htmlspecialchars($animal['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($animal['name']) ?>">
    <?php endif; ?>
    <div class="card-body">
      <h2 class="card-title"><?= htmlspecialchars($animal['name']) ?></h2>
      <h5 class="card-subtitle mb-3 text-muted"><?= htmlspecialchars($animal['race']) ?></h5>
      <?php if (!empty($animal['habitat_name'])): ?>
        <p><strong>Habitat :</strong> <?= htmlspecialchars($animal['habitat_name']) ?></p>
      <?php endif; ?>
      <?php if (!empty($animal['description'])): ?>
        <p><?= nl2br(htmlspecialchars($animal['description'])) ?></p>
      <?php endif; ?>
      <a href="animaux.php" class="btn btn-primary mt-3">Retour à la liste des animaux</a>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


