<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/inscription.css'); ?>">
</head>
<body>
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

        <?php echo form_open('utilisateur/modifier'); ?>

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
    </div>
</body>
</html>
