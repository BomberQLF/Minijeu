document.addEventListener('DOMContentLoaded', () => {
    const addCountry = document.querySelector('.add-country');
    const addContainer = document.querySelector('.add-country-container');

    if (addCountry && addContainer) {
        addCountry.addEventListener('click', () => {
            // Vérifier et alterner la visibilité
            if (addContainer.style.display === 'none' || addContainer.style.display === '') {
                addContainer.style.display = 'block';
                addCountry.style.display = 'none';
            } else {
                addContainer.style.display = 'none';
            }
        });
    } else {
        console.error("Élément non trouvé !");
    }
});