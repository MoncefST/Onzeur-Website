<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('assets/css/artists_list.css') ?>
    <title>Liste des Artistes - Onzeur</title>
</head>
<body>
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
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
