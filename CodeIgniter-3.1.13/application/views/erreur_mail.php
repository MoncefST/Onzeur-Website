<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/erreur_mail'); ?>">
    <title>Erreur d'envoi - Onzeur</title>
</head>
<body>
    <div class="hero">
        <h1>Erreur d'envoi</h1>
        <p>Une erreur s'est produite lors de l'envoi de votre message.</p>
    </div>

    <div class="container">
        <div class="error">
            <h2>Votre message n'a pas pu être envoyé.</h2>
            <p>Veuillez réessayer ultérieurement ou nous contacter directement à l'adresse suivante : onzeur.contact@gmail.com</p>
            <a href="<?php echo site_url('home'); ?>"><button>Retour à l'accueil</button></a>
        </div>
    </div>
</body>
</html>
