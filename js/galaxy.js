const map = L.map('galaxy-map', {
    crs: L.CRS.Simple,
    minZoom: -5,
    maxZoom: 2,
    zoomControl: true
});

map.setView([500, 500], -2);

const planets = [
    { name: 'Tatooine', coords: [200, 300] },
    { name: 'Coruscant', coords: [700, 800] },
    { name: 'Alderaan', coords: [500, 400] }
];

planets.forEach(planet => {
    L.marker(planet.coords)
        .addTo(map)
        .bindPopup(`<b>${planet.name}</b>`);
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
