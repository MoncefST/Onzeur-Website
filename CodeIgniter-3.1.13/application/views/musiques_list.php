<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/musiques_list'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/Logo_ONZEUR.png'); ?>">
    <title>Musiques - Onzeur</title>
</head>
<body>
    <h1 class="title">Liste des musiques</h1>
    
    <div class="filters">
        <form method="GET" action="<?php echo base_url('index.php/musiques/index'); ?>">
            <label for="sort">Trier par:</label>
            <select name="sort" id="sort">
                <option value="name" <?php echo (isset($sort) && $sort == 'name') ? 'selected' : ''; ?>>Titre</option>
                <option value="artist" <?php echo (isset($sort) && $sort == 'artist') ? 'selected' : ''; ?>>Artiste</option>
                <option value="album" <?php echo (isset($sort) && $sort == 'album') ? 'selected' : ''; ?>>Album</option>
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
</html>
