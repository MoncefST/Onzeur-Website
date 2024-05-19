<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/accueil.css">
    <link rel="icon" type="image/x-icon" href="assets/img/Logo_ONZEUR.png">
    <title>Page d'accueil</title>
    
</head>
<body>
    <div class="hero">
        <h1>Bienvenue sur Onzeur !</h1>
        <p>Le service de streaming musical numéro 1 en France.</p>
        <a href="<?php echo base_url('albums'); ?>"><button type="button">Accéder à la musique</button></a>
    </div>

    <div class="container">
        <div class="features">
            <h2>Fonctionnalités</h2>
            <div class="feature">
                <h3>Création de playlist</h3>
                <p>Avec Onzeur, vous pouvez créer des playlists personnalisées en quelques clics. Rassemblez vos morceaux préférés, organisez-les par artiste, album ou genre, et créez des listes de lecture adaptées à toutes les occasions. Ajoutez et supprimez des chansons selon vos envies, et gardez votre musique à portée de main, prête à être écoutée à tout moment</p>
                <img src="assets/img/gallerie/img1.jpg" alt="Image pour la fonctionnalité 'Création de playlist'">
            </div>
            <div class="feature">
                <h3>Consultation des morceaux</h3>
                <p>Explorez une vaste bibliothèque de morceaux de musique avec Onzeur. Parcourez les listes d'artistes, découvrez des albums et explorez des genres musicaux variés. Trouvez rapidement les chansons que vous recherchez en naviguant facilement entre les différentes vues. Que vous soyez à la recherche de nouveautés ou de classiques, cette fonctionnalité vous permettra de découvrir et d'apprécier une large sélection de musique.</p>
                <img src="assets/img/gallerie/img2.jpg" alt="Image pour la fonctionnalité 'Consultation des morceaux'">
            </div>
            <div class="feature">
                <h3>Gestion des comptes utilisateurs</h3>
                <p>Profitez pleinement de toutes les fonctionnalités de l'application en créant votre propre compte utilisateur. Une fois connecté, vous aurez accès à des fonctionnalités avancées telles que la création et la gestion de playlists personnalisées. Ajoutez des chansons à vos favoris, synchronisez votre bibliothèque musicale sur plusieurs appareils et bénéficiez d'une expérience musicale personnalisée.</p>
                <img src="assets/img/gallerie/img3.jpg" alt="Image pour la fonctionnalité 'Gestion des comptes utilisateurs'">
            </div>
        </div>


        <div class="testimonials">
            <h2>Avis</h2>
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
            <?php if (!empty($covers)): ?>
                <?php foreach ($covers as $cover): ?>
                    <?php 
                        $imageData = base64_encode($cover['jpeg']); // Convertir les données binaires en base64
                    ?>
                    <img src="data:image/jpeg;base64,<?= $imageData ?>" alt="Image de couverture d'album">
                <?php endforeach; ?>
            <?php endif; ?>
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
</body>
</html>
