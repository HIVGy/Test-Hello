<template>
  <v-sheet
    elevation="12"
    width="350"
    rounded
    class="text-center pa-4 my-4 mx-auto"
  >
    <div style="height: 150px" class="overflow-auto">
      <h1 class="text-h6 mt-6">{{ mat.nombre }}</h1>
      <p class="my-1 text-medium-emphasis text-body-2">
        {{ mat.descripcion }}
      </p>
    </div>

    <v-divider class="mb-4"></v-divider>

    <div class="text-end">
      <v-btn class="mx-1" icon color="info" @click="$emit('edita', mat)">
        <v-tooltip activator="parent" location="bottom">Modificar</v-tooltip>
        <v-icon icon="mdi-pencil" color="white" />
      </v-btn>
      <v-btn class="mx-1" icon color="error" @click="$emit('elimina', mat)">
        <v-tooltip activator="parent" location="bottom">Eliminar</v-tooltip>
        <v-icon icon="mdi-delete" color="white" />
      </v-btn>
      <v-btn @click="verCreditos = true" class="mx-1" icon color="success">
        <v-tooltip activator="parent" location="bottom">Ver créditos</v-tooltip>
        <v-icon icon="mdi-file-document" color="white" />
      </v-btn>
    </div>
  </v-sheet>

  <!-- Ventana flotante que muestra los creditos -->
  <v-dialog v-model="verCreditos" width="20%">
    <v-card class="elevation-0 text-center pa-1" color="white">
      <p class="text-h6 mt-6">{{ mat.codigo }} - {{ mat.nombre }}</p>
      <p class="text-overline my-6">Créditos: {{ mat.creditos }}</p>
    </v-card>
  </v-dialog>

</template>

<script>
export default {
  name: "materias-component",
  emits: ["edita", 'elimina'],
  props: {
    mat: Object,
  },
  data() {
    return {
      verCreditos: false,
    };
  },
  methods: {
    
  },
};
</script>