<template>
  <div class="row">
    <div class="col-md-12 mb-3">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <select
            class="form-control"
            v-model="currentRound[0].id"
            @change="getRankingsForRound($event)"
          >
            <option
              v-for="(round, index) in allRounds"
              v-bind:value="round.id"
              :key="index"
              :data-round="round.round"
            >
              {{ "Jornada - " + round.round.split("-").pop() }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <span class="h4">Por Jornada</span>
      <weeklyTable></weeklyTable>
    </div>
    <div class="col-md-6">
      <span class="h4">Ranking Global</span>
      <rankingTable></rankingTable>
    </div>
  </div>
</template>
<script>
import rankingTable from "./../reusable/RankingTable";
import weeklyTable from "./../reusable/WeeklyRankingTable";

export default {
  data() {
    return {
      user: this.$store.getters.currentUser,
    };
  },
  components: {
    rankingTable,
    weeklyTable,
  },
  mounted() {
    if (this.user.id) {
      this.$store.dispatch("getUserRanking", this.user.id).then((resp) => {
        console.log("got user ranking");
      });
    }
  },
  computed: {
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
    currentRound: function () {
      return this.$store.getters.currentRound;
    },
    allRounds: function () {
      return this.$store.getters.allRounds;
    },
  },
  methods: {
    getRankingsForRound: function (e) {
      if (e.target.options.selectedIndex > -1) {
        var selectedRound =
          e.target.options[e.target.options.selectedIndex].dataset.round;
      }
      this.$store.dispatch("getWeeklyRankings", selectedRound).then((resp) => {
        console.log("got selected predictions");
      });
    },
  },
};
</script>

<style>
</style>
