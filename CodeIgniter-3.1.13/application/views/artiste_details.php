
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
                        <ul class="songs-list">
                        <?php foreach($album->tracks as $track): ?>
                            <li>
                                <span><strong><?php echo $track->number . '.' . $track->diskNumber; ?></strong></span>
                                <span><?php echo $track->songName; ?></span>
                                <span><strong><?php echo gmdate("i:s", $track->duration); ?></strong></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
