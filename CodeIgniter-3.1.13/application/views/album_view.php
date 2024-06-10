<div class="album-details">
    <h1><?php echo $album->name; ?></h1>
    <p><strong>Artiste :</strong> <a href="<?php echo site_url('artiste/index/' . $album->artistId); ?>"><?php echo $album->artistName; ?></a></p>
    <p><strong>Année :</strong> <?php echo $album->year; ?></p>
    <p><strong>Genre :</strong> <a href="<?php echo base_url('index.php/musiques/index?genre_id='.$album->genreId); ?>"><?php echo $album->genreName; ?></a></p>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($album->jpeg); ?>" alt="Image d'album">

    <?php if ($this->session->userdata('user_id')): ?>
        <!-- Si l'utilisateur est connecté -->
        <?php if (!empty($user_playlists)): ?>
            <h2>Ajouter à la playlist :</h2>
            <select id="playlist_<?php echo $album->id; ?>" class="select-playlist">
                <?php foreach ($user_playlists as $playlist) : ?>
                    <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                <?php endforeach; ?>
            </select>
            <button onclick="addToPlaylist(<?php echo $album->id; ?>)" class="btn-add-to-playlist">Ajouter à la playlist</button>
        <?php else: ?>
            <p>Vous n'avez pas encore de playlist. Créez-en une pour ajouter cet album !</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($tracks)): ?>
        <h2>Musiques</h2>
        <ul>
        <?php foreach ($tracks as $track): ?>
            <li>
                <strong><?php echo $track->diskNumber . '.' . $track->number; ?>:</strong> 
                <a href="<?php echo site_url('musiques/view/' . $track->song_id); ?>"><?php echo $track->songName; ?></a> 
                (<?php echo gmdate("i:s", $track->duration); ?>)
                <?php if ($this->session->userdata('user_id')): ?>
                    <button onclick="addSongToPlaylist(<?php echo $track->id; ?>, <?php echo $album->id; ?>)" class="btn-add-music-to-playlist">Ajouter la musique à la playlist</button>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune musique n'est disponible dans cet album...</p>
    <?php endif; ?>
</div>
<script>
    function addToPlaylist(albumId) {
        // Récupérer l'ID de la playlist sélectionnée
        var playlistId = document.getElementById('playlist_' + albumId).value;

        // Redirection vers la méthode du contrôleur Playlists pour ajouter la chanson à la playlist spécifiée
        window.location.href = "<?php echo base_url('index.php/playlists/add_album_to_playlist/'); ?>" + albumId + "/" + playlistId;
    }

    function addSongToPlaylist(trackId, albumId) {
        // Récupérer l'ID de la playlist sélectionnée pour cet album
        var playlistId = document.getElementById('playlist_' + albumId).value;

        // Redirection vers la méthode du contrôleur Playlists pour ajouter la chanson à la playlist spécifiée
        window.location.href = "<?php echo base_url('index.php/playlists/add_track_to_playlist/'); ?>" + trackId + "/" + playlistId;
    }
</script>
