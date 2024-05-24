<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/inscription'); ?>">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php echo form_open('utilisateur/inscription'); ?>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo set_value('prenom'); ?>" required>
            <?php echo form_error('prenom'); ?>
        </div>

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo set_value('nom'); ?>" required>
            <?php echo form_error('nom'); ?>
        </div>

        <div class="form-group">
            <label for="email">E-mail :</label>
            <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required>
            <?php echo form_error('email'); ?>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" required>
                <button type="button" onclick="togglePasswordVisibility('password')">Afficher</button>
            </div>
            <?php echo form_error('password'); ?>
        </div>

        <button type="submit" class="btn-submit">Inscription</button>

        <?php echo form_close(); ?>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var passwordFieldType = passwordField.getAttribute('type');
            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
            } else {
                passwordField.setAttribute('type', 'password');
            }
        }
    </script>
</body>
</html>
