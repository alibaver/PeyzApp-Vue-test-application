<template>
    <v-app id="inspire">
        <div v-if="$route.fullPath != '/login'">
            <v-app-bar id="appBar" app color="white" elevate-on-scroll>
                <v-app-bar-nav-icon
                    @click.stop="drawer = !drawer"
                    color="primary"
                />
                <a href="/">
                    <span class="subtitle-1 primary--text"
                        >peyz<span class="font-weight-bold primary--text"
                            >APP</span
                        >
                    </span>
                </a>
                <v-chip small class="ml-2 caption">BETA</v-chip>
                <v-spacer></v-spacer>
            </v-app-bar>
            <v-navigation-drawer app v-model="drawer" class="drawerGround">
                <div
                    class="d-flex justify-center align-center w100 pa-10 flex-column"
                >
                    <v-avatar class="" color="white" size="100">
                        <span class="primary--text text-h4"
                            >{{ ad.substr(0, 1) }}{{ soyad.substr(0, 1) }}
                        </span>
                    </v-avatar>
                    <span class="mt-7 white--text">{{ ad }} {{ soyad }} </span>
                </div>
                <v-divider></v-divider>
                <v-list>
                    <div class="d-none d-md-block">
                        <v-list-item
                            dark
                            active-class="activeMenu"
                            :to="'/'"
                            style="min-height: 55px"
                        >
                            <v-icon left>mdi-account-hard-hat</v-icon>
                            Ekip
                        </v-list-item>
                        <v-list-item
                            dark
                            active-class="activeMenu"
                            :to="'/budanan-agac'"
                            style="min-height: 55px"
                        >
                            <v-icon left>mdi-tree</v-icon>
                            Budanan Ağaç
                        </v-list-item>
                        <v-list-item
                            dark
                            active-class="activeMenu"
                            :to="'/takvim'"
                            style="min-height: 55px"
                        >
                            <v-icon left>mdi-calendar</v-icon>
                            Takvim
                        </v-list-item>
                        <v-list-item
                            dark
                            active-class="activeMenu"
                            :to="'/gider'"
                            style="min-height: 55px"
                        >
                            <v-icon left>mdi-currency-try</v-icon>
                            Gider
                        </v-list-item>
                    </div>
                    <v-list-item
                        dark
                        active-class="activeMenu"
                        :to="'/hakedis'"
                        style="min-height: 55px"
                    >
                        <v-icon left>mdi-calculator</v-icon>
                        Hakediş Listesi
                    </v-list-item>
                    <v-list-item
                        dark
                        active-class="activeMenu"
                        :to="'/ayrilan-calisanlar'"
                        style="min-height: 55px"
                    >
                        <v-icon left>mdi-account-cancel</v-icon>
                        Ayrılan Çalışan Listesi
                    </v-list-item>
                    <v-list-item
                        dark
                        active-class="activeMenu"
                        style="min-height: 55px"
                        @click="logout"
                    >
                        <v-icon left>mdi-login</v-icon>
                        Çıkış yap
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>
            <bottom-nav
                style="position: fixed; bottom: 0px; z-index: 2"
                class="d-md-none"
            ></bottom-nav>
        </div>

        <v-main>
            <div
                :class="$route.fullPath === '/login' ? '' : 'pa-4 pb-16'"
                :style="
                    $route.fullPath === '/login'
                        ? 'margin:0;padding:0;height:100vh;max-width:none'
                        : ''
                "
            >
                <router-view></router-view>
            </div>
        </v-main>
    </v-app>
</template>
<script>
export default {
    data: () => ({
        drawer: null,
        ad: window.localStorage.getItem("ad"),
        soyad: window.localStorage.getItem("soyad")
    }),
    computed: {},
    methods: {
        logout() {
            window.localStorage.removeItem("requiresAuth");
            window.localStorage.removeItem("ad");
            window.localStorage.removeItem("soyad");
            window.localStorage.removeItem("_uid");
            this.$router.push("/login");
        }
    },
    mounted() {
        const url =
            "https://api.bybit.com/v2/public/orderBook/L2?symbol=BTCUSD";
        var ourRequest = new XMLHttpRequest();
        ourRequest.open("GET", url, true);
        ourRequest.onload = function() {
            console.log(ourRequest.responseText);
        };
        ourRequest.send();
    },
    watch: {},
    created() {}
};
</script>
<style scope></style>
