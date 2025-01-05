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