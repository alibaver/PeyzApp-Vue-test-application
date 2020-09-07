<template>
  <div>
    <center>
      <v-chip color="primary" label small dark class="body-2 mb-1">
        <v-icon dark small left>mdi-account-hard-hat</v-icon>
        {{ tName ? tName : "Ekip Adı" }}
      </v-chip>
    </center>
    <v-chip color="primary" class="mr-1" x-small v-for="(person, index) in workers" :key="index">
      <v-icon dark x-small left>mdi-account-circle</v-icon>
      {{ person.ad }} {{ person.soyad }}
    </v-chip>

    <v-card class="pa-4 pr-6 mb-4 mt-2 pb-12">
      <v-text-field
        label="Ekip Adı"
        prepend-icon="mdi-pencil"
        clearable
        v-model="tName"
        :rules="rules"
      ></v-text-field>

      <v-text-field
        ref="ad"
        label="Çalışan Adı"
        prepend-icon="mdi-account"
        clearable
        hide-details="auto"
      ></v-text-field>
      <v-text-field
        ref="soyad"
        label="Çalışan Soyadı"
        prepend-icon="mdi-account"
        clearable
        hide-details="auto"
      ></v-text-field>
      <v-text-field
        label="Yevmiye Miktarı"
        prepend-icon="mdi-currency-try"
        clearable
        hide-details="auto"
        type="number"
        ref="yevmiye"
      ></v-text-field>

      <v-btn
        color="primary"
        class="mt-4"
        dark
        small
        fab
        @click="addPerson"
        style="position: absolute; right: 0; transform:translate(-50%, 12px)"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-card>
    <v-btn class="mt-10" color="primary" width="100%" depressed text large @click="save">
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
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    ID: undefined,
    uniq: "",
    alert: {
      isOpen: false,
      message: "",
      style: "",
    },
    tName: "",
    team: { name: "", _id: null, wCount: 0 },
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
          ad: this.$refs.ad.lazyValue,
          soyad: this.$refs.soyad.lazyValue,
          yevmiye: parseFloat(this.$refs.yevmiye.lazyValue),
          gun: 0,
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
      return axios
        .post("postdata.php", JSON.stringify(this.team), {
          params: {
            param: "saveTeam",
          },
        })
        .catch((err) => {
          console.log(err);
        });
    },
    postWorkerDetail() {
      return axios
        .post("postdata.php", JSON.stringify(this.workers), {
          params: {
            param: "saveWorker",
          },
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.ID = function () {
      return "_" + Math.random().toString(36).substr(2, 9);
    };
  },
  watch: {
    tName() {
      this.uniq = this.ID();
      this.team.name = this.tName;
      this.team._id = this.uniq;
    },
  },
  created() {},
};
</script>
<style>
.coloredOutline {
  border: thin solid #7b1fa2 !important;
}
</style>
