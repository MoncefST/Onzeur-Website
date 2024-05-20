<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/musiques_list'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Musiques - Onzeur</title>
</head>
<body>
    <h1>Liste des musiques</h1>
    <ul>
        <?php foreach($musiques as $musique): ?>
            <li>
                <strong>Titre:</strong> <?php echo $musique->name; ?> <br>
                <strong>Artiste:</strong> <?php echo $musique->artistName; ?> <br>
                <strong>Album:</strong> <a href="<?php echo base_url('index.php/albums/view/'.$musique->album_id); ?>"><?php echo $musique->album_name; ?></a> <br>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($musique->cover); ?>" alt="Couverture d'album"> <br>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a class="fleche" href="<?php echo base_url('index.php/musiques/index/'.($current_page-1)); ?>"><</a>
        <?php endif; ?>

        <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <a href="<?php echo base_url('index.php/musiques/index/'.$i); ?>" <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <a class="fleche" href="<?php echo base_url('index.php/musiques/index/'.($current_page+1)); ?>">></a>
        <?php endif; ?>
    </div>

</body>
</html>
