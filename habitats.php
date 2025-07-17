<?php
require_once 'config.php';



if (!$pdo) {
    die("Erreur de connexion à la base de données");
}

// Récupérer tous les habitats
$stmt = $pdo->query("SELECT id, name AS name, image, description FROM habitats ORDER BY name");
$habitats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Habitats - Zoo Naturel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        .habitat-card {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .habitat-card:hover {
            transform: scale(1.05);
        }
        .habitat-image {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
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
        <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link active" href="habitats.php">Habitats</a></li>
        <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div id="sidebar" class="sidebar bg-dark text-white">
  <nav class="nav flex-column p-3">
    <a class="nav-link text-white" href="index.php">Accueil</a>
    <a class="nav-link text-white" href="animaux.php">Animaux</a>
    <a class="nav-link text-white" href="habitats.php">Habitats</a>
    <a class="nav-link text-white" href="services.php">Services</a>
    <a class="nav-link text-white" href="connexion.php">Connexion</a>
    <a class="nav-link text-white" href="contact.html">Contact</a>
  </nav>
</div>

<header class="bg-success text-white text-center py-5 mt-5">
  <h1>Nos habitats</h1>
  <p>Découvrez les différents habitats de nos animaux</p>
</header>

<main class="container py-4" style="padding-top: 60px;">
  <section class="mb-5">
    <div class="row">
      <?php if (count($habitats) === 0): ?>
          <p>Aucun habitat trouvé.</p>
      <?php else: ?>
        <?php foreach ($habitats as $habitat): ?>
          <div class="col-md-4 mb-3">
            <a href="habitat_detail.php?id=<?= $habitat['id'] ?>" class="text-decoration-none text-dark">
              <div class="card habitat-card h-100">
                <?php if (!empty($habitat['image'])): ?>
                  <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="<?= htmlspecialchars($habitat['name']) ?>" class="card-img-top habitat-image" />
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($habitat['name']) ?></h5>
                  <?php if (!empty($habitat['description'])): ?>
                    <p class="card-text"><?= htmlspecialchars($habitat['description']) ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
</main>

<footer class="bg-dark text-white text-center py-3">
  &copy; 2025 Zoo Naturel. Tous droits réservés.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

