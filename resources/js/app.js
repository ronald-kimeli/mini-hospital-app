import './bootstrap';
import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import router from './src/router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import "./src/assets/libs/jquery/dist/jquery.min";
import "./src/assets/js/app.min";
import "./src/assets/libs/simplebar/dist/simplebar";
import "./src/assets/libs/simplebar/dist/simplebar.css";
import "./src/assets/js/dashboard";
import "./src/assets/css/styles.min.css";
import App from './src/App.vue';
import 'bootstrap-icons/font/bootstrap-icons.css'; 
const pinia = createPinia();
pinia.use(({ store }) => {
  store.router = markRaw(router);
});

const app = createApp(App);

app.use(pinia);
app.use(router);

app.mount("#app");
