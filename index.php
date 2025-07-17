<?php
require_once 'config.php';


// Récupère les avis validés
$stmt = $pdo->query("SELECT pseudo, contenu FROM avis WHERE valide = 1 ORDER BY id DESC LIMIT 3");
$avis_valides = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Zoo Naturel - Accueil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/menuderoulant.js"></script>
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
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<button class="btn btn-primary" id="sidebarToggle" style="position: fixed; top: 10px; left: 10px; z-index: 1100;">☰ Menu</button>

<div id="sidebar" class="sidebar bg-dark text-white">
  <nav class="nav flex-column p-3">
    <a class="nav-link text-white" href="index.php">Accueil</a>
    <a class="nav-link text-white" href="animaux.php">Animaux</a>
    <a class="nav-link text-white" href="habitats.php">Habitats</a>
    <a class="nav-link text-white" href="services.php">Services</a>
  </nav>
</div>

<div id="content" style="transition: margin-left 0.3s;">
</div>

<header class="bg-success text-white text-center py-5 mt-5">
  <h1>Bienvenue au Zoo Naturel</h1>
  <p>Un lieu de découverte, de respect et de protection de la faune</p>
</header>

<main class="container py-4" style="padding-top: 60px;">
  <section id="presentation" class="mb-5">
    <h2>Présentation du Zoo</h2>
    <p>Le Zoo Naturel vous accueille dans un espace de 20 hectares de nature...</p>
    <div class="row">
      <div class="col-md-6">
        <img src="assets/images/zoo1.jpg" class="img-fluid rounded" alt="Vue du zoo">
      </div>
      <div class="col-md-6">
        <img src="assets/images/zoo2.jpg" class="img-fluid rounded" alt="Enclos naturel">
      </div>
    </div>
  </section>

  <section id="services" class="mb-5">
    <h2 class="mb-4">Services proposés</h2>
    <div class="row text-center">
      <div class="col-md-3">
        <a href="restaurant.html">
          <img src="assets/images/restaurant.jpg" alt="Restaurant" class="img-fluid rounded mb-2" />
          <p>🍽️ Restaurant</p>
        </a>
      </div>
      <div class="col-md-3">
        <a href="boutique.html">
          <img src="assets/images/boutique.jpg" alt="Boutique souvenirs" class="img-fluid rounded mb-2" />
          <p>🎁 Boutique souvenirs</p>
          <p2>Nos boutiques sont pleines de jolis souvenirs pour vous rappeler votre visite.</p2>
        </a>
      </div>
      <div class="col-md-3">
        <a href="visites.html">
          <img src="assets/images/visite-guidee.jpg" alt="Visite guidée" class="img-fluid rounded mb-2" />
          <p>🧭 Visites guidées</p>
        </a>
      </div>
      <div class="col-md-3">
        <a href="animations.html">
          <img src="assets/images/animations.jpg" alt="Animations enfants" class="img-fluid rounded mb-2" />
          <p>🎉 Animations pour enfants</p>
        </a>
      </div>
    </div>
  </section>

  <section id="animaux" class="mb-5">
    <h2>Quelques-uns de nos animaux</h2>
    <div class="row">
      <div class="col-md-4 mb-3">
        <img src="assets/images/lion.jpg" class="img-fluid rounded" alt="Lion">
        <p class="text-center">Lion d’Afrique</p>
      </div>
      <div class="col-md-4 mb-3">
        <img src="assets/images/pingouin.jpg" class="img-fluid rounded" alt="Pingouin">
        <p class="text-center">Pingouin empereur</p>
      </div>
      <div class="col-md-4 mb-3">
        <img src="assets/images/singe.jpg" class="img-fluid rounded" alt="Singe">
        <p class="text-center">Singe capucin</p>
      </div>
    </div>
  </section>

  <!-- ✅ Avis -->
  <section id="avis" class="mb-5">
    <h2 class="mb-4">Avis de nos visiteurs</h2>
    <div class="row g-4">
      <?php if (count($avis_valides) === 0): ?>
        <p>Aucun avis pour le moment.</p>
      <?php else: ?>
        <?php foreach ($avis_valides as $avis): ?>
          <div class="col-md-4">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <p class="card-text">"<?= htmlspecialchars($avis['contenu']) ?>"</p>
                <p class="fw-bold mb-0">— <?= htmlspecialchars($avis['pseudo']) ?></p>
              </div>
              <div class="mb-2 text-warning">★★★★★</div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Bouton vers le formulaire -->
    <div class="mt-4 text-center">
      <a href="avis_form.php" class="btn btn-primary btn-lg">Laissez votre avis</a>
    </div>
  </section>

</main>

<footer class="bg-dark text-white text-center py-3">
  &copy; 2025 Zoo Naturel. Tous droits réservés.
</footer>

</body>
</html>


