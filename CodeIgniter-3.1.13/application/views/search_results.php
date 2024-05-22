<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
</head>
<body>
    <h2>Résultats de la recherche pour "<?php echo $query; ?>"</h2>

    <?php if (!empty($musiques)): ?>
        <h3>Musiques</h3>
        <ul>
            <?php foreach($musiques as $musique): ?>
                <li><?php echo $musique->name; ?> - <?php echo $musique->artistName; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($albums)): ?>
        <h3>Albums</h3>
        <ul>
            <?php foreach($albums as $album): ?>
                <li><?php echo $album->name; ?> by <?php echo $album->artistName; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($genres)): ?>
        <h3>Genres</h3>
        <ul>
            <?php foreach($genres as $genre): ?>
                <li><?php echo $genre->name; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($artistes)): ?>
        <h3>Artistes</h3>
        <ul>
            <?php foreach($artistes as $artiste): ?>
                <li><?php echo $artiste->name; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (empty($musiques) && empty($albums) && empty($genres) && empty($artistes)): ?>
        <p>Aucun résultat trouvé.</p>
    <?php endif; ?>

</body>
</html>
