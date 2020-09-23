<template>
  <div class="row">
    <div class="col-sm-8">
      <span class="h4">Ranking Global</span>
      <rankingTable></rankingTable>
    </div>
    <div class="col-sm-4">
      <span class="h4">En Juego</span>
      <currentFixturesStatic></currentFixturesStatic>
    </div>
  </div>
</template>
<script>
import currentFixturesStatic from "./../reusable/CurrentFixturesStatic";
import rankingTable from "./../reusable/RankingTable";

export default {
  data() {
    return {
      user: this.$store.getters.currentUser,
    };
  },
  components: {
    currentFixturesStatic,
    rankingTable,
  },
  mounted() {
    if (this.user.id) {
      this.$store.dispatch("getUserRanking", this.user.id).then((resp) => {
        console.log("got user ranking");
      });
    }
    this.$store.dispatch("getCurrentRound").then((resp) => {
      console.log("got current round");
    });
  },
  computed: {
    currentUser: function () {
      return this.$store.getters.currentUser;
    },
  },
};
</script>

<style>
</style>
