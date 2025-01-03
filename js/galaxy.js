var map = L.map('galaxy-map', {
    crs: L.CRS.Simple,
    minZoom: 3,
    attributionControl: false
});

document.getElementById('galaxy-map').style.backgroundColor = 'black';

map.fitBounds(bounds);

var regionColors = {
    'Deep Core': '#6baed6',  // Bleu clair lumineux
    'Core': '#4292c6',      // Bleu vif
    'Colonies': '#2171b5',  // Bleu riche
    'Expansion Region': '#084594',  // Bleu profond mais éclatant
    'Extragalactic': '#fd8d3c',  // Orange vif
    'Hutt Space': '#fc4e2a',     // Rouge-orange intense
    'Inner Rim Territories': '#e31a1c',  // Rouge éclatant
    'Mid Rim Territories': '#bd0026',    // Rouge pur
    'Outer Rim Territories': '#800026',  // Rouge riche et chaud
    'Talcene Sector': '#ff4500',         // Rouge-orangé chaleureux
    'The Centrality': '#ff7f00',         // Orange doré vif
    'Tingel Arm': '#ffbf00',             // Jaune doré
    'Wild Space': '#ffe100'              // Jaune clair éclatant
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

// Couleur par défaut si aucune région n'est trouvée
var defaultColor = 'gray';

// Variables pour stocker les objets Leaflet des cercles de départ et d'arrivée
var departCircle, arriveCircle;
var xDepart, yDepart, xArrive, yArrive;

// Boucler à travers chaque point (planète) et ajouter un cercle avec une couleur basée sur la région
points.forEach(function(point) {
    var diameter = point.diameter || 0; // Assigner 0 si Diameter est null ou undefined
    var region = point.region; // Accéder à la région pour cette planète
    var name = point.name.trim().toLowerCase(); // Assurer que le nom est en minuscule et sans espaces autour
    var color = regionColors[region] || defaultColor; // Récupérer la couleur de la région ou utiliser le gris par défaut
    var imageUrl = generatePlanetImageUrl(point.image); // URL de l'image de la planète
    var content = ''; // Contenu du popup

    // Différencier départ, arrivée et autres planètes
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
    var circle = name === startPlanet || name === endPlanet ? L.circle([y, x], {
        radius: getPlanetRadius(diameter), // Ajuster la taille du point
        color:  '#cdcdcd', // Couleur du bord du cercle
        fillColor: '#cdcdcd', // Couleur du remplissage du cercle
        fillOpacity: 1 // Opacité complète pour un point solide
    }).bindPopup(content).addTo(map) : L.circle([y, x], {
        radius: radius, // Ajuster la taille du point
        color: color, // Couleur du bord du cercle
        fillColor: color, // Couleur du remplissage du cercle
        fillOpacity: 1 // Opacité complète pour un point solide
    }).bindPopup(content).openPopup().addTo(map);

    // Comparer les noms et assigner les coordonnées et cercles spécifiques
    if (name === startPlanet) {
        xDepart = x;
        yDepart = y;
        departCircle = circle; // Stocker le cercle de départ
    } else if (name === endPlanet) {
        xArrive = x;
        yArrive = y;
        arriveCircle = circle; // Stocker le cercle d'arrivée
    }
});
// Ajouter la polyline après avoir amené les cercles au-dessus
if (xDepart !== undefined && yDepart !== undefined && xArrive !== undefined && yArrive !== undefined) {
    var latlngs = [
        [yDepart, xDepart],
        [yArrive, xArrive]
    ];

    // Créer et ajouter la polyline
    var polyline = L.polyline(latlngs, {color: '#cdcdcd'}).addTo(map);
}

// Une fois la boucle terminée, mettre en avant les cercles de départ et d'arrivée
if (departCircle) {
    departCircle.bringToFront(); // Met le cercle de départ au-dessus
    departCircle.color = 'black'
}

if (arriveCircle) {
    arriveCircle.bringToFront(); // Met le cercle d'arrivée au-dessus
}

// Boucle pour dessiner la grille et ajouter les labels
// var gridMargin = -20;
// var gridSpacing = 5;
// var labelSpacing = gridSpacing * 2; // Labels à chaque deux lignes
/*
    for (var i = Math.round((<?php echo $minX; ?> + gridMargin) / labelSpacing) * labelSpacing; i <= <?php echo $maxX; ?> - gridMargin; i += labelSpacing) {
// Ligne verticale de la grille
L.polyline([[<?php echo $minY; ?> + gridMargin, i], [<?php echo $maxY; ?> - gridMargin, i]], {color: 'white', weight: 0.5, opacity: 0.5}).addTo(map);

// Ajouter les labels arrondis sur chaque ligne
L.marker([<?php echo $minY; ?> + gridMargin, i], {
    icon: L.divIcon({
        className: 'label-icon',
        html: `<span style="color: white; font-size: 10px;">${Math.round(i)}</span>`,
        iconSize: [30, 12]
    })
}).addTo(map);
}

for (var j = Math.round((<?php echo $minY; ?> + gridMargin) / labelSpacing) * labelSpacing; j <= <?php echo $maxY; ?> - gridMargin; j += labelSpacing) {
// Ligne horizontale de la grille
L.polyline([[j, <?php echo $minX; ?> + gridMargin], [j, <?php echo $maxX; ?> - gridMargin]], {color: 'white', weight: 0.5, opacity: 0.5}).addTo(map);

// Ajouter les labels arrondis sur chaque ligne
L.marker([j, <?php echo $minX; ?> + gridMargin], {
    icon: L.divIcon({
        className: 'label-icon',
        html: `<span style="color: white; font-size: 10px;">${Math.round(j)}</span>`,
        iconSize: [30, 12]
    })
}).addTo(map);
}*/

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