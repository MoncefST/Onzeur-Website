<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/artiste_details'); ?>">
    <title>Détails de l'artiste <?php echo $artiste->name; ?></title>
</head>
<body>
    <div class="artist-details">
        <h1>Détails de l'artiste <?php echo $artiste->name; ?></h1>

        <h2>Albums de <?php echo $artiste->name; ?></h2>
        <ul class="albums-list">
            <?php foreach($albums as $album): ?>
                <li>
                    <div class="album-details">
                        <h3><?php echo $album->name; ?></h3>
                        <p><strong>Année :</strong> <?php echo $album->year; ?></p>
                        <p><strong>Genre :</strong> <?php echo $album->genreName; ?></p>
                        <?php if (!empty($album->jpeg)): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($album->jpeg); ?>" alt="Couverture de l'album">
                        <?php else: ?>
                            <span class="no-cover">Aucune couverture disponible</span>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
