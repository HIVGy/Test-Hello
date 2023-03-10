<template>
  <v-container class="pt-12 mt-12" background-color="teal-lighten-3">
    <!-- Formulario de inicio de sesión -->
    <v-sheet class="pt-12 mt-12 mx-auto" width="50%" elevation="4">
      <v-form
        @submit.prevent="login"
        ref="formUser"
        id="userForm"
        class="mx-12"
      >
        <input type="hidden" name="_token" :value="csrf" />
        <h1 class="text-h6 my-6 text-center" color="info">Inicia sesión</h1>
        <v-text-field
          v-model="usuario.email"
          class="mb-4"
          prepend-inner-icon="mdi-account"
          label="Correo electrónico"
          placeholder="john@gmail.com"
          color="secondary"
          :rules="[reglas.requerido, reglas.email]"
        />
        <v-text-field
          v-model="usuario.password"
          class="mb-4"
          prepend-inner-icon="mdi-shield-lock"
          :append-inner-icon="mostrarPass ? 'mdi-eye' : 'mdi-eye-off'"
          @click:append-inner="mostrarPass = !mostrarPass"
          :type="mostrarPass ? 'text' : 'password'"
          label="Contraseña"
          placeholder="Escribe tu contraseña"
          color="secondary"
          :rules="[reglas.requerido]"
        />
        <div class="text-center text-white pb-12">
          <v-btn type="submit" form="userForm" color="primary">
            Iniciar sesión
          </v-btn>
        </div>
      </v-form>
    </v-sheet>

    <!-- Ventana flotante de simbolo de carga -->
    <cargando-component :visible="estaCargando"></cargando-component>

    <!-- Ventana flotante con alerta con mensajes de respuesta -->
    <respuestas-component
      :visible="respondiendo"
      :respuesta="respuesta"
      :exito="exito"
      @reset="reset"
    />

  </v-container>
</template>

<script>
import cargando from "../components/cargandoComponent.vue";
import respuestas from "../components/respuestasComponent.vue";

export default {
  name: "login",
  components: {
    "cargando-component": cargando,
    "respuestas-component": respuestas,
  },
  data() {
    return {
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
      //Variables para controlar la visiblidad de los apartados de la página
      mostrarPass: false,
      respondiendo: false,
      estaCargando: false,
      //Variables para asignar valores al componente de respuestas
      exito: false,
      respuesta: "",
      //Variables usadas por el formulario de inicio de sesión
      usuario: {},
      reglas: {
        requerido: (v) => !!v || "Campo requerido",
        email: (v) => {
          const patron = /.+@.+..+/;
          return patron.test(v) || "Ingrese un correo valido";
        },
      },
    };
  },
  methods: {
    async login() {
      this.estaCargando = true;
      const { valid } = await this.$refs.formUser.validate();
      if (valid) {
        axios.post("/login", this.usuario).then((response) => {
          this.asignarRespuesta(response.data.success, response.data.message);
        });
      } else {
        //Cierra la ventana flotante de cargando si hay un error en el formulario
        this.estaCargando = false;
      }
    },
    /* Funciones para controlar el componente de respuestas */
    asignarRespuesta(exito, respuesta) {
      this.estaCargando = false;
      this.respondiendo = true;
      this.exito = exito;
      this.respuesta = respuesta;
    },
    reset() {
      this.respondiendo = false;
      this.exito = false;
      this.respuesta = "";
    },
  },
};
</script>