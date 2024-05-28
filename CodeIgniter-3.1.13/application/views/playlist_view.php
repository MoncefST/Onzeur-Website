<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Playlist - Onzeur</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/playlist_view'); ?>">
</head>
<body>
    <div class="container">
        <!-- Messages Flash -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success mt-3">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <h1><?php echo htmlspecialchars($playlist->name, ENT_QUOTES, 'UTF-8'); ?></h1>
        <form action="<?php echo site_url('playlists/update/' . $playlist->id); ?>" method="post">
            <div class="form-group">
                <label for="name">Nom de la Playlist:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($playlist->name, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description de la Playlist:</label>
                <textarea name="description" class="form-control" required><?php echo htmlspecialchars($playlist->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>

        <h2>Chansons</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Artiste</th>
                <th>Écouter sur</th> 
                <th>Actions</th>
            </tr>
            <tbody>
                <?php if (!empty($songs)) : ?>
                    <?php foreach ($songs as $song) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($song->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><a href="<?php echo site_url('artiste/index/' . $song->artistId); ?>"><?php echo htmlspecialchars($song->artist_name, ENT_QUOTES, 'UTF-8'); ?></a></td>
                            <td>
                                <a href="https://open.spotify.com/search/<?php echo urlencode($song->artist_name . ' ' . $song->name); ?>" class="spotify" target="_blank">Spotify</a> |
                                <a href="https://www.deezer.com/search/<?php echo urlencode($song->artist_name . ' ' . $song->name); ?>" class="deezer" target="_blank">Deezer</a> |
                                <a href="https://www.youtube.com/results?search_query=<?php echo urlencode($song->artist_name . ' ' . $song->name); ?>" class="youtube" target="_blank">YouTube</a>
                            </td>
                            <td>
                                <a href="<?php echo site_url('playlists/remove_song/' . $playlist->id . '/' . $song->id); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette chanson de la playlist ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Aucune chanson trouvée dans cette playlist.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="<?php echo site_url('playlists/add_song/' . $playlist->id); ?>" class="btn btn-primary">Ajouter une musique</a>
        <a href="<?php echo site_url('playlists/add_album/' . $playlist->id); ?>" class="btn btn-primary">Ajouter un album</a>
        <a href="<?php echo site_url('playlists/add_artist/' . $playlist->id); ?>" class="btn btn-primary">Ajouter les musiques d'un artiste</a>
        <a href="<?php echo site_url('playlists'); ?>" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>
