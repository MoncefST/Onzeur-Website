
    <div class="album-details">
        <h1><?php echo $album->name; ?></h1>
        <p><strong>Artiste :</strong> <a href="<?php echo site_url('artiste/index/' . $album->artistId); ?>"><?php echo $album->artistName; ?></a></p>
        <p><strong>Année :</strong> <?php echo $album->year; ?></p>
        <p><strong>Genre :</strong> <a href="<?php echo base_url('index.php/musiques/index?genre_id='.$album->genreId); ?>"><?php echo $album->genreName; ?></a></p>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($album->jpeg); ?>" alt="Image d'album">

        <?php if (!empty($album->tracks)): ?>
            <h2>Musiques</h2>
            <ul>
                <?php foreach ($album->tracks as $track): ?>
                    <li>
                        <strong><?php echo $track->diskNumber . '.' . $track->number; ?>:</strong> <?php echo $track->songName; ?> (<?php echo gmdate("i:s", $track->duration); ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucune musique n'est disponible dans cette album...</p>
        <?php endif; ?>
    </div>
</body>
