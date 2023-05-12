<template>
  <div class="modal-wrapper" v-if="showModal">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="div-close-modal">
        <button  @click="closeModal">Cerrar</button>
      </div>
      <div >
        <h2 class="title-modal">{{title}}</h2>
      </div>
      <div class="container">
        <div class="column-1">
      <calendar @capturarHoraFecha="obtenerHoraFecha"></calendar>
    <!-- Contenido de la primera columna -->
  </div>
  <div class="column-2">
    <div class="dashboard">
      <div class="menu-container">
        <div class="menu">
    <div class="header">
    <!-- contenedor para mostrar la fecha y hora de reserva -->
      <div class="selected-time">
  <span class="selected-date">{{ date }}</span>
  <span class="selected-hour">{{ time }}</span>
</div>
    </div>
    <!-- contenedor para mostrar las pestañas -->
    <div class="folder-tabs">
    <div class="tab-container">
      <span class="tab-buttons " @click="selectedTab = 'products'">Productos</span>
      <span class="tab-buttons " @click="selectedTab = 'services'">Servicios</span>
    </div>
    </div>
    <!-- contenedor para mostrar los productos disponibles -->
    <div class="product-container" v-if="selectedTab === 'products'">
      <span class="arrow">→</span>
      <div v-for="product in sortedProducts" class="product-item">
        <h3>{{ product.name }}</h3>
        <div v-if="product.available" class="not-available"> <span>No disponible</span> </div>
        <p>Precio: ${{ product.price.toFixed(2) }}</p>
        <p>Categoría: {{ product.category }}</p>
        <button @click="addProduct(product)">Agregar</button>
      </div>
    </div>
    <!-- contenedor para mostrar los servicios disponibles -->
        <div class="service-container" v-if="selectedTab === 'services'">
      <span class="arrow">→</span>
      <div v-for="service in sortedService" class="product-item">
        <h3>{{ service.name }}</h3>
        <div v-if="service.available" class="not-available"> <span>No disponible</span> </div>
        <p>Precio: ${{ service.price.toFixed(2) }}</p>
        <p>Categoría: {{ service.category }}</p>
        <button @click="addService(service)">Agregar</button>
      </div>
    </div>
    
    <!-- contenedor para mostrar los productos y servicios seleccionados -->
    <div class="product-service-reserved" v-if="reservationList.length > 0">
    <div v-for="(reservated,id ) in reservationList" class="product-item-reserved">
      <div class="delete-reserved">
        <span class="delete-product">×</span>
      </div>
      <div class="reservated-quantity">
          <div v-if="reservated.quantity" >{{ reservated.quantity }}</div>
        </div>
      <div>
        <h4>{{ reservated.name }}</h4>
        <p>Precio: ${{ reservated.price.toFixed(2) }}</p>
      </div>
    </div>
  </div>
  </div>
</div>
</div>

  </div>
</div>


      </div>
  </div>
</template>

<script>
import Calendar from './Calendar.vue';

export default {
  name:"Modal",
  components: {
    Calendar
  },
  data() {
    return {
      selectedTab: 'products',
      products:[], 
      services:[],
    reservationList: [],
      sortBy: null,
      showModal: false,
      title: "",
     date:null,
     time:null,
    };
  },   computed: {
    sortedProducts() {
      if (this.sortBy === 'price') {
        return this.products.sort((a, b) => a.price - b.price);
      } else if (this.sortBy === 'category') {
        return this.products.sort((a, b) => a.category.localeCompare(b.category));
      } else {
        return this.products;
      }
    },
    sortedService() {
      if (this.sortBy === 'price') {
        return this.services.sort((a, b) => a.price - b.price);
      } else if (this.sortBy === 'category') {
        return this.services.sort((a, b) => a.category.localeCompare(b.category));
      } else {
        return this.services;
      }
    }
  },
  methods: {
    openModal(title, message,id) {
      this.title = title;
      this.message = message;
      this.id = id;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.reservationList=[];
      this.date=null;
      this.time=null;
    },
    obtenerHoraFecha(date,time){
      console.log(date,time)
      this.date= date;
      this.time=time;
    },
    fetchProducts() {
      // Aquí se realiza la petición al backend para obtener los productos
      // y se asignan a la propiedad 'products'
      this.products =  [
  { name: 'Producto 1', price: 9.99, category: 'Categoría A' ,available:true,id:1},
  { name: 'Producto 2', price: 19.99, category: 'Categoría B' ,available:false,id:2},
  { name: 'Producto 3', price: 14.99, category: 'Categoría A' ,available:true,id:3},
  { name: 'Producto 4', price: 24.99, category: 'Categoría C',available:true ,id:4},
  { name: 'Producto 5', price: 29.99, category: 'Categoría B',available:false ,id:5}
]
    },
    fetchServices() {
      // Aquí se realiza la petición al backend para obtener los productos
      // y se asignan a la propiedad 'products'
      this.services =  [
  { name: 'Service 1', price: 9.99, category: 'Categoría A' ,available:true,id:6},
  { name: 'Service 2', price: 19.99, category: 'Categoría B' ,available:false,id:7},
  { name: 'Service 3', price: 14.99, category: 'Categoría A' ,available:true,id:8},
  { name: 'Service 4', price: 24.99, category: 'Categoría C',available:true ,id:9},
  { name: 'Service 5', price: 29.99, category: 'Categoría B',available:false ,id:10}
]
    },
    sortByPrice() {
      this.sortBy = 'price';
    },
    sortByCategory() {
      this.sortBy = 'category';
    },
    addProduct(product) {
        // Verificar si el servicio ya está en la lista de reservados
    const reservedProduct = this.reservationList.find(item => item.id === product.id);
    if (reservedProduct) {
      // Si el servicio ya está reservado, aumentar la cantidad en 1
      reservedProduct.quantity++;
      console.log(this.products)
    } else {
      // Si el servicio no está reservado, agregarlo a la lista con una cantidad de 1
      if(!product.available) {
      this.reservationList.push({
        id: product.id,
        name: product.name,
        price: product.price,
        category: product.category,
        quantity: 1
      });
      console.log(this.reservationList)
      }
    }
     },
     addService(service) {
    // Verificar si el servicio ya está en la lista de reservados
    const reservedService = this.reservationList.find(item => item.id === service.id);
    if (reservedService) {
      // Si el servicio ya está reservado, aumentar la cantidad en 1
      reservedService.quantity++;
      console.log(this.reservationList)
    } else {
      // Si el servicio no está reservado, agregarlo a la lista con una cantidad de 1
      if(!service.available) {
      this.reservationList.push({
        id: service.id,
        name: service.name,
        price: service.price,
        category: service.category,
        quantity: 1
      });
      console.log(this.reservationList)
      }
    }
  

     },
  },  
  created() {
    this.fetchProducts();
    this.fetchServices();
  }
};
</script>
<style scoped>
.modal-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  /* background-color: rgba(0, 0, 0, 0.5);
  z-index: -1; */
}

.modal-content {
  background-color: #fff;
  border-radius: 8px;
  max-width: 90%;
  max-height: 90%;
  overflow-y: auto;
  padding: 24px;
  text-align: center;
  width: auto;
  position: relative;
  z-index: 1;
  width: 950px;
  height: 590px;
}

h2 {
  color: #222;
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 16px;
}

p {
  color: #666;
  font-size: 16px;
  line-height: 24px;
  margin-bottom: 32px;
}

button {
  background-color: #222;
  border: none;
  border-radius: 8px;
  color: #fff;
  cursor: pointer;
  font-size: 16px;
  font-weight: 700;
  padding: 12px 24px;
  transition: background-color 0.2s ease-in-out;
}

button:hover {
  background-color: #444;
}
.div-close-modal {
  display: flex;
  justify-content: flex-end;
}

.div-close-modal button {
  align-self: flex-end;
}
.title-modal{
display: flex;
justify-content:space-between;
}

.container {
  display: flex;
  flex-direction: row;
}

.column-1 {
  flex: 1;
}

.column-2 {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex-basis: 150px; /* Ancho fijo de la segunda columna */
}


.menu h2 {
  margin-top: 0;
}

.products h3 {
  margin-top: 0;
}

ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

li {
  background-color: #ffffff;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
}
.dashboard {
  background-color: #ffffff;
  border-radius: 10px;
}

.dashboard h2 {
  margin-top: 0;
}

.date-time {
  display: flex;
  justify-content: space-between;
  flex-direction: row;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}
.products h3 {
  margin-top: 0;
}

ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

li {
  background-color: #e1e1e1;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
}

@media (max-width: 768px) {
  .dashboard {
    display: flex;
    flex-direction: column;
  }

  .header {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .products {
    margin-top: 30px;
    
  }
}
.products {
  margin-top: 20px;
  width: 180%;
  margin: 0 auto;
  text-align: center;
  background-color: #f2f2f2;
  padding: 10px;
  overflow-x: scroll;
}

.sort-button {
  display: inline-block;
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  margin-right: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.sort-button:hover {
  background-color: #3e8e41;
}

.product-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  flex-direction: column;
  overflow-y: auto;
}
.service-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  flex-direction: column;
  overflow-y: auto;
}
.product-service-reserved{
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  flex-direction: column;
  overflow-y: auto;
  max-height: 400px;
}

.product-item {
  width: 150px;
  margin: 20px;
  padding: 20px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}
.product-item-reserved {
  width: auto;
  height: 100px;
  margin: 20px;
  padding: 20px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
  transform: scale(0.6); /* reducir el tamaño de los productos reservados */
  /* hacer que los productos reservados sean un poco menos visibles */
  /* opacity: 0.1; */
  font-size: small;
align-items: center;
font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}
.product-item:hover {
  transform: translateY(-5px);
  box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.3);
}
.menu-container {
  display: flex;
  align-items: center;
}

.menu {
  /* Estilos de diseño del menú */
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  max-height: 470px;
  max-width: max-content;
  overflow-y: auto;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  gap: 10px;
}
h2 {
  font-size: 24px;
  margin-bottom: 10px;
}


.product-item {
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.product-item h3 {
  font-size: 18px;
  margin-bottom: 5px;
}

.product-item p {
  margin-bottom: 5px;
}
.selected-time {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-family: Arial, sans-serif;
  font-size: 0.9rem;
  color: #333;
  background-color: #f5f5f5;
  padding: 8px;
  border-radius: 5px;
}

.selected-date {
  font-weight:bold;
  margin-bottom: 0.5rem;
}

.selected-hour {
  font-size: 1.5rem;
  font-weight:lighter;;
}

.productos-container {
  position: relative;
}


.arrow {
  display: block;
  font-size: 2rem;
  font-weight: bold;
  color: #ff0000b9;
  position: relative;
  animation: moveRight 1s ease-in-out infinite alternate;
  padding-bottom: 20px;
}

@keyframes moveRight {
  from {
    left: 0;
  }
  to {
    left: 40px;
  }
}
.reservation-container {
  margin-top: 20px;
  padding: 10px;
  background-color: #f1f1f1;
  border-radius: 10px;
  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
}

.reservation-container h2 {
  margin-top: 0;
  font-size: 24px;
  font-weight: bold;
}

.reservation-container p {
  margin: 10px 0;
}
.tab-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  border-bottom: 1px solid #ccc;

}

.tab-buttons {
  width: 45%;
  text-align: center;
  background-color: #000000;
  font-size: 10px;
  border-radius: 5px;
  margin-bottom: 50px;
  display: block;
  padding: 10px;
  font-weight: bold;
  color: #ffffff;
  border-right: 1px solid #ccc;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

@media only screen and (max-width: 768px) {
  .tab-buttons {
    width: 100%;
  }
}
.folder-tabs {
  display: flex;
  flex-direction: column;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 5px;
  overflow: hidden;
}

.tab-buttons:hover {
  background-color: #ddd;
}

.tab-buttons.active {
  background-color: #fff;
  border-bottom: none;
  cursor: default;
}
/* Boton para eliminar producto reservado */
.delete-reserved{
  justify-content: right;
  float: right;
  padding-left: 2rem;


}
.delete-product {
  text-align: center;
  background-color: #ff0000ba;
  color: #ffffff;
  font-size: 20px;
  border-radius: 20%;
  cursor: pointer;
}
.reservated-quantity{
  justify-content: left;
  float: left;
  background-color: #000000;
  color: #ffffff;
  font-weight: bold;
  font-size: 20px;
}
.title-products-reserverd{
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #f5f5f5;
  border-radius: 5px;

}
.title-products-reserverd p{
  font-family: Arial, sans-serif;
  font-size: 0.9rem;
  color: #0d0d0d;
}
.not-available span{
  background-color: #ff000031;
  color: #ffffff;
  border-radius: 5px;
}
</style>