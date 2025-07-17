<?php
session_start();
require_once '../../config/database.php'; // adapte le chemin selon ta structure

// Vérifier que l'utilisateur est vétérinaire
if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: ../../index.php');
    exit;
}

// Récupérer les habitats pour le formulaire
$query = $pdo->query("SELECT id, nom FROM habitats ORDER BY nom");
$habitats = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habitat_id = $_POST['habitat_id'] ?? null;
    $commentaire = trim($_POST['commentaire'] ?? '');

    if ($habitat_id && $commentaire) {
        $stmt = $pdo->prepare("INSERT INTO commentaires_habitats (habitat_id, commentaire, date_commentaire) VALUES (?, ?, NOW())");
        $stmt->execute([$habitat_id, $commentaire]);
        $success = "Commentaire ajouté avec succès.";
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commentaires Habitat - Vétérinaire</title>
</head>
<body>
    <h1>Ajouter un commentaire sur un habitat</h1>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label for="habitat_id">Habitat :</label>
        <select name="habitat_id" id="habitat_id" required>
            <option value="">-- Choisir un habitat --</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?= htmlspecialchars($habitat['id']) ?>"><?= htmlspecialchars($habitat['nom']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="commentaire">Commentaire :</label><br>
        <textarea name="commentaire" id="commentaire" rows="5" cols="50" required></textarea><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
