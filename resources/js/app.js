import './bootstrap';
import "mdi-icons/css/materialdesignicons.min.css";
import { createApp } from 'vue/dist/vue.esm-bundler';

//Importar vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

//Importar componentes
import login from './pages/login.vue';

//Configurar vuetify
const vuetify = createVuetify({
  components,
  directives,
})

//Registrar componentes y montar aplicación
createApp({
    components: {
        login,
    }
}).use(vuetify).mount('#app');
