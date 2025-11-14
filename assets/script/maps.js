document.addEventListener('DOMContentLoaded', function() {
    var mapContainer = document.getElementById('map');
    if (!mapContainer) {
        console.error("Div #map non trouvé !");
        return;
    }

    // Initialisation de la carte centrée sur Paris
    var map = L.map('map').setView([45.660707, 2.9368393], 13);

    // Fond OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Marqueur
    L.marker([45.660707, 2.9368393])
        .addTo(map)
        .bindPopup("Waveform")
        .openPopup();

    // Correction du rendu si le conteneur est dans un flex
    setTimeout(() => { map.invalidateSize(); }, 100);
});
