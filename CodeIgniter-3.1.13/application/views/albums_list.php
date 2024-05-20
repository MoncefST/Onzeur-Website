<head>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/Logo_ONZEUR.png'); ?>">
    <title>Page d'accueil</title>
</head>

<h1 class="title">Listes des albums</h1>
<section class="list">
<?php
foreach($albums as $album){
    echo "<div><article>";
    echo "<header class='short-text'>";
    echo anchor("albums/view/{$album->id}","{$album->name}");
    echo "</header>";
    echo '<img src="data:image/jpeg;base64,'.base64_encode($album->jpeg).'" />';
    echo "<footer class='short-text'>{$album->year} - {$album->artistName}</footer>
    </article></div>";
}
?>
</section>

<div class="pagination">
    <?php if ($current_page > 1): ?>
        <a href="<?php echo base_url('index.php/albums/index/'.($current_page-1)); ?>">Précédent</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="<?php echo base_url('index.php/albums/index/'.$i); ?>" <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
    <?php endfor; ?>
    
    <?php if ($current_page < $total_pages): ?>
        <a href="<?php echo base_url('index.php/albums/index/'.($current_page+1)); ?>">Suivant</a>
    <?php endif; ?>
</div>
