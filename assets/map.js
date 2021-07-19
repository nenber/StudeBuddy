import L from 'leaflet';
import marker_icon_2Path from './img/marker-icon-2x.png';
import marker_iconPath from './img/marker-icon.png';
import marker_shadowPath from './img/marker-shadow.png';
/*
var myIcon = L.icon({
    iconUrl: 'build/images/marker-icon.png',
    shadowUrl: 'build/images/marker-shadow.png',
});*/

L.Icon.Default.mergeOptions({
    iconRetinaUrl:  marker_icon_2Path,
    iconUrl: marker_iconPath,
    shadowUrl: marker_shadowPath,
});

// Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"

var carte = L.map('map').setView([48.866667, 2.333333], 13);

// Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr

L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', { // Il est toujours bien de laisser le lien vers la source des données
    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20
}).addTo(carte);

// var markers = [
//     {pos: [51.51, -0.10], popup: "This is the popup for markeicon_marker_shadowicon_marker_shadowr #1"},
//     {pos: [51.50, -0.09], popup: "This is the popup for marker #2"},
//     {pos: [51.49, -0.08], popup: "This is the popup for marker #3"}];
console.log(markers)
markers.forEach(function(obj) {
    let id = obj[0];
    let adress = obj[1];
    let la = obj[2];
    let ln = obj[3];
    let url = obj[4]

    var m = L.marker([la, ln]).addTo(carte),
        p = new L.Popup({ autoClose: false, closeOnClick: false })
        // .setContent(`<a href={{ path("event_join", "id": ${route}) | escape("js") }}>Rejoindre l'evenement</a>`)
        .setContent("<button class='btn-l green color-white'><a href=" + obj[4] + ">Rejoindre l'evenement<br> - <br>" + obj[1] + "</a></button>")
        .setLatLng([la, ln]);
    m.bindPopup(p);
});