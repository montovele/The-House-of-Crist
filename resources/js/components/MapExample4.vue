<template>
  <div class="bg-gray-100 p-4">

    <div ref="map" class="map h-96"></div>
    <div class="flex items-center justify-between">
        <button class="reset-button bg-gray-200 text-gray-700 px-3 py-1 rounded-md tipograpi" @click="resetFilters">Limpiar</button>
        <button @click="centerMapOnUserLocation" class="center-button hover:bg-blue-700 text-white px-4 py-2 rounded tipograpi">
          Centrar
        </button>
      </div>
    <div class="bg-white rounded-md border py-2 px-3">
      <label for="service-type-select" class="block font-medium text-gray-700 tipograpi">Radio de Busqueda:</label>
      <select v-model="selectedLocation" class="w-full mt-1 form-select rounded-md shadow-sm tipograpi font-bold blink">
        <option disabled selected value="">Selecciona el Radio de busqueda</option>
        <option v-for="(zona, index) in zonas" :key="index" :value="zona">{{ zona.name }}</option>
      </select>
    </div>
    <div v-if="selectedLocation" class="bg-white rounded-md py-2 px-3 mt-4 border">
      <div class="mt-4 border">
        <label for="service-type-select" class="block font-medium text-gray-700 tipograpi border">Filtro por tipo de servicio:</label>
        <select id="service-type-select" v-model="selectedServiceType" class="w-full mt-1 form-select rounded-md shadow-sm tipograpi font-bold blink">
          <option value="">Todo</option>
          <option value="Restaurant">Restaurant</option>
          <option value="Cafeteria">Cafeteria</option>
        </select>
      </div>
      <div class="mt-4 border">
        <label for="distance-slider" class="block font-medium text-gray-700 tipograpi font-bold ">Filtrar por distancia (km): {{selectedDistance}}</label>
        <vue-slider v-model="selectedDistance" :min="1" :max="100" :step="1" id="distance-slider" class="mt-1"></vue-slider>
      </div>
     <img src="/images/map.png" alt="">
      <div>
  <my-modal ref="myModal"></my-modal>
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
    components: {
    VueSlider,
    MyModal,
  },
  data() {
      return {
  map: null,
  selectedLocation: null,
  selectedDistance: null,
  selectedServiceType: null, // nuevo campo
  locations: [
    { name: "D Volada", latlng: [32.4669608, -116.9380798], serviceType: "Cafeteria",id:1 ,img:"map.png"},
    { name: "Electric Coffee Roasters", latlng: [32.5137529,-117.0303605], serviceType: "Cafeteria",id:2,img:"map.png"},
    { name: "DOUX SECRET", latlng: [32.4860517,-116.9279526], serviceType: "Cafeteria",id:3,img:"map.png"},
    { name: "Comida china manfu", latlng: [32.4669575,-116.9380799], serviceType: "Restaurant",id:4,img:"map.png"},
    { name: "Café de la Flor Zona Río", latlng: [32.5261803,-117.0214433], serviceType: "Restaurant",id:5 ,img:"map.png"},

  ], zonas: [
    { name: "Tijuana", latlng: [32.4967325, -117.0302074,]},
    { name: "Tecate", latlng: [32.561938,-116.6433703]},
    { name: "Rosarito", latlng: [32.3594906,-117.0986019] },
    { name: "Ensenada", latlng: [31.8423022,-116.6923418] },
  ],
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

    this.initMap();
  },
  methods: {
    openMyModal(title, message,id) {
    this.$refs.myModal.openModal(title, message,id);
  },
  resetFilters() {
    this.selectedDistance = null;
    this.selectedServiceType = null;
  },
  centerMapOnUserLocation() {
    navigator.geolocation.getCurrentPosition((position) => {
      this.map.setView(
        [position.coords.latitude, position.coords.longitude],
        13
      );
    });
  },
  initMap() {
// Obtenemos la ubicación actual del usuario
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
}, error => {
  // Si no se puede obtener la ubicación, mostramos un mensaje de error
  console.error(`Error getting location: ${error.message}`);
});
},

transactionFunction() {
    console.log("event.target.value");
    
  },
  // Argega popup
addMarkers() {
 
  console.log(this.selectedLocation);
  this.markers = this.locations.map((location) => {
    const marker = L.marker(location.latlng);
    marker.addTo(toRaw(this.map));
    marker.bindPopup(`
      <div  class="popup-menu">
        <div class="max-w-sm rounded overflow-hidden shadow-lg">
          <img class="img-map-marker" src="/images/inside_marker_images/${location.img}" alt="">
          <div class="px-6 py-4">
            <div class="font-bold tipograpi mb-2">  <h3>${location.name}</h3></div>
            <h2 tipograpi>${location.serviceType}</h2>
            <a tipograpi about target=”_blank” href="https://www.google.com/maps/dir/32.5137529,-117.0303605/">Como llegar</a>
            <ul>
              <li><button class="my-button"> <h2 tipograpi>Reservar</h2></button></li>
            </ul>
      </div>
      </div>
    `);
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
      
      // Agregar evento al botón del popup
      const button = document.querySelector(".my-button");
      button.addEventListener('click', () => {
        if(this.selectedLocation){
          console.log('Button clicked!');
          this.openMyModal(location.name, location.serviceType, location.id);
        }
      });
    });
    return marker;
  });
},

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
    selectedLocation() {
      if (!this.selectedLocation) {
        this.markers.forEach((marker) => marker.addTo(this.map));
        return;
      }

      this.filterLocations();
    },
    selectedDistance() {
      this.filterLocations();
    },
  },
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
background-color: transparent;
color: #000000;
border: 2px solid #ff6b6b;
padding: 10px 20px;
border-radius: 20px;
font-size: 1rem;
font-weight: Roboto;
transition: all 0.3s ease;
}
.center-button {
background-color: transparent;
color: #000000;
border: 2px solid #1982cc;
padding: 10px 20px;
border-radius: 20px;
font-size: 1rem;
font-weight: Roboto;
transition: all 0.3s ease;
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

.img-map-marker{
  width: fit-content;
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
  animation: blink 2s infinite;
}
</style>
