<template>
  <div>
    <div
      v-if="pageLoading"
      class="d-flex justify-center align-center w100 flex-column pLoad"
    >
      <v-progress-circular
        :width="3"
        :size="60"
        color="primary"
        indeterminate
      ></v-progress-circular>
      <span class="mt-4 overline primary--text">LOADING..</span>
    </div>
    <div v-else>
      <v-row>
        <v-col class="pt-0">
          <page-path></page-path>
          <v-sheet>
            <div class="d-flex justify-space-around w100 align-center">
              <v-btn fab text small color="grey darken-2" @click="prev">
                <v-icon small>mdi-chevron-left</v-icon>
              </v-btn>
              <span v-if="$refs.calendar">{{ $refs.calendar.title }}</span>
              <v-btn fab text small color="grey darken-2" @click="next">
                <v-icon small>mdi-chevron-right</v-icon>
              </v-btn>
            </div>
          </v-sheet>
          <v-sheet>
            <v-calendar
              ref="calendar"
              v-model="focus"
              color="primary"
              :type="type"
              locale="tr"
              :weekdays="weekdays"
              :events="events"
              :event-color="getEventColor"
              @click:event="showEvent"
              @click:more="viewDay"
            ></v-calendar>
            <v-menu
              v-model="selectedOpen"
              :close-on-content-click="false"
              :activator="selectedElement"
              offset-x
              min-width="270"
            >
              <v-card flat>
                <v-toolbar :color="selectedEvent.color" dark dense flat>
                  <v-btn icon small>
                    <v-icon small>mdi-account-hard-hat</v-icon>
                  </v-btn>
                  <span v-html="selectedEvent.name"></span>
                  <v-spacer></v-spacer>
                  <v-btn icon small>
                    <v-icon small>mdi-dots-vertical</v-icon>
                  </v-btn>
                </v-toolbar>
                <v-card-text>
                  <div class="w100 d-flex justify-space-between align-center">
                    <div>
                      <v-icon small color="green">mdi-check-all</v-icon
                      ><span class="caption"> Tam Gün</span>
                    </div>
                    <div>
                      <v-icon small color="blue">mdi-check</v-icon
                      ><span class="caption"> Yarım Gün</span>
                    </div>
                    <div>
                      <v-icon small color="error">mdi-close </v-icon
                      ><span class="caption"> Gelmedi</span>
                    </div>
                  </div>
                  <v-divider class="mt-2"></v-divider>

                  <v-list dense class="pa-0 ma-0">
                    <v-list-item
                      v-for="person in selectedEvent.details"
                      :key="person.worker_id"
                      class="pa-0"
                      style="height: 25px"
                    >
                      <v-icon
                        v-if="person.status == 'Tam Gün'"
                        small
                        left
                        color="green"
                        >mdi-check-all</v-icon
                      >
                      <v-icon
                        v-else-if="person.status == 'Yarım Gün'"
                        small
                        left
                        color="blue"
                        >mdi-check</v-icon
                      >
                      <v-icon v-else small left color="error">mdi-close</v-icon>

                      <v-icon small left color="gray"
                        >mdi-account-hard-hat</v-icon
                      >
                      <span class="body-2"
                        >{{ person.ad }} {{ person.soyad }}</span
                      >
                    </v-list-item>
                  </v-list>
                </v-card-text>
                <v-card-actions>
                  <v-btn
                    small
                    text
                    color="secondary"
                    @click="selectedOpen = false"
                    >Kapat</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-menu>
          </v-sheet>
        </v-col>
      </v-row>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    pageLoading: true,
    focus: "",
    weekdays: [1, 2, 3, 4, 5, 6, 0],
    type: "month",
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
    events: [],
    calendarData: [],
    colors: [
      "red",
      "red lighten-2",
      "red lighten-1",
      "red darken-1",
      "red darken-2",
      "red darken-3",
      "red darken-4",
      "red accent-2",
      "red accent-3",
      "red accent-4",
      "pink",
      "pink lighten-2",
      "pink lighten-1",
      "pink darken-1",
      "pink darken-2",
      "pink darken-3",
      "pink darken-4",
      "pink accent-2",
      "pink accent-3",
      "pink accent-4",
      "purple",
      "purple lighten-2",
      "purple lighten-1",
      "purple darken-1",
      "purple darken-2",
      "purple darken-3",
      "purple darken-4",
      "purple accent-2",
      "purple accent-3",
      "purple accent-4",
      "deep-purple",
      "deep-purple lighten-2",
      "deep-purple lighten-1",
      "deep-purple darken-1",
      "deep-purple darken-2",
      "deep-purple darken-3",
      "deep-purple darken-4",
      "deep-purple accent-2",
      "deep-purple accent-3",
      "deep-purple accent-4",
      "indigo",
      "indigo lighten-2",
      "indigo lighten-1",
      "indigo darken-1",
      "indigo darken-2",
      "indigo darken-3",
      "indigo darken-4",
      "indigo accent-2",
      "indigo accent-3",
      "indigo accent-4",
      "blue",
      "blue lighten-2",
      "blue lighten-1",
      "blue darken-1",
      "blue darken-2",
      "blue darken-3",
      "blue darken-4",
      "blue accent-2",
      "blue accent-3",
      "blue accent-4",
      "light-blue",
      "light-blue lighten-2",
      "light-blue lighten-1",
      "light-blue darken-1",
      "light-blue darken-2",
      "light-blue darken-3",
      "light-blue darken-4",
      "light-blue accent-2",
      "light-blue accent-3",
      "light-blue accent-4",
      "cyan",
      "cyan lighten-2",
      "cyan lighten-1",
      "cyan darken-1",
      "cyan darken-2",
      "cyan darken-3",
      "cyan darken-4",
      "cyan accent-2",
      "cyan accent-3",
      "cyan accent-4",
      "teal",
      "teal lighten-2",
      "teal lighten-1",
      "teal darken-1",
      "teal darken-2",
      "teal darken-3",
      "teal darken-4",
      "teal accent-2",
      "teal accent-3",
      "teal accent-4",
      "green",
      "green lighten-2",
      "green lighten-1",
      "green darken-1",
      "green darken-2",
      "green darken-3",
      "green darken-4",
      "green accent-2",
      "green accent-3",
      "green accent-4",
      "light-green",
      "light-green lighten-2",
      "light-green lighten-1",
      "light-green darken-1",
      "light-green darken-2",
      "light-green darken-3",
      "light-green darken-4",
      "light-green accent-2",
      "light-green accent-3",
      "light-green accent-4",
      "lime",
      "lime darken-1",
      "lime darken-2",
      "lime darken-3",
      "lime darken-4",
      "lime accent-2",
      "lime accent-3",
      "lime accent-4",
      "amber",
      "amber lighten-2",
      "amber lighten-1",
      "amber darken-1",
      "amber darken-2",
      "amber darken-3",
      "amber darken-4",
      "amber accent-2",
      "amber accent-3",
      "amber accent-4",
      "orange",
      "orange lighten-2",
      "orange lighten-1",
      "orange darken-1",
      "orange darken-2",
      "orange darken-3",
      "orange darken-4",
      "orange accent-2",
      "orange accent-3",
      "orange accent-4",
      "deep-orange",
      "deep-orange lighten-2",
      "deep-orange lighten-1",
      "deep-orange darken-1",
      "deep-orange darken-2",
      "deep-orange darken-3",
      "deep-orange darken-4",
      "deep-orange accent-2",
      "deep-orange accent-3",
      "deep-orange accent-4",
      "brown",
      "brown lighten-2",
      "brown lighten-1",
      "brown darken-1",
      "brown darken-2",
      "brown darken-3",
      "brown darken-4",
      "blue-grey",
      "blue-grey lighten-2",
      "blue-grey lighten-1",
      "blue-grey darken-1",
      "blue-grey darken-2",
      "blue-grey darken-3",
      "blue-grey darken-4",
    ],
  }),
  mounted() {
    //this.$refs.calendar.checkChange();
  },
  methods: {
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    getEventColor(event) {
      return event.color;
    },
    setToday() {
      this.focus = "";
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    showEvent({ nativeEvent, event }) {
      const open = () => {
        this.selectedEvent = event;
        this.selectedElement = nativeEvent.target;
        setTimeout(() => {
          this.selectedOpen = true;
        }, 10);
      };

      if (this.selectedOpen) {
        this.selectedOpen = false;
        setTimeout(open, 10);
      } else {
        open();
      }

      nativeEvent.stopPropagation();
    },
    getCalendar() {
      this.$axios
        .get("ajaxfile.php", {
          params: {
            choose: "getCalendars",
          },
        })
        .then((response) => {
          this.calendarData = response.data;
          this.pageLoading = false;

          this.calendarData.forEach((person) => {
            this.events.push({
              name: person.ekip_adi,
              start: person.tarih,
              end: person.tarih,
              color: this.colors[this.rnd(0, this.colors.length - 1)],
              timed: false,
              details: JSON.parse(person.workers),
            });
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    rnd(a, b) {
      return Math.floor((b - a + 1) * Math.random()) + a;
    },
  },
  created() {
    this.getCalendar();
  },
};
</script>