<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>404 - Page non trouvée</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/error_404.css'); ?>">
</head>
<body>
    <h1>Erreur 404 🤖 - Cette page n'existe pas<h1>
    <p>Ne partez pas si vite, pourquoi ne pas rester pour jouer à Flappy Onzeur ?</p>
    <canvas id="flappyBirdCanvas" width="400" height="600"></canvas>
    <div class="overlay" id="overlay">
        <div class="countdown" id="countdown">3</div>
    </div>
    <script>
        const canvas = document.getElementById('flappyBirdCanvas');
        const ctx = canvas.getContext('2d');
        const GRAVITY = 0.25;
        const FLAP = -4.5;
        const PIPE_WIDTH = 50;
        const PIPE_SPEED = 2;
        const PIPE_SPACING = 150;
        let pipes = [];
        let isGameOver = false;

        // Chargement des ressources
        const birdSprite = new Image();
        birdSprite.src = 'https://dwarves.iut-fbleau.fr/~stiti/SAE_2.02/CodeIgniter-3.1.13/assets/img/Logo_ONZEUR.png';

        const backgroundImage = new Image();
        backgroundImage.src = 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/089918d8-99ff-45de-a084-3fe85d0e3fcc/dg34rsu-29a3d144-dc3f-473e-a949-f73a4ba1ef7c.png/v1/fill/w_608,h_457,q_80,strp/flappy_bird_backdrop_by_lenaxux_dg34rsu-fullview.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NDU3IiwicGF0aCI6IlwvZlwvMDg5OTE4ZDgtOTlmZi00NWRlLWEwODQtM2ZlODVkMGUzZmNjXC9kZzM0cnN1LTI5YTNkMTQ0LWRjM2YtNDczZS1hOTQ5LWY3M2E0YmExZWY3Yy5wbmciLCJ3aWR0aCI6Ijw9NjA4In1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmltYWdlLm9wZXJhdGlvbnMiXX0._FI7nnUO3ZCIz23z4_juaIbbiEa_LQd1lX6MK-0iUEE'; // Remplacez 'background.jpg' par le chemin de votre image de fond

        // Définir la classe Bird
        class Bird {
            constructor() {
                this.x = 150;
                this.y = 200;
                this.vy = 0;
                this.width = 34;
                this.height = 24;
                this.weight = 1;
            }

            update() {
                this.vy += GRAVITY;
                this.y += this.vy;

                if (this.y > canvas.height - this.height) {
                    this.y = canvas.height - this.height;
                    this.vy = 0;
                }

                if (this.y < 0) {
                    this.y = 0;
                    this.vy = 0;
                }
            }

            draw() {
                ctx.drawImage(birdSprite, this.x, this.y, this.width, this.height);
            }

            flap() {
                this.vy += FLAP;
            }
        }

        const bird = new Bird();

        // Contrôles
        document.addEventListener('keydown', function (e) {
            if (e.code === 'Space') bird.flap();
        });

        canvas.addEventListener('click', function () {
            bird.flap();
        });

        // Fonction principale pour démarrer le jeu après un compte à rebours de 3 secondes
        function startGame() {
            // Afficher le compte à rebours
            let countdown = 3;
            const countdownInterval = setInterval(function() {
                // Mettre à jour le compte à rebours dans l'overlay
                document.getElementById('countdown').textContent = countdown;
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval); // Arrêter le compte à rebours
                    document.getElementById('overlay').style.display = 'none'; // Masquer l'overlay
                    animate(); // Démarrer le jeu
                }
            }, 1000);
        }

        // Fonction principale d'animation
        function animate() {
            if (isGameOver) {
                alert('Game Over ! Visiblement les jeux-vidéos ne sont pas fait pour vous... Cliquez sur le bouton \'OK\' pour retourner à la page d\'accueil.');
                window.location.href = '<?php echo base_url(); ?>'; // Rediriger vers la page d'accueil
                return;
            }

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Dessiner le fond
            ctx.drawImage(backgroundImage, 0, 0, canvas.width, canvas.height);

            // Gérer les obstacles (pipes)
            pipes.forEach(pipe => {
                pipe.x -= PIPE_SPEED;

                // Dessiner les tuyaux
                ctx.fillStyle = 'purple';
                ctx.fillRect(pipe.x, 0, PIPE_WIDTH, pipe.top);
                ctx.fillRect(pipe.x, pipe.bottom, PIPE_WIDTH, canvas.height - pipe.bottom);

                // Vérifier la collision avec les tuyaux
                if (bird.x + bird.width > pipe.x && bird.x < pipe.x + PIPE_WIDTH) {
                    if (bird.y < pipe.top || bird.y + bird.height > pipe.bottom) {
                        // Collision détectée, fin de jeu
                        isGameOver = true;
                    }
                }

                // Supprimer les tuyaux sortis de l'écran
                if (pipe.x + PIPE_WIDTH < 0) {
                    pipes.shift();
                }
            });

            // Vérifier la collision avec le sol
            if (bird.y + bird.height >= canvas.height) {
                // Collision avec le sol, fin de jeu
                isGameOver = true;
            }

            // Gérer l'oiseau
            bird.update();
            bird.draw();

            // Générer de nouveaux tuyaux
            if (frames % 100 === 0) {
                const topHeight = Math.random() * (canvas.height / 2);
                const bottomHeight = Math.random() * (canvas.height / 2);
                pipes.push({ x: canvas.width, top: topHeight, bottom: canvas.height - bottomHeight });
            }

            frames++;

            requestAnimationFrame(animate);
        }


        let frames = 0;

        // Lancer le jeu lorsque la page est chargée
        window.onload = function() {
            startGame(); // Commencer le compte à rebours et le jeu après 3 secondes
        };
    </script>
</body>

