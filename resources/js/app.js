import './bootstrap';
import {createApp} from 'vue';
import App from './App.vue';
import {createRouter, createWebHistory} from 'vue-router';
import Login from "./components/Login.vue";
import Review from "./components/Review.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/login', component: Login },
        { path: '/review', component: Review },
    ],
})
const app = createApp(App);
app.use(router);
app.mount("#app");
