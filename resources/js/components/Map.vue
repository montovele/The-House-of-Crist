<template>
    <div id="map">
      <l-map :zoom="zoom" :center="center" ref="map">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        <l-marker v-for="marker in sortedMarkers" :key="marker.id" :lat-lng="marker.latlng">
          <l-popup :content="marker.content"></l-popup>
        </l-marker>
      </l-map>
  
      <div class="search-container">
        <input v-model="query" placeholder="Buscar proveedores de servicios..." @keyup.enter="search">
        <button @click="search">Buscar</button>
        <div>
          <label for="sort-by">Ordenar por:</label>
          <select id="sort-by" v-model="sortBy" @change="sortMarkers">
            <option value="availability">Disponibilidad</option>
            <option value="service_type">Tipo de servicio</option>
          </select>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
  import axios from 'axios';
  
  export default {
    components: {
      LMap,
      LTileLayer,
      LMarker,
      LPopup,
    },
    data() {
      return {
        zoom: 13,
        center: [37.7749, -122.4194],
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        markers: [],
        query: '',
        sortBy: 'availability',
      };
    },
    computed: {
      sortedMarkers() {
        return this.markers.slice().sort((a, b) => {
          if (this.sortBy === 'availability') {
            return b.availability.localeCompare(a.availability);
          } else {
            return a.service_type.localeCompare(b.service_type);
          }
        });
      },
    },
    methods: {
    search() {
      // Obtener la ubicación actual del usuario
      navigator.geolocation.getCurrentPosition((position) => {
        const { latitude, longitude } = position.coords;

        // Realizar la búsqueda en el backend
        axios.get('/api/providers', {
          params: {
            latitude,
            longitude,
            query: this.query,
          },
        }).then((response) => {
          this.markers = response.data.map((provider) => ({
            id: provider.id,
            latlng: [provider.latitude, provider.longitude],
            content: `
              <h4>${provider.name}</h4>
              <p>Tipo de servicio: ${provider.service_type}</p>
              <p>Disponibilidad: ${provider.availability}</p>
            `,
            availability: provider.availability,
            service_type: provider.service_type,
          }));

          // Ajustar el zoom del mapa para que muestre todos los marcadores
          this.$nextTick(() => {
            const bounds = this.$refs.map.map.getBounds();
            this.$refs.map.map.fitBounds(bounds);
          });

          // Ordenar los marcadores por defecto por disponibilidad
          this.sortMarkers();
        }).catch((error) => {
          console.log(error);
        });
      });
    },
    sortMarkers() {
      this.markers.sort((a, b) => {
        if (this.sortBy === 'availability') {
          return b.availability.localeCompare(a.availability);
        } else {
          return a.service_type.localeCompare(b.service_type);
        }
      });
    },
  },
};
</script>