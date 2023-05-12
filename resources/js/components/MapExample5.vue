<template>
  <div class="bg-gray-100 p-4">
    <!-- Mapa -->
    <div ref="map" class="map h-96"></div>
    <!-- Loader -->
    <div id="loading-container" v-if="this.loading">
  <div class="loader"></div>
</div>

    <!-- Modal -->
    <my-modal ref="myModal"></my-modal>
  </div>
    <div class="menu-controls-container">
      <div class="buttons-container">
        <button class="reset-button" @click="resetFilters"><img src="/images/reset.png" alt=""></button> 
        <button @click="centerMapOnUserLocation" class="center-button"> <img src="/images/ubicacion.png" alt=""></button> 
      </div>
    <div class="menu-controls">
      <div class="controls-container">
        <div class="bg-white rounded-md border py-2 px-3 controls-item-ubication">
               <label for="service-type-select" class="block font-medium text-gray-700 tipograpi"> <h1>Radio de Busqueda:</h1></label>
              <select v-model="selectedLocation" class="w-full mt-1 form-select rounded-md shadow-sm tipograpi font-bold blink">
              <option disabled selected value="">Selecciona el Radio de busqueda</option>
              <option v-for="(zona, index) in zonas" :key="index" :value="zona">{{ zona.name }}</option>
              </select>
        </div>
        <div v-if="selectedLocation" >
        <div class="contols-item">
          <div class="mt-4 border">
        <label for="service-type-select" class="block font-medium text-gray-700 tipograpi border">Filtro por tipo de servicio:</label>
        <select id="service-type-select" v-model="selectedServiceType" class="w-full mt-1 form-select rounded-md shadow-sm tipograpi font-bold blink">
          <option value="">Todo</option>
          <option value="Restaurant">Restaurant</option>
          <option value="Cafeteria">Cafeteria</option>
        </select>
      </div>
        </div>
      </div>
        <div v-if="selectedServiceType" >
          <div class="contols-item">
            <div class="mt-4 border">
        <label for="distance-slider" class="block font-medium text-gray-700 tipograpi font-bold ">Filtrar por distancia (km): {{selectedDistance}}</label>
        <vue-slider v-model="selectedDistance" :min="1" :max="100" :step="1" id="distance-slider" class="mt-1"></vue-slider>
      </div>
          </div>
        </div>
      </div>
      </div>
  
  </div>
</template>



<script>
import L from "leaflet";
import { toRaw} from "vue";
import VueSlider from 'vue-slider-component';
import MyModal from './Modal1.vue';
import 'vue-slider-component/theme/default.css';

export default {
  name:"Mapa",
    components: {
    VueSlider,
    MyModal,
  },
  data() {
      return {
  loading:null,
  map: null,
  selectedLocation: null,
  selectedDistance: null,
  selectedServiceType: null, // nuevo campo
  //Lugares registrados
  locations: [],
  //Zonas para el radio de busqueda
   zonas: [],
  //Marcadores que aparecen en el mapa con los lugares registrados
  markers: [],
};
  },
 async mounted() {
    // Obtenemos la ubicación actual del usuario
navigator.geolocation.getCurrentPosition(position => {
  // Creamos un objeto que representa la ubicación actual del usuario
  const currentLocation = {
    name: "Mi Ubicacion",
    latlng: [position.coords.latitude, position.coords.longitude],
  };

  // Agregamos la ubicación actual a la matriz de zonas
  this.zonas.push(currentLocation);
}, error => {
  // Si no se puede obtener la ubicación, mostramos un mensaje de error
  console.error(`Error getting location: ${error.message}`);
});

    //Inicia el mapa
    this.initMap();
    //this.locations= this.fetchLocations
    //this.zones = this.fetchZones
  },
  methods: { 
    //Obtiene los lugares registrados para mostrar en el mapa
    fetchLocations(){
      //return this.$store.getters.locations
    this.locations=[
    { name: "D Volada", latlng: [32.4669608, -116.9380798], serviceType: "Cafeteria",id:1 ,img:"map.png",rating:3,ratingCount:90},
    { name: "Electric Coffee Roasters", latlng: [32.5137529,-117.0303605], serviceType: "Cafeteria",id:2,img:"map.png",rating:4,ratingCount:230},
    { name: "DOUX SECRET", latlng: [32.4860517,-116.9279526], serviceType: "Cafeteria",id:3,img:"map.png",rating:5,ratingCount:100},
    { name: "Comida china manfu", latlng: [32.4669575,-116.9380799], serviceType: "Restaurant",id:4,img:"map.png",rating:2,ratingCount:300},
    { name: "Café de la Flor Zona Río", latlng: [32.5261803,-117.0214433], serviceType: "Restaurant",id:5 ,img:"map.png",rating:2,ratingCount:250},
    { name: "Hotel Eiffel En Ensenada", latlng: [31.860818,-116.6108919], serviceType: "Hotel",id:6 ,img:"map.png",rating:4,ratingCount:12000},

  ]
    },
    //Obtiene las zonas donde se aplica el radio de busqueda
    fetchZones(){
      // return this.$store.getters.zones
      this.zonas =  [
    { name: "Tijuana", latlng: [32.4967325, -117.0302074,]},
    { name: "Tecate", latlng: [32.561938,-116.6433703]},
    { name: "Rosarito", latlng: [32.3594906,-117.0986019] },
    { name: "Ensenada", latlng: [31.8423022,-116.6923418] },
  ]
    },
    // Abre el modal
    openMyModal(title, message,id) {
    this.$refs.myModal.openModal(title, message,id);
  },
  //Reset de parametros de busqueda en mapa
  resetFilters() {
    this.selectedDistance = null;
    this.selectedServiceType = null;
  },
  //Centra el mapa en la ubicacion del usuario
  centerMapOnUserLocation() {
    navigator.geolocation.getCurrentPosition((position) => {
      this.map.setView(
        [position.coords.latitude, position.coords.longitude],
        13
      );
    });
  },
  initMap() {
  // Mostramos la animación de carga
  this.loading = true;

  navigator.geolocation.getCurrentPosition(position => {
    // Creamos el mapa y lo centramos en la ubicación del usuario
    this.map = L.map(this.$refs.map).setView([position.coords.latitude, position.coords.longitude], 13);

    // Agregamos una capa de OpenStreetMap al mapa
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: 'Map data © <a href="">Scaling Places tecnology  </a> contributors',
    }).addTo(toRaw(this.map));

    // Agregamos un marcador en la ubicación del usuario
    const userMarker = L.marker([position.coords.latitude, position.coords.longitude])
      .addTo(toRaw(this.map))
      .bindPopup('Tu estas aqui');

    // add scale control to the map
    L.control.scale().addTo(toRaw(this.map));

    // Agregamos marcadores a las ubicaciones
    this.addMarkers();

    // Ocultamos la animación de carga
    this.loading = false;
  }, error => {
    // Si no se puede obtener la ubicación, mostramos un mensaje de error
    console.error(`Error getting location: ${error.message}`);

    // Ocultamos la animación de carga
    this.loading = false;
  });
},
//Obtiene las estrellas dependiendo del rating asignado
 getStarsHtml(rating) {
  const MAX_STARS = 5;
  const ratingInt = parseInt(rating);
  const starPercentage = (ratingInt / MAX_STARS) * 100;
  const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
  const fullStars = `<div class="stars-container">
                        <div class="stars-filled" style="width: ${starPercentageRounded}"></div>
                        <div class="stars-unfilled"></div>
                     </div>`;
  return fullStars;
}
,

  // Argega popup
  addMarkers() {
  console.log(this.selectedLocation);
  this.markers = this.locations.map((location) => {
    const marker = L.marker(location.latlng);
    const starsHtml = this.getStarsHtml(location.rating);
    marker.addTo(toRaw(this.map));
    marker.bindPopup(`
      <div  class="popup-menu">
        <div class="max-w-sm rounded overflow-hidden shadow-lg">
          <div class="map-container"> 
            <div class="img-map-marker" > <img src="/images/inside_marker_images/${location.img}" alt=""></div>
          </div>
          <div class="px-6 py-4">
            <div class="rating-container">
              <div class="font-bold tipograpi mb-2">  <h3>${location.name}</h3></div>
              <div class="rating-value">${location.rating}</div>
              <div class="rating-stars">${starsHtml}</div>
              <div class="rating-count">(${location.ratingCount})</div>
            </div>
            <div> <h2 tipograpi>${location.serviceType}</h2></div>
          </div>
          <div class="container-get-service">
            <button class="get-service-button BLINK"> <h2 tipograpi>Reservar</h2></button> 
            <span class="button-icon"><i class="fas fa-arrow-right"></i></span>
          </div>
        </div>
      </div>
    `);
   // Agregar evento al botón del popup
const addButtonClickEvent = () => {
  const button = document.querySelector(".get-service-button");
  if (button !== null) {
    button.addEventListener('click', () => {
      if(this.selectedLocation){
        console.log('Button clicked!');
        this.openMyModal(location.name, location.serviceType, location.id);
      }
    });
  }
};

marker.on("click", () => {
  // Abre el popup del marcador cuando se hace clic en el marcador
  if (this.marker) {
    this.marker.openPopup();
  }
  if(!this.selectedLocation){
    console.log(location.img)
    this.zonas.map((zona)=>{
      if(zona.name === "Mi Ubicacion"){
        this.selectedLocation = zona;
        this.filterLocations();
      }
    });
  }
  
  addButtonClickEvent();
});

// Agregar evento para mostrar el popup al pasar el cursor por encima del marcador
marker.on("mouseover", () => {
  // Abre el popup del marcador cuando se hace clic en el marcador
  if (marker) {
   marker.openPopup();
  }
  if(!this.selectedLocation){
    console.log(location.img)
    this.zonas.map((zona)=>{
      if(zona.name === "Mi Ubicacion"){
        this.selectedLocation = zona;
        this.filterLocations();
      }
    });
  }
  
  addButtonClickEvent();
});


    return marker;
  });
},
//Filtra la ubicacion dependiendo de las cordenanadas de las localidades
async filterLocations() {
const selectedLocationLatLng = this.selectedLocation.latlng;
const selectedDistance = this.selectedDistance;
const selectedServiceType = this.selectedServiceType;

  const filterMarkers = (location, index) => {
  const distance = L.latLng(selectedLocationLatLng).distanceTo(L.latLng(location.latlng));
  const withinDistance = !selectedDistance || distance <= selectedDistance * 1000;
  const correctServiceType = !selectedServiceType || location.serviceType === selectedServiceType;
  const shouldShow = withinDistance && correctServiceType;

  if (shouldShow) {
    this.markers[index].addTo(this.map);
  } else {
    this.markers[index].removeFrom(this.map);
  }

  return shouldShow;
};

this.locations.filter(filterMarkers);

// Centramos el mapa en la ubicación seleccionada
this.map.setView(selectedLocationLatLng);
}



  },
  watch: {
    //Escucha el evento y asigna los valores por defecto sin aplicar filtro
    selectedLocation() {
      if (!this.selectedLocation) {
        this.markers.forEach((marker) => marker.addTo(this.map));
        return;
      }

      this.filterLocations();
    },
    //Inicia la seleccion de la ubicacion
    selectedDistance() {
      this.filterLocations();
    },
  },created(){
    this.fetchLocations();
    this.fetchZones();
  }
};
</script>

<style>
/* Estilos para el mapa */
.map {
height: 500px;
}

/* Estilos para el menú de opciones del popup */

.popup-menu {
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
}

.popup-menu h3 {
margin: 0;
font-size: 1.5rem;
}

.popup-menu ul {
list-style: none;
margin: 0;
padding: 0;
}

.popup-menu li {
margin: 10px 0;
}

.popup-menu li a {
color: #333;
text-decoration: none;
transition: color 0.2s ease-in-out;
}

.popup-menu li a:hover {
color: #007bff;
}

/* Estilos para los filtros */
.filters {
display: flex;
flex-direction: column;
align-items: flex-start;
margin-bottom: 20px;
}

.filters label {
margin-bottom: 5px;
}

.filters select {
margin-bottom: 10px;
padding: 5px;
border-radius: 5px;
border: 1px solid #ccc;
font-size: 1rem;
width: 100%;
}

/* Estilos para los botones */
.button {
padding: 10px 20px;
border-radius: 5px;
border: none;
background-color: #007bff;
color: #fff;
font-size: 1rem;
cursor: pointer;
transition: background-color 0.2s ease-in-out;
}

.button:hover {
background-color: #0062cc;
}

/* Estilos para los nuevos select de los filtros */
.filter-section {
display: flex;
flex-direction: column;
margin-bottom: 20px;
}

.filter-section label {
margin-bottom: 5px;
}

.filter-section select {
margin-bottom: 10px;
padding: 5px;
border-radius: 5px;
border: 1px solid #ccc;
font-size: 1rem;
width: 100%;
}

.filter-section select option {
color: #333;
}
.reset-button {
color: #000000;
border: 1px solid #ff0000bb;
padding: 10px 20px;
border-radius: 20px;
font-size: 1rem;
transition: all 0.3s ease;
padding: 4px;
}

.center-button {
color: #000000;
border: 1px solid #1288e3ba;
padding: 10px 20px;
border-radius: 20px;
font-size: 1rem;
transition: all 0.3s ease;
padding: 4px;
}

.buttons-container{
  display: flex;
  flex-direction: column;
  max-width: max-content;
  background-color: #ffffff;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  gap: 10px;
}
.buttons-container img{
width: 100px;
}
.reset-button img{
  width: 50px;
}
.center-button img{
  width: 50px;
}
.center-button:hover {
background-color:  #1982cc;
color: #ffffff;
cursor: pointer;
}

.reset-button:hover {
background-color: #ff6b6b;
color: #ffffff;
cursor: pointer;
}
.border{
color: #000000;
border: .8px solid rgba(rgb(24, 22, 22), rgb(27, 29, 27), rgb(60, 136, 115), .3);
padding: 10px 20px;
border-radius: 10px;
}

.img-map-marker {
  display: flex;
  height: 100px;
  width: 348px;
  overflow: hidden; /* para ocultar lo que sobrepasa el contenedor */
  position:fixed; /* necesario para que la imagen se posicione dentro del contenedor */
  box-shadow: 0px 10px 20px rgba(53, 53, 53, 0.2);
  border-radius: 5;
}
.img-map-marker img{
  position: absolute; /* para que la imagen se posicione dentro del contenedor */
  top: 0;
  left: 0;
  width: 100%;
  height: auto; /* para que la imagen conserve su relación de aspecto */
  z-index: 1; /* para que la imagen se muestre detrás del contenedor */
}
.map-container{
  display: flex;
  align-items: center;
}
.tipograpi{
  font-family: Roboto;
}

@keyframes blink {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.blink {
  animation: blink 7s infinite;
}
.stars-container {
  display: inline-block;
  position: relative;
  font-size: 0.75rem;
  color: #ddd;
  text-shadow: 1px 1px #000;
}

.stars-filled {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background-color: #ffc107;
  border-radius: 7px;
}

.stars-unfilled::before {
  content: '\2605\2605\2605\2605\2605';
}

.stars-filled::before {
  content: '\2605\2605\2605\2605\2605';
  color: #fff;
  text-shadow: 1px 1px #000;
}
.rating-zone{
  width:100px;
}
.rating-container {
  display: flex;
  align-items: center;
  width: 300px; /* ajustar según sea necesario */
  padding-top:54px;
}

.rating-value {
  margin-right: 4px;
  margin-left: 4px;
}

.rating-stars {
  margin-right: 5px;
}
.get-service-button{
justify-content: right;
float: right;
background-color: #e21c1c;
color: #ffffff;
border: 1px solid #e21c1c;
padding-bottom: 2;
padding-right: 3px;
border-radius: 3px;
font-size: 17px;
transition: all 0.3s ease;
}
.container-get-service{
  padding-left: 15rem;
}
.get-service-button:hover {
background-color:  #b10505;
color: #ffffff;
cursor: pointer;
}


.rating-count {
  margin-left: 5px;
}
.fa-arrow-right {
  font-size: 1.2rem;
}
.menu-controls-container {
  display: flex;
  align-items: center;

}



.menu-controls {
  /* Estilos de diseño del menú */
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  max-height: 470px;
  max-width: max-content;
  overflow-y: auto;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  gap: 10px;
}
.controls-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  flex-direction: column;
  overflow-y: auto;
  max-height: 180px;
  width: 828px;
}
.controls-item{
  width: 150px;
  margin: 20px;
  padding: 10px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}
.controls-item-ubication{
  width: 350px;
  margin: 20px;
  padding: 10px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}
#loading-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}
.loader {
  border: 16px solid #f3f3f3;
  border-top: 16px solid #3498db;
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}
.loader span{
  color: #ffffff;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>