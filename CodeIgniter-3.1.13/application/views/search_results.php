<h2 class="search-title">Résultats de la recherche pour "<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"</h2>

<?php if (!empty($error)): ?>
    <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<?php if (!empty($musiques)): ?>
    <div class="section">
        <h3 class="section-title">Musiques</h3>
        <ul class="music-list">
        <?php foreach ($musiques as $musique): ?>
            <li>
                <?php echo htmlspecialchars($musique->name, ENT_QUOTES, 'UTF-8'); ?> - 
                <a href="<?php echo site_url('artiste/' . htmlspecialchars($musique->artist_id, ENT_QUOTES, 'UTF-8')); ?>">
                    <?php echo htmlspecialchars($musique->artistName, ENT_QUOTES, 'UTF-8'); ?>
                </a>
                <?php if ($this->session->userdata('user_id')): ?>
                    <select id="playlist_<?php echo $musique->id; ?>" class="select-playlist">
                        <?php foreach ($user_playlists as $playlist) : ?>
                            <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button onclick="addToMusicPlaylist(<?php echo $musique->id; ?>)" class="btn-add-to-playlist">Ajouter la musique à la playlist</button>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($albums)): ?>
    <div class="section">
        <h3 class="section-title">Albums</h3>
        <ul class="album-list">
        <?php foreach ($albums as $album): ?>
            <li>
                <a href="<?php echo site_url('albums/view/' . htmlspecialchars($album->id, ENT_QUOTES, 'UTF-8')); ?>">
                    <?php echo htmlspecialchars($album->name, ENT_QUOTES, 'UTF-8'); ?>
                </a> - 
                <a href="<?php echo site_url('artiste/' . htmlspecialchars($album->artist_id, ENT_QUOTES, 'UTF-8')); ?>">
                    <?php echo htmlspecialchars($album->artistName, ENT_QUOTES, 'UTF-8'); ?>
                </a>
                <?php if ($this->session->userdata('user_id')): ?>
                    <select id="playlist_<?php echo $album->id; ?>" class="select-playlist">
                        <?php foreach ($user_playlists as $playlist) : ?>
                            <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button onclick="addAlbumToPlaylist(<?php echo $album->id; ?>)" class="btn-add-to-playlist">Ajouter l'album à la playlist</button>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($genres)): ?>
    <div class="section">
        <h3 class="section-title">Genres</h3>
        <ul class="genre-list">
            <?php foreach ($genres as $genre): ?>
                <li>
                    <a href="<?php echo site_url('albums?genre_id=' . htmlspecialchars($genre->id, ENT_QUOTES, 'UTF-8')); ?>">
                        <?php echo htmlspecialchars($genre->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (!empty($artistes)): ?>
    <div class="section">
        <h3 class="section-title">Artistes</h3>
        <ul class="artist-list">
        <?php foreach ($artistes as $artiste): ?>
            <li>
                <a href="<?php echo site_url('artiste/' . htmlspecialchars($artiste->id, ENT_QUOTES, 'UTF-8')); ?>">
                    <?php echo htmlspecialchars($artiste->name, ENT_QUOTES, 'UTF-8'); ?>
                </a>
                <?php if ($this->session->userdata('user_id')): ?>
                    <select id="playlist_<?php echo $artiste->id; ?>" class="select-playlist">
                        <?php foreach ($user_playlists as $playlist) : ?>
                            <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button onclick="addArtistToPlaylist(<?php echo $artiste->id; ?>)" class="btn-add-to-playlist">Ajouter l'artiste à la playlist</button>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (empty($musiques) && empty($albums) && empty($genres) && empty($artistes)): ?>
    <p class="no-results">Aucun résultat trouvé.</p>
<?php endif; ?>

</body>
<script>
function addToMusicPlaylist(musicId) {
    var playlistId = document.getElementById('playlist_' + musicId).value;
    window.location.href = "<?php echo base_url('index.php/playlists/add_music_to_playlist/'); ?>" + musicId + "/" + playlistId;
}

function addArtistToPlaylist(artistId) {
    var playlistId = document.getElementById('playlist_' + artistId).value;
    window.location.href = "<?php echo base_url('index.php/playlists/add_artist_in_playlist_from_list/'); ?>" + artistId + "/" + playlistId;
}

function addAlbumToPlaylist(albumId) {
    var playlistId = document.getElementById('playlist_' + albumId).value;
    window.location.href = "<?php echo base_url('index.php/playlists/add_album_to_playlist/'); ?>" + albumId + "/" + playlistId;
}
</script>