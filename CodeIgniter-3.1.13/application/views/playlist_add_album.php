    <div class="container">
        <h1>Ajouter un Album à la Playlist</h1>
        <?php echo form_open('playlists/add_album/'.$playlist_id); ?>
            <div class="form-group">
                <label for="album_id">Sélectionner un Album :</label>
                <select name="album_id" class="form-control" required>
                    <?php foreach ($albums as $album): ?>
                        <option value="<?php echo $album->id; ?>"><?php echo $album->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        <?php echo form_close(); ?>
    </div>

