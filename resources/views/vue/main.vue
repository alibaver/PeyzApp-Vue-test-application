<template>
    <div>
        <!--CHİPS -->
        <v-col v-if="clientWidth > 699" class="py-0">
            <v-chip
                small
                outlined
                class="overline"
                style="font-size:10px!important;"
                color="error"
            >
                <v-icon left x-small>mdi-circle</v-icon>KAPALI
            </v-chip>
            <v-chip
                small
                outlined
                class="overline"
                style="font-size:10px!important;"
            >
                <v-icon left x-small>mdi-calendar</v-icon>HAFTA İÇİ: 08:00-24:00
            </v-chip>
            <v-chip
                small
                outlined
                class="overline"
                style="font-size:10px!important;"
            >
                <v-icon left x-small>mdi-calendar</v-icon>HAFTA SONU:
                10:00-24:00
            </v-chip>
            <v-chip
                small
                outlined
                class="overline"
                style="font-size:10px!important;"
            >
                <v-icon left x-small>mdi-calendar</v-icon>RESMİ TATİL: KAPALI
            </v-chip>
        </v-col>

        <!--ARAMA VE SIKÇA SORULAN SORULAR -->
        <v-row>
            <!-- SEARCH -->
            <v-col cols="12" md="8">
                <search-component></search-component>
            </v-col>
            <!--SIKCA SORULAN SORULAR -->
            <v-col cols="12" md="4" class="py-0">
                <v-row>
                    <v-col cols="12" sm="6">
                        <v-card
                            to="/sıkca-sorulan-sorular"
                            ripple
                            hover
                            outlined
                            style="display:grid"
                            height="206"
                            class="px-3 py-6 justify-content-center align-items-center text-center"
                        >
                            <v-icon
                                size="70"
                                :color="$vuetify.theme.dark ? '' : 'base'"
                                >mdi-frequently-asked-questions</v-icon
                            >

                            <v-card-subtitle class="pa-0 font-weight-bold"
                                >SIKÇA SORULAN SORULAR</v-card-subtitle
                            >
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-card
                            ripple
                            hover
                            outlined
                            style="display:grid"
                            height="206"
                            class="px-6 py-6 justify-content-center align-items-center text-center"
                        >
                            <v-icon
                                size="70"
                                :color="$vuetify.theme.dark ? '' : 'base'"
                                >mdi-help-circle</v-icon
                            >

                            <v-card-subtitle class="pa-0 font-weight-bold"
                                >KÜTÜPHANECİYE SOR</v-card-subtitle
                            >
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <!--DUYURU VE ETKİNLİK -->
        <v-row>
            <v-col cols="12" md="6">
                <notify-card :notify-card="notification"></notify-card>
            </v-col>
            <v-col cols="12" md="6">
                <event-card :event-card="eventList"></event-card>
            </v-col>
        </v-row>

        <!-- IMAGE SLIDER 
    <carousel></carousel>-->

        <!-- AYIN SEÇKİLERİ -->
        <v-row>
            <v-col>
                <special-choose :monthly-award="monthly_award"></special-choose>
            </v-col>
        </v-row>

        <!-- YENİ EKLENEN VERİ TABANLARI  order-last order-sm-first -->
        <v-row>
            <v-col>
                <trial-database
                    :trial-database="trial_databases"
                ></trial-database>
            </v-col>
        </v-row>

        <!-- FİRMALAR LOGO -->
        <v-row id="compLogo" class="py-5">
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

        <!-- NOTİCE -->
        <notice></notice>
    </div>
</template>

<script>
export default {
    props: {
        source: Array
    },
    data: () => ({
        clientWidth: null,
        trial_databases: [],
        monthly_award: [],
        notification: [
            {
                date: "26.03.2020",
                title: "İdealonline Deneme Erişimi"
            },
            {
                date: "25.03.2020",
                title: "Webinar Etkinlik Takvimi"
            },
            {
                date: "25.03.2020",
                title:
                    "Koronavirüs ( COVID-19 ): Koronavirüs Hakkında Bilgi Kaynakları"
            },
            {
                date: "21.02.2020",
                title: "İSTE Merkez Kütüphanesi Elektronik Kaynak ve Araçları"
            },
            {
                date: "26.03.2020",
                title:
                    "Abonelik Sağlanan Veri Tabanları (ASTM Standards and Engineering Digital Library )"
            },
            {
                date: "26.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "21.02.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            }
        ],
        eventList: [
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            },
            {
                date: "25.03.2020",
                title:
                    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, labore!"
            }
        ]
    }),
    methods: {
        getWindowWidth() {
            this.clientWidth = window.innerWidth;
        },
        getMontlyAwardDate() {
            let date = new Date()
                .toLocaleString("tr")
                .split(" ")[0]
                .split(".");
            date[0] = "01";
            let ldate = date;
            date = date.reverse().join("-");
            if (parseInt(ldate[1]) < 12) {
                if (parseInt(ldate[1]) < 9) {
                    ldate[1] = "0" + (parseInt(ldate[1]) + 1).toString();
                } else {
                    ldate[1] = (parseInt(ldate[1]) + 1).toString();
                }
            } else {
                ldate[1] = "01";
                ldate[0] = (parseInt(ldate[0]) + 1).toString();
            }
            ldate = ldate.join("-");
        },
        getTrialDatabase() {
            axios
                .get("ajaxfile.php", {
                    params: {
                        choose: "trial_database"
                    }
                })
                .then(response => {
                    this.trial_databases = response.data;
                });
        },
        getMontlyAward() {
            axios
                .get("ajaxfile.php", {
                    params: {
                        choose: "monthly_award",
                        param: date,
                        param2: ldate
                    }
                })
                .then(response => {
                    this.monthly_award = response.data;
                });
        }
    },
    mounted() {
        darkMode
            ? $("#compLogo")
                  .find(".imgchangeColor")
                  .toggleClass("whiteBG")
            : "";
    },
    watch: {},
    created() {
        window.addEventListener("resize", this.getWindowWidth);
        this.clientWidth = window.innerWidth;
        getMontlyAwardDate();
        getTrialDatabase();
        getMontlyAward();
    }
};
</script>

<style></style>
