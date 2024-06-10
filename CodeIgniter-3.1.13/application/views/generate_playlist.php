<body>
    <h1>Générer une playlist</h1>
    <form action="<?php echo site_url('playlists/generate_random'); ?>" method="post" class="formulaire">
        <label for="nbrMusiqueAleatoire">Nombre de musiques :</label>
        <input type="number" name="nbrMusiqueAleatoire" id="nbrMusiqueAleatoire" value="5" min="1" max="100"><br><br>

        <label for="genre">Genre :</label>
        <select name="genre" id="genre">
            <option value="">Tous les genres</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="artist">Artiste :</label>
        <select name="artist" id="artist">
            <option value="">Tous les artistes</option>
            <?php foreach ($artists as $artist): ?>
                <option value="<?php echo $artist; ?>"><?php echo $artist; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Générer la playlist">
    </form>
