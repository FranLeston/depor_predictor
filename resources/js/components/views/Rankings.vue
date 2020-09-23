<template>
  <div>
    <div class="row justify-content-between">
      <div class="col-sm-6 mb-3">
        <v-select
          :clearable="false"
          :options="$store.state.allRounds"
          label="round"
          :value="$store.state.activeRound"
          @input="getRankingsForRound($event)"
        >
        </v-select>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <span class="h4">Por Jornada</span>
        <weeklyTable></weeklyTable>
      </div>
      <div class="col-sm-6">
        <span class="h4">Ranking Global</span>
        <rankingTable></rankingTable>
      </div>
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
  computed: {},
  methods: {
    getRankingsForRound: function (e) {
      this.$store.commit("setActiveRound", e);
      var selectedRound = e.round;

      this.$store.dispatch("getWeeklyRankings", selectedRound).then((resp) => {
        console.log("got selected predictions");
      });
    },
  },
};
</script>

<style>
</style>
