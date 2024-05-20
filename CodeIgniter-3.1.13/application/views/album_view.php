<!-- application/views/album_view.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/album_view'); ?>">
    <title><?php echo $album->name; ?> - Details</title>
</head>
<body>
    <div class="album-details">
        <h1><?php echo $album->name; ?></h1>
        <p><strong>Artiste :</strong> <?php echo $album->artistName; ?></p>
        <p><strong>Année :</strong> <?php echo $album->year; ?></p>
        <p><strong>Genre :</strong> <?php echo $album->genreName; ?></p>
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
</html>
