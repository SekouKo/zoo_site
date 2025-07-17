<?php
// Affiche les erreurs pour debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

// Récupération de l'ID de l'habitat depuis l'URL
$habitatId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Redirection si aucun ID
if (!$habitatId) {
    header('Location: habitats.php');
    exit;
}

// Requête pour récupérer l'habitat
$stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
$stmt->execute([$habitatId]);
$habitat = $stmt->fetch();

// Si habitat non trouvé
if (!$habitat) {
    echo "<p style='color:red;'>Habitat non trouvé pour l'ID $habitatId</p>";
    exit;
}

// Requête pour récupérer les animaux liés à l'habitat avec leur dernier état
$stmt = $pdo->prepare("
    SELECT a.*, 
    (SELECT etat FROM veterinaire_visites vv WHERE vv.animal_id = a.id ORDER BY date_passage DESC LIMIT 1) AS dernier_etat
    FROM animaux a
    WHERE a.habitat_id = ?
    ORDER BY a.name
");
$stmt->execute([$habitatId]);
$animaux = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l'habitat : <?= htmlspecialchars($habitat['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .animal-card {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .animal-card:hover {
            transform: scale(1.05);
        }
        .animal-image {
            max-height: 150px;
            object-fit: cover;
        }
        .habitat-image {
            max-height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body class="container py-4">

    <h1 class="mb-4"><?= htmlspecialchars($habitat['name']) ?></h1>

    <?php if (!empty($habitat['image'])): ?>
        <img src="<?= htmlspecialchars($habitat['image']) ?>" alt="<?= htmlspecialchars($habitat['name']) ?>" class="img-fluid habitat-image mb-4" />
    <?php endif; ?>

    <?php if (!empty($habitat['description'])): ?>
        <p><?= nl2br(htmlspecialchars($habitat['description'])) ?></p>
    <?php endif; ?>

    <h2 class="mt-5">Animaux de cet habitat</h2>

    <div class="row">
        <?php if (empty($animaux)): ?>
            <p>Aucun animal dans cet habitat.</p>
        <?php else: ?>
            <?php foreach ($animaux as $animal): ?>
                <div class="col-md-4 mb-4">
                    <a href="animal_detail.php?id=<?= $animal['id'] ?>" class="text-decoration-none text-dark">
                        <div class="card animal-card h-100">
                            <?php if (!empty($animal['image'])): ?>
                                <img src="<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" class="card-img-top animal-image" />
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($animal['name']) ?></h5>
                                <p class="card-text">Race : <?= htmlspecialchars($animal['race']) ?></p>
                                <p><strong>État :</strong> <?= htmlspecialchars($animal['dernier_etat'] ?? 'Inconnu') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="habitats.php" class="btn btn-secondary mt-4">← Retour aux habitats</a>

</body>
</html>


