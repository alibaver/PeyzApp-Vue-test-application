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

            <v-card-title class="overline pt-0"> TOPLAM GİDER </v-card-title>
            <v-card-subtitle class="body-2"
              >₺{{ totalExpense }}</v-card-subtitle
            >

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
                    GİDER EKLE
                    <v-icon small right>mdi-plus</v-icon>
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title> Gider Ekle </v-card-title>
                  <v-divider></v-divider>
                  <v-card-text class="pa-0">
                    <v-row class="ma-0">
                      <v-col cols="12" class="pa-0">
                        <!-- ekipler -->
                        <v-col cols="12">
                          <v-select
                            v-if="!teamID"
                            class="mb-1"
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
                        <!-- aciklama -->
                        <v-col cols="12" class="py-1">
                          <v-textarea
                            outlined
                            hide-details=""
                            label="Açıklama"
                            ref="aciklama"
                            prepend-inner-icon="mdi-pen"
                          ></v-textarea>
                        </v-col>
                        <!-- fiyat -->
                        <v-col cols="12" class="py-1 pb-3">
                          <v-text-field
                            ref="fiyat"
                            label="Fiyat"
                            type="number"
                            outlined
                            hide-details=""
                            prepend-inner-icon="mdi-currency-try"
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
                    <v-btn color="primary" text @click="save"> Kaydet </v-btn>
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
                @click="teamID ? getExpense(teamID) : getAllExpense()"
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
          :items="expenseData"
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
    totalExpense: 0,
    items: [],
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
        value: "tarih",
      },
      { text: "Ekip Adı", value: "ekip_adi" },
      { text: "Açıklama", value: "aciklama", sortable: false },
      { text: "Harcama Tutarı (₺)", value: "total" },
    ],
    expenseData: [],
    pageLoading: true,
  }),
  methods: {
    close(e) {
      this.alert.isOpen = false;
    },
    save() {
      let _ekipId, _ekipAdi, _tarih, _aciklama, _total;

      if (!this.teamID && !this.teamName) {
        if (
          this.$refs.ekipAdi.lazyValue != undefined &&
          this.$refs.ekipAdi.selectedItems[0].text != undefined &&
          this.$refs.aciklama.lazyValue != undefined &&
          this.$refs.aciklama.lazyValue != "" &&
          this.$refs.fiyat.lazyValue != undefined &&
          this.$refs.fiyat.lazyValue != ""
        ) {
          _ekipAdi = this.$refs.ekipAdi.selectedItems[0].text;
          _ekipId = this.$refs.ekipAdi.selectedItems[0].value;
          _aciklama = this.$refs.aciklama.lazyValue;
          _tarih = this.$refs.tarih.value;
          _total = this.$refs.fiyat.lazyValue;

          let sendObj = {
            ekipId: _ekipId,
            ekipAdi: _ekipAdi,
            aciklama: _aciklama,
            tarih: _tarih,
            total: numeral(parsePrice(_total)).format("0,0.00"),
          };

          this.$refs.fiyat.lazyValue = "";
          this.$refs.aciklama.lazyValue = "";

          this.postExpense(sendObj).then((res) => {
            this.alert.style = "success";
            this.alert.message = "Kayıt başarılı..";
          });
        } else {
          this.alert.style = "error";
          this.alert.message = "Hata..";
        }
      } else {
        if (
          this.$refs.aciklama.lazyValue != undefined &&
          this.$refs.aciklama.lazyValue != "" &&
          this.$refs.fiyat.lazyValue != undefined &&
          this.$refs.fiyat.lazyValue != ""
        ) {
          _ekipAdi = this.teamName;
          _ekipId = this.teamID;
          _aciklama = this.$refs.aciklama.lazyValue;
          _tarih = this.$refs.tarih.value;
          _total = this.$refs.fiyat.lazyValue;

          let sendObj = {
            ekipId: _ekipId,
            ekipAdi: _ekipAdi,
            aciklama: _aciklama,
            tarih: _tarih,
            total: numeral(parsePrice(_total)).format("0,0.00"),
          };

          this.$refs.fiyat.lazyValue = "";
          this.$refs.aciklama.lazyValue = "";

          this.postExpense(sendObj).then((res) => {
            this.alert.style = "success";
            this.alert.message = "Kayıt başarılı..";
          });
        } else {
          this.alert.style = "error";
          this.alert.message = "Hata..";
        }
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
    postExpense(obj) {
      return this.$axios
        .post("postdata.php", JSON.stringify(obj), {
          params: {
            param: "expense",
          },
        })
        .catch((err) => {
          console.log(err);
        });
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

      this.getFilteredExpense(tarih1, tarih2);
    },
    getAllExpense() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getAllExpense",
          },
        })
        .then((response) => {
          this.totalExpense = 0;
          this.expenseData = response.data;
          this.expenseData.forEach((data) => {
            this.totalExpense += parsePrice(data.total);
            data.tarih = data.tarih.split("-").reverse().join(".");
          });
          this.totalExpense = numeral(this.totalExpense).format("0,0.00");
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getExpense(_id) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getExpense",
            param: _id,
          },
        })
        .then((response) => {
          this.totalExpense = 0;
          this.expenseData = response.data;
          this.expenseData.forEach((data) => {
            this.totalExpense += parsePrice(data.total);
            data.tarih = data.tarih.split("-").reverse().join(".");
          });
          this.totalExpense = numeral(this.totalExpense).format("0,0.00");
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getFilteredExpense(t1, t2) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getFilteredExpense",
            param: t1,
            param2: t2,
          },
        })
        .then((response) => {
          this.totalExpense = 0;
          this.expenseData = response.data;
          this.expenseData.forEach((data) => {
            this.totalExpense += parsePrice(data.total);
            data.tarih = data.tarih.split("-").reverse().join(".");
          });
          this.totalExpense = numeral(this.totalExpense).format("0,0.00");
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {},
  computed: {},
  watch: {},
  created() {
    this.getTeams();
    this.date = this.$getDate();
    this.rangedate = [this.$getDate(), this.$getDate()];
    this.teamID = this.$route.query.teamId;
    this.teamName = this.$route.query.teamName;
    if (this.teamID == undefined && this.teamName == undefined) {
      this.getAllExpense();
    } else {
      this.getExpense(this.teamID);
    }
  },
};
</script>
