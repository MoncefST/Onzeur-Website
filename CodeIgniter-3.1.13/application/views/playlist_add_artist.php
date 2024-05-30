    <div class="container">
        <h1>Ajouter les musiques d'un Artiste à la Playlist</h1>
        <?php echo form_open('playlists/add_artist/'.$playlist_id); ?>
            <div class="form-group">
                <label for="artist_id">Sélectionner un Artiste :</label>
                <select name="artist_id" class="form-control" required>
                    <?php foreach ($artists as $artist): ?>
                        <option value="<?php echo $artist->id; ?>"><?php echo $artist->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter les musiques de l'artiste</button>
        <?php echo form_close(); ?>
    </div>
</body>
