document.addEventListener('DOMContentLoaded', () => {
    const addCountry = document.querySelector('.add-country');
    const addContainer = document.querySelector('.add-country-container');

    if (addCountry && addContainer) {
        addCountry.addEventListener('click', () => {
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

    document.querySelectorAll('.stats-container').forEach(container => {
        container.addEventListener('click', () => {
            const statsDetails = container.nextElementSibling;
            if (statsDetails && statsDetails.classList.contains('stats-details')) {
                statsDetails.style.display = statsDetails.style.display === "block" ? "none" : "block";
            }
        });
    });
});
