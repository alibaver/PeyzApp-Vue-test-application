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
      <center>
        <v-chip color="primary" label dark class="body-2 mb-2">
          <v-icon dark small left>mdi-account-hard-hat</v-icon>
          {{ tName ? tName : "Ekip Adı" }}
        </v-chip>
        <br />
        <v-chip
          color="primary"
          class="mr-1"
          small
          v-for="(person, index) in workers"
          :key="index"
        >
          <v-icon dark small left>mdi-account-circle</v-icon>
          {{ person.ad }} {{ person.soyad }}
        </v-chip>
      </center>

      <v-card class="pa-6 mb-4 mt-2 pb-12 mx-auto" max-width="500">
        <v-dialog
          ref="dialog"
          v-model="modal"
          :return-value.sync="date"
          persistent
          width="100%"
          max-width="400"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="formattedDate"
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
          <v-date-picker v-model="date" scrollable locale="tr" width="auto">
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="modal = false">Kapat</v-btn>
            <v-btn text color="primary" @click="$refs.dialog.save(date)"
              >Tamam</v-btn
            >
          </v-date-picker>
        </v-dialog>
        <v-text-field
          label="Ekip Adı"
          prepend-inner-icon="mdi-pencil"
          hide-details="auto"
          clearable
          outlined
          v-model="tName"
          :rules="rules"
          class="mt-5"
        ></v-text-field>
        <v-text-field
          ref="ad"
          label="Çalışan Adı"
          prepend-inner-icon="mdi-account"
          clearable
          outlined
          hide-details="auto"
          class="mt-5"
        ></v-text-field>
        <v-text-field
          ref="soyad"
          label="Çalışan Soyadı"
          prepend-inner-icon="mdi-account"
          clearable
          outlined
          hide-details="auto"
          class="mt-5"
        ></v-text-field>
        <v-text-field
          label="Yevmiye Miktarı"
          prepend-inner-icon="mdi-currency-try"
          clearable
          outlined
          hide-details="auto"
          type="number"
          ref="yevmiye"
          class="mt-5"
        ></v-text-field>

        <v-btn
          color="primary"
          class="mt-4"
          dark
          fab
          @click="addPerson"
          style="position: absolute; right: 0; transform: translate(-50%, 5px)"
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-card>
      <v-btn
        class="mt-10"
        color="primary"
        width="100%"
        depressed
        text
        large
        @click="save"
      >
        EKİBİ KAYDET
        <v-icon small>mdi-check-all</v-icon>
      </v-btn>

      <alert-component
        @closeAlert="close($event)"
        :alert-msg="alert.message"
        :alert-style="alert.style"
        :alert-open="alert.isOpen"
      ></alert-component>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    date: "",
    pageLoading: true,
    modal: false,
    uniq: "",
    alert: {
      isOpen: false,
      message: "",
      style: "",
      time: -1,
    },
    tName: "",
    team: {
      name: "",
      _id: null,
      wCount: 0,
      tYevmiye: numeral(0).format("0,0.00"),
      agacSayi: 0,
    },
    workers: [],
    rules: [(value) => !!value || "Gerekli."],
  }),
  methods: {
    goHome() {
      this.$router.push("/");
    },
    close(e) {
      this.alert.isOpen = false;
    },
    isEmpty() {
      let adValue = this.$refs.ad.lazyValue;
      let soyadValue = this.$refs.soyad.lazyValue;
      let yevmiyeValue = this.$refs.yevmiye.lazyValue;
      if (
        adValue != undefined &&
        adValue != "" &&
        soyadValue != undefined &&
        soyadValue != "" &&
        yevmiyeValue != undefined &&
        yevmiyeValue != ""
      ) {
        return false;
      } else {
        return true;
      }
    },
    addPerson() {
      if (!this.isEmpty()) {
        this.workers.push({
          _teamID: this.uniq,
          ad: this.$refs.ad.lazyValue.turkishToUpper(),
          soyad: this.$refs.soyad.lazyValue.turkishToUpper(),
          yevmiye: numeral(parseFloat(this.$refs.yevmiye.lazyValue)).format(
            "0,0.00"
          ),
          tam_gun: 0,
          yarim_gun: 0,
          ktarihi: this.date,
        });
        this.$refs.ad.lazyValue = "";
        this.$refs.soyad.lazyValue = "";
        this.$refs.yevmiye.lazyValue = "";
      } else {
        this.alert.isOpen = true;
        this.alert.message = "Eksik veya hatalı bilgi girişi.";
        this.alert.style = "error";
      }
    },
    save() {
      if (
        this.team.name != null &&
        this.workers.length &&
        this.tName != "" &&
        this.tName != undefined
      ) {
        this.team.wCount = this.workers.length;

        let promise = Promise.all([
          this.postTeamDetail(),
          this.postWorkerDetail(),
        ]).then(function (results) {
          const postteam = results[0];
          const postworker = results[1];
          if (postteam.status == 200 && postworker.status == 200) {
            return true;
          } else return false;
        });
        promise ? this.goHome() : (this.alert.isOpen = true),
          (this.alert.message = "Ekip oluşturulamadı."),
          (this.alert.style = "error");
      } else {
        this.alert.isOpen = true;
        this.alert.message = "Eksik veya hatalı bilgi girişi.";
        this.alert.style = "error";
      }
    },
    postTeamDetail() {
      return this.$axios
        .post("postdata.php", JSON.stringify(this.team), {
          params: {
            param: "saveTeam",
            uid: this.$uid,
          },
        })
        .catch((err) => {
          console.log(err);
        });
    },
    postWorkerDetail() {
      return this.$axios
        .post("postdata.php", JSON.stringify(this.workers), {
          params: {
            param: "saveWorker",
            uid: this.$uid,
          },
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  computed: {
    formattedDate() {
      return this.date.split("-").reverse().join(".");
    },
  },
  mounted() {
    this.pageLoading = false;
  },
  watch: {
    tName() {
      this.uniq = this.$createId("_");
      this.team.name = this.tName.turkishToUpper();
      this.team._id = this.uniq;
    },
  },
  created() {
    this.date = this.$getDate();
  },
};
</script>
<style></style>
