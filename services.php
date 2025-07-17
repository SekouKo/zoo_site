<?php
require_once 'config.php'; // Connexion PDO à ta BDD
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Services - Zoo Naturel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS perso -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <!-- Menu commun -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html">Zoo Naturel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" 
        aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link active" href="services.php">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="habitats.php">Habitats</a></li>
          <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-success text-white text-center py-5 mt-5">
    <h1>Nos Services</h1>
    <p>Découvrez tout ce que nous proposons pour votre confort et plaisir</p>
  </header>

  <!-- Contenu -->
  <main class="container py-4" style="padding-top: 60px;">
    <section class="row text-center">

      <?php
      $stmt = $pdo->query("SELECT * FROM services");
      while ($service = $stmt->fetch()) :
      ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($service['name']) ?></h5>
              <p class="card-text"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

    </section>
  </main>

  <footer class="bg-dark text-white text-center py-3">
    &copy; 2025 Zoo Naturel. Tous droits réservés.
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
