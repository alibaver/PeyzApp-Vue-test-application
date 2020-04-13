<template>
  <div class="mx-1">
    <v-menu offset-y transition="scroll-y-transition">
      <template v-slot:activator="{ on: menu }">
        <v-tooltip bottom open-delay="500" z-index="1">
          <template v-slot:activator="{ on: tooltip }">
            <v-btn dark icon v-on="{ ...tooltip, ...menu }">
              <v-icon>mdi-cog</v-icon>
            </v-btn>
          </template>
          <span>Gelişmiş Arama</span>
        </v-tooltip>
      </template>
      <v-list dense rounded>
        <v-list-item-group v-model="model" :color="isDark ? '' : 'base'">
          <v-list-item v-for="(item, index) in list" :key="index">
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title v-text="item.title"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-menu>
  </div>
</template>
<script>
export default {
  data: () => ({
    model: 0,
    isDark: JSON.parse(localStorage.getItem("darkMode")),
    list: [
      { title: "TÜMÜ", icon: "mdi-collapse-all" },
      { title: "Katalog", icon: "mdi-book-open-page-variant" },
      { title: "E-Dergiler", icon: "mdi-file-pdf" },
      { title: "Makaleler", icon: "mdi-file" },
      { title: "E-Kitaplar", icon: "mdi-book-open" },
      { title: "Tezler", icon: "mdi-file" },
      { title: "İSTE Akademik Arşiv", icon: "mdi-archive" }
    ]
  })
};
</script>
