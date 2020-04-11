<template>
    <div>
        <v-col v-if="clientWidth > 699" class="pt-0">
            <v-chip small outlined class="overline" color="error">
                <v-icon left x-small>mdi-circle</v-icon>KAPALI
            </v-chip>
            <v-chip small outlined class="overline">
                <v-icon left x-small>mdi-calendar</v-icon>HAFTA İÇİ: 08:00-24:00
            </v-chip>
            <v-chip small outlined class="overline">
                <v-icon left x-small>mdi-calendar</v-icon>HAFTA SONU:
                10:00-24:00
            </v-chip>
            <v-chip small outlined class="overline">
                <v-icon left x-small>mdi-calendar</v-icon>RESMİ TATİL: KAPALI
            </v-chip>
        </v-col>
        <v-row>
            <v-col
                cols="12"
                sm="6"
                md="7"
                class="pt-0 order-last order-sm-first"
            >
                <v-row>
                    <v-col
                        v-for="(item, index) in databases"
                        :key="index"
                        cols="12"
                        sm="12"
                        md="6"
                    >
                        <info-card :info-card="item"></info-card>
                    </v-col>
                </v-row>
            </v-col>
            <v-col
                cols="12"
                sm="6"
                md="5"
                class="pt-0 order-first order-sm-last"
            >
                <v-row>
                    <v-col>
                        <notify-card :notify-card="notification"></notify-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <!-- <v-card> -->
        <v-row id="compLogo" class="mt-10 py-5">
            <v-col
                cols="6"
                sm="3"
                class="d-flex justify-content-center align-items-center"
            >
                <img
                    class="imgchangeColor"
                    :src="'images/logo/ankos.png'"
                    alt
                    height="50"
                    width="auto"
                />
            </v-col>
            <v-col
                cols="6"
                sm="3"
                class="d-flex justify-content-center align-items-center"
            >
                <img
                    class="imgchangeColor"
                    :src="'images/logo/kits.png'"
                    alt
                    height="50"
                    width="auto"
                />
            </v-col>
            <v-col
                cols="6"
                sm="3"
                class="d-flex justify-content-center align-items-center"
            >
                <img
                    class="imgchangeColor"
                    :src="'images/logo/tokat.png'"
                    alt
                    height="50"
                    width="auto"
                />
            </v-col>
            <v-col
                cols="6"
                sm="3"
                class="d-flex justify-content-center align-items-center"
            >
                <img
                    class="imgchangeColor"
                    :src="'images/logo/ulakbim.png'"
                    alt
                    height="50"
                    width="auto"
                />
            </v-col>
            <v-col
                cols="12"
                class="mt-5 d-flex justify-content-center align-items-center"
            >
                <img
                    :src="'images/logo/google-play.png'"
                    alt
                    height="55"
                    width="auto"
                    class="mr-2"
                />
                <img
                    :src="'images/logo/apple-store.png'"
                    alt
                    height="55"
                    width="auto"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    props: {
        source: Array,
    },
    data: () => ({
        clientWidth: null,
        isDark: false,
        databases: [
            {
                icon: "mdi-database",
                category: "Veritabanı",
                date: "20.04.2020",
                title: "İdealonline",
                content:
                    "Değerli öğretim kullanıcılarımız, 30 Nisan 2020 tarihine kadar deneme erişimine açılan İdealOnline veri tabanı hakkında bilgi vermek isteriz. 'İdealonline' , Popüler ve Akademik Yayınları bir platform altında toplayan, kapsamlı bilgiye Türkçe kaynaklarda da ulaşılmasını sağlayan ve bunları okuyucuların hizmetine sunan veri tabanıdır. İdealonline içerisinde Türk Dünyasının önde gelen dergileri de yer almaktadır. Azerbaycan, Kırgızistan, Kazakistan, Başkortsan, Kırım, Karaçay-Malkar gibi Türki Cumhuriyetler tarafından yayınlanan bu dergiler, ilk kez “İdealonline Süreli Yayın Veri Tabanı” aracılığı ile Türkiye’deki Üniversite kütüphanelerinin erişimine açılmıştır.Üniversite kütüphaneleri tarafından aktif olarak kullanılan İdealonline, yayınların  ulaşması için etkili bir veritabanıdır. İçerisindeki gelişmiş arama motorları ile ilgili alana direk erişim sağlayan  EDS  ve Summon gibi uluslararası arama motorlarında da taranmaktadır. Sistem içerisindeki “Kütüphanem”, “Duyuru Kaydı” ve Bildirim Al” özellikleri ile yayın takibini en kolay hâle getirmekle birlikte, geniş filtreleme özelliğiyle de ilgili alana erişimi hızlandırmaktadır.",
            },
            {
                icon: "mdi-database",
                category: "Veritabanı",
                date: "31.03.2020",
                title: "World eBook Library",
                content:
                    "World eBook Library akademik araştırmalara yardımcı elektronik kitap ve elektronik belgelerin sunulduğu dünyanın en büyük elektronik kütüphanelerinden biridir. 4,000.000’den fazla akademik belgeye tam metin erişim sağlar. PDF formatında sınırsız kullanım ve indirme imkanı Her dilde ve her konu başlığında binlerce kitap Eşsiz bir birincil kaynak ve nadir eser koleksiyonu Dünyanın en büyük elektronik kütüphanesi İçerik (4.000.000 ‘den fazla doküman!) 1000 yılı kapsayan bir koleksiyon 200+ dilde kitap ve doküman içerir 16 milyon Ansiklopedi makalesi 4,186,162 başlık 3.000.000+ ekitap (pdf) 510.252 çeşitli dokümanlar (pdf) 145.503 dergi (pdf) 11.158 gazete (pdf) 5791 sesli kitap (mp4) 5318 eğitim videosu 15,126 ciltlenmemiş",
            },
            {
                icon: "mdi-database",
                category: "Veritabanı",
                date: "20.04.2020",
                title: "İdealonline",
                content:
                    "Değerli öğretim kullanıcılarımız, 30 Nisan 2020 tarihine kadar deneme erişimine açılan İdealOnline veri tabanı hakkında bilgi vermek isteriz. 'İdealonline' , Popüler ve Akademik Yayınları bir platform altında toplayan, kapsamlı bilgiye Türkçe kaynaklarda da ulaşılmasını sağlayan ve bunları okuyucuların hizmetine sunan veri tabanıdır. İdealonline içerisinde Türk Dünyasının önde gelen dergileri de yer almaktadır. Azerbaycan, Kırgızistan, Kazakistan, Başkortsan, Kırım, Karaçay-Malkar gibi Türki Cumhuriyetler tarafından yayınlanan bu dergiler, ilk kez “İdealonline Süreli Yayın Veri Tabanı” aracılığı ile Türkiye’deki Üniversite kütüphanelerinin erişimine açılmıştır.Üniversite kütüphaneleri tarafından aktif olarak kullanılan İdealonline, yayınların  ulaşması için etkili bir veritabanıdır. İçerisindeki gelişmiş arama motorları ile ilgili alana direk erişim sağlayan  EDS  ve Summon gibi uluslararası arama motorlarında da taranmaktadır. Sistem içerisindeki “Kütüphanem”, “Duyuru Kaydı” ve Bildirim Al” özellikleri ile yayın takibini en kolay hâle getirmekle birlikte, geniş filtreleme özelliğiyle de ilgili alana erişimi hızlandırmaktadır.",
            },
            {
                icon: "mdi-database",
                category: "Veritabanı",
                date: "31.03.2020",
                title: "World eBook Library",
                content:
                    "World eBook Library akademik araştırmalara yardımcı elektronik kitap ve elektronik belgelerin sunulduğu dünyanın en büyük elektronik kütüphanelerinden biridir. 4,000.000’den fazla akademik belgeye tam metin erişim sağlar. PDF formatında sınırsız kullanım ve indirme imkanı Her dilde ve her konu başlığında binlerce kitap Eşsiz bir birincil kaynak ve nadir eser koleksiyonu Dünyanın en büyük elektronik kütüphanesi İçerik (4.000.000 ‘den fazla doküman!) 1000 yılı kapsayan bir koleksiyon 200+ dilde kitap ve doküman içerir 16 milyon Ansiklopedi makalesi 4,186,162 başlık 3.000.000+ ekitap (pdf) 510.252 çeşitli dokümanlar (pdf) 145.503 dergi (pdf) 11.158 gazete (pdf) 5791 sesli kitap (mp4) 5318 eğitim videosu 15,126 ciltlenmemiş",
            },
        ],
        notification: [
            {
                date: "26.03.2020",
                title: "İdealonline Deneme Erişimi",
            },
            {
                date: "25.03.2020",
                title: "Webinar Etkinlik Takvimi",
            },
            {
                date: "25.03.2020",
                title:
                    "Koronavirüs ( COVID-19 ): Koronavirüs Hakkında Bilgi Kaynakları",
            },
            {
                date: "21.02.2020",
                title: "İSTE Merkez Kütüphanesi Elektronik Kaynak ve Araçları",
            },
            {
                date: "26.03.2020",
                title:
                    "Abonelik Sağlanan Veri Tabanları (ASTM Standards and Engineering Digital Library )",
            },
            {
                date: "26.03.2020",
                title: "İdealonline Deneme Erişimi",
            },
            {
                date: "25.03.2020",
                title: "Webinar Etkinlik Takvimi",
            },
            {
                date: "25.03.2020",
                title:
                    "Koronavirüs ( COVID-19 ): Koronavirüs Hakkında Bilgi Kaynakları",
            },
            {
                date: "21.02.2020",
                title: "İSTE Merkez Kütüphanesi Elektronik Kaynak ve Araçları",
            },
        ],
    }),
    methods: {
        getWindowWidth() {
            this.clientWidth = window.innerWidth;
        },
    },
    mounted() {},
    watch: {},
    created() {
        window.addEventListener("resize", this.getWindowWidth);
        this.clientWidth = window.innerWidth;
    },
};
</script>

<style></style>
