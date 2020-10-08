/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// window.$ = require("jquery");
// window.JQuery = require("jquery");

window.Vue = require("vue");

import Vuetify from "../plugins/vuetify";
import VueRouter from "vue-router";
import axios from "axios";
import _numeral from "numeral";
import parseprice from "parse-price";

window.numeral = require("numeral");
window.parsePrice = require("parse-price");

window.numeral.register("locale", "tr", {
    delimiters: {
        thousands: ".",
        decimal: ","
    },
    abbreviations: {
        thousand: "k",
        million: "m",
        billion: "b",
        trillion: "t"
    },
    ordinal: function(number) {
        return number === 1 ? "er" : "ème";
    },
    currency: {
        symbol: "₺"
    }
});
window.numeral.locale("tr");

Vue.use(VueRouter);
Vue.prototype.$axios = axios;

Vue.prototype.$uid = window.localStorage.getItem("_uid");
Vue.prototype.$ad = window.localStorage.getItem("ad");
Vue.prototype.$soyad = window.localStorage.getItem("soyad");

Vue.prototype.$getDate = function() {
    let date;
    date = new Date()
        .toLocaleString("tr")
        .split(" ")[0]
        .split(".");
    date = date.reverse().join("-");
    return date;
};

Vue.prototype.$createId = function(letter) {
    return (
        letter.toString() +
        Math.random()
            .toString(36)
            .substr(2, 11)
    );
};
String.prototype.turkishToLower = function() {
    var string = this;
    var letters = { İ: "i", I: "ı", Ş: "ş", Ğ: "ğ", Ü: "ü", Ö: "ö", Ç: "ç" };
    string = string.replace(/(([İIŞĞÜÇÖ]))/g, function(letter) {
        return letters[letter];
    });
    return string.toLowerCase();
};
String.prototype.turkishToUpper = function() {
    var string = this;
    var letters = { i: "İ", ş: "Ş", ğ: "Ğ", ü: "Ü", ö: "Ö", ç: "Ç", ı: "I" };
    string = string.replace(/(([iışğüçö]))/g, function(letter) {
        return letters[letter];
    });
    return string.toUpperCase();
};

import main from "../views/vue/main";
import takvim from "../views/vue/takvim";
import gider from "../views/vue/gider";
import ekipOlustur from "../views/vue/ekip-olustur";
import budananAgac from "../views/vue/budanan-agac";
import ekipDetay from "../views/vue/ekip-detay";
import calisanEkle from "../views/vue/calisan-ekle";
import hakedis from "../views/vue/hakedis";
import ayrilanCalisanlar from "../views/vue/ayrilan-calisanlar";
import login from "../views/vue/login";

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
            component: main,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/takvim",
            name: "Takvim",
            component: takvim,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/gider",
            name: "Gider",
            component: gider,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/ekip-olustur",
            name: "Ekip Oluştur",
            component: ekipOlustur,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/budanan-agac",
            name: "Budanan Ağaç",
            component: budananAgac,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/ekip-detay",
            name: "Ekip Detay",
            component: ekipDetay,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/calisan-ekle",
            name: "Çalışan Ekle",
            component: calisanEkle,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/hakedis",
            name: "Hakediş",
            component: hakedis,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/ayrilan-calisanlar",
            name: "Ayrılan Çalışanlar",
            component: ayrilanCalisanlar,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/login",
            name: "Giriş Sayfası",
            component: login
        }
    ]
});

router.beforeEach(function(to, from, next) {
    const requiresAuth = JSON.parse(
        window.localStorage.getItem("requiresAuth")
    );

    if (to.path !== "/login" && to.path !== "login" && !requiresAuth) {
        next({ path: "/login" });
    } else if ((to.path === "/login" || to.path === "login") && requiresAuth) {
        next({ path: "/" });
    } else {
        next();
    }
});

const app = new Vue({
    vuetify: Vuetify,
    el: "#app",
    router
});
