    <div class="container">
        <h2>Connexion</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php echo form_open('utilisateur/connexion'); ?>

        <div class="form-group">
            <label for="email">Email :</label>
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


        <button type="submit" class="btn-submit">Connexion</button>

        <?php echo form_close(); ?>
        <p>Vous n'avez pas encore de compte ? <a href="<?php echo base_url('index.php/utilisateur/inscription'); ?>">Inscrivez-vous ici</a>.</p>
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

