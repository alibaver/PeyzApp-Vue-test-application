<template>
  <v-app id="inspire">
    <div v-if="$route.fullPath != '/login'">
      <v-app-bar id="appBar" app color="white" elevate-on-scroll>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" color="primary" />
        <a href="/">
          <span class="subtitle-1 primary--text"
            >peyz<span class="font-weight-bold primary--text">APP</span>
          </span>
        </a>
        <v-spacer></v-spacer>
      </v-app-bar>
      <v-navigation-drawer app v-model="drawer">
        <div class="d-flex justify-center align-center w100 pa-5 flex-column">
          <v-avatar class="gradientCard" size="100">
            <span class="white--text text-h4"
              >{{ ad.substr(0, 1) }}{{ soyad.substr(0, 1) }}
            </span>
          </v-avatar>
          <span class="mt-4">{{ ad }} {{ soyad }} </span>
        </div>
        <v-divider></v-divider>
        <v-list>
          <div class="d-none d-md-block">
            <v-list-item active-class="colBorder" :to="'/'">
              <v-icon color="primary" small left>mdi-account-hard-hat</v-icon>
              Ekip
            </v-list-item>
            <v-list-item active-class="colBorder" :to="'/budanan-agac'">
              <v-icon color="primary" small left>mdi-tree</v-icon>
              Budanan Ağaç
            </v-list-item>
            <v-list-item active-class="colBorder" :to="'/takvim'">
              <v-icon color="primary" small left>mdi-calendar</v-icon>
              Takvim
            </v-list-item>
            <v-list-item active-class="colBorder" :to="'/gider'">
              <v-icon color="primary" small left>mdi-currency-try</v-icon>
              Gider
            </v-list-item>
          </div>
          <v-list-item active-class="colBorder" :to="'/hakedis'">
            <v-icon color="primary" small left>mdi-calculator</v-icon>
            Hakediş Listesi
          </v-list-item>
          <v-list-item active-class="colBorder" :to="'/ayrilan-calisanlar'">
            <v-icon color="primary" small left>mdi-account-cancel</v-icon>
            Ayrılan Çalışan Listesi
          </v-list-item>
          <v-list-item active-class="colBorder" @click="logout">
            <v-icon color="primary" small left>mdi-login</v-icon>
            Çıkış yap
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
      <bottom-nav
        style="position: fixed; bottom: 0px; z-index: 2"
        class="d-md-none"
      ></bottom-nav>
    </div>

    <v-main>
      <v-container
        class="pb-16"
        :style="
          $route.fullPath === '/login'
            ? 'margin:0;padding:0;height:100vh;max-width:none'
            : ''
        "
      >
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    drawer: null,
    ad: window.localStorage.getItem("ad"),
    soyad: window.localStorage.getItem("soyad"),
  }),
  computed: {},
  methods: {
    logout() {
      window.localStorage.removeItem("requiresAuth");
      window.localStorage.removeItem("ad");
      window.localStorage.removeItem("soyad");
      window.localStorage.removeItem("_uid");
      this.$router.push("/login");
    },
  },
  mounted() {},
  watch: {},
  created() {},
};
</script>
<style scope></style>
