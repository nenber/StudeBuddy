import L from 'leaflet';

L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

// Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"

var carte = L.map('map').setView([51.505, -0.09], 13);

// Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr

L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', { // Il est toujours bien de laisser le lien vers la source des données
    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20
}).addTo(carte);

var marker = L.marker([51.505, -0.09]).addTo(carte);
marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();