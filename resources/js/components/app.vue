<template>
  <v-app id="inspire" :dark="isDark">
    <v-app-bar
      id="appBar"
      app
      :color="isDark ? '' : 'base'"
      :prominent="clientWidth < 600 ? true : false"
      dense
      clipped-left
      flat
      :style="appBarStyle"
    >
      <v-app-bar-nav-icon
        :class="clientWidth < 600 ? 'position-absolute' : ''"
        dark
        @click.stop="drawer = !drawer"
      />
      <v-btn
        :class="clientWidth >= 600 ? 'ml-6': ''"
        class="position-absolute mt-3"
        style="margin-left:50%;transform:translateX(-100%)"
        v-if="clientWidth < 600"
        depressed
        active-class="_noActive"
        small
        icon
        :to="'/'"
        @click="scrollTop()"
      >
        <v-img width="25" height="25" :src="'../../images/logo/iste_ico.png'" class="whiteBG"></v-img>
      </v-btn>
      <v-row class="justify-center align-self-end">
        <v-col cols="12" class="pa-0">
          <div id="responsePlace" class="d-flex align-items-center justify-content-center">
            <v-btn
              v-if="clientWidth >= 600"
              depressed
              active-class="_noActive ml-6 mr-2"
              small
              icon
              :to="'/'"
              @click="scrollTop()"
            >
              <v-img width="25" height="25" :src="'../../images/logo/iste_ico.png'" class="whiteBG"></v-img>
            </v-btn>
            <v-text-field
              id="search"
              class="ml-2"
              style="max-width: 500px;"
              flat
              solo
              dense
              name="search"
              placeholder="Kitap, makale, diğer tüm kaynakları arayın.."
              hide-details
              prepend-inner-icon="mdi-magnify"
              :color="isDark ? '' : 'base'"
            ></v-text-field>
            <filter-menu></filter-menu>
          </div>
        </v-col>
      </v-row>
    </v-app-bar>

    <v-navigation-drawer
      app
      v-model="drawer"
      clipped
      :style="clientWidth > 1263
                    ? scY > bannerHeight
                        ? 'position:fixed;'
                        : 'position:absolute; height: calc(100vh - (' +
                          bannerHeight +
                          'px - ' +
                          scY +
                          'px + 48px ))'
                    : 'position:absolute; height: 100vh;'
            "
    >
      <v-row v-if="clientWidth < 1264">
        <v-col>
          <img
            :src="' ../../images/logo/iste_tr.png '"
            alt="İskenderun Teknik Üniversitesi"
            class="isteLogo"
          />
        </v-col>
      </v-row>
      <v-divider></v-divider>
      <v-list dense :flat="isDark ? false : true">
        <div v-for="(menu, index) in menus" :key="index">
          <div v-if="menu.items.length" class="py-1">
            <v-list-group :prepend-icon="menu.icon" no-action :color="isDark ? '' : 'base'">
              <template v-slot:activator>
                <v-list-item-content>
                  <v-list-item-title v-text="menu.name"></v-list-item-title>
                </v-list-item-content>
              </template>

              <v-list-item
                v-for="(subItem, index) in menu.items"
                :key="index"
                link
                :href="subItem.path"
                target="blank"
              >
                <v-list-item-content>
                  <v-list-item-title v-text="subItem.title"></v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
          </div>
          <div v-else>
            <v-list-item @click="scrollTop()" link :to="menu.path" :color="isDark ? '' : 'base'">
              <v-list-item-action>
                <v-icon>{{ menu.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{
                  menu.name
                  }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </div>
        </div>
        <v-list-group
          v-if="clientWidth < 700"
          prepend-icon="mdi-calendar-clock"
          :color="isDark ? '' : 'base'"
          link
          class="py-1"
        >
          <template v-slot:activator>
            <v-list-item-title>Çalışma Saatleri</v-list-item-title>
          </template>
          <div style="padding-left: 70px;">
            <v-chip outlined x-small class="overline" color="error">
              <v-icon left x-small>mdi-circle</v-icon>KAPALI
            </v-chip>
            <v-chip outlined x-small class>
              <v-icon left x-small>mdi-calendar</v-icon>Hafta içi
              : 08:00 - 24:00
            </v-chip>
            <v-chip outlined x-small class>
              <v-icon left x-small>mdi-calendar</v-icon>Hafta sonu
              : 10:00 - 24:00
            </v-chip>
            <v-chip outlined x-small class>
              <v-icon left x-small>mdi-calendar</v-icon>Resmi
              Tatil : Kapalı
            </v-chip>
          </div>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <float-action @set-theme="setTheme"></float-action>

    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>

      <footer-component></footer-component>
    </v-content>
  </v-app>
</template>
<script>
import JQuery from "jquery";
var $ = JQuery;

export default {
  props: {
    source: String
  },
  data: () => ({
    scY: null,
    drawer: null,
    barHeight: null,
    clientWidth: window.innerWidth,
    bannerHeight: document.getElementById("topBanner").clientHeight,
    appBarStyle: "position:absolute;",
    isDark: JSON.parse(localStorage.getItem("darkMode")),
    menus: [
      { icon: "mdi-home", name: "Anasayfa", path: "/", items: [] },
      {
        icon: "mdi-database",
        name: "Veritabanları",
        path: "/databases",
        items: []
      },
      {
        icon: "mdi-adobe-acrobat",
        name: "Açık Erişimli E-Kaynaklar",
        path: "",
        items: []
      },
      {
        icon: "mdi-cellphone-android",
        name: "Cep Kütüphanem",
        path: "/cep-kutuphanem",
        items: []
      },
      {
        icon: "mdi-image",
        name: "Galeri",
        path: "/galeri",
        items: []
      },
      {
        icon: "mdi-account-supervisor-circle",
        name: "Birimlerimiz",
        path: "/birimler",
        items: []
      },
      {
        icon: "mdi-frequently-asked-questions",
        name: "Sıkça Sorulan Sorular",
        path: "/sıkca-sorulan-sorular",
        items: []
      },
      {
        icon: "mdi-apps",
        name: "Hızlı Erişim",
        path: "",
        items: [
          {
            title: "Üniversite Anasayfa",
            path: "http://iste.edu.tr"
          },
          {
            title: "Öğrenci Bilgi Sistemi",
            path: "https://obs.iste.edu.tr/oibs/ogrenci/login.aspx"
          },
          {
            title: "Akademik Bilgi Sistemi",
            path: "https://obs.iste.edu.tr/oibs/akademik/login.aspx"
          },
          {
            title: "Akademik Takvim",
            path: "http://iste.edu.tr/oidb/akademik-takvim"
          },
          { title: "E-Posta", path: "http://eposta.iste.edu.tr/" },
          {
            title: "Uygulama Merkezi",
            path: "http://iste.edu.tr/uygulama-merkezi"
          }
        ]
      }
    ]
  }),
  computed: {},
  methods: {
    focusInput() {},
    scrollTop() {
      window.scrollTo(0, 0);
    },
    setTheme(val) {
      if (val == true) {
        this.isDark = true;
        darkMode = true;
        localStorage.setItem("darkMode", this.isDark);
        $("#topBanner,.isteLogo,.teknoversite").addClass("theme--dark");
        return (this.$vuetify.theme.dark = true);
      } else {
        this.isDark = false;
        darkMode = false;
        localStorage.setItem("darkMode", this.isDark);
        $("#topBanner,.isteLogo,.teknoversite").removeClass("theme--dark");
        return (this.$vuetify.theme.dark = false);
      }
    },
    resizeWindow() {
      this.clientWidth = window.innerWidth;
      this.clientWidth < 600 ? (this.barHeight = 96) : (this.barHeight = 48);
      this.handleScroll();
      if (this.clientWidth < 600) {
        //$("#resSearch").appendTo("#appBar");
        //$("#appBar").css("height", this.barHeight);
      } else {
        //$("#resSearch").appendTo("#responsePlace");
        //$("#appBar").css("height", this.barHeight);
      }
    },
    handleScroll() {
      this.scY = window.scrollY;
      this.bannerHeight = document.getElementById("topBanner").clientHeight;
      if (this.scY > this.bannerHeight) {
        this.appBarStyle = "position: fixed;"; // height:" + this.barHeight + "px";
      } else {
        this.appBarStyle = "position: absolute;"; // height:" + this.barHeight + "px";
      }
    }
  },
  mounted() {
    console.log("App loaded");
    this.clientWidth < 600 ? (this.barHeight = 96) : (this.barHeight = 48);
    this.breakpointName = this.$vuetify.breakpoint.name;
    this.setTheme(this.isDark);
    this.resizeWindow();
  },
  watch: {},
  created() {
    window.addEventListener("scroll", this.handleScroll);
    window.addEventListener("resize", this.resizeWindow);
    this.scY = window.scrollY;
    this.clientWidth = window.innerWidth;
  }
};
</script>
<style scope>
.position-absolute {
  position: absolute !important;
}
</style>
