<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/header_not_logged_dark.css">
    <link rel="icon" type="image/x-icon" href="assets/img/Logo_ONZEUR.png">
    <title>Onzeur</title>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <img src="assets/img/Logo_ONZEUR_DARK.png" alt="Logo de ONZEUR">
            </div>
            <nav class="nav">
                <div class="nav-buttons">
                    <a href="connexion.php" class="btn-connexion">Connexion</a>
                    <a href="inscription.php" class="btn-inscription">Inscription</a>
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
