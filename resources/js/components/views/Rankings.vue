<template>
  <div>
    <div class="row justify-content-between">
      <div class="col-md-6 mb-3">
        <vselect
          :clearable="false"
          :options="$store.state.allRounds"
          label="round"
          :value="$store.state.activeRound"
          @input="getRankingsForRound($event)"
        >
        </vselect>
        <!-- <select
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
        </select> -->
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <span class="h4">Por Jornada</span>
        <weeklyTable></weeklyTable>
      </div>
      <div class="col-md-6">
        <span class="h4">Ranking Global</span>
        <rankingTable></rankingTable>
      </div>
    </div>
  </div>
</template>
<script>
import rankingTable from "./../reusable/RankingTable";
import weeklyTable from "./../reusable/WeeklyRankingTable";
import vselect from "vue-select";

export default {
  data() {
    return {
      user: this.$store.getters.currentUser,
    };
  },
  components: {
    rankingTable,
    weeklyTable,
    vselect,
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
    activeRound: function () {
      return this.$store.state.activeRound;
    },
  },
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
