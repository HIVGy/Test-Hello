<template>
  <v-dialog v-model="modelo" width="200" persistent>
    <v-card class="elevation-0 text-center" height="150" color="transparent">
      <v-progress-circular size="124" color="primary" indeterminate />
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "cargando-component",
  props: {
    visible: Boolean,
  },
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