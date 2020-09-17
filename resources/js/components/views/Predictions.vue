<template>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <vselect
        :clearable="false"
        :options="$store.state.allRounds"
        label="round"
        :value="$store.state.activeRound"
        @input="getGamesForRound($event)"
      >
      </vselect>
      <!-- <select
        class="form-control"
        v-model="currentRound[0].id"
        @change="getGamesForRound($event)"
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

    <SinglePredictionComponent></SinglePredictionComponent>
  </div>
</template>
<script>
import SinglePredictionComponent from "./../reusable/SinglePredictionComponent";
import vselect from "vue-select";
export default {
  data() {
    return {};
  },
  mounted() {
    this.$store.dispatch("getAllRounds").then((resp) => {
      console.log("got all rounds");
    });
    this.$store.dispatch("getCurrentRound").then((resp) => {
      console.log("got current round");
    });
  },
  components: {
    SinglePredictionComponent,
    vselect,
  },
  computed: {
    allRounds: function () {
      return this.$store.getters.allRounds;
    },
    currentRound: function () {
      return this.$store.getters.currentRound;
    },
    activeRound: function () {
      return this.$store.state.activeRound;
    },
  },
  methods: {
    getGamesForRound: function (e) {
      this.$store.commit("setActiveRound", e);
      var selectedRound = e.round;


      this.$store
        .dispatch("getSelectedPredictions", selectedRound)
        .then((resp) => {
          console.log("got selected predictions");
        });
    },
  },
};
</script>
<style lang="css" scoped>
input[type="search"] {
  position: absolute;
  top: 0;
  left: 0;
}

.dropdown-toggle {
  height: 30px;
}
</style>
