import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./../components/views/Home.vue";
import Login from "./../components/views/Login.vue";
import Register from "./../components/views/Register.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },

];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
