<template>
  <div>
    <v-snackbar
      v-model="alertOpen"
      multi-line
      :color="alertStyle"
      :timeout="alertTime"
    >
      {{ alertMsg }}
      <template v-slot:action="{ attrs }" v-if="alertTime == -1">
        <v-btn text v-bind="attrs" @click="cls"> kapat </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>
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
