<h1 class="title">Liste des musiques</h1>
    
    <div class="filters">
        <form method="GET" action="<?php echo base_url('index.php/musiques/index'); ?>">
            <label for="genre">Genre:</label>
            <select name="genre_id" id="genre">
                <option value="">Tous les genres</option>
                <?php foreach($genres as $genre): ?>
                    <option value="<?php echo $genre->id; ?>" <?php echo ($genre->id == $genre_id) ? 'selected' : ''; ?>><?php echo $genre->name; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="artist">Artiste:</label>
            <select name="artist_id" id="artist">
                <option value="">Tous les artistes</option>
                <?php foreach($artists as $artist): ?>
                    <option value="<?php echo $artist->id; ?>" <?php echo ($artist->id == $artist_id) ? 'selected' : ''; ?>><?php echo $artist->name; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="sort">Trier par:</label>
            <select name="sort" id="sort">
                <option value="name" <?php echo ($sort == 'name') ? 'selected' : ''; ?>>Nom</option>
                <option value="year" <?php echo ($sort == 'year') ? 'selected' : ''; ?>>Année</option>
            </select>

            <button type="submit">Filtrer</button>
        </form>
    </div>

    <section class="list">
        <?php foreach($musiques as $musique): ?>
            <div>
                <article>
                    <header class="short-text">
                        <?php echo $musique->name; ?>
                    </header>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($musique->cover); ?>" alt="Couverture de l'album">
                    <footer class="short-text">
                        <a href="<?php echo base_url('index.php/artiste/index/'.$musique->artist_id); ?>" class="artist-name">
                            <?php echo $musique->artistName; ?>
                        </a> -
                        <a href="<?php echo base_url('index.php/albums/view/'.$musique->album_id); ?>" class="album-name">
                            <?php echo $musique->album_name; ?>
                        </a>
                        <div class="music-links">
                            <!-- Lien Spotify -->
                            <a href="https://open.spotify.com/search/<?php echo urlencode($musique->name . ' ' . $musique->artistName); ?>" class="spotify" target="_blank">Spotify</a> |
                            <!-- Lien Deezer -->
                            <a href="https://www.deezer.com/search/<?php echo urlencode($musique->name . ' ' . $musique->artistName); ?>" class="deezer" target="_blank">Deezer</a> |
                            <!-- Lien YouTube  -->
                            <a href="https://www.youtube.com/results?search_query=<?php echo urlencode($musique->name . ' ' . $musique->artistName); ?>" class="youtube"  target="_blank">YouTube</a>
                        </div>
                        <?php if ($this->session->userdata('user_id')): ?>
                            <?php if (!empty($user_playlists)): ?>
                            <select id="playlist_music_<?php echo $musique->id; ?>" class="select-playlist">
                                <?php foreach ($user_playlists as $playlist) : ?>
                                    <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button onclick="addToPlaylistMusic(<?php echo $musique->id; ?>)" class="btn-add-to-playlist">Ajouter la musique à la playlist</button>
                        <?php endif; ?>
                        <?php endif; ?>
                    </footer>
                </article>
            </div>
        <?php endforeach; ?>
    </section>

    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a class="fleche" href="<?php echo base_url('index.php/musiques/index/'.($current_page-1).((isset($sort)) ? '?sort='.$sort : '')); ?>"><</a>
        <?php endif; ?>

        <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <a href="<?php echo base_url('index.php/musiques/index/'.$i.((isset($sort)) ? '?sort='.$sort : '')); ?>" <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <a class="fleche" href="<?php echo base_url('index.php/musiques/index/'.($current_page+1).((isset($sort)) ? '?sort='.$sort : '')); ?>">></a>
        <?php endif; ?>
    </div>
</body>
<script>
    function addToPlaylistMusic(musiqueId) {
        // Récupérer l'ID de la playlist sélectionnée
        var playlistId = document.getElementById('playlist_music_' + musiqueId).value;

        // Redirection vers la méthode du contrôleur Playlists pour ajouter la musique à la playlist spécifiée
        window.location.href = "<?php echo base_url('index.php/playlists/add_music_to_playlist/'); ?>" + musiqueId + "/" + playlistId;
    }
</script>