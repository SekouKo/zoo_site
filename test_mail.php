<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Paramètres SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // ou autre selon ton fournisseur
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ton_email@gmail.com';    // ton adresse email
    $mail->Password   = 'ton_mot_de_passe';       // ton mot de passe ou mot de passe d'application
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Expéditeur et destinataire
    $mail->setFrom('ton_email@gmail.com', 'ZooSite');
    $mail->addAddress('destinataire@example.com');  // adresse du destinataire

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = 'Test PHPMailer';
    $mail->Body    = 'Ceci est un email envoyé depuis PHPMailer.';

    $mail->send();
    echo 'Message envoyé avec succès.';
} catch (Exception $e) {
    echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
}
