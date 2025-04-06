$(document).ready(function() {
    // Function to handle AJAX imports
    function importData(url, feedbackElement, successMessage, errorMessage) {
        // Display waiting text
        $(feedbackElement).text("Import in progress, please wait...").removeClass("text-success text-danger").addClass("text-info");

        $.ajax({
            url: url,
            method: "POST",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $(feedbackElement).text(successMessage).addClass("text-success").removeClass("text-danger");
                } else {
                    $(feedbackElement).text(response.message || errorMessage).addClass("text-danger").removeClass("text-success");
                }
            },
            error: function() {
                $(feedbackElement).text(errorMessage).addClass("text-danger").removeClass("text-success");
            }
        });
    }

    // Event listeners for import buttons
    $('#importShips').click(function() {
        importData('../scripts/import_ships.php', '#importFeedback', 'Successful ships import !', 'Error when importing ships.');
    });
    $('#importPlanets').click(function() {
        importData('../scripts/import_planets.php', '#importFeedback', 'Successful planets import !', 'Error when importing planets.');
    });
});