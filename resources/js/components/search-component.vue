<template>
  <!-- Search Container -->
  <v-card outlined>
    <v-col>
      <!-- SLİDE GROUP -->
      <v-col class="px-0">
        <v-sheet elevation="0">
          <v-slide-group mandatory show-arrows>
            <v-slide-item
              v-for="(item, index) in searchOptions"
              :key="index"
              v-slot:default="{ active, toggle }"
            >
              <v-btn
                class="mx-1"
                :input-value="active"
                :active-class="
                                    $vuetify.theme.dark
                                        ? ''
                                        : 'base white--text'
                                "
                depressed
                small
                @click="toggle"
              >{{ item.title }}</v-btn>
            </v-slide-item>
          </v-slide-group>
        </v-sheet>
      </v-col>
      <!-- SEARCH İNPUT  -->
      <v-col class="pa-0">
        <span class="caption ml-1">
          ISTE Kütüphane'deki tüm kitap, makale ve diğer kaynakları
          arayın.
        </span>
        <v-row>
          <v-col id="searchCon">
            <v-text-field
              id="search"
              rounded
              clearable
              outlined
              flat
              solo
              dense
              name="search"
              placeholder="Kitap, makale, diğer tüm kaynakları arayın.."
              hide-details
              :color="$vuetify.theme.dark ? 'white' : 'base'"
            ></v-text-field>
            <v-btn
              dark
              depressed
              class="customSearchBtn"
              :class="
                                $vuetify.theme.dark
                                    ? 'searchDark'
                                    : 'searchNrml'
                            "
              :color="$vuetify.theme.dark ? '' : 'base'"
            >
              <v-icon>mdi-magnify</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-col>

      <!-- OTHER SETTİNGS -->
      <v-col class="px-0 pb-0">
        <div class="d-flex" v-if="clientWidth >= 650">
          <v-btn text depressed small>
            <v-icon v-if="clientWidth >= 1000 || clientWidth <= 960" small left>mdi-help</v-icon>YARDIM
          </v-btn>
          <v-btn text depressed small class="ml-1">
            <v-icon v-if="clientWidth >= 1000 && clientWidth <= 960" small left>mdi-database</v-icon>VERİTABANLARI
          </v-btn>
          <v-btn text depressed small class="ml-1">
            <v-icon
              v-if="clientWidth >= 1000 || clientWidth <= 960"
              small
              left
            >mdi-text-box-search-outline</v-icon>GELİŞMİŞ ARAMA
          </v-btn>
          <v-btn text depressed small class="ml-auto">
            <v-icon v-if="clientWidth >= 1000 || clientWidth <= 960" small left>mdi-wifi-off</v-icon>KAMPÜS DIŞI ERİŞİM
          </v-btn>
        </div>
        <!-- OPTIONS BUTTON -->
        <div class="d-flex" v-else>
          <v-btn text depressed>
            <v-icon small left>mdi-help</v-icon>YARDIM
          </v-btn>
          <v-menu offset-y transition="scroll-y-transition" rounded="0">
            <template v-slot:activator="{ on: menu }">
              <v-btn text v-on="{ ...menu }" class="ml-auto">
                SEÇENEKLER
                <v-icon small right>mdi-menu-down</v-icon>
              </v-btn>
              <!-- <v-btn v-else dark icon v-on="{ ...menu }">
                            <v-icon>mdi-menu-down</v-icon>
              </v-btn>-->
            </template>
            <v-list dense>
              <v-list-item-group v-model="model" :color="isDark ? '' : 'base'">
                <v-list-item v-for="(item, index) in list" :key="index">
                  <v-list-item-icon class="mr-4">
                    <v-icon small v-text="item.icon"></v-icon>
                  </v-list-item-icon>

                  <v-list-item-content>
                    <v-list-item-title v-text="item.title"></v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-menu>
        </div>
      </v-col>
    </v-col>
  </v-card>
</template>
<style scoped>
</style>
<script>
import JQuery from "jquery";
var $ = JQuery;
export default {
  data: () => ({
    isDark: JSON.parse(localStorage.getItem("darkMode")),
    model: null,
    clientWidth: null,
    list: [
      { title: "VERİTABANLARI", icon: "mdi-database" },
      { title: "GELİŞMİŞ ARAMA", icon: "mdi-text-box-search-outline" },
      { title: "KAMPÜS DIŞI ERİŞİM", icon: "mdi-wifi-off" }
    ],
    searchOptions: null
  }),
  methods: {
    getWindowWidth() {
      this.clientWidth = window.innerWidth;
    }
  },
  mounted() {
    var elem = $("#searchCon")
      .find("div.v-input__append-inner")
      .css("padding-right", "50px");
  },
  created() {
    window.addEventListener("resize", this.getWindowWidth);
    this.clientWidth = window.innerWidth;
    // get searchBox list
    axios
      .get("ajaxfile.php", {
        params: {
          choose: "menu",
          param: "searchBoxMenus"
        }
      })
      .then(response => {
        this.searchOptions = JSON.parse(response.data[0].jsonContent);
      })
      .catch(err => {
        console.log(err);
      });
  }
};
</script>
