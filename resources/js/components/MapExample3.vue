<template>
  <div style="height:600px; width:800px">
    <div class="controls">
      <select  @change="onselect">
        <option value="">Seleccione Tipo</option>
        <option v-for="(tipo, index) in this.tipo" :value="index">{{ tipo.tipo }}</option>
      </select>
      <select  @change="onChange">
        <option value="">Seleccione Disponibilidad</option>
        <option v-for="(disponibilidad, index) in this.disponibilidad" :value="index">{{ disponibilidad.disponibilidad }}</option>
      </select>
    </div>
    <l-map ref="map" v-model:zoom="zoom" :center="center">
      <l-tile-layer
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        layer-type="base"
        name="OpenStreetMap"
      ></l-tile-layer>
      <l-marker
        v-for="(marker, index) in sortedMarkers"
        :key="index"
        :lat-lng="[marker.lat, marker.lng]"
      >
        <l-popup>
          <div class="popup">
            <div class="popup-title">{{ marker.title }}</div>
            <div class="popup-info">
              <div><span>Tipo de Servicio: </span>{{ marker.tipo }}</div>
              <div><span>Disponibilidad: </span>{{ marker.disponibilidad }}</div>
            </div>
          </div>
        </l-popup>
      </l-marker>
    </l-map>
  </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import 'leaflet/dist/leaflet.css';
import axios from "axios";

export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
  },
  data() {
    return {
      zoom: 16,
      center: [],
     unicos : [],
      markers: [
    {
      lat: 32.4650454,
      lng: -116.9071413,
      title: "Tacos El Paisa",
      tipo: "Restaurant",
      disponibilidad: "Disponible",
    },
    {
      lat: 32.4643385,
      lng: -116.9140287,
      title: "Restaurant San Marcos Insurgentes",
      tipo: "Restaurant",
      disponibilidad: "No disponible",
    },
    {
      lat: 32.4643385,
      lng: -116.9327648,
      title: "DPH TECHNICAL RESOURCES",
      tipo: "Fontanero",
      disponibilidad: "Disponible",
    },
  ], disponibilidad: [
    {
      disponibilidad: "Disponible",
    },
    {
      disponibilidad: "No disponible",
    },
  ], tipo: [
    {
      tipo: "Restaurant",
    },
    {
      tipo: "Hospital",
    },{
      tipo:"Fontanero"
    }
  ],
    };
  },
  methods: {
    onChange(event) {
      console.log(event.target.value);

      
    },
    getMyLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          this.center = [position.coords.latitude, position.coords.longitude];
        });
      }
    },
    setCenterPos() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
      this.center = [position.coords.latitude, position.coords.longitude];
    });
  }
},
  },

  computed: {
    sortedMarkers() {
  return this.markers.sort((a, b) => {
    if (a.disponibilidad !== b.disponibilidad) {
      return a.disponibilidad === "Disponible" ? -1 : 1;
    }
    return a.tipo.localeCompare(b.tipo);
  });
},


},
  mounted() {
    // Obtenemos la ubicación del usuario
    this.getMyLocation();
  },
  created() {
  this.setCenterPos();
},

};
</script>

<style>
.popup {
  text-align: center;
}

.popup-title {
  font-weight: bold;
  font-size: 16px;
  margin-bottom: 5px;
}

.popup-info {
  display: flex;
  flex-direction: column;
}

.popup-info > div {
  margin-bottom: 5px;
}

.popup-info > div > span {
  font-weight: bold;
}

.leaflet-control-custom {
  background-color: white;
  border-radius: 2px;
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.65);
  cursor: pointer;
  display: flex;
  height: 34px;
  justify-content: center;
  margin: 5px;
  width: 34px;
}

.leaflet-control-custom:hover {
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.65);
}

.leaflet-control-custom button {
  background-color: transparent;
  border: none;
  color: #333;
  cursor: pointer;
  font-size: 1.25rem;
  padding: 0;
}

</style>