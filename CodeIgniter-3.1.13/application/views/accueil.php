<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/accueil'); ?>">
    <title>Accueil - Onzeur</title>
</head>
<body>
    <div class="hero">
        <h1>Bienvenue sur Onzeur !</h1>
        <p>Le service de streaming musical numéro 1 en France.</p>
        <a href="<?php echo site_url('musiques'); ?>"><button type="button">Accéder à la musique</button></a>
    </div>

    <div class="container">
        <div class="features">
            <h2>Fonctionnalités</h2>
            <div class="feature">
                <h3>Création de playlist</h3>
                <p>Avec Onzeur, vous pouvez créer des playlists personnalisées en quelques clics. Rassemblez vos morceaux préférés, organisez-les par artiste, album ou genre, et créez des listes de lecture adaptées à toutes les occasions. Ajoutez et supprimez des chansons selon vos envies, et gardez votre musique à portée de main, prête à être écoutée à tout moment</p>
                <img src="<?php echo base_url('assets/img/gallerie/img1.jpg'); ?>" alt="Image pour la fonctionnalité 'Création de playlist'">
            </div>
            <div class="feature">
                <h3>Consultation des morceaux</h3>
                <p>Explorez une vaste bibliothèque de morceaux de musique avec Onzeur. Parcourez les listes d'artistes, découvrez des albums et explorez des genres musicaux variés. Trouvez rapidement les chansons que vous recherchez en naviguant facilement entre les différentes vues. Que vous soyez à la recherche de nouveautés ou de classiques, cette fonctionnalité vous permettra de découvrir et d'apprécier une large sélection de musique.</p>
                <img src="<?php echo base_url('assets/img/gallerie/img2.jpg'); ?>" alt="Image pour la fonctionnalité 'Consultation des morceaux'">
            </div>
            <div class="feature">
                <h3>Gestion des comptes utilisateurs</h3>
                <p>Profitez pleinement de toutes les fonctionnalités de l'application en créant votre propre compte utilisateur. Une fois connecté, vous aurez accès à des fonctionnalités avancées telles que la création et la gestion de playlists personnalisées. Ajoutez des chansons à vos favoris, synchronisez votre bibliothèque musicale sur plusieurs appareils et bénéficiez d'une expérience musicale personnalisée.</p>
                <img src="<?php echo base_url('assets/img/gallerie/img3.jpg'); ?>" alt="Image pour la fonctionnalité 'Gestion des comptes utilisateurs'">
            </div>
        </div>

        <div class="testimonials">
            <h2>Avis</h2>
            <?php if (!empty($avis)): ?>
                <?php foreach ($avis as $a): ?>
                    <div class="testimonial">
                        <p>"<?= htmlspecialchars($a->commentaire) ?>"</p>
                        <p>- <?= htmlspecialchars($a->prenom) ?> <?= htmlspecialchars($a->nom) ?></p>
                        <!-- Ajout de la notation -->
                        <div class="rating">
                            <?php for ($i = 0; $i < $a->notation; $i++): ?>
                                <span class="star">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <!-- Ajout du lien de suppression (sous condition d'être l'utilisateur connecté) -->
                        <?php if ($this->session->userdata('user_id') && $this->session->userdata('user_id') == $a->utilisateur_id): ?>
                            <a href="<?php echo site_url('utilisateur/supprimer_avis_accueil/' . $a->id); ?>">Supprimer</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

            <?php if ($this->session->userdata('user_id')): ?>
                <div class="comment-form">
                    <h2>Ajouter un commentaire</h2>
                    <form action="<?php echo site_url('utilisateur/ajouter_avis'); ?>" method="post">
                        <textarea name="commentaire" rows="3" placeholder="Écrivez votre commentaire ici..." required></textarea>
                        <!-- Ajout des étoiles pour la notation -->
                        <h3>Note :</h3>
                        <div class="rating">
                            <input type="radio" id="star1" name="rating" value="1" checked><label for="star1">&#9733;</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
                        </div>
                        <!-- Champ caché pour stocker la valeur de notation -->
                        <input type="hidden" name="notation" id="notation">
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
            <?php endif; ?>

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
            <form action="<?php echo site_url('contact/send_message'); ?>" method="post">
                <input type="text" name="name" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <textarea name="message" rows="5" placeholder="Votre message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</body>
    <script src="<?php echo base_url('assets/js/script_accueil'); ?>"></script>
</html>