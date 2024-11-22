const map = L.map('galaxy-map', {
    crs: L.CRS.Simple,
    minZoom: -5,
    maxZoom: 2,
    zoomControl: true
});

map.setView([500, 500], -2);

const planetIcons = {
    Tatooine: L.icon({
        iconUrl: '../images/tatooine.png',
        iconSize: [75, 75],
        iconAnchor: [20, 20],
        popupAnchor: [0, -20]
    }),
    Coruscant: L.icon({
        iconUrl: '../images/coruscant.png',
        iconSize: [75, 75],
        iconAnchor: [20, 20],
        popupAnchor: [0, -20]
    }),
    Alderaan: L.icon({
        iconUrl: '../images/alderaan.png',
        iconSize: [75, 75],
        iconAnchor: [20, 20],
        popupAnchor: [0, -20]
    })
};

const planets = [
    { name: 'Tatooine', coords: [1200, 600], icon: planetIcons.Tatooine },
    { name: 'Coruscant', coords: [6710, 7500], icon: planetIcons.Coruscant },
    { name: 'Alderaan', coords: [-4540, -1500], icon: planetIcons.Alderaan }
];

planets.forEach(planet => {
    L.marker(planet.coords, { icon: planet.icon })
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
