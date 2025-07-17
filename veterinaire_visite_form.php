<?php
session_start();
require_once 'config.php';

// Vérifier que l'utilisateur est vétérinaire (exemple)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'veterinaire') {
    header('Location: connexion.php');
    exit;
}

$animalId = $_GET['animal_id'] ?? null;
$visiteId = $_GET['id'] ?? null;

if (!$animalId) {
    echo "ID de l'animal manquant.";
    exit;
}

// Récupérer infos animal pour affichage
$stmt = $pdo->prepare("SELECT * FROM animaux WHERE id = ?");
$stmt->execute([$animalId]);
$animal = $stmt->fetch();
if (!$animal) {
    echo "Animal non trouvé.";
    exit;
}

// Initialisation des variables du formulaire
$etat = '';
$nourriture = '';
$grammage = '';
$date_passage = '';
$details = '';

// Si modification, récupérer la visite existante
if ($visiteId) {
    $stmt = $pdo->prepare("SELECT * FROM veterinaire_visites WHERE id = ? AND animal_id = ?");
    $stmt->execute([$visiteId, $animalId]);
    $visite = $stmt->fetch();
    if ($visite) {
        $etat = $visite['etat'];
        $nourriture = $visite['nourriture'];
        $grammage = $visite['grammage'];
        $date_passage = $visite['date_passage'];
        $details = $visite['details'];
    } else {
        echo "Visite non trouvée.";
        exit;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $etat = $_POST['etat'] ?? '';
    $nourriture = $_POST['nourriture'] ?? '';
    $grammage = $_POST['grammage'] ?? '';
    $date_passage = $_POST['date_passage'] ?? '';
    $details = $_POST['details'] ?? '';

    if ($etat && $nourriture && $grammage && $date_passage) {
        if ($visiteId) {
            // Modifier visite
            $stmt = $pdo->prepare("UPDATE veterinaire_visites SET etat = ?, nourriture = ?, grammage = ?, date_passage = ?, details = ? WHERE id = ? AND animal_id = ?");
            $stmt->execute([$etat, $nourriture, $grammage, $date_passage, $details, $visiteId, $animalId]);
        } else {
            // Ajouter visite
            $stmt = $pdo->prepare("INSERT INTO veterinaire_visites (animal_id, etat, nourriture, grammage, date_passage, details) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$animalId, $etat, $nourriture, $grammage, $date_passage, $details]);
        }
        header("Location: animal_detail.php?id=$animalId");
        exit;
    } else {
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title><?= $visiteId ? "Modifier" : "Ajouter" ?> une visite vétérinaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">

    <h1><?= $visiteId ? "Modifier" : "Ajouter" ?> une visite vétérinaire pour <?= htmlspecialchars($animal['prenom']) ?></h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="etat" class="form-label">État de l'animal *</label>
            <input type="text" id="etat" name="etat" class="form-control" required value="<?= htmlspecialchars($etat) ?>">
        </div>
        <div class="mb-3">
            <label for="nourriture" class="form-label">Nourriture proposée *</label>
            <input type="text" id="nourriture" name="nourriture" class="form-control" required value="<?= htmlspecialchars($nourriture) ?>">
        </div>
        <div class="mb-3">
            <label for="grammage" class="form-label">Grammage (en grammes) *</label>
            <input type="number" id="grammage" name="grammage" class="form-control" required min="0" value="<?= htmlspecialchars($grammage) ?>">
        </div>
        <div class="mb-3">
            <label for="date_passage" class="form-label">Date de passage *</label>
            <input type="date" id="date_passage" name="date_passage" class="form-control" required value="<?= htmlspecialchars($date_passage) ?>">
        </div>
        <div class="mb-3">
            <label for="details" class="form-label">Détail de l'état (facultatif)</label>
            <textarea id="details" name="details" class="form-control"><?= htmlspecialchars($details) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?= $visiteId ? "Modifier" : "Ajouter" ?></button>
        <a href="animal_detail.php?id=<?= $animalId ?>" class="btn btn-secondary">Annuler</a>
    </form>

</body>
</html>
