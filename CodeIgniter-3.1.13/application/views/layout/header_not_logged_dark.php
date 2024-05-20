<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/header_not_logged_dark'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/Logo_ONZEUR.png'); ?>">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <a href="<?php echo site_url('home'); ?>">
                    <img src="<?php echo base_url('assets/img/Logo_ONZEUR_DARK.png'); ?>" alt="Logo de ONZEUR">
                </a>
            </div>
            <nav class="nav">
                <div class="nav-buttons">
                    <a href="<?php echo site_url('albums'); ?>" class="btn-albums">Albums</a>
                    <a href="<?php echo site_url('artistes'); ?>" class="btn-artistes">Artistes</a>
                    <a href="<?php echo site_url('musiques'); ?>" class="btn-musiques">Musiques</a>
                    <a href="#CONNEXIONBIENTOT" class="btn-connexion">Connexion</a>
                    <a href="#INSCRIPTIONBIENTOT" class="btn-inscription">Inscription</a>
                </div>
            </nav>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-buttons').classList.toggle('active');
        });
    </script>
</body>
</html>
