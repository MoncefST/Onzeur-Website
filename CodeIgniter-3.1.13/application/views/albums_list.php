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
        <a class="fleche" href="<?php echo base_url('index.php/albums/index/'.($current_page-1)); ?>"><</a>
    <?php endif; ?>


    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
        <a href="<?php echo base_url('index.php/albums/index/'.$i); ?>" <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages): ?>
        <a class="fleche" href="<?php echo base_url('index.php/albums/index/'.($current_page+1)); ?>">></a>
    <?php endif; ?>
</div>
</body>
</html>