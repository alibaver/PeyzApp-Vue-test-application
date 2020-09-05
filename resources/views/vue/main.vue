<template>
  <div>
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-100%);">
      <center>
        <v-icon size="50" color="grey">mdi-alert</v-icon>
      </center>
      <span class="grey--text caption">Ekip Bulunamadı</span>
    </div>
    <v-btn
      small
      depressed
      color="primary"
      style="position:absolute; bottom:90px; left:50%; transform:translateX(-50%);"
    >
      EKİP OLUŞTUR
      <v-icon small right>mdi-plus</v-icon>
    </v-btn>
  </div>
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

<style></style>
