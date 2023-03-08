<template>
  <v-container>
    <v-sheet
      class="pt-12 mt-12 text-center mx-auto"
      width="50%"
      elevation="4"
      rounded
    >
      <v-form @submit.prevent="submit" ref="formUser" class="mx-4">
        <input type="hidden" name="_token" :value="csrf" />

        <h1 class="text-h6 mb-6">Inicia sesión</h1>
        <v-text-field
          v-model="usuario.email"
          prepend-inner-icon="mdi-account"
          label="Correo electrónico"
          placeholder="john@gmail.com"
          type="email"
          :rules="[reglas.requerido, reglas.email]"
        />
        <v-text-field
          v-model="usuario.password"
          prepend-inner-icon="mdi-shield-lock"
          :append-inner-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
          :type="show1 ? 'text' : 'password'"
          label="Contraseña"
          placeholder="Escribe tu contraseña"
          @click:append-inner="show1 = !show1"
          :rules="[reglas.requerido]"
        />
        <v-btn
          type="submit"
          form="userForm"
          color="primary"
          class="text-white mb-4"
        >
          Iniciar sesión
        </v-btn>
      </v-form>
    </v-sheet>

    <!--Dialog de mensajes de confirmación o error-->
    <template>
      <v-dialog v-model="dialogRespuesta" persistent width="300">
        <v-card>
          <template v-if="exito">
            <div class="pt-6 text-center">
              <v-avatar color="green" size="64">
                <v-icon color="white" x-large class="mdi-48px">
                  mdi-check-bold
                </v-icon>
              </v-avatar>
            </div>
            <div class="text-center pt-3">
              <v-card-text class="text-center text-h4 font-weight-bold">
                Exito
              </v-card-text>
            </div>
          </template>
          <template v-else>
            <div class="pt-6 text-center">
              <v-avatar color="warning" size="64">
                <v-icon color="white" x-large class="mdi-48px">
                  mdi-alert
                </v-icon>
              </v-avatar>
            </div>
            <div class="text-center pt-3">
              <v-card-text class="text-center text-h4 font-weight-bold">
                Oh no
              </v-card-text>
            </div>
          </template>
          <v-card-subtitle class="pt-2 text-h6 text-center">
            {{ respuesta.message }}
          </v-card-subtitle>
          <div class="pb-2 text-center">
            <v-btn
              outlined
              large
              plain
              color="primary"
              text
              @click="confirmar()"
            >
              Aceptar
            </v-btn>
          </div>
        </v-card>
      </v-dialog>
    </template>

    <cargando :visible="true"></cargando>
  </v-container>
</template>

<script>
import cargando from "../components/cargandoComponent.vue";

export default {
  name: "login",
  components: {
    cargando: cargando,
  },
  data() {
    return {
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
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
    validar() {
      if (this.$refs.formUser.validate()) {
        return true;
      }
      return false;
    },
    submit: function () {
      this.dialogLoading = true;
      if (this.validar()) {
        axios
          .post("/login", this.usuario)
          .then((response) => {
            if (response.status == 204) {
              //usuario identificado
            } else {
              //usuario invalido
            }
          })
          .catch((error) => {
            //error de validacion
          });
      }
    },
  },
};
</script>