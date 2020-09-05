<template>
  <v-app id="inspire">
    <v-app-bar id="appBar" app color="primary" dense clipped-left flat dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <span class="subtitle-1">peyz</span>
      <span class="font-weight-bold">APP</span>
      <v-spacer></v-spacer>
      <span class="caption">v1.0.0</span>
    </v-app-bar>
    <!-- navigation -->
    <v-navigation-drawer app v-model="drawer" clipped></v-navigation-drawer>
    <!-- /navigation -->

    <v-main>
      <v-container class="pb-16">
        <router-view></router-view>
      </v-container>

      <bottom-nav style="position:fixed; bottom:0px"></bottom-nav>
    </v-main>
  </v-app>
</template>
<script>
import JQuery from "jquery";
var $ = JQuery;

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
<style scope>
</style>
