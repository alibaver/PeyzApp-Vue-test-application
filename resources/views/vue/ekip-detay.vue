<template>
  <div>
    <div
      v-if="pageLoading"
      class="d-flex justify-center align-center w100 flex-column"
      style="height: calc(100vh - 140px)"
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
      <div class="overline w100 px-0 mb-3 d-flex justify-space-between">
        <v-chip label color="primary" dark>
          <v-icon small left>mdi-account-group</v-icon>{{ ekipAdi }}
        </v-chip>
        <v-spacer></v-spacer>
        <v-chip label color="primary" dark>
          <v-icon small left>mdi-tree</v-icon>{{ agacSayi }}
        </v-chip>
      </div>

      <v-row>
        <!-- budama bilgileri -->
        <!-- <v-col cols="12">
        <v-card class="pa-3 colBorder">
          <v-row>
            <v-col
              cols="4"
              style="
                justify-content: center;
                align-items: center;
                display: flex;
              "
            >
              <v-avatar size="90">
                <v-icon size="90">mdi-tree</v-icon>
              </v-avatar>
            </v-col>
            <v-col cols="8" class="pl-0">
              <v-card-title class="overline pt-0 pb-2 d-block text-center"
                >BUDAMA DETAYI</v-card-title
              >
              <v-card-text class="caption">
                <v-list class="pa-0">
                  <v-list-item
                    class="px-0"
                    style="min-height: 30px"
                    v-for="(budama, index) in pruningData"
                    :key="index"
                  >
                    {{ budama.agac_adi }} :
                    <span style="position: absolute; right: 0"
                      >{{ budama.adet }} Adet</span
                    >
                  </v-list-item>
                  <v-divider></v-divider>
                  <v-list-item class="px-0" style="min-height: 30px">
                    Toplam :
                    <span style="position: absolute; right: 0"
                      >{{ pruningTotal }} Adet</span
                    >
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-col>
          </v-row>
          <v-divider></v-divider>
          <span class="overline pa-0 d-block text-center">HAFTALIK VERİ</span>
          <span class="caption d-block text-center">{{
            date.split("-").reverse().join(".")
          }}</span>
          <div class="my-4 d-flex justify-space-between">
            <v-chip class="px-1" label x-small color="primary"
              >Pts : 137</v-chip
            >
            <v-chip class="px-1" label x-small color="primary"
              >Salı : 317</v-chip
            >
            <v-chip class="px-1" label x-small color="primary"
              >Çar : 317</v-chip
            >
            <v-chip class="px-1" label x-small color="primary"
              >Prş : 137</v-chip
            >
            <v-chip class="px-1" label x-small color="primary"
              >Cuma : 137</v-chip
            >
          </div>
          <center>
            <v-chip outlined small label color="primary" class="text-caption"
              >Toplam: 340 Ağaç</v-chip
            >
          </center>
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
      </v-col> -->

        <!-- Çalışan bilgileri -->
        <v-col
          cols="12"
          sm
          md
          lg="3"
          class="py-3"
          v-for="(worker, index) in workerData"
          :key="index"
        >
          <v-card class="pa-3 colBorder">
            <!-- menu -->
            <v-menu offset-y>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  style="position: absolute; left: 10px; top: 10px"
                >
                  <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item ripple="">
                  <v-icon left>mdi-information-outline</v-icon>
                  Detaylı bilgi
                </v-list-item>
                <v-list-item ripple="" @click="workerDataBackup(worker.id)">
                  <v-icon left color="error">mdi-account-remove</v-icon>
                  Ekipten çıkar
                </v-list-item>
              </v-list>
            </v-menu>
            <v-row>
              <!-- icon -->
              <v-col
                cols="4"
                style="
                  justify-content: center;
                  align-items: center;
                  display: flex;
                "
              >
                <v-avatar size="64">
                  <v-icon size="64">mdi-account-hard-hat</v-icon>
                </v-avatar>
              </v-col>
              <v-col cols="8" class="py-0 pl-0">
                <!-- AD SOYAD -->
                <span class="subtitle-1 d-block"
                  >{{ worker.ad }} {{ worker.soyad }}</span
                >
                <!-- YEVMİYE MİKTARI -->
                <span class="body-2 d-block my-1">
                  <v-icon x-small color="black">mdi-cash</v-icon>
                  : ₺{{ worker.yevmiye }} /
                  <span class="caption">Günlük</span>
                </span>
                <!-- BAŞLANGIÇ TARİHİ -->
                <span class="body-2 d-block my-1">
                  <v-icon x-small color="black">mdi-calendar</v-icon>
                  :
                  {{ worker.kayit_tarihi.split("-").reverse().join(".") }}
                  <span class="caption">
                    ({{ workDay(worker.tam_gun, worker.yarim_gun) }}
                    Gün)
                  </span>
                </span>

                <!-- HAK EDİŞ TUTARI -->
                <v-chip
                  class="body-1 d-block mt-2 text-center px-2"
                  color="primary"
                  outlined
                  label
                >
                  Hakediş Tutarı : ₺{{
                    hakedisTutari(
                      worker.tam_gun,
                      worker.yarim_gun,
                      worker.yevmiye
                    )
                  }}
                </v-chip>

                <!-- yarım / tam -->
                <v-select
                  :disabled="worker.guncelleme_tarihi >= getDate()"
                  @change="changed = !changed"
                  class="my-1"
                  :value="gunler[0]"
                  hide-details
                  :items="gunler"
                  ref="dayInfo"
                  :id="worker.id"
                ></v-select>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <!-- kaydet btn -->
        <div class="d-flex align-center justify-center w100 my-5 mx-3">
          <v-btn
            :disabled="!canSave"
            class="w100"
            depressed
            text
            color="primary"
            @click="dialog = !dialog"
          >
            kaydet
            <v-icon small right>mdi-check-all</v-icon>
          </v-btn>
        </div>
      </v-row>

      <!-- dialog -->
      <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card>
            <v-card-title class="text-h6">Değişiklikleri kaydet?</v-card-title>
            <v-card-text class="text-body-2">
              Yaptığınız düzenlemeler kaydedilecek ve geri alınamayacaktır.
              Onaylıyor musunuz?
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="grey darken-2" text @click="dialog = false"
                >hayır</v-btn
              >
              <v-btn color="primary" depressed @click="save">evet</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>

      <alert-component
        @closeAlert="close($event)"
        :alert-msg="alert.message"
        :alert-style="alert.style"
        :alert-open="alert.isOpen"
        :alert-time="alert.time"
      ></alert-component>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    changed: false,
    pageLoading: true,
    ekipAdi: "",
    agacSayi: "",
    dialog: false,
    snackbar: false,
    teamID: null,
    pruningTotal: 0,
    teamData: [],
    backupsWorker: [],
    workerData: [],
    updatedWorkers: [],
    pruningData: [],
    date: "",
    canSave: false,
    nWorker: "",
    gunler: ["Tam Gün", "Yarım Gün", "Gelmedi"],
    alert: {
      isOpen: false,
      message: "",
      style: "",
      time: 2000,
    },
    value: [50, 200, 60, 0, 0, 0],
    days: ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"],
  }),
  methods: {
    close(e) {
      this.alert.isOpen = false;
    },
    save() {
      let calendar = [],
        wDetail = [],
        _total = 0;

      this.$refs.dayInfo.forEach((item) => {
        let person = this.workerData.find(({ id }) => id === item.id);
        let arr = [];
        if (!item.disabled) {
          let gun = 0,
            tgun = 0;
          if (item.lazyValue === "Yarım Gün") {
            gun = parseInt(person.yarim_gun) + 1;
            tgun = parseInt(person.tam_gun);
          } else if (item.lazyValue === "Gelmedi") {
            gun = parseInt(person.yarim_gun);
            tgun = parseInt(person.tam_gun);
          } else {
            gun = parseInt(person.yarim_gun);
            tgun = parseInt(person.tam_gun) + 1;
          }
          _total =
            _total + parsePrice(this.hakedisTutari(tgun, gun, person.yevmiye));

          arr.push({
            yGun: gun,
            tGun: tgun,
            uDate: this.getDate(),
            _id: parseInt(item.id),
          });
        } else {
          _total =
            _total +
            parsePrice(
              this.hakedisTutari(
                person.tam_gun,
                person.yarim_gun,
                person.yevmiye
              )
            );

          arr.push({
            yGun: person.yarim_gun,
            tGun: person.tam_gun,
            uDate: this.getDate(),
            _id: parseInt(item.id),
          });
        }

        wDetail.push({
          worker_id: parseInt(person.id),
          ad: person.ad,
          soyad: person.soyad,
          status: item.lazyValue,
        });
        this._uWorkers(arr);

        this.dialog = false;
      });

      this.backupsWorker.length > 0
        ? this.backupsWorker.forEach((worker) => {
            _total =
              _total +
              parsePrice(
                this.hakedisTutari(
                  worker.tam_gun,
                  worker.yarim_gun,
                  worker.yevmiye
                )
              );
          })
        : "";
      _total != 0
        ? this._utotalPrice({
            id: this.teamID,
            total: numeral(_total).format("0,0.00"),
          })
        : 0;
      if (!this.$refs.dayInfo[0].disabled) {
        calendar.push({
          ekip_id: this.teamID,
          ekip_adi: this.ekipAdi,
          date: this.getDate(),
          workers: JSON.stringify(wDetail),
        });
        this._sCalendar(calendar);
        this.goHome();
      }
    },
    getTeamDetails() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "teamDetails",
            param: this.teamID,
          },
        })
        .then((response) => {
          this.teamData = response.data;
          this.ekipAdi = this.teamData[0].ekip_adi;
          this.agacSayi = this.teamData[0].toplam_kesilen_agac;
        })
        .catch((err) => {
          console.log(err);
        });

      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "pruningDetails",
            param: this.teamID,
          },
        })
        .then((response) => {
          this.pruningData = response.data;
          this.pruningData.forEach((item) => {
            this.pruningTotal += parseInt(item.adet);
          });

          const seen = new Set();

          const filteredArr = this.pruningData.filter((el) => {
            const duplicate = seen.has(el.agac_ID);
            seen.add(el.agac_ID);
            return !duplicate;
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getWorkerDetails() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "workerDetails",
            param: this.teamID,
          },
        })
        .then((response) => {
          this.workerData = response.data;
          this.nWorker = this.workerData.find(
            ({ guncelleme_tarihi }) => guncelleme_tarihi < this.getDate()
          );
          this.nWorker !== undefined
            ? (this.canSave = true)
            : (this.canSave = false);
          this.pageLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getDate() {
      let date;
      date = new Date().toLocaleString("tr").split(" ")[0].split(".");
      date = date.reverse().join("-");
      // this.date[0] = "01";
      // this.lastDate = this.date;
      // this.date = this.date.reverse().join(""); //.join("-");
      // if (parseInt(this.lastDate[1]) < 12) {
      //   if (parseInt(this.lastDate[1]) < 9) {
      //     this.lastDate[1] = "0" + (parseInt(this.lastDate[1]) + 1).toString();
      //   } else {
      //     this.lastDate[1] = (parseInt(this.lastDate[1]) + 1).toString();
      //   }
      // } else {
      //   this.lastDate[1] = "01";
      //   this.lastDate[0] = (parseInt(this.lastDate[0]) + 1).toString();
      // }
      // this.lastDate = this.lastDate.join(""); //.join("-");
      return date;
    },
    getBackupWorkers() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getBackups",
            param: this.teamID,
          },
        })
        .then((res) => {
          this.backupsWorker = res.data;
        });
    },
    workerDataBackup(_id) {
      let person = this.workerData.find(({ id }) => id === _id);
      let price =
        parsePrice(person.yevmiye) * (person.tam_gun - person.yarim_gun * 0.5);
      person.hakedis = numeral(price < 0 ? price * -1 : price).format("0,0.00");
      person.ayrilis_tarihi = this.$getDate();
      person.ekip_adi = this.ekipAdi;
      this.$axios
        .post("postdata.php", JSON.stringify(person), {
          params: {
            param: "workerDataBackup",
          },
        })
        .then((res) => {
          this.removeWorker({ id: person.id });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    removeWorker(_obj) {
      this.$axios
        .post("postdata.php", JSON.stringify(_obj), {
          params: {
            param: "removeWorker",
          },
        })
        .then((res) => {
          this.uwCount({ id: this.teamID, num: -1 });
          this.alert.message = "Çalışan çıkarıldı.";
          this.alert.style = "success";
          this.alert.isOpen = true;
          this.alert.time = 1500;
          this.alert.time > -1
            ? setTimeout(() => {
                this.alert.isOpen = false;
                window.location.reload();
              }, this.alert.time)
            : "";
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
    _utotalPrice(_obj) {
      this.$axios
        .post("postdata.php", JSON.stringify(_obj), {
          params: {
            param: "updatedTotalPrice",
          },
        })
        .then((res) => {})
        .catch((err) => {
          console.log(err);
        });
    },
    _uWorkers(array) {
      this.$axios
        .post("postdata.php", JSON.stringify(array), {
          params: {
            param: "updatedWorkers",
          },
        })
        .then((res) => {})
        .catch((err) => {
          console.log(err);
        });
    },
    _sCalendar(cal) {
      this.$axios
        .post("postdata.php", JSON.stringify(cal), {
          params: {
            param: "setCalendar",
          },
        })
        .then((res) => {})
        .catch((err) => {
          console.log(err);
        });
    },
    goHome() {
      this.alert.isOpen = true;
      this.alert.message = "Kayıt başarılı. Anasayfaya yönlendiriliyorsunuz..";
      this.alert.style = "success";
      this.alert.time > -1
        ? setTimeout(() => {
            this.alert.isOpen = false;
            this.$router.push("/");
          }, this.alert.time)
        : "";
    },
    workDay(t, y) {
      let res = parseFloat(t) - parseFloat(y) * 0.5;
      res < 0 ? (res = res * -1) : (res = res);
      return res;
    },
    hakedisTutari(t, y, p) {
      let price = this.workDay(t, y) * parsePrice(p);
      return numeral(price).format("0,0.00");
    },
  },
  mounted() {},
  watch: {},
  created() {
    this.teamID = this.$route.query.teamId;
    this.getTeamDetails();
    this.date = this.getDate();
    this.getBackupWorkers();
    this.getWorkerDetails();
  },
};
</script>
