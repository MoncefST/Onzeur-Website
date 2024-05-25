<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/confirmation_mail'); ?>">
    <title>Confirmation d'envoi - Onzeur</title>
</head>
<body>
    <div class="hero">
        <h1>Confirmation d'envoi</h1>
        <p>Merci ! Votre message a été envoyé avec succès.</p>
    </div>

    <div class="container">
        <div class="confirmation">
            <h2>Votre message :</h2>
            <p>Nom: <?php echo htmlspecialchars($_POST['name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($_POST['email']); ?></p>
            <p>Message: <?php echo htmlspecialchars($_POST['message']); ?></p>
            <a href="<?php echo site_url('accueil'); ?>"><button>Retour à l'accueil</button></a>
        </div>
    </div>
</body>
</html>
