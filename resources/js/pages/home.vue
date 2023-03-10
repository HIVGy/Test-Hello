<template>
  <v-container class="pt-12 mt-12">
    <!-- Barra de navegación -->
    <v-layout>
      <v-app-bar :elevation="0" color="primary">
        <v-toolbar-title> Bienvenido {{ nombre }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn
          @click="registrar"
          class="mx-2"
          variant="outlined"
          color="success"
        >
          Añadir materia
        </v-btn>

        <v-form @submit.prevent="logout" variant="outlined">
          <input type="hidden" name="_token" :value="csrf" />
          <v-btn type="submit"> Cerrar sesión </v-btn>
        </v-form>
      </v-app-bar>
    </v-layout>

    <!-- Materias en la base de datos -->
    <v-row>
      <materias-component
        v-for="item in materias"
        :mat="item"
        :key="item.id"
        @edita="editar"
        @elimina="eliminar"
      />
    </v-row>

    <!-- Ventana flotante de registro/edición -->
    <v-dialog v-model="registrando" width="40%">
      <v-card class="elevation-0 text-center" color="white">
        <h1 class="text-h6 my-6 text-center" v-if="editando">
          Editando una materia
        </h1>
        <h1 class="text-h6 my-6 text-center" v-else>
          Ingresa una nueva materia
        </h1>
        <!-- Formulario y campos de registro -->
        <v-form
          @submit.prevent="guardar"
          ref="formMat"
          id="matForm"
          class="mx-6"
        >
          <input type="hidden" name="_token" :value="csrf" />
          <v-text-field
            v-model="materiaFormulario.nombre"
            class="mb-2"
            label="Nombre de la materia"
            placeholder="Matematicas"
            color="secondary"
            :rules="[reglas.requerido]"
          />
          <v-text-field
            v-model="materiaFormulario.codigo"
            class="mb-2"
            label="Código de la materia"
            placeholder="XXX1234"
            color="secondary"
            :rules="[reglas.requerido]"
          />
          <v-text-field
            v-model="materiaFormulario.creditos"
            class="mb-2"
            label="Créditos de la materia"
            placeholder="10"
            color="secondary"
            :rules="[reglas.requerido, reglas.numeros]"
          />
          <v-textarea
            v-model="materiaFormulario.descripcion"
            class="mb-2"
            label="Descripción"
            placeholder="Añade una descripción de la materia"
            counter="150"
            rows="3"
            auto-grow
            :rules="[reglas.requerido, reglas.maximo]"
          />
          <div class="text-center text-white pb-6">
            <v-btn type="submit" form="matForm" color="primary">
              Guardar Materia
            </v-btn>
          </div>
        </v-form>
      </v-card>
    </v-dialog>

    <!-- Ventana flotante de confirmación de eliminación -->
    <v-dialog v-model="eliminando" persistent width="400">
      <v-sheet class="pa-4 text-center mx-auto" elevation="4">
        <v-icon class="mb-6" color="error" icon="mdi-alert" size="112" />
        <h1 class="mb-6 text-h4 font-weight-bold">
          ¿Estas seguro que quieres eliminar esta materia?
        </h1>
        <p class="text-h5 mb-6">Esta acción no se puede deshacer</p>

        <v-btn class="mx-6" color="primary" @click="eliminando = false">
          Cancelar
        </v-btn>

        <v-btn class="mx-6" color="error" @click="remover"> Eliminar </v-btn>
      </v-sheet>
    </v-dialog>

    <!-- Ventana flotante de simbolo de carga -->
    <cargando-component :visible="estaCargando"></cargando-component>

    <!-- Ventana flotante con alerta con mensajes de respuesta -->
    <respuestas-component
      :visible="respondiendo"
      :exito="exito"
      :respuesta="respuesta"
      @reset="reset"
    />
  </v-container>
</template>

<script>
import cargando from "../components/cargandoComponent.vue";
import respuestas from "../components/respuestasComponent.vue";
import materias from "../components/materiasComponent.vue";

export default {
  name: "home",
  props: {
    nombre: String,
  },
  components: {
    "cargando-component": cargando,
    "respuestas-component": respuestas,
    "materias-component": materias,
  },
  mounted() {
    this.obtenerMaterias();
  },
  data() {
    return {
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
      //Variables para controlar la visiblidad de los apartados de la página
      respondiendo: false,
      estaCargando: false,
      registrando: false,
      editando: false,
      eliminando: false,
      //Variables para asignar valores al componente de respuestas
      exito: false,
      respuesta: "",
      // Variables para controlar el formulario de registro y actualización de materias
      materiaFormulario: {},
      materias: [],
      reglas: {
        requerido: (v) => !!v || "Campo requerido",
        numeros: (v) => {
          const patron = /^\d{1,}$/;
          return patron.test(v) || "Ingrese un número entero valido";
        },
        maximo: (v) => {
          if (v) {
            return v.length <= 150 || "Máximo 150 caracteres";
          }
          return true;
        },
      },
    };
  },
  methods: {
    obtenerMaterias() {
      this.estaCargando = true;
      axios.get("/materias").then((response) => {
        this.materias = response.data;
        this.estaCargando = false;
      });
    },
    /* Funciones para crear, editar y eliminar las materias */
    async guardar() {
      this.estaCargando = true;
      const { valid } = await this.$refs.formMat.validate();
      if (valid) {
        if (this.editando) {
          axios.put("/materia", this.materiaFormulario).then((response) => {
            this.registrando = false;
            this.asignarRespuesta(response.data.success, response.data.message);
          });
        } else {
          axios.post("/materia", this.materiaFormulario).then((response) => {
            this.registrando = false;
            this.asignarRespuesta(response.data.success, response.data.message);
          });
        }
      } else {
        this.estaCargando = false;
      }
    },
    remover() {
      axios
        .delete("/materia", { data: this.materiaFormulario })
        .then((response) => {
          this.eliminando = false;
          this.asignarRespuesta(response.data.success, response.data.message);
        });
    },
    /* Funciones para abrir las ventanas flotantes y asignar los valores de las materias */
    registrar() {
      this.materiaFormulario = {};
      this.editando = false;
      this.registrando = true;
    },
    editar(mat) {
      this.materiaFormulario = mat;
      this.editando = true;
      this.registrando = true;
    },
    eliminar(mat) {
      this.materiaFormulario = mat;
      this.eliminando = true;
    },
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