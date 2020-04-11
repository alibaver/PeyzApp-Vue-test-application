<template>
  <v-card>
    <v-card-title class="subtitle-1 pb-1">
      {{ tableTitle }}
      <v-spacer></v-spacer>
      <v-text-field
        color="footerDark"
        v-model="search"
        append-icon="mdi-magnify"
        label="Tüm veritabanında arayın"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-col v-if="dataFilter" cols="12" class="mt-4">
      <v-row>
        <v-col class="py-3" cols="12" sm="12" md="4">
          <v-select
            dense
            item-color="footerDark"
            color="footerDark"
            outlined
            hide-details
            :items="subjectType"
            :value="subjectType[0]"
            label="Konular"
          ></v-select>
        </v-col>
        <v-col class="py-3" cols="12" sm="12" md="4">
          <v-select
            dense
            item-color="footerDark"
            color="footerDark"
            outlined
            hide-details
            :items="databaseType"
            :value="databaseType[0]"
            label="Veritabanı türü"
          ></v-select>
        </v-col>
        <v-col class="py-3" cols="12" sm="12" md="4">
          <v-select
            dense
            item-color="footerDark"
            color="footerDark"
            outlined
            hide-details
            :items="vendorsType"
            :value="vendorsType[0]"
            label="Dağıtıcı / Satıcı"
          ></v-select>
        </v-col>
      </v-row>
    </v-col>
    <v-data-table
      :search="search"
      :headers="dataHeaders"
      :items="dataItems"
      :sort-by.sync="tableOptions.sortBy"
      :sort-desc.sync="tableOptions.sortDesc"
      :footer-props="tableOptions.footerProps"
    >
      <template v-slot:item.name="{item}">
        <v-icon small left>mdi-database</v-icon>
        {{ item.name }}
      </template>
      <template v-slot:item.path="{item}">
        <v-btn small color="footerDark" class="white--text" :to="item.path">
          <v-icon small left>mdi-link-variant</v-icon>GİT
        </v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import JQuery from "jquery";
var $ = JQuery;
export default {
  props: {
    subjectType: {
      type: Array,
      required: false
    },
    databaseType: {
      type: Array,
      required: false
    },
    vendorsType: {
      type: Array,
      required: false
    },
    dataFilter: {
      type: Boolean,
      required: true
    },
    dataHeaders: {
      type: Array,
      required: true
    },
    dataItems: {
      type: Array,
      required: true
    },
    tableOptions: {
      type: Object,
      required: true
    },
    tableTitle: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      search: "",
      sortLabel: ""
    };
  },
  methods: {
    sortBy() {
      let labelLen = $(".v-select__slot > .v-label").length;

      if (
        window.innerWidth < 600 &&
        this.$router.currentRoute.name == "databases"
      ) {
        $(".v-select__slot > .v-label")
          .last()
          .html("Göre sırala");
        $(".v-select__slot > .v-label")[labelLen - 2].innerHTML = "Göre sırala";
      }
    }
  },
  watch: {},
  mounted() {
    this.sortBy();
  },
  created() {
    window.addEventListener("resize", this.sortBy);
  }
};
</script>