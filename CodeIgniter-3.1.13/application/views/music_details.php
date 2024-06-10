<div class="music-details">
    <?php if (!empty($song)) : ?>
        <h1><?php echo $song->name; ?></h1>
        <p><strong>Artiste :</strong> <a href="<?php echo site_url('artiste/index/' . $song->artist_id); ?>"><?php echo $song->artistName; ?></a></p>
        <p><strong>Album :</strong> <a href="<?php echo site_url('albums/view/' . $song->album_id); ?>"><?php echo $song->album_name; ?></a></p>
        <?php if (!empty($song->cover_base64)) : ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($song->cover_base64); ?>" alt="Couverture de l'album">
        <?php endif; ?>
        <p><strong>Durée :</strong> <?php echo gmdate("i:s", $song->duration); ?></p>

        <?php if ($this->session->userdata('user_id')): ?>
            <?php if (!empty($user_playlists)): ?>
                <select id="playlist_music_<?php echo $song->id; ?>" class="select-playlist">
                    <?php foreach ($user_playlists as $playlist) : ?>
                        <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <button onclick="addToPlaylistMusic(<?php echo $song->id; ?>)" class="btn-add-to-playlist">Ajouter la musique à la playlist</button>
            <?php else: ?>
                <p>Vous n'avez pas encore de playlist. Créez-en une pour ajouter cette chanson !</p>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <p>Aucune information sur la musique n'a été trouvée.</p>
    <?php endif; ?>

    <?php if (!empty($recommended_songs)) : ?>
        <h2>Musiques recommandées</h2>
        <div class="recommended-songs">
            <?php foreach ($recommended_songs as $recommended_song) : ?>
                <div class="recommended-song">
                    <a href="<?php echo site_url('music/details/' . $recommended_song->id); ?>">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($recommended_song->cover_base64); ?>" alt="Cover">
                    </a>
                    <h3 class="titre"><a href="<?php echo site_url('musiques/view/' . $recommended_song->id); ?>"> <?php echo $recommended_song->name; ?></a></h3>
                    <p><a href="<?php echo site_url('artiste/index/' . $recommended_song->artist_id); ?>"><?php echo $recommended_song->artistName; ?></a> - <a href="<?php echo site_url('albums/view/' . $recommended_song->album_id); ?>"><?php echo $recommended_song->album_name; ?></a></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function addToPlaylistMusic(musiqueId) {
        // Récupérer l'ID de la playlist sélectionnée
        var playlistId = document.getElementById('playlist_music_' + musiqueId).value;

        // Redirection vers la méthode du contrôleur Playlists pour ajouter la musique à la playlist spécifiée
        window.location.href = "<?php echo base_url('index.php/playlists/add_music_to_playlist/'); ?>" + musiqueId + "/" + playlistId;
    }
</script>