<template>
  <!-- <v-speed-dial
    v-model="fab"
    :top="top"
    :bottom="bottom"
    :right="right"
    :left="left"
    :direction="direction"
    :open-on-hover="hover"
    :transition="transition"
  >
    <template v-slot:activator>
      <v-btn v-model="fab" color="blue darken-2" dark fab>
        <v-icon v-if="fab">mdi-close</v-icon>
        <v-icon v-else>mdi-account-circle</v-icon>
      </v-btn>
    </template>
    <v-btn fab dark small color="green">
      <v-icon>mdi-pencil</v-icon>
    </v-btn>
    <v-btn fab dark small color="indigo">
      <v-icon>mdi-plus</v-icon>
    </v-btn>
    <v-btn fab dark small color="red">
      <v-icon>mdi-delete</v-icon>
    </v-btn>
  </v-speed-dial>-->

  <v-speed-dial
    v-model="fab"
    transition="scale-transition"
    z-index="2"
    style="position:fixed; right: 20px; bottom:20px;"
  >
    <template v-slot:activator>
      <v-btn v-model="fab" color="base" dark fab>
        <v-icon v-if="fab">mdi-close</v-icon>
        <v-icon v-else>mdi-plus</v-icon>
      </v-btn>
    </template>
    <v-btn fab dark small color="indigo">
      <v-icon>mdi-face-agent</v-icon>
    </v-btn>
    <v-btn fab dark small color="red">
      <v-icon>mdi-pen</v-icon>
    </v-btn>
    <v-btn fab dark small color="green" @click="darkMode = !darkMode">
      <v-icon>mdi-brightness-4</v-icon>
    </v-btn>
  </v-speed-dial>
</template>
<script>
import JQuery from "jquery";
var $ = JQuery;
export default {
  data: () => ({
    fab: false,
    darkMode: JSON.parse(localStorage.getItem("darkMode"))
  }),
  computed: {},
  watch: {
    darkMode(val) {
      this.$emit("set-theme", this.darkMode);
      $("#compLogo")
        .find(".imgchangeColor")
        .toggleClass("whiteBG");
    },
    mounted() {}
  }
};
</script>
<style>
/* This is for documentation purposes and will not be needed in your application */
#create .v-speed-dial {
  position: absolute;
}

#create .v-btn--floating {
  position: relative;
}
</style>