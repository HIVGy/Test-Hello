<template>
  <v-container class="pt-12 mt-12">
    <v-layout>
      <v-app-bar :elevation="0" color="primary">
        <v-toolbar-title> Bienvenido {{ nombre }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-form @submit.prevent="logout">
          <v-btn type="submit" plain> Cerrar sesión </v-btn>
        </v-form>
      </v-app-bar>
    </v-layout>

    <h1>PRUEBA</h1>

    <cargando-component :visible="estaCargando"></cargando-component>

    <respuestas-component
      :visible="respondiendo"
      :exito="exito"
      :respuesta="respuesta"
      @reset="reset"
    ></respuestas-component>

    <v-btn @click="respondiendo = !respondiendo"></v-btn>

  </v-container>
</template>

<script>
import cargando from "../components/cargandoComponent.vue";
import respuestas from "../components/respuestasComponent.vue";

export default {
  name: "home",
  props: {
    nombre: String,
  },
  components: {
    "cargando-component": cargando,
    "respuestas-component": respuestas,
  },
  data() {
    return {
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
      respondiendo: false,
      estaCargando: false,
      exito: false,
      respuesta: '',
    };
  },
  methods: {
    logout() {
      this.estaCargando = true;
      axios.post("/logout", this.usuario).then((response) => {
        if (response.data.success) {
          window.location.href = "/";
        } else {
          this.asignarRespuesta(response.data.success, response.data.message);
        }
      });
    },
    asignarRespuesta(exito, respuesta){
      this.estaCargando = false;
      this.respondiendo = true;
      this.exito = exito;
      this.respuesta = respuesta;
    },
    reset(){
      this.respondiendo = false;
      this.exito = false;
      this.respuesta = '';
    },
  },
};
</script>