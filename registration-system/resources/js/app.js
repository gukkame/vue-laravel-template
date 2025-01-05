import "./bootstrap";
import router from "./router";
import { createApp } from "vue";
import { createPinia } from 'pinia'

import '../css/app.css';

import App from "./App.vue";
const pinia = createPinia()

createApp(App).use(router).use(pinia).mount("#app");