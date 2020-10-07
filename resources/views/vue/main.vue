<template>
  <div>
    <div
      v-if="pageLoading"
      class="d-flex justify-center align-center w100 flex-column pLoad"
    >
      <v-progress-circular
        :width="3"
        :size="60"
        color="primary"
        indeterminate
      ></v-progress-circular>
      <span class="mt-4 overline primary--text">LOADING..</span>
    </div>
    <div
      v-else
      id="ekipCon"
      class="fill-height w100 d-flex justify-center align-end flex-column"
    >
      <!-- EKİP YOK -->
      <div v-if="!teamData.length" class="fill-height">
        <div
          style="
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -100%);
          "
        >
          <center>
            <v-icon size="90" color="grey">mdi-alert</v-icon>
          </center>
          <span class="grey--text overline">EKİP BULUNAMADI</span>
        </div>
      </div>
      <!-- EKİP BİLGİLER -->
      <div v-else class="w100 mb-4 mx-auto">
        <v-row>
          <v-col
            cols="12"
            lg="4"
            md="6"
            sm="6"
            v-for="(team, index) in teamData"
            :key="index"
          >
            <v-card
              @click="
                $router.push({
                  path: '/ekip-detay',
                  query: { teamId: team.ekip_ID },
                })
              "
              class="mb-4 pa-1"
              :ripple="false"
            >
              <!-- ekip detay -->

              <v-card-title class="subtitle-1"
                >{{ team.ekip_adi }}
                <v-spacer></v-spacer>
                <!-- menu -->
                <v-menu offset-y>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                      <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                  </template>
                  <v-list>
                    <v-list-item
                      ripple=""
                      @click="
                        $router.push({
                          path: '/calisan-ekle',
                          query: {
                            teamId: team.ekip_ID,
                            teamName: team.ekip_adi,
                          },
                        })
                      "
                    >
                      <v-icon left>mdi-account-plus</v-icon>
                      Çalışan Ekle
                    </v-list-item>
                    <v-list-item
                      ripple=""
                      @click="
                        $router.push({
                          path: '/budanan-agac',
                          query: {
                            teamId: team.ekip_ID,
                            teamName: team.ekip_adi,
                          },
                        })
                      "
                    >
                      <v-icon left>mdi-palm-tree</v-icon>
                      Budanan Ağaç </v-list-item
                    ><v-list-item
                      ripple=""
                      @click="
                        $router.push({
                          path: '/gider',
                          query: {
                            teamId: team.ekip_ID,
                            teamName: team.ekip_adi,
                          },
                        })
                      "
                    >
                      <v-icon left>mdi-currency-try</v-icon>
                      Giderler
                    </v-list-item>
                    <v-list-item ripple="" @click="calcHakedis(team.ekip_ID)">
                      <v-icon left>mdi-calculator</v-icon>
                      Hakediş Hesapla
                    </v-list-item>
                    <v-list-item ripple="" @click="removeTeam(team.ekip_ID)">
                      <v-icon left color="error">mdi-account-remove</v-icon>
                      <span class="error--text">Ekibi Sil</span>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </v-card-title>
              <v-card-subtitle
                >{{ team.calisan_sayisi }} Çalışan</v-card-subtitle
              >
              <v-card-title class="subtitle-1 pt-0">
                HAKEDİŞ
                <span class="caption">&nbsp;(Toplam)</span></v-card-title
              >
              <v-card-subtitle class="font-weight-bold primary--text body-1">
                ₺{{ team.toplam_yevmiye }}
              </v-card-subtitle>
              <v-card-text class="pa-2">
                <v-chip outlined class="success--text mb-2 mr-1">
                  <v-icon small left color="success">mdi-arrow-up-bold</v-icon>
                  <span class="mr-2 caption">Gelir :</span>
                  ₺{{ calcPruning(team.ekip_ID) }}
                </v-chip>
                <v-chip outlined class="error--text mb-2 mr-1">
                  <v-icon small left color="error">mdi-arrow-down-bold</v-icon>
                  <span class="mr-2 caption">Gider :</span>
                  - ₺{{ calcExpense(team.ekip_ID) }}
                </v-chip>
              </v-card-text>

              <v-divider></v-divider>
              <!-- ağaç sayı -->
              <v-card-text
                class="secondary--text text-overline d-block text-center"
                >HAFTALIK AĞAÇ GRAFİĞİ</v-card-text
              >
              <v-sheet color="transparent" class="pa-2">
                <v-sparkline
                  :key="String(days)"
                  :smooth="15"
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
          </v-col>
        </v-row>
      </div>

      <v-btn
        text
        :dark="!teamData.length ? true : false"
        class="mb-4 mt-auto mx-auto overline"
        :class="!teamData.length ? 'gradientCard' : ''"
        :color="!teamData.length ? '' : 'primary'"
        :to="'/ekip-olustur'"
        :style="
          !teamData.length
            ? 'position: absolute;bottom: 50px;left: 50%;transform: translateX(-50%);'
            : ''
        "
      >
        EKİP OLUŞTUR
        <v-icon right small>mdi-account-multiple-plus</v-icon>
      </v-btn>

      <alert-component
        @closeAlert="close($event)"
        :alert-msg="alert.message"
        :alert-style="alert.style"
        :alert-open="alert.isOpen"
        :alert-time="alert.time"
      ></alert-component>
      <!-- dialog -->
      <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card>
            <v-card-title class="text-h6">Ekibi Sil?</v-card-title>
            <v-card-text class="text-body-2">
              Yaptığınız düzenlemeler kaydedilecek ve geri alınamayacaktır.
              Onaylıyor musunuz?
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="grey darken-2" text @click="dialog = false"
                >hayır</v-btn
              >
              <v-btn color="primary" depressed>evet</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    pageLoading: true,
    teamData: [],
    workers: [],
    backups: [],
    expense: [],
    pruning: [],
    workerLen: null,
    dialog: false,
    value: [140, 70, 320, 270, 280, 225, 500],
    days: [
      "Pazartesi",
      "Salı",
      "Çarşamba",
      "Perşembe",
      "Cuma",
      "Cumartesi",
      "Pazar",
    ],
    alert: {
      isOpen: false,
      message: "",
      style: "",
      time: 1300,
    },
  }),
  methods: {
    calcPruning(_id) {
      let price = 0;
      this.pruning.forEach((item) => {
        item.ekip_ID === _id ? (price += parsePrice(item.total)) : "";
      });
      return numeral(price).format("0,0.00");
    },
    calcExpense(_id) {
      let price = 0;
      this.expense.forEach((item) => {
        item.ekip_ID === _id ? (price += parsePrice(item.total)) : "";
      });
      return numeral(price).format("0,0.00");
    },
    calcHakedis(_id) {
      let worker = [],
        backup = [];
      let price = 0,
        pruningPrice = 0;
      let team = this.teamData.find(({ ekip_ID }) => ekip_ID === _id);
      this.backups.forEach((item) => {
        item.ekip_ID === _id ? backup.push(item) : "";
      });
      this.workers.forEach((item) => {
        item.ekip_ID === _id ? worker.push(item) : "";
      });
      this.expense.forEach((item) => {
        item.ekip_ID === _id ? (price += parsePrice(item.total)) : "";
      });
      this.pruning.forEach((item) => {
        item.ekip_ID === _id ? (pruningPrice += parsePrice(item.total)) : "";
      });
      price = numeral(price).format("0,0.00");
      pruningPrice = numeral(pruningPrice).format("0,0.00");

      let date = new Date()
        .toLocaleDateString("tr")
        .split(".")
        .reverse()
        .join("-");

      let obj = {
        tarih: date,
        ekip_ID: _id,
        ekip_adi: team.ekip_adi,
        calisan_sayisi: team.calisan_sayisi,
        toplam_yevmiye: team.toplam_yevmiye,
        toplam_gider: price,
        toplam_kesilen_agac: team.toplam_kesilen_agac,
        agac_gelir: pruningPrice,
        calisanlar: JSON.stringify(worker),
        ayrilan_calisanlar: backup != undefined ? JSON.stringify(backup) : "",
      };
      this.postHakedis(obj);
    },
    postHakedis(_obj) {
      this.$axios
        .post("postdata.php", JSON.stringify(_obj), {
          params: {
            param: "progressPayment",
          },
        })
        .then((response) => {
          if (response.status == 200) {
            let promise = Promise.all([
              this.postUpdatePayment({ ekip_ID: _obj.ekip_ID }),
              this.postUpdateTeamPayment({
                ekip_ID: _obj.ekip_ID,
              }),
              this.postUpdateBackupPayment({
                ekip_ID: _obj.ekip_ID,
              }),
              this.postUpdatePruning({
                ekip_ID: _obj.ekip_ID,
              }),
              this.postUpdateExpense({
                ekip_ID: _obj.ekip_ID,
              }),
            ]).then(function (results) {
              const res1 = results[0];
              const res2 = results[1];
              const res3 = results[2];
              const res4 = results[3];
              const res5 = results[4];
              if (
                res1.status == 200 &&
                res2.status == 200 &&
                res3.status == 200 &&
                res4.status == 200 &&
                res5.status == 200
              ) {
                return true;
              } else return false;
            });
            promise
              ? ((this.alert.style = "success"),
                (this.alert.message = "Hakediş hesaplandı."))
              : ((this.alert.style = "error"),
                (this.alert.message = "Hakediş hesaplanamadı."));
            this.alert.isOpen = true;
            this.alert.time > -1
              ? setTimeout(() => {
                  this.alert.isOpen = false;
                  this.$router.push({
                    path: "/hakedis",
                    query: {
                      teamId: _obj.ekip_ID,
                      teamName: _obj.ekip_adi,
                    },
                  });
                }, this.alert.time)
              : "";
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    removeTeam(_id) {
      let promise = Promise.all([
        this.postDeleteTeam({ ekip_ID: _id }),
        this.postDeleteTeamWorker({ ekip_ID: _id }),
      ]).then(function (results) {
        const res1 = results[0];
        const res2 = results[1];
        if (res1.status == 200 && res2.status == 200) {
          return true;
        } else return false;
      });
      promise
        ? ((this.alert.style = "success"),
          (this.alert.message = "Ekip Silindi."))
        : ((this.alert.style = "error"), (this.alert.message = "Hata.."));
      this.alert.isOpen = true;
      this.alert.time > -1
        ? setTimeout(() => {
            this.alert.isOpen = false;
            window.location.reload();
          }, this.alert.time)
        : "";
    },
    postDeleteTeam(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "deleteTeam",
        },
      });
    },
    postDeleteTeamWorker(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "deleteTeamWorker",
        },
      });
    },
    postUpdatePruning(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "updatePruning",
        },
      });
    },
    postUpdatePayment(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "resetPayment",
        },
      });
    },
    postUpdateTeamPayment(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "resetTeamPayment",
        },
      });
    },
    postUpdateBackupPayment(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "updateBackupPayment",
        },
      });
    },
    postUpdateExpense(_id) {
      return this.$axios.post("postdata.php", JSON.stringify(_id), {
        params: {
          param: "updateExpense",
        },
      });
    },
    getBackups() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "allBackups",
          },
        })
        .then((response) => {
          this.backups = response.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getWorkers() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "allWorkers",
          },
        })
        .then((response) => {
          this.workers = response.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getTeamDetails() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "teams",
            param: window.localStorage.getItem("_uid"),
          },
        })
        .then((response) => {
          response.data.indexOf("Connection failed: Connection refused") > -1
            ? (this.teamData = 0)
            : (this.teamData = response.data);
          this.pageLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllExpense() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getAllExpense",
          },
        })
        .then((response) => {
          this.expense = response.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllPruning() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getAllPruning",
          },
        })
        .then((response) => {
          this.pruning = response.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    //window.scrollTo(0, 0);
  },
  computed: {},
  watch: {},
  created() {
    this.getTeamDetails();
    this.getWorkers();
    this.getBackups();
    this.getAllExpense();
    this.getAllPruning();
  },
};
</script>

<style></style>
