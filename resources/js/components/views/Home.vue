<template>
  <div class="row">
    <div class="col-md-7">
      <div class="row">
        <div class="col-md-3">
          <rankingTable></rankingTable>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <currentFixturesStatic></currentFixturesStatic>
    </div>
  </div>
</template>
<script>
import currentFixturesStatic from "./../reusable/CurrentFixturesStatic";
import rankingTable from "./../reusable/RankingTable";

export default {
  components: {
    currentFixturesStatic,
    rankingTable,
  },
  mounted() {
    this.$store.dispatch("getCurrentRound").then((resp) => {
      console.log(resp);
    });
  },
  computed: {
    currentRound: function () {
      return this.$store.getters.currentRound;
    },
  },
};
</script>

<style>
</style>
