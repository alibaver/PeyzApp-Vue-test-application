<template>
  <div id="ekipCon">
    <div v-if="!teamData.length">
      <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-100%);">
        <center>
          <v-icon size="50" color="grey">mdi-alert</v-icon>
        </center>
        <span class="grey--text caption">Ekip Bulunamadı</span>
      </div>
      <v-btn
        depressed
        dark
        class="gradientCard"
        style="position:absolute; bottom:90px; left:50%; transform:translateX(-50%);"
        :to="'/ekip-olustur'"
      >
        EKİP OLUŞTUR
        <v-icon right>mdi-plus</v-icon>
      </v-btn>
    </div>
    <div v-else>
      <v-card
        class="mb-4 pa-1"
        ripple
        v-for="(team, index) in teamData"
        :key="index"
        @click="teamDetails(team.ekip_ID)"
      >
        <v-card-title class="body-1">{{ team.ekip }}</v-card-title>
        <v-card-subtitle>{{team.calisan_sayisi}} Çalışan</v-card-subtitle>
        <v-divider></v-divider>
        <span class="body-1 teamCost">₺{{team.toplam_yevmiye}}</span>
        <v-card-text class="secondary--text text-body-2">
          <v-icon small left color="secondary">mdi-tree</v-icon>Kesilen Ağaç Sayısı
        </v-card-text>
        <v-sheet color="transparent" class="pa-2">
          <v-sparkline
            :key="String(days)"
            :smooth="10"
            :gradient="['#4776E6', '#8E54E9']"
            :line-width="3"
            :value="value"
            :labels="days"
            :padding="16"
            color="secondary"
            auto-draw
            gradient-direction="left"
            stroke-linecap="round"
          ></v-sparkline>
        </v-sheet>
      </v-card>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    teamData: [],
    workerLen: null,
    value: [100, 50, 320, 100, 80, 225],
    days: ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"],
  }),
  methods: {
    teamDetails(ID) {
      this.$router.push({ path: "/ekip-detay", query: { teamId: ID } });
    },
    getTeamDetails() {
      axios
        .get("ajaxfile.php", {
          params: {
            choose: "teams",
          },
        })
        .then((response) => {
          let myslqConnect = response.data.indexOf("mysqli_connect()");
          let nullIndex = response.data.indexOf("[]");
          nullIndex > -1 || myslqConnect > -1
            ? (this.teamData = 0)
            : (this.teamData = response.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {},
  watch: {},
  created() {
    this.getTeamDetails();
  },
};
</script>

<style></style>
