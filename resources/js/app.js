import 'bootstrap/dist/css/bootstrap.css';
import {createApp} from 'vue';
import App from './App.vue';
import {createRouter, createWebHistory} from 'vue-router';
import Login from "./components/Login.vue";
import Review from "./components/Review.vue";
import ManualImport from "./components/ManualImport.vue";
import Register from "./components/Register.vue";
import Home from "./components/Home.vue";
import * as Sentry from "@sentry/vue";

Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: Home },
        { path: '/login', component: Login },
        { path: '/register', component: Register },
        { path: '/review', component: Review },
        { path: '/manualimport', component: ManualImport },
    ],
})
const app = createApp(App);
app.use(router);
app.mount("#app");
