<template>
  <div class="modal-wrapper" v-if="showExampleModal">
    <div class="modal-background" @click="closeExampleModal"></div>
    <div class="modal-content">
      <div class="div-close-modal">
        <button  @click="closeExampleModal">Cerrar</button>
      </div>
      <div >
        <h2 class="title-modal">ExampleModal</h2>
      </div>
      <div class="container">
        <div class="column-1">
         <h1>1</h1>
    <!-- Contenido de la primera columna -->
       </div>
       <div class="column-2">
       <h1>2</h1>
      </div>
    </div>
    </div>
  </div>
</template>

<script>

export default {
  name:"ExampleModal",
  components: {
  
  },
  data() {
    return {
      showExampleModal: false,
    };
  },   
  computed: {

  },
  methods: {
    openControl() {
      this.showExampleModal = true;
    },
    closeExampleModal() {
      this.showExampleModal = false;
    },
  },  
  created() {

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
  }

</style>