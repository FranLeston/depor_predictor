<template>
  <div class="row justify-content-center">
    <select
      class="form-control w-25"
      v-model="currentRound[0].id"
      @change="getGamesForRound($event)"
    >
      <option
        v-for="(round, index) in allRounds"
        v-bind:value="round.id"
        :key="index"
        :data-round="round.round"
      >
        {{ round.round }}
      </option>
    </select>
    <SinglePredictionComponent></SinglePredictionComponent>
  </div>
</template>
<script>
import SinglePredictionComponent from "./../reusable/SinglePredictionComponent";

export default {
  mounted() {
    this.$store.dispatch("getAllRounds").then((resp) => {
      console.log(resp);
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
          console.log(resp);
        });
    },
  },
};
</script>
<style>
</style>
