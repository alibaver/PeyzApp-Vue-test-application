<template>
  <div>
    ekip detay {{ teamID }}
    <v-row>
      <v-col
        cols="4"
        v-for="(worker, index) in workerData"
        :key="index"
      >{{worker.ad}} {{worker.soyad}}</v-col>
    </v-row>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    teamID: null,
    teamData: [],
    workerData: [],
  }),
  methods: {
    getTeamDetails() {
      return axios
        .get("ajaxfile.php", {
          params: {
            choose: "teamDetails",
            param: this.teamID,
          },
        })
        .then((response) => {
          let myslqConnect = response.data.indexOf("mysqli_connect()");
          let nullIndex = response.data.indexOf("[]");
          nullIndex > -1 || myslqConnect > -1
            ? (this.teamData = 0)
            : (this.teamData = response.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getWorkerDetails() {
      return axios
        .get("ajaxfile.php", {
          params: {
            choose: "workerDetails",
            param: this.teamID,
          },
        })
        .then((response) => {
          let myslqConnect = response.data.indexOf("mysqli_connect()");
          let nullIndex = response.data.indexOf("[]");
          nullIndex > -1 || myslqConnect > -1
            ? (this.workerData = 0)
            : (this.workerData = response.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {},
  watch: {},
  created() {
    this.teamID = this.$route.query.teamId;
    this.getWorkerDetails();
    this.getTeamDetails();
  },
};
</script>