<template>
  <v-app id="inspire">
    <div v-if="$route.fullPath != '/login'">
      <v-app-bar id="appBar" app clipped-left color="white" elevate-on-scroll>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" color="primary" />
        <a href="/">
          <span class="subtitle-1 primary--text"
            >peyz<span class="font-weight-bold primary--text">APP</span>
          </span>
        </a>
        <v-spacer></v-spacer>
      </v-app-bar>
      <v-navigation-drawer app v-model="drawer" clipped>
        <div class="d-flex justify-center align-center w100 pa-5 flex-column">
          <v-avatar class="gradientCard" size="100">
            <span class="white--text text-h4">DK</span>
          </v-avatar>
          <span class="mt-4">Delal Kahraman</span>
        </div>
        <v-divider></v-divider>
        <v-list>
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
      <bottom-nav style="position: fixed; bottom: 0px; z-index: 2"></bottom-nav>
    </div>

    <v-main>
      <v-container
        class="pb-16"
        :style="
          $route.fullPath === '/login' ? 'margin:0;padding:0;height:100vh' : ''
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
  }),
  computed: {},
  methods: {
    logout() {
      window.localStorage.setItem("requiresAuth", false);
      this.$router.push("/login");
    },
  },
  mounted() {},
  watch: {},
  created() {},
};
</script>
<style scope></style>
