<template>
  <div>
    <div
      v-if="pageLoading"
      class="d-flex justify-center align-center w100 flex-column"
      style="height: calc(100vh - 130px)"
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
      <v-row>
        <v-col>
          <!-- kart -->
          <v-card class="pa-3 colBorder elevation-1">
            <!-- ekipler -->
            <v-col cols="12">
              <v-select
                class="mt-1 mb-1"
                prepend-inner-icon="mdi-account-hard-hat"
                outlined
                hide-details
                ref="ekipAdi"
                label="Ekip Seçin"
                :items="items"
                @change="changeTeam"
              ></v-select>
            </v-col>
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
              <v-btn color="primary" text small @click="getAllBackups()">
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
          :items="backupData"
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
    pageLoading: true,
    items: [],
    date: "",
    rangedate: "",
    tarih: false,
    modal: false,
    dialog: false,
    loading: true,
    headers: [
      { text: "Ekip Adı", value: "ekip_adi", align: "start" },
      { text: "Ad", value: "ad" },
      { text: "Soyad", value: "soyad" },
      { text: "Yevmiye (₺)", value: "yevmiye" },
      { text: "Kayit Tarihi", value: "kayit_tarihi" },
      { text: "Ayrılış Tarihi", value: "ayrilis_tarihi" },
      { text: "Hakedis (₺)", value: "hakedis" },
    ],
    backupData: [],
  }),
  methods: {
    changeTeam(val) {
      this.getBackups(val);
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

      this.getFilteredBackups(tarih1, tarih2);
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
    getBackups(_id) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getBackups",
            param: _id,
          },
        })
        .then((response) => {
          this.backupData = response.data;
          this.backupData.forEach((item) => {
            item.kayit_tarihi = item.kayit_tarihi
              .split("-")
              .reverse()
              .join(".");
            item.ayrilis_tarihi = item.ayrilis_tarihi
              .split("-")
              .reverse()
              .join(".");
          });
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllBackups() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getAllBackups",
          },
        })
        .then((response) => {
          this.backupData = response.data;
          this.backupData.forEach((item) => {
            item.kayit_tarihi = item.kayit_tarihi
              .split("-")
              .reverse()
              .join(".");
            item.ayrilis_tarihi = item.ayrilis_tarihi
              .split("-")
              .reverse()
              .join(".");
          });
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getFilteredBackups(t1, t2) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getFilteredBackups",
            param: t1,
            param2: t2,
          },
        })
        .then((response) => {
          this.backupData = response.data;
          this.backupData.forEach((item) => {
            item.kayit_tarihi = item.kayit_tarihi
              .split("-")
              .reverse()
              .join(".");
            item.ayrilis_tarihi = item.ayrilis_tarihi
              .split("-")
              .reverse()
              .join(".");
          });
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  computed: {},
  mounted() {},
  watch: {},
  created() {
    this.getTeams();
    this.getAllBackups();
    this.date = this.$getDate();
    this.rangedate = [this.$getDate(), this.$getDate()];
  },
};
</script>