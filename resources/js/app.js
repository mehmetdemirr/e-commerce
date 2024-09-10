import './bootstrap';
import 'flowbite';
import { createApp } from 'vue';
import router from "./router/router.js";
import App from "./layouts/App.vue";
import "../css/app.css"

const app = createApp(App);

app.use(router);

app.mount('#app');
