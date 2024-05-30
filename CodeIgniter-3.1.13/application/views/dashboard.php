    <div class="container">
        <h2>Bienvenue, <?php echo $user->prenom; ?> 👋 !</h2>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <h3>Vos informations personnelles</h3>
        <table class="user-info">
            <tr>
                <th>Prénom</th>
                <td><?php echo $user->prenom; ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?php echo $user->nom; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $user->email; ?></td>
            </tr>
        </table>

        <h3>Modifier vos informations</h3>

        <?php echo form_open_multipart('utilisateur/modifier'); ?>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo set_value('prenom', $user->prenom); ?>" required>
            <?php echo form_error('prenom'); ?>
        </div>

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo set_value('nom', $user->nom); ?>" required>
            <?php echo form_error('nom'); ?>
        </div>

        <div class="form-group">
            <label for="email">E-mail :</label>
            <input type="email" name="email" id="email" value="<?php echo set_value('email', $user->email); ?>" required>
            <?php echo form_error('email'); ?>
        </div>
        
        
        <button type="submit" class="btn-submit">Mettre à jour</button>

        <?php echo form_close(); ?>

        <h3>Modifier votre mot de passe</h3>
        <?php echo form_open('utilisateur/modifier_mot_de_passe'); ?>
        <div class="form-group">
            <label for="ancien_password">Ancien mot de passe :</label>
            <input type="password" name="ancien_password" id="ancien_password" required>
            <?php echo form_error('ancien_password'); ?>
        </div>
        <div class="form-group">
            <label for="nouveau_password">Nouveau mot de passe :</label>
            <input type="password" name="nouveau_password" id="nouveau_password" required>
            <?php echo form_error('nouveau_password'); ?>
        </div>
        <div class="form-group">
            <label for="confirmer_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" name="confirmer_password" id="confirmer_password" required>
            <?php echo form_error('confirmer_password'); ?>
        </div>
        <button type="submit" class="btn-submit">Modifier le mot de passe</button>
        <?php echo form_close(); ?>

        <h3>Vos avis</h3>
        <?php if (isset($avis) && !empty($avis)): ?>
            <ul>
                <?php foreach ($avis as $avi): ?>
                    <li>
                        <p><?php echo $avi->commentaire; ?> - <strong><?php echo $avi->notation; ?>/5</strong></p>
                        <p><a href="<?php echo site_url('utilisateur/supprimer_avis_dashboard/'.$avi->id); ?>">Supprimer</a></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez écrit aucun avis.</p>
        <?php endif; ?>
    </div>
</body>