<template>
  <v-bottom-navigation grow shift dark class="gradientCard">
    <v-btn :to="'/'">
      <span>Ekip</span>
      <v-icon>mdi-account-hard-hat</v-icon>
    </v-btn>

    <v-btn :to="'/kesilen-agac'">
      <span>K. Ağaç</span>
      <v-icon>mdi-tree</v-icon>
    </v-btn>

    <v-btn :to="'/takvim'">
      <span>Takvim</span>
      <v-icon>mdi-calendar</v-icon>
    </v-btn>

    <v-btn :to="'/giderler'">
      <span>Giderler</span>
      <v-icon>mdi-currency-try</v-icon>
    </v-btn>
  </v-bottom-navigation>
</template>

<script>
export default {
  data: () => ({}),
  methods: {},
  mounted() {},
  watch: {},
  created() {},
};
</script>
