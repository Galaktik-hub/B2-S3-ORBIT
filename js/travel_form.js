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

    // Event listener to handle form submission and log search information
    // $('#searchForm').on('submit', function(event) {
    //     event.preventDefault(); // Prevent default form submission
    //
    //     const startPlanet = $('#startPlanet').val();
    //     const endPlanet = $('#endPlanet').val();
    //     const date = $('#date').val();
    //     const passengers = $('#passengers').val();
    //     const shipName = $('#shipName').val();
    //
    //     // Perform AJAX call to log the search
    //     $.ajax({
    //         url: '../../scripts/log_search.php', // The PHP script handling log insertion
    //         method: 'POST',
    //         data: {
    //             startPlanet: startPlanet,
    //             endPlanet: endPlanet,
    //             date: date,
    //             passengers: passengers,
    //             shipName: shipName
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success) {
    //                 window.location.href = "travelResult.php";
    //             } else {
    //                 alert('Failed to log the search.');
    //             }
    //         },
    //         error: function() {
    //             alert('An error occurred during search registration.');
    //         }
    //     });
    // });
});