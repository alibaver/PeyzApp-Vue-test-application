/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
window.$ = require("jquery");
window.JQuery = require("jquery");

window.Vue = require("vue");

import Vuetify from "../plugins/vuetify";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import main from "../views/vue/main";
import takvim from "../views/vue/takvim";
import giderler from "../views/vue/giderler";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "main",
            component: main
        },
        {
            path: "/takvim",
            name: "takvim",
            component: takvim
        },
        {
            path: "/giderler",
            name: "giderler",
            component: giderler
        }
    ]
});

const app = new Vue({
    vuetify: Vuetify,
    el: "#app",
    router
});
