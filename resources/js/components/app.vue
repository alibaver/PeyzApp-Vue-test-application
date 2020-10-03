<template>
  <v-app id="inspire">
    <v-app-bar
      id="appBar"
      app
      clipped-left
      dense
      color="white"
      elevate-on-scroll
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" color="primary" />
      <a href="/">
        <span class="subtitle-1 primary--text"
          >peyz<span class="font-weight-bold primary--text">APP</span>
        </span>
      </a>
      <v-spacer></v-spacer>
      <!-- <span class="caption primary--text">v1.0.0</span> -->
    </v-app-bar>
    <!-- navigation -->
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
      </v-list>
    </v-navigation-drawer>
    <!-- /navigation -->

    <v-main>
      <v-container class="pb-16">
        <router-view></router-view>
      </v-container>

      <bottom-nav style="position: fixed; bottom: 0px; z-index: 2"></bottom-nav>
    </v-main>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    drawer: null,
  }),
  computed: {},
  methods: {},
  mounted() {},
  watch: {},
  created() {},
};
</script>
<style scope></style>
