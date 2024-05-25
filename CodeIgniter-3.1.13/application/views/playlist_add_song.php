<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Chanson à la Playlist</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/playlist_add_song'); ?>">
</head>
<body>
    <div class="container">
        <h1>Ajouter une Chanson à la Playlist</h1>
        <?php echo form_open('playlists/add_song/'.$playlist_id); ?>
            <div class="form-group">
                <label for="song_id">Sélectionner une Chanson :</label>
                <select name="song_id" class="form-control" required>
                <?php foreach ($songs as $song): ?>
                    <option value="<?php echo $song->id; ?>"><?php echo $song->name; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        <?php echo form_close(); ?>
    </div>
</body>
</html>
