<?php
session_start();
require_once 'config.php'; // connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Récupère l'utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Stockage des infos utilisateur dans la session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'email' => $user['email']
        ];

        // Redirection selon rôle
        switch ($user['role']) {
            case 'admin':
                header('Location: admin/index.php');
                break;
            case 'veto': // correspond bien à la BDD
                header('Location: veterinaire/index.php');
                break;
            case 'employe':
                header('Location: employe/index.php');
                break;
            default:
                // Rôle inconnu : détruit la session
                session_destroy();
                $_SESSION['error'] = "Rôle utilisateur non reconnu.";
                header('Location: connexion.php');
                break;
        }
        exit;
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header('Location: connexion.php');
        exit;
    }
} else {
    header('Location: connexion.php');
    exit;
}


