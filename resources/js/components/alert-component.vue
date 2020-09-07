<template>
  <div>
    <v-alert
      class="alert-msg"
      :value="alertOpen"
      :type="alertStyle"
      border="left"
      colored-border
      transition="scale-transition"
      elevation="3"
      dismissible
      @input="cls"
    >{{ alertMsg }}</v-alert>
  </div>
</template>
<style scoped>
.alert-msg {
  position: fixed;
  bottom: 0;
  width: 90%;
  max-width: 1000px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 99;
}
</style>
<script>
export default {
  props: {
    alertMsg: {
      type: String,
      required: true,
    },
    alertStyle: {
      type: String,
      required: true,
    },
    alertOpen: {
      type: Boolean,
      required: true,
    },
  },
  data: () => ({}),
  mounted() {},
  methods: {
    cls(e) {
      this.$emit("closeAlert", e);
    },
  },
  created() {},
  computed: {},
  watch: {},
};
</script>