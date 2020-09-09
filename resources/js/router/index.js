import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./../components/views/Home.vue";
import Login from "./../components/views/Login.vue";
import Register from "./../components/views/Register.vue";
import Predictions from "./../components/views/Predictions.vue";
import Profile from "./../components/views/Profile.vue";

import store from "./../store";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,

    },
    {
        path: "/predictions",
        name: "Predictions",
        component: Predictions,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
        meta: {
            requiresAuth: true
        }
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next('/login');
    } else {
        next();
    }
});

export default router;
