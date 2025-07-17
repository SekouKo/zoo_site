<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
}

require '../../config/database.php';

// Récupérer la liste des animaux pour le select
$animaux = $pdo->query("SELECT id, nom FROM animaux ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validation simple
    if (!$animal_id) $errors[] = "Veuillez sélectionner un animal.";
    if (!$date) $errors[] = "Veuillez entrer une date.";
    if (!$description) $errors[] = "Veuillez saisir une description.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO compte_rendus (animal_id, date, description) VALUES (?, ?, ?)");
        $stmt->execute([$animal_id, $date, $description]);
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ajouter un compte rendu</title>
</head>
<body>
<h1>Ajouter un compte rendu vétérinaire</h1>

<?php if ($errors): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">
    <label>Animal :
        <select name="animal_id">
            <option value="">-- Sélectionnez --</option>
            <?php foreach ($animaux as $animal): ?>
                <option value="<?= $animal['id'] ?>" <?= (isset($animal_id) && $animal_id == $animal['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($animal['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Date :
        <input type="date" name="date" value="<?= htmlspecialchars($date ?? '') ?>" />
    </label><br><br>

    <label>Description :<br>
        <textarea name="description" rows="6" cols="50"><?= htmlspecialchars($description ?? '') ?></textarea>
    </label><br><br>

    <button type="submit">Ajouter</button>
    <a href="index.php">Annuler</a>
</form>
</body>
</html>
