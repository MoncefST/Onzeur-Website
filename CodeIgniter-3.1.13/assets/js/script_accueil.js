document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez tous les boutons radio d'étoiles
    const stars = document.querySelectorAll('.rating input[type="radio"]');
    // Sélectionnez le champ caché pour la notation
    const notationInput = document.getElementById('notation');

    // Vérifiez si une étoile est déjà sélectionnée par défaut
    const defaultStar = document.querySelector('.rating input[type="radio"]:checked');

    if (defaultStar) {
        // Obtenez le numéro de l'étoile sélectionnée
        const selectedStar = parseInt(defaultStar.value);

        // Parcourez toutes les étoiles
        stars.forEach(star => {
            // Si l'étoile est inférieure ou égale à l'étoile sélectionnée, colorez-la en jaune, sinon, laissez-la grise
            if (parseInt(star.value) <= selectedStar) {
                star.nextElementSibling.style.color = '#FFD700'; // Colorez l'étoile en jaune
            } else {
                star.nextElementSibling.style.color = '#ccc'; // Laissez l'étoile grise
            }
        });

        // Mettez à jour la valeur du champ caché "notation" avec la valeur de l'étoile sélectionnée
        notationInput.value = selectedStar;
    }

    // Parcourez tous les boutons radio d'étoiles
    stars.forEach(star => {
        // Ajoutez un écouteur d'événement pour le clic sur chaque étoile
        star.addEventListener('click', function() {
            // Obtenez le numéro de l'étoile sélectionnée
            const selectedStar = parseInt(this.value);

            // Mettez à jour la valeur du champ caché "notation" avec la valeur de l'étoile sélectionnée
            notationInput.value = selectedStar;

            // Parcourez toutes les étoiles
            stars.forEach(star => {
                // Si l'étoile est inférieure ou égale à l'étoile sélectionnée, colorez-la en jaune, sinon, laissez-la grise
                if (parseInt(star.value) <= selectedStar) {
                    star.nextElementSibling.style.color = '#FFD700'; // Colorez l'étoile en jaune
                } else {
                    star.nextElementSibling.style.color = '#ccc'; // Laissez l'étoile grise
                }
            });
        });
    });
});
