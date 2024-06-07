<h1 class="title">Listes des albums</h1>

<div class="filters">
    <form method="GET" action="<?php echo base_url('index.php/albums/index'); ?>">
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

        <label for="order_by">Trier par:</label>
        <select name="order_by" id="order_by">
            <option value="year" <?php echo ($order_by == 'year') ? 'selected' : ''; ?>>Année</option>
            <option value="name" <?php echo ($order_by == 'name') ? 'selected' : ''; ?>>Nom</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>
</div>

<section class="list">
    <?php if (empty($albums)): ?>
        <p>Aucun album trouvé pour cette sélection.</p>
    <?php else: ?>
        <?php foreach($albums as $album): ?>
            <div>
                <article>
                    <header class="short-text">
                        <?php echo anchor("albums/view/{$album->id}", $album->name); ?>
                    </header>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($album->jpeg); ?>" alt="<?php echo $album->name; ?>">
                    <footer class="short-text"><?php echo $album->year; ?> - <?php echo $album->artistName; ?>
                    <?php if ($this->session->userdata('user_id')): ?>
                        <?php if (!empty($user_playlists)): ?>
                            <br><br>
                            <select id="playlist_<?php echo $album->id; ?>" class="select-playlist">
                                <?php foreach ($user_playlists as $playlist) : ?>
                                    <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button onclick="addToPlaylist(<?php echo $album->id; ?>)" class="btn-add-to-playlist">Ajouter l'album à la playlist</button>
                        <?php endif; ?>
                    <?php endif; ?>
                    </footer>
                </article>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<div class="pagination">
    <?php if ($current_page > 1): ?>
        <a class="fleche" href="<?php echo base_url('index.php/albums/index/'.($current_page-1).'?order_by='.$order_by.'&genre_id='.$genre_id.'&artist_id='.$artist_id); ?>"><</a>
    <?php endif; ?>

    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
        <a href="<?php echo base_url('index.php/albums/index/'.$i.'?order_by='.$order_by.'&genre_id='.$genre_id.'&artist_id='.$artist_id); ?>" <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages): ?>
        <a class="fleche" href="<?php echo base_url('index.php/albums/index/'.($current_page+1).'?order_by='.$order_by.'&genre_id='.$genre_id.'&artist_id='.$artist_id); ?>">></a>
    <?php endif; ?>
</div>

<script>
    function addToPlaylist(albumId) {
        // Récupérer l'ID de la playlist sélectionnée
        var playlistId = document.getElementById('playlist_' + albumId).value;

        // Redirection vers la méthode du contrôleur Playlists pour ajouter la chanson à la playlist spécifiée
        window.location.href = "<?php echo base_url('index.php/playlists/add_album_to_playlist/'); ?>" + albumId + "/" + playlistId;
    }
</script>
