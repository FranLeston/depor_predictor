<template>
  <div class="row justify-content-center">
    <select class="form-control w-25" v-model="currentRound[0].id">
      <option
        v-for="(round, index) in allRounds"
        v-bind:value="round.id"
        :key="index"
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
};
</script>
<style>
</style>
