<?php
require_once 'config.php';

// Requête pour récupérer les animaux avec leur habitat associé
$stmt = $pdo->query("SELECT a.id, a.name, a.race, a.image, h.name AS habitat_name 
                     FROM animaux a 
                     LEFT JOIN habitats h ON a.habitat_id = h.id 
                     ORDER BY a.name");
$animaux = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Animaux - Zoo Naturel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        .animal-card {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .animal-card:hover {
            transform: scale(1.05);
        }
        .animal-image {
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
        <li class="nav-item"><a class="nav-link" href="habitats.php">Habitats</a></li>
        <li class="nav-item"><a class="nav-link active" href="animaux.php">Animaux</a></li>
        <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="bg-primary text-white text-center py-5 mt-5">
  <h1>Nos animaux</h1>
  <p>Découvrez les animaux présents dans notre zoo</p>
</header>

<main class="container py-4" style="padding-top: 60px;">
  <section class="mb-5">
    <div class="row">
      <?php if (count($animaux) === 0): ?>
          <p>Aucun animal trouvé.</p>
      <?php else: ?>
        <?php foreach ($animaux as $animal): ?>
          <div class="col-md-4 mb-3">
            <div class="card animal-card h-100">
              <?php if (!empty($animal['image'])): ?>
                <a href="animal_details.php?id=<?= $animal['id'] ?>">
                  <img src="<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" class="card-img-top animal-image" />
                </a>
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title">
                  <a href="animal_details.php?id=<?= $animal['id'] ?>" class="text-decoration-none text-dark">
                    <?= htmlspecialchars($animal['name']) ?>
                  </a>
                </h5>
                <?php if (!empty($animal['habitat_name'])): ?>
                  <p><strong>Habitat :</strong> <?= htmlspecialchars($animal['habitat_name']) ?></p>
                <?php endif; ?>
              </div>
            </div>
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
