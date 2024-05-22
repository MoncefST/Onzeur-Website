<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/Logo_ONZEUR.png'); ?>">
    <title>Albums - Onzeur</title>
</head>
<body>
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
        <?php foreach($albums as $album): ?>
            <div>
                <article>
                    <header class="short-text">
                        <?php echo anchor("albums/view/{$album->id}", $album->name); ?>
                    </header>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($album->jpeg); ?>" alt="<?php echo $album->name; ?>">
                    <footer class="short-text"><?php echo $album->year; ?> - <?php echo $album->artistName; ?></footer>
                </article>
            </div>
        <?php endforeach; ?>
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
</body>
</html>
