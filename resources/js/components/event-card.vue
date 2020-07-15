<template>
  <v-card outlined>
    <!-- PAGINATIONS -->
    <v-list subheader two-line>
      <v-subheader class="d-inline-flex">
        <v-icon small class="pr-2">mdi-halloween</v-icon>ETKİNLİKLER
      </v-subheader>
      <v-btn small text class="m-2 float-right">TÜMÜ</v-btn>
      <v-list-item
        class="text-wrap text-center"
        v-for="(item, index) in visibleEvent"
        :key="index"
        link
      >
        <v-list-item-action
          class="d-flex justify-content-center align-items-center m-0 overline"
          style="font-size:10px!important;"
        >
          <v-icon small>mdi-calendar</v-icon>
          {{ item.date }}
        </v-list-item-action>
        <v-list-item-content class="text-left pl-4">
          <v-list-item-subtitle class="text-wrap">
            {{
            item.title
            }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-list>
    <div class="my-3">
      <v-pagination
        :color="$vuetify.theme.dark ? '' : 'base'"
        v-model="page"
        :length="Math.ceil(eventCard.length / perPage)"
      ></v-pagination>
    </div>
  </v-card>
</template>
<script>
export default {
  props: {
    eventCard: {
      type: Array,
      required: true
    }
  },
  data: () => ({
    page: 1,
    perPage: 5
  }),
  mounted() {},
  computed: {
    visibleEvent() {
      return this.eventCard.slice(
        (this.page - 1) * this.perPage,
        this.page * this.perPage
      );
    }
  }
};
</script>
