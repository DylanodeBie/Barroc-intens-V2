document.addEventListener('DOMContentLoaded', function () {
    var map = L.map('map').setView([51.606721409705294, 4.778318554751258], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Als je locaties van Laravel krijgt
    if (typeof locations !== 'undefined') {
        locations.forEach(function(location) {
            L.marker([location.latitude, location.longitude]).addTo(map)
                .bindPopup(location.name);
        });
    }

    var marker = L.marker([51.606721409705294, 4.778318554751258]).addTo(map)
        .bindPopup('Onze locatie!')
        .openPopup();
});