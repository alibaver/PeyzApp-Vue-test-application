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
    <div v-else>
      <page-path></page-path>
      <alert-component
        @closeAlert="close($event)"
        :alert-msg="alert.message"
        :alert-style="alert.style"
        :alert-open="alert.isOpen"
        :alert-time="alert.time"
      ></alert-component>

      <v-row>
        <!-- kart -->
        <v-col>
          <v-card class="pa-3 colBorder elevation-1">
            <div v-if="teamID">
              <v-card-title class="overline pt-0">EKİP ADI</v-card-title>
              <v-card-subtitle class="body-2"> {{ teamName }} </v-card-subtitle>
            </div>

            <v-card-title class="overline pt-0">
              TOPLAM BUDANAN AĞAÇ
            </v-card-title>
            <v-card-subtitle class="body-2">
              {{ totalPruning }} Adet
            </v-card-subtitle>
            <v-card-title class="overline pt-0"> TOPLAM MALİYET </v-card-title>
            <v-card-subtitle class="body-2">
              ₺{{ totalPrice }}
            </v-card-subtitle>

            <!-- Gider Ekle -->
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    text
                    depressed
                    small
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                  >
                    BUDANAN AĞAÇ BİLGİSİ EKLE
                    <v-icon small right>mdi-plus</v-icon>
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title> Budanan Ağaç Ekle </v-card-title>
                  <v-divider></v-divider>
                  <v-card-text class="pa-0">
                    <v-row class="ma-0">
                      <v-col cols="12" class="pa-0">
                        <!-- ekipler -->
                        <v-col cols="12">
                          <v-select
                            v-if="!teamID"
                            class="mt-1 mb-1"
                            prepend-inner-icon="mdi-account-hard-hat"
                            outlined
                            hide-details
                            ref="ekipAdi"
                            label="Ekip Seçin"
                            :items="items"
                          ></v-select>
                        </v-col>
                        <!-- tarih -->
                        <v-col cols="12" class="py-1">
                          <v-dialog
                            ref="dialog"
                            v-model="modal"
                            :return-value.sync="date"
                            persistent
                          >
                            <template v-slot:activator="{ on, attrs }">
                              <v-text-field
                                v-model="date"
                                label="Tarih seçin"
                                prepend-inner-icon="mdi-calendar"
                                readonly
                                hide-details=""
                                outlined
                                v-bind="attrs"
                                v-on="on"
                                ref="tarih"
                              ></v-text-field>
                            </template>
                            <v-date-picker
                              v-model="date"
                              scrollable
                              locale="tr"
                              width="auto"
                            >
                              <v-spacer></v-spacer>
                              <v-btn text color="primary" @click="modal = false"
                                >Kapat</v-btn
                              >
                              <v-btn
                                text
                                color="primary"
                                @click="$refs.dialog.save(date)"
                                >Tamam</v-btn
                              >
                            </v-date-picker>
                          </v-dialog>
                        </v-col>
                        <!-- Budama türü -->
                        <v-col cols="12" class="py-1">
                          <v-select
                            class="mt-2 mb-1"
                            prepend-inner-icon="mdi-tree"
                            outlined
                            hide-details
                            ref="budamaTuru"
                            label="Budama Türü"
                            :items="budamaTuru"
                            :value="budamaTuru[0]"
                          ></v-select>
                        </v-col>
                        <!-- ağaç sayı -->
                        <v-col cols="12" class="py-1 pb-4">
                          <v-text-field
                            ref="agacSayi"
                            label="Ağaç Sayısı"
                            type="number"
                            outlined
                            hide-details=""
                            prepend-inner-icon="mdi-counter"
                          >
                          </v-text-field>
                        </v-col>
                      </v-col>
                    </v-row>
                  </v-card-text>
                  <v-divider></v-divider>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="dialog = !dialog">
                      Kapat
                    </v-btn>
                    <v-btn text color="primary" @click="save">Kaydet</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-card-actions>
          </v-card>
          <!-- Filtre -->
          <v-card class="pa-3 colBorder elevation-1 mt-4">
            <v-card-title class="overline pt-0"> FİLTRELEME </v-card-title>
            <v-card-subtitle class="caption">
              Gider listesini filtreleyeceğiniz tarih aralığını
              seçin.</v-card-subtitle
            >
            <v-card-text>
              <!-- tarih1 -->
              <v-dialog
                ref="range"
                v-model="tarih"
                :return-value.sync="rangedate"
                persistent
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="rangedate"
                    label="Tarih Aralığı Seçin"
                    prepend-inner-icon="mdi-calendar"
                    readonly
                    hide-details=""
                    outlined
                    v-bind="attrs"
                    v-on="on"
                    ref="tarih"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="rangedate"
                  scrollable
                  locale="tr"
                  width="auto"
                  range
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="tarih = false"
                    >Kapat</v-btn
                  >
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.range.save(rangedate)"
                    >Tamam</v-btn
                  >
                </v-date-picker>
              </v-dialog>
            </v-card-text>
            <v-card-actions>
              <v-btn
                color="primary"
                text
                small
                @click="teamID ? getPruning(teamID) : getAllPruning()"
              >
                TEMİZLE
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn color="primary" text small @click="filter">
                FİLTRELE
                <v-icon small right>mdi-check-all</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
        <!-- datatable -->
        <v-data-table
          :headers="headers"
          :items="pruningData"
          class="elevation-0"
          disable-sort
          :items-per-page="5"
          :loading="loading"
          loading-text="Veriler yükleniyor..."
        >
        </v-data-table>
      </v-row>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    teams: "",
    teamID: "",
    teamName: "",
    pageLoading: true,
    totalPruning: 0,
    totalPrice: 0,
    trees: "",
    items: [],
    budamaTuru: [],
    date: "",
    rangedate: "",
    tarih: false,
    modal: false,
    alert: {
      isOpen: false,
      message: "",
      style: "",
      time: 2000,
    },
    dialog: false,
    loading: true,
    headers: [
      {
        text: "Tarih",
        align: "start",
        value: "budama_tarihi",
      },
      { text: "Ekip Adı", value: "ekip_adi" },
      { text: "Ağaç Türü", value: "agac_adi" },
      { text: "Adet", value: "adet" },
      { text: "Toplam (₺)", value: "total" },
    ],
    pruningData: [],
  }),
  methods: {
    close(e) {
      this.alert.isOpen = false;
    },
    save() {
      let _ekipId,
        _ekipAdi,
        _tarih,
        _budamaTuru,
        _budamaAdi,
        _agacSayisi,
        _total,
        err = false;

      if (!this.teamID && !this.teamName) {
        if (
          this.$refs.ekipAdi.lazyValue != undefined &&
          this.$refs.ekipAdi.selectedItems[0].text != undefined &&
          this.$refs.budamaTuru.lazyValue != undefined &&
          this.$refs.budamaTuru.selectedItems[0].text != undefined &&
          this.$refs.agacSayi.lazyValue != undefined &&
          this.$refs.agacSayi.lazyValue != ""
        ) {
          _ekipAdi = this.$refs.ekipAdi.selectedItems[0].text;
          _ekipId = this.$refs.ekipAdi.selectedItems[0].value;
        } else {
          this.alert.style = "error";
          this.alert.message = "Hata..";
          err = true;
        }
      } else {
        if (
          this.$refs.budamaTuru.lazyValue != undefined &&
          this.$refs.budamaTuru.selectedItems[0].text != undefined &&
          this.$refs.agacSayi.lazyValue != undefined &&
          this.$refs.agacSayi.lazyValue != ""
        ) {
          _ekipAdi = this.teamName;
          _ekipId = this.teamID;
        } else {
          this.alert.style = "error";
          this.alert.message = "Hata..";
          err = true;
        }
      }

      // hata yoksa
      if (!err) {
        _budamaTuru = this.$refs.budamaTuru.selectedItems[0].value;
        _budamaAdi = this.$refs.budamaTuru.selectedItems[0].text;
        _tarih = this.$refs.tarih.value;
        _agacSayisi = this.$refs.agacSayi.lazyValue;
        let selectedTree = this.trees.find(
          ({ agac_ID }) => agac_ID === _budamaTuru
        );

        let sendObj = {
          id: this.$createId("."),
          ekipId: _ekipId,
          ekipAdi: _ekipAdi,
          budamaTuru: _budamaTuru,
          budamaAdi: _budamaAdi,
          tarih: _tarih,
          agacSayisi: parseFloat(_agacSayisi),
          total: numeral(
            parsePrice(selectedTree.agac_ucret) * parseFloat(_agacSayisi)
          ).format("0,0.00"),
        };

        let promise = Promise.all([
          this.postPruning(sendObj),
          this.updateTeamTree({
            ekipId: _ekipId,
            agacSayisi: parseFloat(_agacSayisi),
          }),
        ]).then(function (results) {
          const postteam = results[0];
          const postworker = results[1];
          if (postteam.status == 200 && postworker.status == 200) {
            return true;
          } else return false;
        });
        promise
          ? ((this.alert.style = "success"),
            (this.alert.message = "Kayıt Başarılı.."))
          : ((this.alert.style = "error"), (this.alert.message = "Hata.."));

        this.$refs.agacSayi.lazyValue = "";
      }

      this.alert.isOpen = true;
      this.alert.time > -1
        ? setTimeout(() => {
            this.alert.isOpen = false;
            this.dialog = false;
            window.location.reload();
          }, this.alert.time)
        : "";
    },
    filter() {
      let tarih1, tarih2;

      tarih1 = this.rangedate[0];
      tarih2 = this.rangedate[1];

      if (parsePrice(tarih1) > parsePrice(tarih2)) {
        let buff = tarih1;
        tarih1 = tarih2;
        tarih2 = buff;
      }

      this.getFilteredPruning(tarih1, tarih2);
    },
    getTeams() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "teams",
          },
        })
        .then((response) => {
          this.teams = response.data;
          this.teams.forEach((item) => {
            this.items.push({
              text: item.ekip_adi,
              value: item.ekip_ID,
            });
          });
          this.pageLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getTrees() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "trees",
          },
        })
        .then((response) => {
          this.trees = response.data;
          this.trees.forEach((item) => {
            this.budamaTuru.push({
              text: item.agac_adi,
              value: item.agac_ID,
            });
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    postPruning(obj) {
      return this.$axios
        .post("postdata.php", JSON.stringify(obj), {
          params: {
            param: "pruning",
          },
        })
        .catch((err) => {
          console.log(err);
        });
    },
    updateTeamTree(_obj) {
      return this.$axios
        .post("postdata.php", JSON.stringify(_obj), {
          params: {
            param: "updateTeamTree",
          },
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
          this.totalPruning = 0;
          this.totalPrice = 0;
          this.pruningData = response.data;
          this.pruningData.forEach((data) => {
            this.totalPruning += parseInt(data.adet);
            this.totalPrice += parsePrice(data.total);
            data.budama_tarihi = data.budama_tarihi
              .split("-")
              .reverse()
              .join(".");
          });
          this.totalPrice = numeral(this.totalPrice).format("0,0.00");
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getPruning(_id) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getPruning",
            param: _id,
          },
        })
        .then((response) => {
          this.totalPruning = 0;
          this.totalPrice = 0;
          this.pruningData = response.data;
          this.pruningData.forEach((data) => {
            this.totalPruning += parseInt(data.adet);
            this.totalPrice += parsePrice(data.total);
            data.budama_tarihi = data.budama_tarihi
              .split("-")
              .reverse()
              .join(".");
          });
          this.totalPrice = numeral(this.totalPrice).format("0,0.00");
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getFilteredPruning(t1, t2) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getFilteredPruning",
            param: t1,
            param2: t2,
          },
        })
        .then((response) => {
          this.totalPruning = 0;
          this.totalPrice = 0;
          this.pruningData = response.data;
          this.pruningData.forEach((data) => {
            this.totalPruning += parseInt(data.adet);
            this.totalPrice += parsePrice(data.total);
            data.budama_tarihi = data.budama_tarihi
              .split("-")
              .reverse()
              .join(".");
          });
          this.totalPrice = numeral(this.totalPrice).format("0,0.00");
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {},
  watch: {},
  created() {
    this.getTeams();
    this.getTrees();
    this.date = this.$getDate();
    this.rangedate = [this.$getDate(), this.$getDate()];
    this.teamID = this.$route.query.teamId;
    this.teamName = this.$route.query.teamName;
    if (this.teamID == undefined && this.teamName == undefined) {
      this.getAllPruning();
    } else {
      this.getPruning(this.teamID);
    }
  },
};
</script>
