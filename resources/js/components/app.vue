<template>
  <v-app id="inspire" :dark="isDark">
    <!-- APPBAR -->
    <v-app-bar id="appBar" app :color="isDark ? '' : 'base'" dense flat :style="appBarStyle">
      <!-- HAMBURGER MENU -->
      <v-app-bar-nav-icon class="d-block d-lg-none" dark @click.stop="drawer = !drawer" />

      <!-- ISTE LOGO BUTTON -->
      <div class="d-flex justify-content-center align-center d-lg-none" style="width:100%;">
        <v-avatar size="35" tile>
          <v-img contain :src="'../../images/logo/iste_ico.png'" class="whiteBG"></v-img>
        </v-avatar>
      </div>

      <!-- LINKS -->
      <div v-for="(item, index) in Links" :key="index" class="d-none d-lg-block">
        <!-- menu item -->
        <v-btn
          v-if="!item.childList"
          small
          text
          tile
          color="white"
          :style="'height:' + barHeight + 'px'"
          :to="item.path"
        >{{ item.title }}</v-btn>
        <!-- dropdown menu -->
        <v-menu
          v-else
          offset-y
          transition="scroll-y-transition"
          rounded="0"
          :close-on-content-click="false"
          open-on-hover
          :key="'dropMenu-' + index"
          ref="menuRef"
        >
          <template v-slot:activator="{ on: menu }">
            <v-btn
              small
              text
              tile
              color="white"
              :style="'height:' + barHeight + 'px'"
              v-on="{ ...menu }"
            >
              {{ item.title }}
              <v-icon small right>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list dense>
            <div v-for="(item, index) in item.childList" :key="index">
              <!-- child list -->
              <v-list-item
                v-if="!item.childList"
                link
                :class="item.childList ? 'px-0' : ''"
                :color="isDark ? '' : 'base'"
                :to="item.path"
              >
                <v-list-item-content>
                  <v-list-item-title v-text="item.title"></v-list-item-title>
                </v-list-item-content>
              </v-list-item>

              <!-- child in child list-->
              <v-list-group
                v-else
                no-action
                :color="isDark ? '' : 'base'"
                :close-on-content-click="false"
              >
                <template v-slot:activator>
                  <v-list-item-content>
                    <v-list-item-title v-text="item.title"></v-list-item-title>
                  </v-list-item-content>
                </template>

                <v-list-item
                  v-for="(subItem, index) in item.childList"
                  :key="index"
                  link
                  target="blank"
                  class="pl-8"
                  :to="item.path"
                >
                  <v-list-item-content>
                    <v-list-item-title v-text="subItem.title"></v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-group>
            </div>
          </v-list>
        </v-menu>
      </div>

      <v-spacer></v-spacer>
      <!-- DARK MODE -->
      <v-tooltip bottom open-delay="500" z-index="1">
        <template v-slot:activator="{ on: tooltip }">
          <v-btn class="float-right" icon dark v-on="{ ...tooltip }" @click="isDark = !isDark">
            <v-icon v-if="!isDark">mdi-brightness-4</v-icon>
            <v-icon v-else>mdi-brightness-7</v-icon>
          </v-btn>
        </template>
        <span>Karanlık Tema</span>
      </v-tooltip>
    </v-app-bar>

    <!-- NAVİGATION -->
    <v-navigation-drawer app v-model="drawer" temporary>
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
        <div v-for="(menu, index) in Links" :key="index">
          <div v-if="menu.childList" class="py-1">
            <v-list-group :prepend-icon="menu.icon" no-action :color="isDark ? '' : 'base'">
              <template v-slot:activator>
                <v-list-item-content>
                  <v-list-item-title v-text="menu.title"></v-list-item-title>
                </v-list-item-content>
              </template>

              <v-list-item
                v-for="(subItem, index) in menu.childList"
                :key="index"
                link
                :href="subItem.path"
                target="blank"
                class="pl-9"
              >
                <v-list-item-content>
                  <v-list-item-title
                    style="-webkit-line-clamp: unset; white-space:normal;"
                  >{{ subItem.title }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
          </div>
          <div v-else>
            <v-list-item @click="scrollTop()" link :to="menu.path" :color="isDark ? '' : 'base'">
              <!-- <v-list-item-action>
                                <v-icon>{{ menu.icon }}</v-icon>
              </v-list-item-action>-->
              <v-list-item-content>
                <v-list-item-title>{{ menu.title }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </div>
        </div>
        <!-- ÇALIŞMA SAATLERİ -->
        <v-list-group v-if="clientWidth < 700" :color="isDark ? '' : 'base'" link class="py-1">
          <template v-slot:activator>
            <v-list-item-title>ÇALIŞMA SAATLERİ</v-list-item-title>
          </template>
          <div style="padding-left: 30px;">
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

    <!-- SUPPORT BUTTON -->
    <float-action></float-action>

    <v-main>
      <v-container fluid :class="isDark ? '' : 'bgColor'">
        <router-view></router-view>
      </v-container>
      <footer-component></footer-component>
      <!-- ALERT -->
      <alert-component
        :alert-msg="alert.message"
        :alert-style="alert.style"
        :alert-open="alert.isOpen"
      ></alert-component>
    </v-main>
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
    alert: {
      isOpen: false,
      message: "",
      style: ""
    },
    scY: null,
    drawer: null,
    barHeight: null,
    clientWidth: window.innerWidth,
    bannerHeight: document.getElementById("topBanner").clientHeight,
    appBarStyle: "position:absolute;",
    isDark: JSON.parse(localStorage.getItem("darkMode")),
    model: null,
    Links: null,
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
    },
    $route(to, from) {
      const menus = this.$refs.menuRef;
      menus.forEach(menu => (menu.isActive = false));
    }
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
    window.addEventListener("resize", this.resizeWindow);
    this.scY = window.scrollY;
    this.clientWidth = window.innerWidth;
    // get menu list
    axios
      .get("ajaxfile.php", {
        params: {
          choose: "menu",
          param: "appBarMenus"
        }
      })
      .then(response => {
        let myslqConnect = response.data.indexOf("mysqli_connect()");
        let nullIndex = response.data.indexOf("[]");
        nullIndex > -1 || myslqConnect > -1
          ? ((this.alert.isOpen = true),
            (this.alert.message = "Hata: Veri Tabanı Bağlantı Sorunu."),
            (this.alert.style = "error"))
          : (this.Links = JSON.parse(response.data[0].jsonContent));
      })
      .catch(err => {
        console.log(err);
      });
  }
};
</script>
<style scope>
.position-absolute {
  position: absolute !important;
  display: block !important;
}
</style>
