    <h2 class="search-title">Résultats de la recherche pour "<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>"</h2>

    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($musiques)): ?>
        <div class="section">
            <h3 class="section-title">Musiques</h3>
            <ul class="music-list">
                <?php foreach($musiques as $musique): ?>
                    <li>
                        <?php echo htmlspecialchars($musique->name, ENT_QUOTES, 'UTF-8'); ?> - 
                        <a href="<?php echo site_url('artiste/'.$musique->artist_id); ?>">
                            <?php echo htmlspecialchars($musique->artistName, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($albums)): ?>
        <div class="section">
            <h3 class="section-title">Albums</h3>
            <ul class="album-list">
                <?php foreach($albums as $album): ?>
                    <li>
                        <a href="<?php echo site_url('albums/view/'.$album->id); ?>">
                            <?php echo htmlspecialchars($album->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a> 
                        - 
                        <a href="<?php echo site_url('artiste/'.$musique->artist_id); ?>">
                            <?php echo htmlspecialchars($musique->artistName, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($genres)): ?>
        <div class="section">
            <h3 class="section-title">Genres</h3>
            <ul class="genre-list">
                <?php foreach($genres as $genre): ?>
                    <li><?php echo htmlspecialchars($genre->name, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($artistes)): ?>
        <div class="section">
            <h3 class="section-title">Artistes</h3>
            <ul class="artist-list">
                <?php foreach($artistes as $artiste): ?>
                    <li>
                        <a href="<?php echo site_url('artiste/'.$artiste->id); ?>">
                            <?php echo htmlspecialchars($artiste->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (empty($musiques) && empty($albums) && empty($genres) && empty($artistes)): ?>
        <p class="no-results">Aucun résultat trouvé.</p>
    <?php endif; ?>

</body>
