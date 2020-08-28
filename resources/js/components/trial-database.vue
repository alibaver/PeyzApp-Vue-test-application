<template>
  <v-sheet elevation="0" class="pa-0 mt-5" style="background-color:transparent">
    <div class="justify-content-center align-items-center d-flex w100">
      <v-icon class="pr-2">mdi-database-lock</v-icon>
      <span class="text-body-1">DENEME VERİTABANLARI</span>
    </div>
    <v-slide-group
      :show-arrows="$vuetify.breakpoint.name == 'xs' ? false : true"
      center-active
      mandatory
      class="mt-3"
    >
      <v-slide-item
        v-for="(item, index) in trialDatabase"
        :key="index"
        v-slot:default="{toggle}"
      >
        <v-card width="285" height="330" class="ma-4 removeShadow" @click="toggle" :ripple="false">
          <v-card-text>
            <v-icon x-small>mdi-database-lock</v-icon>
            <span class="text-caption">Deneme Veritabanı</span>
            <div class="mb-2 text-caption">Son Erişim Tarihi: {{ item.sonErisimTarihi }}</div>
            <p class="title text--primary text-subtitle-1">{{ item.title }}</p>
            <p v-line-clamp:20="5">{{ item.content }}</p>
          </v-card-text>
          <v-card-actions class="position-absolute bottom-0 w100">
            <v-btn text color="footerLight" class="float-right">
              Devamı
              <v-icon small right>mdi-chevron-right</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-slide-item>
    </v-slide-group>
  </v-sheet>
</template>
<style scoped>
</style>
<script>
export default {
  props: {
    trialDatabase: {
      type: Array,
      required: true
    }
  },
  data: () => ({}),
  mounted() {}
};
</script>
