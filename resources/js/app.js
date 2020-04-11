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

import galeri from "../views/vue/galeri";
import ssSorular from "../views/vue/sıkca-sorulan-sorular";
import cep from "../views/vue/cep-kutuphanem";
import databases from "../views/vue/databases";
import main from "../views/vue/main";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files
    .keys()
    .map((key) =>
        Vue.component(key.split("/").pop().split(".")[0], files(key).default)
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
            component: main,
        },
        {
            path: "/databases",
            name: "databases",
            component: databases,
        },
        {
            path: "/cep-kutuphanem",
            name: "cep-kutuphanem",
            component: cep,
        },
        {
            path: "/sıkca-sorulan-sorular",
            name: "sıkça-sorulan-sorular",
            component: ssSorular,
        },
        {
            path: "/galeri",
            name: "galeri",
            component: galeri,
        },
    ],
});

const app = new Vue({
    vuetify: Vuetify,
    el: "#app",
    router,
});
