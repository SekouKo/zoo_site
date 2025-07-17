<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
}

require '../../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = (int)$_GET['id'];

// Récupérer la liste des animaux
$animaux = $pdo->query("SELECT id, nom FROM animaux ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM compte_rendus WHERE id = ?");
$stmt->execute([$id]);
$compteRendu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$compteRendu) {
    echo "Compte rendu non trouvé.";
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!$animal_id) $errors[] = "Veuillez sélectionner un animal.";
    if (!$date) $errors[] = "Veuillez entrer une date.";
    if (!$description) $errors[] = "Veuillez saisir une description.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE compte_rendus SET animal_id = ?, date = ?, description = ? WHERE id = ?");
        $stmt->execute([$animal_id, $date, $description, $id]);
        header('Location: index.php');
        exit();
    }
} else {
    // Valeurs initiales
    $animal_id = $compteRendu['animal_id'];
    $date = $compteRendu['date'];
    $description = $compteRendu['description'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Modifier un compte rendu</title>
</head>
<body>
<h1>Modifier un compte rendu vétérinaire</h1>

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
                <option value="<?= $animal['id'] ?>" <?= ($animal_id == $animal['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($animal['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Date :
        <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" />
    </label><br><br>

    <label>Description :<br>
        <textarea name="description" rows="6" cols="50"><?= htmlspecialchars($description) ?></textarea>
    </label><br><br>

    <button type="submit">Modifier</button>
    <a href="index.php">Annuler</a>
</form>
</body>
</html>
