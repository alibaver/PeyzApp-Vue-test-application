<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" scrollable max-width="500px">
      <v-card>
        <v-card-title>
          <v-icon left>mdi-bell</v-icon>Duyuru
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-card-title class="px-0">{{ noticeTitle }}</v-card-title>
          <v-card-subtitle class="px-0">{{ noticeDate }}</v-card-subtitle>
          <v-img class="mb-6" :src="noticeImg" contain></v-img>
          {{ noticeText }}
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            :color="$vuetify.theme.dark ? '' : 'base'"
            dark
            small
            depressed
            @click="dialog = false"
          >kapat</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      noticeImg: "",
      noticeTitle: "",
      noticeText: "",
      noticeDate: ""
    };
  },
  created() {
    // get menu list
    axios
      .get("ajaxfile.php", {
        params: {
          choose: "notice"
        }
      })
      .then(response => {
        this.noticeImg = response.data[0].noticeImg;
        this.noticeTitle = response.data[0].noticeTitle;
        this.noticeText = response.data[0].noticeText;
        this.noticeDate = response.data[0].noticeDate;
      })
      .catch(err => {
        console.log(err);
      });
  }
};
</script>