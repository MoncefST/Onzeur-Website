<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // Protocole d'envoi des emails
    'smtp_host' => 'smtp.gmail.com', // Hôte SMTP
    'smtp_port' => 587, // Port SMTP
    'smtp_user' => 'onzeur.contact@gmail.com', // Nom d'utilisateur SMTP
    'smtp_pass' => 'ofoi hjpo isxf azdk', // Mot de passe SMTP
    'smtp_crypto' => 'tls', // Type de chiffrement (tls ou ssl)
    'mailtype' => 'html', // Type de contenu (text ou html)
    'charset' => 'utf-8', // Encodage des caractères
    'newline' => "\r\n", // Caractère de nouvelle ligne
    'wordwrap' => TRUE // Activation du retour automatique à la ligne
);

?>
