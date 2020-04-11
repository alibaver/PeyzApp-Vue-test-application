<template>
  <v-footer color="footerLight" padless>
    <v-row justify="center" no-gutters>
      <v-col cols="12" class="d-flex justify-content-center my-5">
        <img
          :src="'../../images/logo/iste_tr_white.png'"
          alt="İskenderun Teknik Üniversitesi"
          class="isteLogo p-0"
        />
      </v-col>
      <v-col cols="12" class="px-3 d-flex justify-content-center mt-5">
        <span class="body-2 white--text">Hızlı Erişim</span>
      </v-col>
      <v-btn
        v-for="link in links"
        :key="link"
        text
        rounded
        class="my-2 white--text"
        x-small
      >{{ link }}</v-btn>
      <!-- <v-col cols="12" class="d-flex justify-content-center mt-5 mb-3">
                <span class="body-2 white--text">İletişim</span>
      </v-col>-->

      <v-col cols="12" class="d-flex justify-content-center mt-7">
        <v-btn class="ma-2" x-small dark outlined fab disabled>
          <v-icon>mdi-map-marker</v-icon>
        </v-btn>
      </v-col>
      <v-col cols="12" class="px-3 d-flex justify-content-center">
        <span class="caption white--text text-center">
          İskenderun Teknik Üniversitesi (İSTE) Rektörlüğü Merkez
          Kampüs, 31200, İskenderun, Hatay, Türkiye
        </span>
      </v-col>

      <v-col cols="12" class="d-flex justify-content-center mt-4">
        <v-btn class="ma-2" x-small dark outlined fab disabled>
          <v-icon>mdi-email</v-icon>
        </v-btn>
      </v-col>
      <v-col cols="12" class="px-3 d-flex justify-content-center">
        <span class="caption white--text text-center">kddb@iste.edu.tr</span>
      </v-col>

      <v-col cols="12" class="d-flex justify-content-center mt-4">
        <v-btn class="ma-2" x-small dark outlined fab disabled>
          <v-icon>mdi-phone</v-icon>
        </v-btn>
      </v-col>
      <v-col cols="12" class="px-3 d-flex justify-content-center">
        <span class="caption white--text text-center">0 (326) 613 56 00</span>
      </v-col>

      <v-col cols="12" class="d-flex justify-content-center mt-10 mb-4">
        <v-btn class="ma-2" small fab depressed>
          <v-icon color="footerLight">mdi-facebook</v-icon>
        </v-btn>
        <v-btn class="ma-2" small fab depressed>
          <v-icon color="footerLight">mdi-twitter</v-icon>
        </v-btn>
        <v-btn class="ma-2" small fab depressed>
          <v-icon color="footerLight">mdi-google-plus</v-icon>
        </v-btn>
        <v-btn class="ma-2" small fab depressed>
          <v-icon color="footerLight">mdi-youtube</v-icon>
        </v-btn>
        <v-btn class="ma-2" small fab depressed>
          <v-icon color="footerLight">mdi-linkedin</v-icon>
        </v-btn>
      </v-col>

      <v-col class="footerDark white--text py-2 text-center overline" cols="12">
        İSKENDERUN TEKNİK ÜNİVERSİTESİ - BİLGİ İŞLEM DAİRE BAŞKANLIĞI ©
        2017
      </v-col>
    </v-row>
  </v-footer>
</template>
<script>
export default {
  data: () => ({
    links: [
      "ÜNİVERSİTE ANASAYFA",
      "ÖĞRENCİ BİLGİ SİSTEMİ",
      "AKADEMİK BİLGİ SİSTEMİ",
      "AKADEMİK TAKVİM",
      "E-POSTA",
      "UYGULAMA MERKEZİ"
    ]
  })
};
</script>
