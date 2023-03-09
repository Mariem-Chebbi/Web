 // On initialise la latitude et la longitude de Paris (centre de la carte)
 var lat = 36.842613650785914;
 var lon = 10.150719620279624;
 var macarte = null;
 // Fonction d'initialisation de la carte
 function initMap() {
     // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
     macarte = L.map('map').setView([lat, lon], 11);
     // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
     L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
         // Il est toujours bien de laisser le lien vers la source des données
         attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
         minZoom: 1,
         maxZoom: 20
     }).addTo(macarte);
 }
 window.onload = function(){
// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
initMap(); 
 };
// Nous initialisons une liste de marqueurs
var villes = {
"ONFP tunis": { "lat": 36.842613650785914 , "lon": 10.150719620279624 },
"Mawjoudin": { "lat": 36.816161364180395,  "lon": 10.178793625581282 },
"Centre 2223": { "lat": 36.84699740691096,  "lon": 10.187402368236963 },
//"Quimper": { "lat": 48.000, "lon": -4.100 },
//"Bayonne": { "lat": 43.500, "lon": -1.467 }
};
// Fonction d'initialisation de la carte
function initMap() {
// Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
macarte = L.map('map').setView([lat, lon], 11);
// Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
// Il est toujours bien de laisser le lien vers la source des données
attribution: 'données © OpenStreetMap/ODbL - rendu OSM France',
minZoom: 1,
maxZoom: 20
}).addTo(macarte);
// Nous parcourons la liste des villes
for (ville in villes) {
var marker = L.marker([villes[ville].lat, villes[ville].lon]).addTo(macarte);
marker.bindPopup(ville);
//TODO - marker.bindPopup(<a href="{{path('showCentre', {'id':ville.id})}}">centre</a>);
}

//var marker = L.marker([36.816161364180395, 10.178793625581282]).addTo(map);
//var marker = L.marker([36.84699740691096, 10.187402368236963]).addTo(map);

}