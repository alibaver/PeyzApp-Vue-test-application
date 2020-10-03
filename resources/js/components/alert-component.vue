<template>
  <div>
    <v-snackbar
      v-model="alertOpen"
      multi-line
      bottom
      :color="alertStyle"
      :timeout="alertTime"
      transition="scale-transition"
    >
      {{ alertMsg }}
      <template v-slot:action="{ attrs }" v-if="alertTime == -1">
        <v-btn text v-bind="attrs" @click="cls"> kapat </v-btn>
      </template>
    </v-snackbar>
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
    alertTime: {
      type: Number,
      required: false,
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
