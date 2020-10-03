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
      <page-path></page-path>
      <alert-component
        @closeAlert="close($event)"
        :alert-msg="alert.message"
        :alert-style="alert.style"
        :alert-open="alert.isOpen"
        :alert-time="alert.time"
      ></alert-component>
      <v-card class="colBorder pa-4 pb-1">
        <v-row>
          <v-col cols="12">
            <!-- icon -->
            <div
              style="
                justify-content: center;
                align-items: center;
                display: flex;
              "
              class="mb-4 pa-0"
            >
              <v-avatar size="64" tile>
                <v-icon size="64">mdi-account-plus</v-icon>
              </v-avatar>
            </div>
            <center v-if="checkTeamId">
              <v-chip color="white" label class="mb-2 overline"
                ><v-icon small left color="primary">mdi-account-group</v-icon
                >{{ teamName }}
              </v-chip>
            </center>
            <v-select
              v-if="!checkTeamId"
              class=""
              prepend-inner-icon="mdi-account-hard-hat"
              outlined
              hide-details
              ref="ekipAdi"
              label="Ekip Seçin"
              :items="items"
            >
            </v-select>
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
                  class="mt-3"
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
              ref="ad"
              label="Çalışan Adı"
              prepend-inner-icon="mdi-account"
              clearable
              outlined
              hide-details="auto"
              class="mt-3"
            ></v-text-field>
            <v-text-field
              ref="soyad"
              label="Çalışan Soyadı"
              prepend-inner-icon="mdi-account"
              clearable
              outlined
              hide-details="auto"
              class="mt-3"
            ></v-text-field>
            <v-text-field
              label="Yevmiye Miktarı"
              prepend-inner-icon="mdi-currency-try"
              clearable
              outlined
              type="number"
              hide-details="auto"
              ref="yevmiye"
              class="mt-3"
            ></v-text-field>
            <v-btn
              class="mt-5"
              color="primary"
              width="100%"
              depressed
              text
              large
              @click="save"
            >
              KAYDET
            </v-btn>
          </v-col>
        </v-row>
      </v-card>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    items: [],
    teamID: "",
    teamName: "",
    date: "",
    pageLoading: true,
    modal: false,
    checkTeamId: false,
    alert: {
      isOpen: false,
      message: "",
      style: "",
      time: 2000,
    },
  }),
  methods: {
    save() {
      let _ekipId, _ad, _soyad, _yevmiye;

      this.checkTeamId
        ? (_ekipId = this.teamID)
        : (_ekipId = this.$refs.ekipAdi.lazyValue);
      _ad = this.$refs.ad.lazyValue;
      _soyad = this.$refs.soyad.lazyValue;
      _yevmiye = this.$refs.yevmiye.lazyValue;

      if (
        _ekipId != undefined &&
        _ad != undefined &&
        _soyad != undefined &&
        _yevmiye != undefined
      ) {
        let obj = [
          {
            _teamID: _ekipId,
            ktarihi: this.date,
            ad: _ad.turkishToUpper(),
            soyad: _soyad.turkishToUpper(),
            yevmiye: numeral(_yevmiye).format("0,0.00"),
            tam_gun: 0,
            yarim_gun: 0,
          },
        ];
        this.postNewWorker(obj);
        this.$refs.ad.lazyValue = "";
        this.$refs.soyad.lazyValue = "";
        this.$refs.yevmiye.lazyValue = "";
      } else {
        this.alert.message = "Hata..";
        this.alert.style = "error";
      }
      this.alert.isOpen = true;
      this.alert.time > -1
        ? setTimeout(() => {
            this.alert.isOpen = false;
          }, this.alert.time)
        : "";
    },
    postNewWorker(_obj) {
      this.$axios
        .post("postdata.php", JSON.stringify(_obj), {
          params: {
            param: "saveWorker",
          },
        })
        .then((res) => {
          this.alert.message = "Kayıt başarılı..";
          this.alert.style = "success";
          this.uwCount({ id: _obj[0]._teamID, num: 1 });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    uwCount(_obj) {
      this.$axios
        .post("postdata.php", JSON.stringify(_obj), {
          params: {
            param: "uwCount",
          },
        })
        .then((res) => {})
        .catch((err) => {
          console.log(err);
        });
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
              text: item.ekip,
              value: item.ekip_ID,
            });
          });
          this.pageLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  watch: {},
  mounted() {},
  created() {
    this.teamID = this.$route.query.teamId;
    this.teamName = this.$route.query.teamName;
    this.teamID === undefined ? this.getTeams() : (this.checkTeamId = true);
    this.date = this.$getDate();
  },
};
</script>
