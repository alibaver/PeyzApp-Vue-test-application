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
        class="position-absolute mt-2"
        style="left:50%;transform:translateX(-100%)"
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
      <v-btn class="position-absolute" icon dark v-if="clientWidth < 600" style="right:0">
        <v-icon>mdi-brightness-4</v-icon>
      </v-btn>
      <v-row class="justify-center align-self-end">
        <v-col :cols="clientWidth >= 600 ? '11' : '12'" class="pa-0">
          <div id="responsePlace" class="d-flex align-items-center justify-content-center">
            <!-- logo btn -->
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
            <!-- /logo btn -->
            <!-- search input -->
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
            <!-- /search input -->
            <!-- filter-menu -->
            <div class="mx-1">
              <v-menu offset-y transition="scroll-y-transition">
                <template v-slot:activator="{ on: menu }">
                  <v-tooltip bottom open-delay="500" z-index="1">
                    <template v-slot:activator="{ on: tooltip }">
                      <v-btn dark icon v-on="{ ...tooltip, ...menu }">
                        <v-icon>mdi-filter-variant</v-icon>
                      </v-btn>
                    </template>
                    <span>Gelişmiş Arama</span>
                  </v-tooltip>
                </template>
                <v-list dense rounded>
                  <v-list-item-group v-model="model" :color="isDark ? '' : 'base'">
                    <v-list-item v-for="(item, index) in list" :key="index">
                      <v-list-item-icon>
                        <v-icon v-text="item.icon"></v-icon>
                      </v-list-item-icon>

                      <v-list-item-content>
                        <v-list-item-title v-text="item.title"></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
              </v-menu>
            </div>
            <!-- /filter-menu -->
          </div>
        </v-col>
        <v-col cols="1" class="pa-0" v-if="clientWidth >= 600">
          <v-tooltip bottom open-delay="500" z-index="1">
            <template v-slot:activator="{ on: tooltip }">
              <v-btn class="float-right" icon dark v-on="{ ...tooltip}" @click="isDark = !isDark">
                <v-icon v-if="!isDark">mdi-brightness-4</v-icon>
                <v-icon v-else>mdi-brightness-7</v-icon>
              </v-btn>
            </template>
            <span>Karanlık Tema</span>
          </v-tooltip>
        </v-col>
      </v-row>
    </v-app-bar>
    <!-- navigation -->
    <v-navigation-drawer
      app
      v-model="drawer"
      clipped
      :style="clientWidth > 1263 
        ? scY > bannerHeight 
          ? 'position:fixed;'
          : 'position:absolute; height: calc(100vh - (' +bannerHeight +'px - ' +scY +'px + 48px ))'
        : 'position:absolute; height: 100vh;'"
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
    <!-- /navigation -->
    <float-action></float-action>
    <!-- @set-theme="setTheme" -->
    <v-content>
      <v-container fluid :class="isDark ? '' : 'bgColor'">
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
    model: 0,
    list: [
      { title: "TÜMÜ", icon: "mdi-collapse-all" },
      { title: "Katalog", icon: "mdi-book-open-page-variant" },
      { title: "E-Dergiler", icon: "mdi-file-pdf" },
      { title: "Makaleler", icon: "mdi-file" },
      { title: "E-Kitaplar", icon: "mdi-book-open" },
      { title: "Tezler", icon: "mdi-file" },
      { title: "İSTE Akademik Arşiv", icon: "mdi-archive" }
    ],
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
    this.setTheme(this.isDark);
    this.clientWidth < 600 ? (this.barHeight = 96) : (this.barHeight = 48);
    this.breakpointName = this.$vuetify.breakpoint.name;
    this.resizeWindow();
  },
  watch: {
    isDark(val) {
      this.setTheme(val);
      $("#compLogo")
        .find(".imgchangeColor")
        .toggleClass("whiteBG");
    }
  },
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
