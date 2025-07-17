<?php
$host = 'localhost';
$dbname = 'zoo_naturel';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);
    $role = "employe"; // Par défaut

    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe,
        ':role' => $role
    ]);

    header("Location: connexion.php?inscription=ok");
    exit();
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Créer un compte</h2>
  <form method="POST" action="">
    <div class="mb-3">
      <label>Nom</label>
      <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Mot de passe</label>
      <input type="password" name="mot_de_passe" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">S’inscrire</button>
  </form>
</body>
</html>
