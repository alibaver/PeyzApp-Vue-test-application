<template>
  <div
    class="w100 gradientCard d-flex justify-center align-center flex-column"
    style="height: 100vh"
  >
    <span class="white--text body-1"
      ><v-icon left dark>mdi-palm-tree</v-icon>peyz<span
        class="white--text font-weight-bold body-1"
        >APP</span
      ></span
    >
    <v-card max-width="290" class="elevation-0 transparent">
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-text-field
              dark
              label="Kullanıcı Adı"
              prepend-inner-icon="mdi-account"
              hide-details=""
              ref="kadi"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              dark
              label="Şifre"
              prepend-inner-icon="mdi-lock"
              hide-details=""
              :type="eye ? 'text' : 'password'"
              :append-icon="eye ? 'mdi-eye' : 'mdi-eye-off'"
              @click:append="eye = !eye"
              ref="sifre"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-checkbox
              dense
              dark
              label="Beni hatırla"
              v-model="checkbox"
            ></v-checkbox>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions class="d-flex justify-center align-center">
        <v-btn text dark @click="login">
          <v-icon left small>mdi-login</v-icon>GİRİŞ YAP</v-btn
        >
      </v-card-actions>
    </v-card>

    <div
      v-if="pageLoading"
      class="d-flex justify-center align-center pLoad"
      style="
        position: fixed;
        z-index: 99;
        background-color: rgba(0, 0, 0, 0);
        width: 100%;
        top: 0;
        left: 0;
        height: 100vh !important;
      "
    >
      <v-card class="pa-5 d-flex justify-center align-center flex-column">
        <v-progress-circular
          :width="3"
          :size="60"
          color="primary"
          indeterminate
        ></v-progress-circular>
        <span class="mt-4 overline primary--text">loading..</span>
      </v-card>
    </div>
    <alert-component
      :alert-msg="alert.message"
      :alert-style="alert.style"
      :alert-open="alert.isOpen"
      :alert-time="alert.time"
    ></alert-component>
  </div>
</template>
<script>
export default {
  data() {
    return {
      eye: false,
      pageLoading: false,
      checkbox: true,
      alert: {
        isOpen: false,
        style: "",
        message: "",
        time: 2000,
      },
    };
  },
  watch: {},
  methods: {
    login() {
      this.pageLoading = true;
      let kadi, sifre;
      kadi = this.$refs.kadi.lazyValue;
      sifre = this.$refs.sifre.lazyValue;

      this.isUser(kadi, sifre);
    },
    isUser(p1, p2) {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getUsers",
            param: p1,
            param2: p2,
          },
        })
        .then((res) => {
          this.pageLoading = false;
          const user = res.data[0];
          if (res.data.length > 0) {
            window.localStorage.setItem("requiresAuth", true);
            window.localStorage.setItem("_uid", user.kullanici_id);
            window.localStorage.setItem("ad", user.ad);
            window.localStorage.setItem("soyad", user.soyad);

            this.alert.message = "Giriş başarılı";
            this.alert.style = "success";
            this.alert.isOpen = true;
            window.location.reload();
          } else {
            this.alert.message = "Kullanıcı adı veya şifre hatalı.";
            this.alert.style = "error";
            this.alert.isOpen = true;
          }
          this.alert.time > -1
            ? setTimeout(() => {
                this.alert.isOpen = false;
              }, this.alert.time)
            : "";
        });
    },
  },
  mounted() {
    console.log("login");
  },
};
</script>