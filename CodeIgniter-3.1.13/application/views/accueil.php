<!DOCTYPE html>
<html>
<?php include 'layout/header_not_logged_dark.php'; ?>
<head>
    <link rel="stylesheet" href="assets/css/accueil.css">
    <link rel="icon" type="image/x-icon" href="assets/img/Logo_ONZEUR.png">
    <title>Page d'accueil</title>
    
</head>
<body>
    <div class="hero">
        <h1>Bienvenue sur Onzeur !</h1>
        <p>Le service de streaming musical numéro 1 en France.</p>
    </div>

    <div class="container">
        <div class="features">
            <h2>Fonctionnalités</h2>
            <div class="feature">
                <h3>Fonctionnalité N°1</h3>
                <p>Description de la fonctionnalité 1. Cette fonctionnalité permet de ...</p>
            </div>
            <div class="feature">
                <h3>Fonctionnalité N°2</h3>
                <p>Description de la fonctionnalité 2. Cette fonctionnalité permet de ...</p>
            </div>
            <div class="feature">
                <h3>Fonctionnalité N°3</h3>
                <p>Description de la fonctionnalité 3. Cette fonctionnalité permet de ...</p>
            </div>
        </div>

        <div class="testimonials">
            <h2>Commentaires</h2>
            <div class="testimonial">
                <p>"Ce site est incroyable! Depuis que j'utilise Onzeur ma vie as changé ! Je suis devenu riche et célèbre ! Je recommande 🤩"</p>
                <p>- Mike</p>
            </div>
            <div class="testimonial">
                <p>"Une expérience utilisateur fantastique. Je recommande vivement 🤌."</p>
                <p>- Laura</p>
            </div>
            <div class="testimonial">
                <p>"Service client exceptionnel et fonctionnalités géniales. La fonctionnalité de playlist est vraiment top ! 👍"</p>
                <p>- Joe</p>
            </div>
        </div>

        <div class="gallery">
            <h2>Ils nous ont fait confiance</h2>
            <img src="assets/img/gallerie/pnl.png" alt="PNL">
            <img src="assets/img/gallerie/booba.png" alt="BOOBA">
            <img src="assets/img/gallerie/niska.png" alt="NISKA">
        </div>

        <div class="contact">
            <h2>Contactez-nous</h2>
            <form action="#" method="post">
                <input type="text" name="name" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <textarea name="message" rows="5" placeholder="Votre message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
    <?php include 'layout/footer_dark.php'; ?>
</body>
</html>
