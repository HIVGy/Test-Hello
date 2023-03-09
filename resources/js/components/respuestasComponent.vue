<template>
  <v-dialog v-model="dRespuesta" persistent width="40%">
    <v-sheet class="pa-4 text-center mx-auto" elevation="4" width="100%">
      <template v-if="exito">
        <v-icon
          class="mb-5"
          color="success"
          icon="mdi-check-circle"
          size="112"
        />
        <h1 class="text-h4 font-weight-bold">Exito</h1>
      </template>
      <template v-else>
        <v-icon class="mb-5" color="error" icon="mdi-alert" size="112" />
        <h1 class="text-h4 font-weight-bold">¡Oh no!</h1>
      </template>
      <h2 class="text-h5 text-medium-emphasis my-3">{{ respuesta }}</h2>
      <v-btn color="primary" outlined large plain text @click="reset">
        Aceptar
      </v-btn>
    </v-sheet>
  </v-dialog>
</template>

<script>
export default {
  name: "respuestas-component",
  props: {
    visible: Boolean,
    exito: Boolean,
    respuesta: String,
  },
  watch: {
    visible(val) {
      this.dRespuesta = val;
    },
  },
  data() {
    return {
      dRespuesta: false,
    };
  },
  methods: {
    reset() {
      this.dRespuesta = false;
      this.$emit('reset', false);
    },
  },
};
</script>