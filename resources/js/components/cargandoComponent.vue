<template>
  <!-- Ventana flotante transparente con el progreso circular -->
  <v-dialog v-model="modelo" width="10%" persistent>
    <v-card class="elevation-0 text-center" height="150" color="transparent">
      <v-progress-circular size="80" color="primary" indeterminate />
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "cargando-component",
  props: {
    visible: Boolean,
  },
  //Cuando se modifique el valor de visible se vuelve visible o invisible la ventana flotante
  watch: {
    visible(val){
      this.modelo = val;
    }
  },
  data() {
    return {
      modelo: false,
    };
  },
};
</script>