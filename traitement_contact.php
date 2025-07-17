<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!$titre || !$description || !$email) {
        $_SESSION['contact_message'] = "Tous les champs sont obligatoires.";
        $_SESSION['contact_success'] = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_message'] = "Veuillez saisir une adresse email valide.";
        $_SESSION['contact_success'] = false;
    } else {
        $to = "contact@zoo-naturel.com"; // ✅ Modifie ici avec ton vrai mail
        $subject = "[Contact Zoo] " . $titre;
        $body = "Vous avez reçu un nouveau message :\n\n";
        $body .= "Email de l'expéditeur : $email\n\n";
        $body .= "Message :\n$description\n";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['contact_message'] = "Votre message a bien été envoyé. Merci de nous avoir contactés.";
            $_SESSION['contact_success'] = true;
        } else {
            $_SESSION['contact_message'] = "Erreur lors de l'envoi du message, veuillez réessayer plus tard.";
            $_SESSION['contact_success'] = false;
        }
    }

    header('Location: contact.php');
    exit;
} else {
    // Accès direct non autorisé
    http_response_code(405);
    echo "Méthode non autorisée.";
}

