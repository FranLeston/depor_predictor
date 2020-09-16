<template>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <select
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
      </select>
    </div>

    <SinglePredictionComponent></SinglePredictionComponent>
  </div>
</template>
<script>
import SinglePredictionComponent from "./../reusable/SinglePredictionComponent";

export default {
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
  },
  computed: {
    allRounds: function () {
      return this.$store.getters.allRounds;
    },
    currentRound: function () {
      return this.$store.getters.currentRound;
    },
  },
  methods: {
    getGamesForRound: function (e) {
      if (e.target.options.selectedIndex > -1) {
        var selectedRound =
          e.target.options[e.target.options.selectedIndex].dataset.round;
      }
      this.$store
        .dispatch("getSelectedPredictions", selectedRound)
        .then((resp) => {
          console.log("got selected predictions");
        });
    },
  },
};
</script>
<style>
</style>
