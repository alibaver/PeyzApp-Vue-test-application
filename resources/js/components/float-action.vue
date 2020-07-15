<template>
  <div>
    <!-- <v-speed-dial
    v-model="fab"
    transition="slide-y-reverse-transition"
    z-index="2"
    style="position:fixed; right: 20px; bottom:20px;"
  >
    <template v-slot:activator>
      <v-btn v-model="fab" color="base" dark fab>
        <v-icon v-if="fab">mdi-close</v-icon>
        <v-icon v-else>mdi-plus</v-icon>
      </v-btn>
    </template>
    <div class="d-inline-flex float_action justify-content-center align-items-center">
      <v-chip small class="ma-1" label>Destek</v-chip>
      <v-btn fab dark small color="indigo">
        <v-icon>mdi-face-agent</v-icon>
      </v-btn>
    </div>
    <div class="d-inline-flex float_action justify-content-center align-items-center">
      <v-chip small class="ma-1" label>Karanlık Tema</v-chip>
      <v-btn fab dark small color="green" @click="darkMode = !darkMode">
        <v-icon>mdi-brightness-4</v-icon>
      </v-btn>
    </div>
    </v-speed-dial>-->

    <v-btn color="base" fab dark fixed bottom right @click="support = !support">
      <v-icon>mdi-face-agent</v-icon>
    </v-btn>
  </div>
</template>
<script>
import JQuery from "jquery";
var $ = JQuery;
export default {
  data: () => ({
    fab: false
  }),
  methods: {},
  computed: {},
  watch: {},
  mounted() {
    $(".v-speed-dial__list").css({
      "justify-content": "flex-start",
      "align-items": "flex-end"
    });
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
