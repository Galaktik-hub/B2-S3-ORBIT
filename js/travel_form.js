$(document).ready(function() {
    // Setup autocomplete for departure and arrival planets
    function setupAutocomplete(selector) {
        $(selector).autocomplete({
            source: planetNames,
            minLength: 3
        });
    }

    // Apply autocomplete to both input fields
    setupAutocomplete("#startPlanet");
    setupAutocomplete("#endPlanet");
    setupAutocomplete("#startPlanet2");
    setupAutocomplete("#endPlanet2");
});

function toggleForms() {
    const searchTravel = document.getElementById('search-travel');
    const taxiReservation = document.getElementById('taxi-reservation');
    const showTaxi = document.getElementById('show-taxi-reservation');
    const showTravel = document.getElementById('show-search-travel');

    showTaxi.addEventListener('click', (e) => {
        e.preventDefault();
        searchTravel.classList.add('fade-out');
        taxiReservation.classList.remove('fade-out');
        taxiReservation.classList.add('fade-in');

        setTimeout(() => {
            searchTravel.style.display = 'none';
            taxiReservation.style.display = 'block';
        }, 500);
    });

    showTravel.addEventListener('click', (e) => {
        e.preventDefault();
        taxiReservation.classList.add('fade-out');
        searchTravel.classList.remove('fade-out');
        searchTravel.classList.add('fade-in');

        setTimeout(() => {
            taxiReservation.style.display = 'none';
            searchTravel.style.display = 'block';
        }, 500);
    });
}

toggleForms();

document.addEventListener("DOMContentLoaded", () => {
    const startInput = document.getElementById("startPlanet2");
    const endInput = document.getElementById("endPlanet2");

    function calculateDistance(start, end) {
        const x1 = (start.x + start.sub_grid_x) * 6;
        const y1 = (start.y + start.sub_grid_y) * 6;
        const x2 = (end.x + end.sub_grid_x) * 6;
        const y2 = (end.y + end.sub_grid_y) * 6;
        return Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
    }

    function updatePrices() {
        // Récupération des noms dans les champs input
        const startValue = startInput.value.trim();
        const endValue = endInput.value.trim();

        // Recherche des planètes correspondantes
        const startPlanet = planetDetails.find(planet => planet.name === startValue);
        const endPlanet = planetDetails.find(planet => planet.name === endValue);

        // Vérification et affichage
        if (!startPlanet || !endPlanet) {
            console.error("Planètes non trouvées :", startValue, endValue);
        }

        const distance = calculateDistance(startPlanet, endPlanet);

        Object.entries(companyRates).forEach(([company, rate]) => {
            const price = Math.round(distance * 100 * rate); // Exemple : 100 crédits par unité
            document.getElementById(`${company}-price`).textContent = `${price} crédits`;
        });
    }

    function onBlurHandler() {
        if (startInput.value.trim() && endInput.value.trim()) {
            updatePrices(); // Met à jour les prix si les deux champs sont remplis
        }
    }

    // Attacher les événements `blur`
    startInput.addEventListener("blur", onBlurHandler);
    endInput.addEventListener("blur", onBlurHandler);
});