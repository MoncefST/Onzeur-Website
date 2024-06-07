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
            
            <?php if (!empty($_FILES['attachment']['name'])): ?>
                <p>Fichier attaché: <?php echo htmlspecialchars($_FILES['attachment']['name']); ?></p>
            <?php endif; ?>
            
            <a href="<?php echo site_url('home'); ?>"><button>Retour à l'accueil</button></a>
        </div>
    </div>

