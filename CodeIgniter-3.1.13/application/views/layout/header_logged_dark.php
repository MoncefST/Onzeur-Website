<header class="header">
    <div class="header-content">
        <div class="logo">
            <a href="<?php echo site_url('home'); ?>">
            <?= img(array('src' => 'assets/img/Logo_ONZEUR_DARK.png', 'alt' =>'logo')); ?>
            </a>
        </div>
        <nav class="nav">
            <div class="nav-buttons">
                <form action="<?php echo site_url('search'); ?>" method="get" class="search-form">
                    <input type="text" name="query" placeholder="Recherche...">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="15px" height="15px">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.94-5-5.75-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.81 2.56 5.28 5.34 5.75a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                    </button>
                </form>
                <a href="<?php echo site_url('albums'); ?>" class="btn-albums">Albums</a>
                <a href="<?php echo site_url('artiste/list_artists'); ?>" class="btn-artistes">Artistes</a>
                <a href="<?php echo site_url('musiques'); ?>" class="btn-musiques">Musiques</a>
                <a href="#PlaylistBIENTOT" class="btn-playlist">Mes Playlists</a>
                <a href="<?php echo site_url('utilisateur/dashboard'); ?>" class="btn-MonCompte">Mon compte</a>
            </div>
        </nav>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>


    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-buttons').classList.toggle('active');
        });
    </script>
