<template>
  <div style="height:600px; width:800px">
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
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
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
      zoom: 12,
      center: [32.4629769, -113.2526363],
      markers: [
    {
      lat: 32.4650454,
      lng: -116.9071413,
      title: "Tacos El Paisa",
      tipo: "Restaurante",
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
  ],
    };
  },
  methods: {
    getMyLocation() {
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
      // Primero se ordena por disponibilidad, luego por tipo de servicio
      if (a.disponibilidad !== b.disponibilidad) {
        if (a.disponibilidad === "Disponible") {
          return -1;
        } else {
          return 1;
        }
      } else {
        if (a.tipo < b.tipo) {
          return -1;
        } else {
          return 1;
        }
      }
    });
  },
},
  mounted() {
    // Obtenemos la ubicación del usuario
    this.getMyLocation();
    // Obtenemos los proveedores desde el servidor
  //   axios.get("http://localhost:3000/proveedores").then((response) => {
  //     this.markers = response.data;
  //     // Ordenamos los marcadores
  //     this.markers.sort((a, b) => {
  //       // Primero se ordena por disponibilidad, luego por tipo de servicio
  //       if (a.disponibilidad !== b.disponibilidad) {
  //         if (a.disponibilidad === "Disponible") {
  //           return -1;
  //         } else {
  //           return 1;
  //         }
  //       } else {
  //         if (a.tipo < b.tipo) {
  //           return -1;
  //         } else {
  //           return 1;
  //         }
  //       }
  //     });
  //   });
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
</style>