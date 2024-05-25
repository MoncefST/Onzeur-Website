<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Nouvelle Playlist</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/playlist_create'); ?>">
</head>
<body>
    <div class="container">
        <h1>Créer une Nouvelle Playlist</h1>
        <?php echo form_open('playlists/create'); ?>
            <div class="form-group">
                <label for="name">Nom de la Playlist :</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        <?php echo form_close(); ?>
    </div>
</body>
</html>
