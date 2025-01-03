var map = L.map('galaxy-map', {
    crs: L.CRS.Simple,
    minZoom: 3,
    attributionControl: false
});

document.getElementById('galaxy-map').style.backgroundColor = 'black';

map.fitBounds(bounds);

var regionColors = {
    'Deep Core': '#6baed6',
    'Core': '#4292c6',
    'Colonies': '#2171b5',
    'Expansion Region': '#084594',
    'Extragalactic': '#fd8d3c',
    'Hutt Space': '#fc4e2a',
    'Inner Rim Territories': '#e31a1c',
    'Mid Rim Territories': '#bd0026',
    'Outer Rim Territories': '#800026',
    'Talcene Sector': '#ff4500',
    'The Centrality': '#ff7f00',
    'Tingel Arm': '#ffbf00',
    'Wild Space': '#ffe100'
};

function getDiameterScale(diameter) {
    if (diameter === 0) return 0.1;
    if (diameter > 0 && diameter <= 50000) return 0.3;
    if (diameter > 50000 && diameter <= 100000) return 0.5;
    if (diameter > 100000 && diameter <= 150000) return 0.7;
    if (diameter > 150000 && diameter <= 200000) return 0.9;
    if (diameter > 200000) return 1.1;
}
function getPlanetRadius(diameter, scale = 4) {
    // Le diamètre de base est 2, donc on ajuste proportionnellement
    return (diameter / 50000) * scale; // Ajuster l'échelle ici si nécessaire
}
function generatePlanetImageUrl(image) {
    if (image) {
        const imageName = image.replace(/\s+/g, '_');
        const md5Hash = md5(imageName);
        const url = `https://static.wikia.nocookie.net/starwars/images/${md5Hash[0]}/${md5Hash.substring(0, 2)}/${imageName}`;
        return url;
    }
    return "No image available";
}

var defaultColor = 'gray';

var departCircle, arriveCircle;
var xDepart, yDepart, xArrive, yArrive;
var latlngs = [];

points.forEach(function(point) {
    var diameter = point.diameter || 0;
    var region = point.region;
    var name = point.name.trim().toLowerCase();
    var color = regionColors[region] || defaultColor;
    var imageUrl = generatePlanetImageUrl(point.image);
    var content = '';

    if (name === startPlanet) {
        content = `
            <b>Type:</b> Departure<br>
            <b>Name:</b> ${point.name}<br>
            <img src="${imageUrl}" alt="${point.name}" style="width: 100px; height: 100px; object-fit: cover;">
        `;
    } else if (name === endPlanet) {
        content = `
            <b>Type:</b> Arrival<br>
            <b>Name:</b> ${point.name}<br>
            <img src="${imageUrl}" alt="${point.name}" style="width: 100px; height: 100px; object-fit: cover;">
        `;
    } else {
        content = `
            <b>Name:</b> ${point.name}<br>
            <img src="${imageUrl}" alt="${point.name}" style="width: 100px; height: 100px; object-fit: cover;">
        `;
    }

    var x = (point.x + point.sub_grid_x) * 6;
    var y = (point.y + point.sub_grid_y) * 6;
    var radius = getDiameterScale(diameter);

    // Créer le cercle pour chaque planète
    var planetInRoute = routePlanets.includes(name);
    var circle = L.circle([y, x], {
        radius: name === startPlanet || name === endPlanet ? getPlanetRadius(diameter) : radius,
        color: planetInRoute ? '#cdcdcd' : color,
        fillColor: planetInRoute ? '#cdcdcd' : color,
        fillOpacity: 1
    }).bindPopup(content).addTo(map);

    if (name === startPlanet) {
        xDepart = x;
        yDepart = y;
        departCircle = circle;
    } else if (name === endPlanet) {
        xArrive = x;
        yArrive = y;
        arriveCircle = circle;
    }
});
routePlanets.forEach(function(routePlanet) {
    var planet = points.find(function(point) {
        return point.name.trim().toLowerCase() === routePlanet.toLowerCase();
    });
    if (planet) {
        var x = (planet.x + planet.sub_grid_x) * 6;
        var y = (planet.y + planet.sub_grid_y) * 6;

        latlngs.push([y, x]);
    }
});
if (latlngs.length > 1) {
    var polyline = L.polyline(latlngs, {color: '#cdcdcd'}).addTo(map);
}

if (departCircle) {
    departCircle.bringToFront();
}
if (arriveCircle) {
    arriveCircle.bringToFront();
}

// Existing code for creating the region color legend
var legend = document.getElementById("legend");
legend.innerHTML += "<br><strong>Region</strong><br>";
for (var region in regionColors) {
    var color = regionColors[region];
    var item = `<div class="legend-item">
                <span class="color-box" style="background-color: ${color}; width: 10px; height: 10px; border: none"></span>
                <span class="legend-text">${region}</span>
            </div>`;
    legend.innerHTML += item;
}

// Add diameter legend section
legend.innerHTML += "<br><strong>Diameter</strong><br>";

var diameterSizes = [
    { diameter: 0, label: "0" },
    { diameter: 50000, label: "50,000" },
    { diameter: 100000, label: "100,000" },
    { diameter: 150000, label: "150,000" },
    { diameter: 200000, label: "200,000" },
    { diameter: 250000, label: "250,000" }
];

// Function to get diameter legend scale for consistent legend display
function getLegendDiameterScale(diameter) {
    if (diameter === 0) return 3;         // Plus petit cercle pour 0
    if (diameter > 0 && diameter <= 50000) return 5; // Proportionnel à 0.3
    if (diameter > 50000 && diameter <= 100000) return 7; // Proportionnel à 0.5
    if (diameter > 100000 && diameter <= 150000) return 9; // Proportionnel à 0.7
    if (diameter > 150000 && diameter <= 200000) return 11; // Proportionnel à 0.9
    if (diameter > 200000) return 13;    // Proportionnel à 1.1
}

// Add diameter items to legend
diameterSizes.forEach(function(size) {
    var diameterScale = getLegendDiameterScale(size.diameter);
    var diameterItem = `<div class="legend-item">
                            <span class="color-box" style="width: ${diameterScale}px; height: ${diameterScale}px; background-color: black; border: none"></span>
                            <span class="legend-text">${size.label}</span>
                        </div>`;
    legend.innerHTML += diameterItem;
});


const starLayer = L.layerGroup().addTo(map);

function generateStars(numberOfStars = 6000) {
    const minCoord = -50000;
    const maxCoord = 50000;

    for (let i = 0; i < numberOfStars; i++) {
        const lat = Math.random() * (maxCoord - minCoord) + minCoord;
        const lng = Math.random() * (maxCoord - minCoord) + minCoord;

        const star = L.circleMarker([lat, lng], {
            radius: Math.random() * 2 + 1,
            color: 'white',
            fillColor: 'white',
            fillOpacity: 0.8,
            opacity: 0.5,
        });

        star.addTo(starLayer);
    }
}

generateStars();