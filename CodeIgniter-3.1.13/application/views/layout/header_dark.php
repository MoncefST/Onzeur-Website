<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=link_tag('assets/css/header_dark.css')?>
    <?=link_tag('assets/img/Logo_ONZEUR.png')?>
    <?=link_tag(array(
        'href'=>'assets/img/Logo_ONZEUR.png',
        'rel'=>'icon',
        'type'=>'image/x-icon'
    ))?>
    <?=link_tag('assets/css/footer_dark.css')?>
</head>
<body>
<?php if (get_cookie('user_logged_in')): ?>
    <!-- Utilisateur connecté -->
    <?php $this->load->view('layout/header_logged_dark'); ?>
<?php else: ?>
    <!-- Utilisateur non connecté -->
    <?php $this->load->view('layout/header_not_logged_dark'); ?>
<?php endif; ?>

<!-- Contenu de la page -->
</body>
</html>
