import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';

// Import Bootstrap & BootstrapVue CSS files
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

// Import BootstrapVue 3
import BootstrapVue3 from 'bootstrap-vue-3';

// Buat instance Vue
const app = createApp(App);

// Gunakan BootstrapVue3
app.use(BootstrapVue3);

app.mount('#app');
