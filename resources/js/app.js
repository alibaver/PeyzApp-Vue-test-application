/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.$ = require("jquery");
window.JQuery = require("jquery");

window.Vue = require("vue");

import Vuetify from "../plugins/vuetify";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import main from "../views/vue/main";
import takvim from "../views/vue/takvim";
import giderler from "../views/vue/giderler";
import ekipOlustur from "../views/vue/ekip-olustur";
import kesilenAgac from "../views/vue/kesilen-agac";
import ekipDetay from "../views/vue/ekip-detay";

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
            name: "Anasayfa",
            component: main
        },
        {
            path: "/takvim",
            name: "Takvim",
            component: takvim
        },
        {
            path: "/giderler",
            name: "Giderler",
            component: giderler
        },
        {
            path: "/ekip-olustur",
            name: "Ekip Oluştur",
            component: ekipOlustur
        },
        {
            path: "/kesilen-agac",
            name: "Kesilen Agaç",
            component: kesilenAgac
        },
        {
            path: "/ekip-detay",
            name: "Ekip Detay",
            component: ekipDetay
        }
    ]
});

const app = new Vue({
    vuetify: Vuetify,
    el: "#app",
    router
});
