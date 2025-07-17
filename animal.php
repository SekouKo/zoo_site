<?php
// Supposons que tu passes l’ID dans l’URL : animal.php?id=42
$animalId = $_GET['id'] ?? null;

// ⚠️ À remplacer par une requête SQL vers MySQL pour récupérer l’animal
$prenom = "Medor"; // Ex: récupéré depuis MySQL par ID

require_once 'mongo/increment_view.php';
incrementAnimalView($animalId, $prenom);
?>

<h1>Détails de l’animal <?= htmlspecialchars($prenom) ?></h1>
<p>Vous consultez cet animal. Merci pour votre visite !</p>
