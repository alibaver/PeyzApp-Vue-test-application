<template></template>
<script lang="ts">
export default {
  data: () => ({
    isDark: JSON.parse(localStorage.getItem("darkMode"))
  })
};
</script>