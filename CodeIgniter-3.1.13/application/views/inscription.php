<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/inscription.css'); ?>">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php echo form_open('utilisateur/inscription'); ?>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required>
            <?php echo form_error('email'); ?>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            <?php echo form_error('password'); ?>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <?php echo form_error('confirm_password'); ?>
        </div>



        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo set_value('nom'); ?>" required>
            <?php echo form_error('nom'); ?>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo set_value('prenom'); ?>" required>
            <?php echo form_error('prenom'); ?>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone :</label>
            <input type="text" name="telephone" id="telephone" value="<?php echo set_value('telephone'); ?>">
        </div>

        <button type="submit" class="btn-submit">Inscription</button>

        <?php echo form_close(); ?>
    </div>
</body>
</html>
