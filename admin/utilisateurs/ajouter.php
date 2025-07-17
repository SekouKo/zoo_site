<?php
session_start();
require_once '../../config.php';

// ✅ Sécurité : Vérifier que l'utilisateur est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../connexion.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($email === '' || $password === '' || !in_array($role, ['employe', 'veterinaire'])) {
        $message = 'Veuillez remplir tous les champs correctement.';
    } else {
        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $role]);

        // Envoi de l'email (sans le mot de passe)
        $to = $email;
        $subject = "Création de votre compte Zoo Naturel";
        $headers = "From: zoo@votresite.com";
        $body = "Bonjour,\n\nVotre compte a été créé avec succès.\nIdentifiant : $email\nRapprochez-vous de l’administrateur pour obtenir votre mot de passe.\n\nCordialement,\nL’équipe Zoo Naturel.";

        mail($to, $subject, $body, $headers);

        $message = "Utilisateur créé avec succès. Un mail a été envoyé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Ajouter un utilisateur</h1>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rôle :</label>
            <select name="role" id="role" class="form-select" required>
                <option value="employe">Employé</option>
                <option value="veterinaire">Vétérinaire</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Créer l'utilisateur</button>
    </form>
</body>
</html>
