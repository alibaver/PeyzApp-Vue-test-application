<template>
  <div>
    <v-row>
      <v-col>
        <!-- kart -->
        <v-card v-if="!teamID" class="pa-3 colBorder elevation-1">
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
                <v-btn text color="primary" @click="tarih = false">Kapat</v-btn>
                <v-btn text color="primary" @click="$refs.range.save(rangedate)"
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
              @click="teamID ? getPayment(teamID) : getAllPayment()"
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
        :items="paymentData"
        class="elevation-0"
        disable-sort
        :items-per-page="5"
        :loading="loading"
        loading-text="Veriler yükleniyor..."
      >
        <template v-slot:[`item.calisanlar`]="{ item }">
          <div style="display: table-caption; height: 50px; overflow: auto">
            <v-chip
              class="my-1 text-center"
              x-small
              v-for="(worker, index) in item.calisanlar"
              :key="index"
            >
              {{ worker.ad }} {{ worker.soyad }}
            </v-chip>
          </div>
        </template>
        <template v-slot:[`item.ayrilan_calisanlar`]="{ item }">
          <div style="display: table-caption; height: 50px; overflow: auto">
            <v-chip
              class="my-1 text-center"
              x-small
              v-for="(worker, index) in item.ayrilan_calisanlar"
              :key="index"
            >
              {{ worker.ad }} {{ worker.soyad }}
            </v-chip>
          </div>
        </template>
      </v-data-table>
    </v-row>
  </div>
</template>
<script>
export default {
  data: () => ({
    teamID: "",
    teamName: "",
    items: [],
    date: "",
    rangedate: "",
    tarih: false,
    modal: false,
    alert: {
      isOpen: false,
      message: "",
      style: "",
      time: 1000,
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
      { text: "Çalışan Sayısı", value: "calisan_sayisi" },
      { text: "Çalışanlar", value: "calisanlar" },
      { text: "Toplam Yevmiye (₺)", value: "toplam_yevmiye" },
      { text: "Gider (₺)", value: "toplam_gider" },
      { text: "Budanan Ağaç Sayısı", value: "toplam_kesilen_agac" },
      { text: "Gelir (₺)", value: "agac_gelir" },
      { text: "Ayrılan Çalışanlar", value: "ayrilan_calisanlar" },
    ],
    paymentData: [],
  }),
  methods: {
    changeTeam(val) {
      this.getPayment(val);
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

      this.getFilteredPayment(tarih1, tarih2);
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
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getPayment(_id) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getPayment",
            param: _id,
          },
        })
        .then((response) => {
          this.paymentData = response.data;
          this.paymentData.forEach((item) => {
            item.tarih = item.tarih.split("-").reverse().join(".");
            item.calisanlar = JSON.parse(item.calisanlar);
            item.ayrilan_calisanlar = JSON.parse(item.ayrilan_calisanlar);
          });
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllPayment() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getAllPayment",
          },
        })
        .then((response) => {
          this.paymentData = response.data;
          this.paymentData.forEach((item) => {
            item.tarih = item.tarih.split("-").reverse().join(".");
            item.calisanlar = JSON.parse(item.calisanlar);
            item.ayrilan_calisanlar = JSON.parse(item.ayrilan_calisanlar);
          });
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getFilteredPayment(t1, t2) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getFilteredPayment",
            param: t1,
            param2: t2,
          },
        })
        .then((response) => {
          this.paymentData = response.data;
          this.paymentData.forEach((item) => {
            item.tarih = item.tarih.split("-").reverse().join(".");
            item.calisanlar = JSON.parse(item.calisanlar);
            item.ayrilan_calisanlar = JSON.parse(item.ayrilan_calisanlar);
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
    this.date = this.$getDate();
    this.rangedate = [this.$getDate(), this.$getDate()];
    this.teamID = this.$route.query.teamId;
    this.teamName = this.$route.query.teamName;
    if (this.teamID == undefined && this.teamName == undefined) {
      this.getAllPayment();
    } else {
      this.getPayment(this.teamID);
    }
  },
};
</script>