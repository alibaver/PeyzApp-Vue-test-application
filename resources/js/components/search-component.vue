<template>
  <v-text-field
    id="search"
    class="ml-2"
    style="max-width: 500px;"
    clearable
    flat
    solo
    dense
    name="search"
    placeholder="Kitap, makale, diğer tüm kaynakları arayın.."
    hide-details
    prepend-inner-icon="mdi-magnify"
    :color="isDark ? '' : 'base'"
  ></v-text-field>
  <!-- <filter-menu></filter-menu> -->
</template>
<script lang="ts">
export default {
  data: () => ({
    isDark: JSON.parse(localStorage.getItem("darkMode"))
  })
};
</script>