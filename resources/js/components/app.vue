<template>
  <v-app id="inspire">
    <v-app-bar id="appBar" app dense color="white" elevate-on-scroll>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" color="primary" />
      <span class="subtitle-1 primary--text">peyz</span>
      <span class="font-weight-bold primary--text">APP</span>
      <v-spacer></v-spacer>
      <span class="caption primary--text">v1.0.0</span>
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
  created() {
    // , {
    //     params: {
    //       choose: "menu",
    //       param: "appBarMenus"
    //     }
    //   }
    // axios
    //   .get("ajaxfile.php")
    //   .then((response) => {
    //     console.log(response.data);
    //   })
    //   .catch((err) => {
    //     console.log(err);
    //   });
  },
};
</script>
<style scope>
</style>
