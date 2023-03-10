import './bootstrap';
import "mdi-icons/css/materialdesignicons.min.css";
import { createApp } from 'vue/dist/vue.esm-bundler';

//Importar vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import colors from 'vuetify/lib/util/colors'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

//Importar componentes globales
import login from './pages/login.vue';
import home from './pages/home.vue';

//Configurar vuetify
const vuetify = createVuetify({
  components,
  directives,
  //Configuración de un tema por defecto con los colores de la página
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          primary: '#124567',
          secondary: '#914FAE', 
          info: '#40B0A6',
          error: '#BC4A4A',
          success: '#80F5B7',
        }
      },
    },
  },
})

//Registrar componentes y montar aplicación
createApp({
    components: {
        login,
        home,
    }
}).use(vuetify).mount('#app');
