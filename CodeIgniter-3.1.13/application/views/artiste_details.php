<div class="artist-details">
    <h1>Détails de l'artiste <?php echo $artiste->name; ?></h1>
    <p><strong>Genre le plus utilisé par l'artiste :</strong> <?php echo $mostUsedGenre->genreName; ?></p>
    <h2>Albums de <?php echo $artiste->name; ?></h2>
    <ul class="albums-list">
        <?php foreach($albums as $album): ?>
            <li>
                <div class="album-details">
                    <h2><a href="<?php echo site_url('albums/view/' . $album->id); ?>"><?php echo $album->name; ?></a></h2>
                    <p><strong>Année :</strong> <?php echo $album->year; ?></p>
                    <p><strong>Genre :</strong> <?php echo $album->genreName; ?></p>
                    <?php if (!empty($album->jpeg)): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($album->jpeg); ?>" alt="Couverture de l'album">
                    <?php else: ?>
                        <span class="no-cover">Aucune couverture disponible</span>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_id')): ?>
                        <!-- Si l'utilisateur est connecté -->
                        <?php if (!empty($user_playlists)): ?>
                            <h3>Ajouter l'album à la playlist :</h3>
                            <select id="playlist_<?php echo $album->id; ?>" class="select-playlist">
                                <?php foreach ($user_playlists as $playlist) : ?>
                                    <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button onclick="addAllAlbumToPlaylist(<?php echo $album->id; ?>)" class="btn-add-to-playlist">Ajouter tout l'album à la playlist</button>
                            <br>
                            <!-- Boutons pour chaque chanson de l'album -->
                            <h3>Ajouter une chanson à la playlist :</h3>
                            <ul class="songs-list">
                                <?php foreach($album->tracks as $track): ?>
                                    <li>
                                        <span><strong><?php echo $track->number . '.' . $track->diskNumber; ?></strong></span>
                                        <span><?php echo $track->songName; ?></span>
                                        <span><strong><?php echo gmdate("i:s", $track->duration); ?></strong></span>
                                        <button onclick="addSongToPlaylist(<?php echo $track->id; ?>, <?php echo $album->id; ?>)" class="btn-add-to-playlist">Ajouter à la playlist</button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="no-playlist">Vous n'avez pas encore de playlist. Créez-en une pour ajouter cet album !</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    function addAllAlbumToPlaylist(albumId) {
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