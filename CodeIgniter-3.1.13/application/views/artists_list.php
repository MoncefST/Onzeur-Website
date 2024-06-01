<div class="artist-list-container">
    <h1>Liste des Artistes</h1>
    <div class="sort-options">
        <a href="<?php echo site_url('artiste/list_artists?order=ASC'); ?>">Trier par ordre alphabétique</a> |
        <a href="<?php echo site_url('artiste/list_artists?order=DESC'); ?>">Trier par ordre inverse</a>
    </div>
    <ul class="artist-list">
        <?php foreach($artists as $artist): ?>
            <li>
                <div class="artist-details">
                    <h2><?php echo $artist->name; ?></h2>
                    <p>
                        <a href="<?php echo site_url('artiste/'.$artist->id); ?>">Voir les détails</a> <br><br>
                        <a href="https://open.spotify.com/search/<?php echo urlencode($artist->name); ?>/artists" class="spotify" target="_blank">Spotify</a> |
                        <a href="https://www.deezer.com/search/<?php echo urlencode($artist->name); ?>/artist" class="deezer" target="_blank">Deezer</a> |
                        <a href="https://www.youtube.com/results?search_query=<?php echo urlencode($artist->name); ?>&sp=EgIQAg%253D%253D" class="youtube" target="_blank">YouTube</a>
                    </p>
                    <?php if ($this->session->userdata('user_id')): ?>
                        <form method="post" action="<?php echo site_url('playlists/add_artist_in_playlist_from_list/'.$artist->id); ?>">
                            <select name="playlist_id" class="select-playlist">
                                <?php foreach ($user_playlists as $playlist) : ?>
                                    <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="artist_id" value="<?php echo $artist->id; ?>">
                            <button type="submit" class="btn-add-to-playlist">Ajouter les musiques de l'artiste à la playlist</button>
                        </form>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
